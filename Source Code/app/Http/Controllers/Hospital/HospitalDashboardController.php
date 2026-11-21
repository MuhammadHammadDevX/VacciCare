<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\HospitalVaccine;
use App\Models\ParentRequest;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\Vaccinator;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HospitalDashboardController extends Controller
{
    /**
     * Resolve the current hospital model and linked hospital_users record.
     */
    protected function getHospitalContext(): array
    {
        $hospitalUser = Auth::guard('hospital')->user();
        $hospitalUserId = $hospitalUser ? $hospitalUser->id : (session('hospital_id') ?? session('user_id'));

        if (!$hospitalUser && $hospitalUserId) {
            $hospitalUser = HospitalUser::find($hospitalUserId);
        }

        // Link with hospitals table
        $hospital = null;
        if ($hospitalUser) {
            $hospital = Hospital::where('email', $hospitalUser->email)
                ->orWhere('license_no', $hospitalUser->registration_number ?? '')
                ->orWhere('hospital_id', $hospitalUser->id)
                ->first();
        }

        if (!$hospital && $hospitalUserId) {
            $hospital = Hospital::where('hospital_id', $hospitalUserId)->orWhere('user_id', $hospitalUserId)->first();
        }

        return [$hospitalUser, $hospital];
    }

    /**
     * Show Hospital Login form.
     */
    public function showLogin()
    {
        return view('hospital.login');
    }

    /**
     * Process Hospital Login.
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'hospitalEmail' => 'required|email',
            'hospitalPassword' => 'required',
        ], [
            'hospitalEmail.required' => 'Please enter your email.',
            'hospitalPassword.required' => 'Please enter your password.',
        ]);

        $email = trim($request->input('hospitalEmail'));
        $password = $request->input('hospitalPassword');
        $remember = $request->boolean('remember');

        // Check hospital_users
        $hospitalUser = HospitalUser::where('email', $email)->first();
        if ($hospitalUser && Hash::check($password, $hospitalUser->password)) {
            $request->session()->regenerate();
            Auth::guard('hospital')->login($hospitalUser, $remember);

            session([
                'user_id' => $hospitalUser->id,
                'hospital_id' => $hospitalUser->id,
                'hospital_name' => $hospitalUser->hospital_name,
                'hospital_email' => $hospitalUser->email,
                'role' => 'hospital',
            ]);

            return redirect()->route('hospital.dashboard');
        }

        // Check web users with role hospital
        $webUser = User::where('email', $email)->where('role', 'hospital')->where('status', 'active')->first();
        if ($webUser && Hash::check($password, $webUser->password)) {
            $request->session()->regenerate();
            Auth::guard('web')->login($webUser, $remember);

            session([
                'user_id' => $webUser->user_id,
                'hospital_id' => $webUser->user_id,
                'hospital_name' => $webUser->name,
                'hospital_email' => $webUser->email,
                'role' => 'hospital',
            ]);

            return redirect()->route('hospital.dashboard');
        }

        return back()->withInput($request->only('hospitalEmail'))->with('loginError', 'Hospital account not found or invalid password.');
    }

    /**
     * Show Hospital Registration form.
     */
    public function showRegister()
    {
        return view('hospital.register');
    }

    /**
     * Process Hospital Registration.
     */
    public function postRegister(Request $request)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:150',
            'hospital_type' => 'required|string|max:50',
            'registration_number' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:hospital_users,email',
            'phone' => ['required', 'regex:/^03\d{9}$/'],
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
            'terms' => 'accepted',
        ], [
            'email.unique' => 'A hospital account with this email already exists.',
            'phone.regex' => 'Please enter a valid Pakistani mobile number (e.g. 03001234567).',
            'password.min' => 'Password must contain at least 8 characters.',
            'confirm_password.same' => 'Passwords do not match.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        DB::beginTransaction();
        try {
            $hospitalUser = HospitalUser::create([
                'hospital_name' => trim($request->input('hospital_name')),
                'hospital_type' => trim($request->input('hospital_type')),
                'registration_number' => trim($request->input('registration_number')),
                'email' => trim($request->input('email')),
                'phone' => trim($request->input('phone')),
                'address' => trim($request->input('address')),
                'city' => trim($request->input('city')),
                'province' => trim($request->input('province')),
                'password' => Hash::make($request->input('password')),
                'role' => 'hospital',
            ]);

            // Also create or sync with hospitals directory table if not existing
            Hospital::firstOrCreate([
                'license_no' => $hospitalUser->registration_number ?: ('RG-' . rand(10000, 99999)),
            ], [
                'user_id' => $hospitalUser->id,
                'hospital_name' => $hospitalUser->hospital_name,
                'hospital_type' => $hospitalUser->hospital_type,
                'email' => $hospitalUser->email,
                'phone' => $hospitalUser->phone,
                'city' => $hospitalUser->city,
                'address' => $hospitalUser->address,
                'contact_person' => 'Hospital Administrator',
                'working_hours' => '24 Hours',
                'status' => 'Active',
            ]);

            DB::commit();

            Auth::guard('hospital')->login($hospitalUser);

            session([
                'user_id' => $hospitalUser->id,
                'hospital_id' => $hospitalUser->id,
                'hospital_name' => $hospitalUser->hospital_name,
                'hospital_email' => $hospitalUser->email,
                'role' => 'hospital',
            ]);

            return redirect()->route('hospital.dashboard');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('errorMessage', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Hospital main dashboard.
     */
    public function dashboard()
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);
        $hospitalUserId = $hospitalUser ? $hospitalUser->id : 0;

        $totalChildren = ParentRequest::where(function ($q) use ($hospitalId, $hospitalUserId) {
            $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
        })->where('request_type', 'Vaccination')->where('status', 'Approved')->distinct('child_id')->count('child_id');

        $vaccinesUpdated = Vaccination::where('hospital_id', $hospitalId)->where('status', 'Completed')->count();

        $pendingUpdates = ParentRequest::where(function ($q) use ($hospitalId, $hospitalUserId) {
            $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
        })->where('request_type', 'Vaccination')->where('status', 'Approved')->count();

        $recentUpdates = Vaccination::with(['child', 'vaccine'])
            ->where('hospital_id', $hospitalId)
            ->orderBy('vaccination_id', 'desc')
            ->limit(5)
            ->get();

        // Inventory metrics
        $hospitalVaccinesQuery = HospitalVaccine::where('hospital_id', $hospitalId);
        $totalStock = (clone $hospitalVaccinesQuery)->sum('stock_quantity');
        $lowStockCount = (clone $hospitalVaccinesQuery)
            ->where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->count();
        $outOfStockCount = (clone $hospitalVaccinesQuery)->where('stock_quantity', '<=', 0)->count();
        $expiringSoonCount = (clone $hospitalVaccinesQuery)
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now()->toDateString(), now()->addDays(30)->toDateString()])
            ->count();

        return view('hospital.dashboard', compact(
            'hospitalUser',
            'hospital',
            'totalChildren',
            'vaccinesUpdated',
            'pendingUpdates',
            'recentUpdates',
            'totalStock',
            'lowStockCount',
            'outOfStockCount',
            'expiringSoonCount'
        ));
    }

    /**
     * Hospital profile view.
     */
    public function profile()
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        return view('hospital.profile', compact('hospitalUser', 'hospital'));
    }

    /**
     * Edit hospital profile form.
     */
    public function editProfile()
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        return view('hospital.edit-profile', compact('hospitalUser', 'hospital'));
    }

    /**
     * Update hospital profile.
     */
    public function updateProfile(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();

        $request->validate([
            'hospital_name' => 'required|string|max:150',
            'hospital_type' => 'required|string|max:50',
            'registration_number' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:hospital_users,email,' . ($hospitalUser ? $hospitalUser->id : 0),
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
        ]);

        if ($hospitalUser) {
            $hospitalUser->update([
                'hospital_name' => trim($request->input('hospital_name')),
                'hospital_type' => trim($request->input('hospital_type')),
                'registration_number' => trim($request->input('registration_number')),
                'email' => trim($request->input('email')),
                'phone' => trim($request->input('phone')),
                'address' => trim($request->input('address')),
                'city' => trim($request->input('city')),
                'province' => trim($request->input('province')),
            ]);

            session([
                'hospital_name' => $hospitalUser->hospital_name,
                'hospital_email' => $hospitalUser->email,
            ]);
        }

        if ($hospital) {
            $hospital->update([
                'hospital_name' => trim($request->input('hospital_name')),
                'hospital_type' => trim($request->input('hospital_type')),
                'email' => trim($request->input('email')),
                'phone' => trim($request->input('phone')),
                'city' => trim($request->input('city')),
                'address' => trim($request->input('address')),
            ]);
        }

        return redirect()->route('hospital.profile')->with('success_message', 'Profile updated successfully.');
    }

    /**
     * List and confirm hospital appointments.
     */
    public function appointments(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);
        $hospitalUserId = $hospitalUser ? $hospitalUser->id : 0;

        if ($request->isMethod('post') && $request->has('confirm_appointment')) {
            $requestId = (int) $request->input('request_id');
            $parentRequest = ParentRequest::where('request_id', $requestId)
                ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                    $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
                })
                ->where('status', 'Approved')
                ->firstOrFail();

            // Find vaccine
            $hospitalVaccine = HospitalVaccine::find($parentRequest->hospital_vaccine_id);
            $vaccineName = $hospitalVaccine ? $hospitalVaccine->vaccine_name : 'BCG';
            $systemVaccine = Vaccine::whereRaw('LOWER(TRIM(vaccine_name)) = ?', [strtolower(trim($vaccineName))])->first()
                ?? Vaccine::first();

            // Find an active vaccinator for this hospital
            $vaccinator = Vaccinator::where('hospital_id', $hospitalId)->where('status', 'Active')->first()
                ?? Vaccinator::first();

            // Check if already booked
            $existing = Booking::where('parent_id', $parentRequest->parent_id)
                ->where('child_id', $parentRequest->child_id)
                ->where('hospital_id', $hospitalId)
                ->where('booking_date', $parentRequest->request_date)
                ->first();

            if (!$existing) {
                Booking::create([
                    'parent_id' => $parentRequest->parent_id,
                    'child_id' => $parentRequest->child_id,
                    'hospital_id' => $hospitalId,
                    'vaccine_id' => $systemVaccine ? $systemVaccine->vaccine_id : 4,
                    'vaccinator_id' => $vaccinator ? $vaccinator->vaccinator_id : 3,
                    'booking_date' => $parentRequest->request_date,
                    'booking_time' => $parentRequest->preferred_time ?? '09:00:00',
                    'status' => 'Confirmed',
                ]);
            }

            return back()->with('message', 'Appointment confirmed successfully!')->with('messageType', 'success');
        }

        $appointments = ParentRequest::with(['parent', 'child', 'hospitalVaccine'])
            ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
            })
            ->where('status', 'Approved')
            ->orderBy('request_date', 'asc')
            ->get();

        // Attach booking info if exists
        foreach ($appointments as $apt) {
            $bk = Booking::with('vaccinator')
                ->where('child_id', $apt->child_id)
                ->where('booking_date', $apt->request_date)
                ->where('hospital_id', $hospitalId)
                ->first();

            $apt->booking_id = $bk ? $bk->booking_id : null;
            $apt->vaccinator_name = $bk && $bk->vaccinator ? $bk->vaccinator->name : null;
        }

        return view('hospital.appointments', compact('hospitalUser', 'hospital', 'appointments'));
    }

    /**
     * Vaccine status update form and submission.
     */
    public function vaccineStatus(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);
        $hospitalUserId = $hospitalUser ? $hospitalUser->id : 0;

        if ($request->isMethod('post')) {
            $appointmentId = (int) $request->input('request_id');
            $result = trim($request->input('vaccination_result'));
            $notes = trim($request->input('notes', ''));

            $booking = Booking::where('booking_id', $appointmentId)
                ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                    $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
                })
                ->first();

            // If not found in bookings, check if it was passed as parent_requests request_id
            if (!$booking) {
                $parentReq = ParentRequest::where('request_id', $appointmentId)
                    ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                        $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
                    })
                    ->where('status', 'Approved')
                    ->first();

                if ($parentReq) {
                    $hospitalVaccine = HospitalVaccine::find($parentReq->hospital_vaccine_id);
                    $vaccineName = $hospitalVaccine ? $hospitalVaccine->vaccine_name : 'BCG';
                    $systemVaccine = Vaccine::whereRaw('LOWER(TRIM(vaccine_name)) = ?', [strtolower(trim($vaccineName))])->first()
                        ?? Vaccine::first();
                    $vaccinator = Vaccinator::where('hospital_id', $hospitalId)->where('status', 'Active')->first()
                        ?? Vaccinator::first();

                    $booking = Booking::create([
                        'parent_id' => $parentReq->parent_id,
                        'child_id' => $parentReq->child_id,
                        'hospital_id' => $hospitalId,
                        'vaccine_id' => $systemVaccine ? $systemVaccine->vaccine_id : 1,
                        'vaccinator_id' => $vaccinator ? $vaccinator->vaccinator_id : 1,
                        'booking_date' => $parentReq->request_date,
                        'booking_time' => $parentReq->preferred_time ?? '09:00:00',
                        'status' => 'Confirmed',
                    ]);
                }
            }

            if (!$booking) {
                return back()->with('message', 'The selected appointment was not found.')->with('messageType', 'error');
            }

            DB::beginTransaction();
            try {
                if ($result === 'Vaccinated') {
                    Vaccination::create([
                        'child_id' => $booking->child_id,
                        'vaccine_id' => $booking->vaccine_id,
                        'hospital_id' => $booking->hospital_id,
                        'vaccinator_id' => $booking->vaccinator_id,
                        'vaccination_date' => $booking->booking_date,
                        'vaccination_time' => $booking->booking_time,
                        'status' => 'Completed',
                        'notes' => $notes ?: 'Administered successfully',
                    ]);

                    $booking->update(['status' => 'Completed']);

                    Child::where('child_id', $booking->child_id)->update(['vaccination_status' => 'Up to Date']);

                    // Auto-decrement inventory stock
                    $bookingVaccine = Vaccine::find($booking->vaccine_id);
                    if ($bookingVaccine) {
                        $vacName = trim($bookingVaccine->vaccine_name);
                        $hVac = HospitalVaccine::whereIn('hospital_id', array_filter([$booking->hospital_id, $hospitalId, $hospitalUserId]))
                            ->where('vaccine_name', 'LIKE', $vacName)
                            ->first();

                        if (!$hVac) {
                            $shortName = trim(explode('(', $vacName)[0]);
                            $hVac = HospitalVaccine::whereIn('hospital_id', array_filter([$booking->hospital_id, $hospitalId, $hospitalUserId]))
                                ->where('vaccine_name', 'LIKE', "%{$shortName}%")
                                ->first();
                        }

                        if ($hVac && $hVac->stock_quantity > 0) {
                            $hVac->decrement('stock_quantity', 1);
                            if ($hVac->stock_quantity <= 0) {
                                $hVac->update(['availability' => 'Unavailable']);
                            }
                        }
                    }
                } else {
                    $booking->update(['status' => 'Cancelled']);
                }

                DB::commit();
                return back()->with('message', 'Vaccine status updated successfully!')->with('messageType', 'success');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->with('message', 'Unable to update status: ' . $e->getMessage())->with('messageType', 'error');
            }
        }

        // Get confirmed bookings
        $confirmedAppointments = Booking::with(['parent', 'child', 'vaccine', 'vaccinator'])
            ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
            })
            ->where('status', 'Confirmed')
            ->orderBy('booking_date', 'asc')
            ->get();

        // Also check approved parent requests that don't have a completed booking yet
        $approvedRequests = ParentRequest::with(['parent', 'child', 'hospitalVaccine'])
            ->where(function ($q) use ($hospitalId, $hospitalUserId) {
                $q->where('hospital_id', $hospitalId)->orWhere('hospital_id', $hospitalUserId);
            })
            ->where('status', 'Approved')
            ->orderBy('request_date', 'asc')
            ->get();

        $mergedList = collect();
        foreach ($confirmedAppointments as $b) {
            $mergedList->push($b);
        }

        $existingChildDates = $confirmedAppointments->map(function ($b) {
            return $b->child_id . '_' . $b->booking_date;
        })->toArray();

        foreach ($approvedRequests as $pr) {
            $key = $pr->child_id . '_' . ($pr->request_date ? (is_string($pr->request_date) ? $pr->request_date : $pr->request_date->format('Y-m-d')) : '');
            if (!in_array($key, $existingChildDates)) {
                // Synthesize an object compatible with the dropdown
                $pseudo = (object) [
                    'booking_id' => $pr->request_id,
                    'child' => $pr->child,
                    'vaccine' => (object) ['vaccine_name' => $pr->hospitalVaccine?->vaccine_name ?? 'Vaccination'],
                    'booking_date' => $pr->request_date,
                    'booking_time' => $pr->preferred_time ?? '09:00:00',
                    'vaccinator' => null,
                ];
                $mergedList->push($pseudo);
            }
        }

        $confirmedAppointments = $mergedList;

        return view('hospital.vaccine-status', compact('hospitalUser', 'hospital', 'confirmedAppointments'));
    }

    /**
     * Add / Manage vaccines for this hospital.
     */
    public function vaccines(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        // Edit mode
        $editVaccine = null;
        if ($request->has('edit')) {
            $editVaccine = HospitalVaccine::where('id', $request->query('edit'))->where('hospital_id', $hospitalId)->first();
        }

        $vaccines = HospitalVaccine::where('hospital_id', $hospitalId)->orderBy('vaccine_name')->get();

        return view('hospital.add-vaccine', compact('hospitalUser', 'hospital', 'vaccines', 'editVaccine'));
    }

    /**
     * Store vaccine for hospital.
     */
    public function storeVaccine(Request $request)
    {
        if ($request->has('update_vaccine')) {
            return $this->updateVaccine($request);
        }
        if ($request->has('delete_vaccine')) {
            return $this->destroyVaccine($request);
        }

        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        $request->validate([
            'vaccine_name' => 'required|string|max:150',
            'availability' => 'required|in:Available,Unavailable',
            'description' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'low_stock_threshold' => 'nullable|integer|min:1',
        ]);

        $exists = HospitalVaccine::where('hospital_id', $hospitalId)
            ->whereRaw('LOWER(vaccine_name) = ?', [strtolower(trim($request->input('vaccine_name')))])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('message', 'This vaccine has already been added to your hospital.')->with('messageType', 'error');
        }

        $stock = $request->filled('stock_quantity') ? (int) $request->input('stock_quantity') : 50;
        $availability = $stock <= 0 ? 'Unavailable' : $request->input('availability');

        HospitalVaccine::create([
            'hospital_id' => $hospitalId,
            'vaccine_name' => trim($request->input('vaccine_name')),
            'description' => trim($request->input('description', '')),
            'availability' => $availability,
            'stock_quantity' => $stock,
            'batch_number' => trim($request->input('batch_number', 'BATCH-' . strtoupper(Str::random(6)))),
            'expiry_date' => $request->input('expiry_date'),
            'low_stock_threshold' => $request->filled('low_stock_threshold') ? (int) $request->input('low_stock_threshold') : 10,
        ]);

        return redirect()->route('hospital.add-vaccine')->with('message', 'Vaccine added to inventory successfully.')->with('messageType', 'success');
    }

    /**
     * Update vaccine for hospital.
     */
    public function updateVaccine(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        $vaccineId = (int) $request->input('vaccine_id');
        $vaccine = HospitalVaccine::where('id', $vaccineId)->where('hospital_id', $hospitalId)->firstOrFail();

        $request->validate([
            'vaccine_name' => 'required|string|max:150',
            'availability' => 'required|in:Available,Unavailable',
            'description' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'low_stock_threshold' => 'nullable|integer|min:1',
        ]);

        $exists = HospitalVaccine::where('hospital_id', $hospitalId)
            ->where('id', '!=', $vaccineId)
            ->whereRaw('LOWER(vaccine_name) = ?', [strtolower(trim($request->input('vaccine_name')))])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('message', 'Another vaccine with this name already exists.')->with('messageType', 'error');
        }

        $stock = $request->filled('stock_quantity') ? (int) $request->input('stock_quantity') : $vaccine->stock_quantity;
        $availability = $stock <= 0 ? 'Unavailable' : $request->input('availability');

        $vaccine->update([
            'vaccine_name' => trim($request->input('vaccine_name')),
            'description' => trim($request->input('description', '')),
            'availability' => $availability,
            'stock_quantity' => $stock,
            'batch_number' => $request->filled('batch_number') ? trim($request->input('batch_number')) : $vaccine->batch_number,
            'expiry_date' => $request->input('expiry_date') ?: $vaccine->expiry_date,
            'low_stock_threshold' => $request->filled('low_stock_threshold') ? (int) $request->input('low_stock_threshold') : $vaccine->low_stock_threshold,
        ]);

        return redirect()->route('hospital.add-vaccine')->with('message', 'Vaccine inventory updated successfully.')->with('messageType', 'success');
    }

    /**
     * Delete vaccine for hospital.
     */
    public function destroyVaccine(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        $vaccineId = (int) $request->input('vaccine_id');
        $vaccine = HospitalVaccine::where('id', $vaccineId)->where('hospital_id', $hospitalId)->firstOrFail();
        $vaccine->delete();

        return redirect()->route('hospital.add-vaccine')->with('message', 'Vaccine deleted successfully.')->with('messageType', 'success');
    }

    /**
     * View all hospital vaccines list.
     */
    public function allVaccines()
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        $vaccines = HospitalVaccine::where('hospital_id', $hospitalId)->orderBy('vaccine_name')->get();
        $totalVaccines = $vaccines->count();
        $availableVaccines = $vaccines->where('availability', 'Available')->count();
        $unavailableVaccines = $vaccines->where('availability', 'Unavailable')->count();

        return view('hospital.all-vaccines', compact(
            'hospitalUser',
            'hospital',
            'vaccines',
            'totalVaccines',
            'availableVaccines',
            'unavailableVaccines'
        ));
    }

    /**
     * Vaccinators list and management for hospital.
     */
    public function vaccinators(Request $request)
    {
        [$hospitalUser, $hospital] = $this->getHospitalContext();
        $hospitalId = $hospital ? $hospital->hospital_id : ($hospitalUser ? $hospitalUser->id : 0);

        // Handle Add Vaccinator
        if ($request->isMethod('post') && $request->has('add_vaccinator')) {
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'qualification' => 'required|string|max:150',
                'phone' => 'required|string|max:30',
            ]);

            $email = trim($request->input('email'));

            // Check if user exists
            $user = User::whereRaw('LOWER(TRIM(email)) = ?', [strtolower($email)])->first();
            if (!$user) {
                $user = User::create([
                    'name' => trim($request->input('name')),
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'vaccinator',
                    'status' => 'active',
                ]);
            }

            $alreadyVaccinator = Vaccinator::where('user_id', $user->user_id)->exists();
            if ($alreadyVaccinator) {
                return back()->with('errorMessage', 'This email is already registered as a vaccinator.');
            }

            Vaccinator::create([
                'user_id' => $user->user_id,
                'hospital_id' => $hospitalId,
                'name' => trim($request->input('name')),
                'qualification' => trim($request->input('qualification')),
                'phone' => trim($request->input('phone')),
                'status' => 'Active',
            ]);

            return back()->with('successMessage', 'Vaccinator added successfully.');
        }

        // Handle toggle status
        if ($request->isMethod('post') && $request->has('change_status')) {
            $vaccinatorId = (int) $request->input('vaccinator_id');
            $newStatus = $request->input('status') === 'Active' ? 'Active' : 'Inactive';

            Vaccinator::where('vaccinator_id', $vaccinatorId)
                ->where('hospital_id', $hospitalId)
                ->update(['status' => $newStatus]);

            return back()->with('successMessage', 'Vaccinator status updated.');
        }

        $vaccinators = Vaccinator::where('hospital_id', $hospitalId)->get();

        return view('hospital.vaccinators', compact('hospitalUser', 'hospital', 'vaccinators'));
    }
}
