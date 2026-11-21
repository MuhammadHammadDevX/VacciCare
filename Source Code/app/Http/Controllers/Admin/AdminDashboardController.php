<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalVaccine;
use App\Models\ParentModel;
use App\Models\ParentRequest;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    /**
     * Show dedicated Admin Login page.
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Process Admin Login.
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required',
        ], [
            'admin_email.required' => 'Please enter your email.',
            'admin_password.required' => 'Please enter your password.',
        ]);

        $email = trim($request->input('admin_email'));
        $password = $request->input('admin_password');
        $remember = $request->boolean('remember');

        $user = User::where('email', $email)
            ->where('role', 'admin')
            ->where('status', 'active')
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            $request->session()->regenerate();
            Auth::guard('web')->login($user, $remember);

            session([
                'user_id' => $user->user_id,
                'admin_id' => $user->user_id,
                'name' => $user->name,
                'admin_name' => $user->name,
                'email' => $user->email,
                'admin_email' => $user->email,
                'role' => 'admin',
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withInput($request->only('admin_email'))->with('loginError', 'Admin account not found or invalid credentials.');
    }

    /**
     * Show Create Admin Account (first admin only).
     */
    public function showCreateAdmin()
    {
        $adminExists = false;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                $adminExists = User::where('role', 'admin')->exists();
            }
        } catch (\Throwable $e) {
            $adminExists = false;
        }
        return view('admin.create-admin', compact('adminExists'));
    }

    /**
     * Store first Admin Account.
     */
    public function postCreateAdmin(Request $request)
    {
        $adminExists = false;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                $adminExists = User::where('role', 'admin')->exists();
            }
        } catch (\Throwable $e) {
            $adminExists = false;
        }
        if ($adminExists) {
            return redirect()->route('admin.login')->with('info', 'An administrator account already exists.');
        }

        $request->validate([
            'admin_name' => 'required|string|max:100',
            'admin_email' => 'required|email|max:150|unique:users,email',
            'admin_password' => 'required|string|min:8',
            'confirm_password' => 'required|same:admin_password',
        ], [
            'admin_name.required' => 'Please enter admin name.',
            'admin_email.required' => 'Please enter admin email.',
            'admin_password.min' => 'Password must contain at least 8 characters.',
            'confirm_password.same' => 'Passwords do not match.',
        ]);

        User::create([
            'name' => trim($request->input('admin_name')),
            'email' => trim($request->input('admin_email')),
            'password' => Hash::make($request->input('admin_password')),
            'role' => 'admin',
            'status' => 'active',
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin account created successfully. Please sign in.');
    }

    /**
     * Admin main dashboard.
     */
    public function dashboard(Request $request)
    {
        $admin = Auth::guard('web')->user() ?? User::where('role', 'admin')->first();

        // Handle quick approve/reject from dashboard
        if ($request->isMethod('post') && $request->has('request_id')) {
            $requestId = (int) $request->input('request_id');
            $action = strtolower($request->input('action'));

            if (in_array($action, ['approved', 'rejected'])) {
                $status = ucfirst($action);
                $updated = ParentRequest::where('request_id', $requestId)
                    ->where('status', 'Pending')
                    ->update([
                        'status' => $status,
                        'reviewed_by' => $admin ? $admin->user_id : null,
                        'reviewed_at' => now(),
                    ]);

                if ($updated) {
                    return back()->with('requestMessage', "Parent request has been {$action} successfully.")
                        ->with('requestMessageType', 'success');
                }
            }
        }

        $totalChildren = Child::count();
        $totalVaccinations = Vaccination::where('status', 'Completed')->count();
        $totalHospitals = Hospital::count();
        $pendingRequests = ParentRequest::where('status', 'Pending')->count();
        $availableVaccines = HospitalVaccine::where('availability', 'Available')->count();
        $todaysVaccinations = ParentRequest::where('request_type', 'Vaccination')
            ->where('status', 'Approved')
            ->where('request_date', now()->toDateString())
            ->count();

        $stats = [
            ['title' => 'Total Children', 'value' => number_format($totalChildren), 'label' => 'Registered children', 'icon' => 'bi-people-fill', 'class' => 'blue'],
            ['title' => 'Total Vaccinations', 'value' => number_format($totalVaccinations), 'label' => 'Completed records', 'icon' => 'bi-shield-check', 'class' => 'green'],
            ['title' => 'Total Hospitals', 'value' => number_format($totalHospitals), 'label' => 'Registered hospitals', 'icon' => 'bi-hospital-fill', 'class' => 'purple'],
            ['title' => 'Parent Requests', 'value' => number_format($pendingRequests), 'label' => 'Awaiting review', 'icon' => 'bi-person-lines-fill', 'class' => 'orange'],
            ['title' => 'Available Vaccines', 'value' => number_format($availableVaccines), 'label' => 'Currently available', 'icon' => 'bi-capsule-pill', 'class' => 'cyan'],
            ['title' => "Today's Vaccinations", 'value' => number_format($todaysVaccinations), 'label' => 'Scheduled today', 'icon' => 'bi-calendar2-check-fill', 'class' => 'pink'],
        ];

        // Monthly chart data
        $currentYear = (int) date('Y');
        $previousYear = $currentYear - 1;

        $currentYearData = array_fill(1, 12, 0);
        $previousYearData = array_fill(1, 12, 0);

        $driver = DB::connection()->getDriverName();
        $monthSql = $driver === 'sqlite' ? "CAST(strftime('%m', vaccination_date) AS INTEGER)" : 'MONTH(vaccination_date)';

        $currRows = DB::table('vaccinations')
            ->selectRaw("{$monthSql} as m, COUNT(*) as c")
            ->whereYear('vaccination_date', $currentYear)
            ->where('status', 'Completed')
            ->groupBy('m')
            ->get();

        foreach ($currRows as $r) {
            $currentYearData[(int) $r->m] = (int) $r->c;
        }

        $prevRows = DB::table('vaccinations')
            ->selectRaw("{$monthSql} as m, COUNT(*) as c")
            ->whereYear('vaccination_date', $previousYear)
            ->where('status', 'Completed')
            ->groupBy('m')
            ->get();

        foreach ($prevRows as $r) {
            $previousYearData[(int) $r->m] = (int) $r->c;
        }

        $currentYearData = array_values($currentYearData);
        $previousYearData = array_values($previousYearData);

        // Recent vaccinations
        $recentVaccinations = Vaccination::with(['child', 'vaccine', 'hospital'])
            ->orderBy('vaccination_date', 'desc')
            ->orderBy('vaccination_time', 'desc')
            ->limit(4)
            ->get();

        // Recent parent requests (pending, limit 3 like original)
        $parentRequests = ParentRequest::with(['child', 'parent'])
            ->where('status', 'Pending')
            ->orderBy('request_id', 'desc')
            ->limit(3)
            ->get();

        // Hospital overview (limit 4, order by created_at DESC like original)
        $hospitalOverview = DB::table('hospitals as h')
            ->select('h.hospital_id', 'h.hospital_name', 'h.city', 'h.status',
                DB::raw('(SELECT COUNT(*) FROM vaccinations vax WHERE vax.hospital_id = h.hospital_id) AS vaccination_count'))
            ->orderBy('h.created_at', 'desc')
            ->orderBy('h.hospital_id', 'desc')
            ->limit(4)
            ->get();

        return view('admin.dashboard', compact(
            'admin',
            'stats',
            'currentYear',
            'previousYear',
            'currentYearData',
            'previousYearData',
            'recentVaccinations',
            'parentRequests',
            'pendingRequests',
            'hospitalOverview'
        ));
    }

    /**
     * Admin Profile.
     */
    public function profile()
    {
        $admin = Auth::guard('web')->user() ?? User::where('role', 'admin')->first();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Edit Admin Profile.
     */
    public function editProfile()
    {
        $admin = Auth::guard('web')->user() ?? User::where('role', 'admin')->first();
        return view('admin.edit-profile', compact('admin'));
    }

    /**
     * Update Admin Profile.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('web')->user() ?? User::where('role', 'admin')->firstOrFail();

        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $admin->user_id . ',user_id',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'nullable|same:new_password',
        ], [
            'name.required' => 'Please enter admin name.',
            'email.required' => 'Please enter admin email.',
            'new_password.min' => 'New password must contain at least 6 characters.',
            'confirm_password.same' => 'New password and confirm password do not match.',
        ]);

        if ($request->filled('new_password')) {
            if (!$request->filled('current_password') || !Hash::check($request->input('current_password'), $admin->password)) {
                return back()->withInput()->with('errorMessage', 'Current password is incorrect.');
            }
            $admin->password = Hash::make($request->input('new_password'));
        }

        $admin->name = trim($request->input('name'));
        $admin->email = trim($request->input('email'));
        $admin->save();

        session([
            'name' => $admin->name,
            'admin_name' => $admin->name,
            'email' => $admin->email,
            'admin_email' => $admin->email,
        ]);

        return redirect()->route('admin.profile')->with('successMessage', 'Admin profile updated successfully.');
    }

    /**
     * Children list.
     */
    public function children()
    {
        $children = Child::with(['parent.user'])->orderBy('child_id', 'desc')->get();
        $totalChildren = $children->count();
        $upToDateCount = $children->where('vaccination_status', 'Up to Date')->count();
        $pendingCount = $children->where('vaccination_status', 'Pending')->count();
        $partiallyVaccinatedCount = $children->where('vaccination_status', 'Partially Vaccinated')->count();
        $parents = ParentModel::with('user')->get();

        return view('admin.children', compact(
            'children',
            'totalChildren',
            'upToDateCount',
            'pendingCount',
            'partiallyVaccinatedCount',
            'parents'
        ));
    }

    /**
     * Store new child registered by Admin.
     */
    public function storeChild(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,parent_id',
            'child_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:5',
            'contact' => 'nullable|string|max:30',
            'additional_notes' => 'nullable|string',
            'vaccination_status' => 'required|in:Up to Date,Pending,Partially Vaccinated',
        ]);

        Child::create([
            'parent_id' => $request->parent_id,
            'child_name' => $request->child_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'contact' => $request->contact,
            'additional_notes' => $request->additional_notes,
            'vaccination_status' => $request->vaccination_status,
        ]);

        return redirect()->route('admin.children')->with('success', 'Child record created successfully.');
    }

    /**
     * Update child by Admin.
     */
    public function updateChild(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'required|exists:parents,parent_id',
            'child_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:5',
            'contact' => 'nullable|string|max:30',
            'additional_notes' => 'nullable|string',
            'vaccination_status' => 'required|in:Up to Date,Pending,Partially Vaccinated',
        ]);

        $child = Child::findOrFail($id);
        $child->update([
            'parent_id' => $request->parent_id,
            'child_name' => $request->child_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'contact' => $request->contact,
            'additional_notes' => $request->additional_notes,
            'vaccination_status' => $request->vaccination_status,
        ]);

        return redirect()->back()->with('success', 'Child record updated successfully.');
    }

    /**
     * Delete child by Admin.
     */
    public function destroyChild($id)
    {
        $child = Child::findOrFail($id);
        $child->delete();

        return redirect()->route('admin.children')->with('success', 'Child record removed successfully.');
    }

    /**
     * Child Details.
     */
    public function childDetails($id)
    {
        $child = Child::with(['parent.user', 'vaccinations.vaccine', 'vaccinations.hospital'])
            ->where('child_id', $id)
            ->firstOrFail();

        $parents = ParentModel::with('user')->get();

        return view('admin.child-details', compact('child', 'parents'));
    }

    /**
     * Hospital list.
     */
    public function hospitals()
    {
        $hospitals = Hospital::orderBy('hospital_id', 'desc')->get();
        $totalHospitals = $hospitals->count();
        $activeHospitals = $hospitals->where('status', 'Active')->count();
        $inactiveHospitals = $hospitals->where('status', 'Inactive')->count();

        return view('admin.hospital-list', compact(
            'hospitals',
            'totalHospitals',
            'activeHospitals',
            'inactiveHospitals'
        ));
    }

    /**
     * Add Hospital Form.
     */
    public function createHospital()
    {
        $hospitals = Hospital::orderBy('hospital_id', 'desc')->get();
        return view('admin.add-hospital', compact('hospitals'));
    }

    /**
     * Store new Hospital.
     */
    public function storeHospital(Request $request)
    {
        $adminId = Auth::guard('web')->id() ?? session('user_id', 13);

        $request->validate([
            'hospital_name' => 'required|string|max:150',
            'hospital_type' => 'required|string|max:100',
            'license_no' => 'required|string|max:100|unique:hospitals,license_no',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contact_person' => 'nullable|string|max:100',
            'working_hours' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ], [
            'license_no.unique' => 'This license number is already registered.',
        ]);

        Hospital::create([
            'user_id' => $adminId,
            'hospital_name' => trim($request->input('hospital_name')),
            'hospital_type' => trim($request->input('hospital_type')),
            'license_no' => trim($request->input('license_no')),
            'email' => trim($request->input('email')),
            'phone' => trim($request->input('phone')),
            'city' => trim($request->input('city')),
            'address' => trim($request->input('address')),
            'latitude' => $request->filled('latitude') ? (float)$request->input('latitude') : 24.8924,
            'longitude' => $request->filled('longitude') ? (float)$request->input('longitude') : 67.0739,
            'contact_person' => trim($request->input('contact_person', '')),
            'working_hours' => trim($request->input('working_hours', '24 Hours')),
            'status' => $request->input('status', 'Active'),
        ]);

        return redirect()->route('admin.add-hospital')->with('success', 'Hospital added successfully.');
    }

    /**
     * View Hospital details.
     */
    public function showHospital($id)
    {
        $hospital = Hospital::where('hospital_id', $id)->firstOrFail();
        return view('admin.view-hospital', compact('hospital'));
    }

    /**
     * Edit Hospital form.
     */
    public function editHospital($id)
    {
        $hospital = Hospital::where('hospital_id', $id)->firstOrFail();
        return view('admin.edit-hospital', compact('hospital'));
    }

    /**
     * Update Hospital.
     */
    public function updateHospital(Request $request, $id)
    {
        $hospital = Hospital::where('hospital_id', $id)->firstOrFail();

        $request->validate([
            'hospital_name' => 'required|string|max:150',
            'hospital_type' => 'required|string|max:100',
            'license_no' => 'required|string|max:100|unique:hospitals,license_no,' . $hospital->hospital_id . ',hospital_id',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'contact_person' => 'nullable|string|max:100',
            'working_hours' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        $hospital->update([
            'hospital_name' => trim($request->input('hospital_name')),
            'hospital_type' => trim($request->input('hospital_type')),
            'license_no' => trim($request->input('license_no')),
            'email' => trim($request->input('email')),
            'phone' => trim($request->input('phone')),
            'city' => trim($request->input('city')),
            'address' => trim($request->input('address')),
            'latitude' => $request->filled('latitude') ? (float)$request->input('latitude') : $hospital->latitude,
            'longitude' => $request->filled('longitude') ? (float)$request->input('longitude') : $hospital->longitude,
            'contact_person' => trim($request->input('contact_person', '')),
            'working_hours' => trim($request->input('working_hours', '24 Hours')),
            'status' => $request->input('status', 'Active'),
        ]);

        return redirect()->route('admin.hospital-list')->with('success', 'Hospital updated successfully.');
    }

    /**
     * Delete Hospital.
     */
    public function destroyHospital(Request $request, $id = null)
    {
        $hospitalId = $id ?? $request->input('hospital_id');
        $hospital = Hospital::where('hospital_id', $hospitalId)->firstOrFail();
        $hospital->delete();

        return redirect()->route('admin.hospital-list')->with('deleted', '1');
    }

    /**
     * Vaccine List.
     */
    public function vaccines()
    {
        $vaccines = HospitalVaccine::with('hospital')
            ->orderBy('created_at', 'desc')
            ->orderBy('vaccine_name', 'asc')
            ->get();

        $totalVaccines = $vaccines->count();
        $availableVaccines = $vaccines->where('availability', 'Available')->count();
        $unavailableVaccines = $vaccines->where('availability', 'Unavailable')->count();
        $hospitals = Hospital::orderBy('hospital_name')->get();

        return view('admin.vaccine-list', compact(
            'vaccines',
            'totalVaccines',
            'availableVaccines',
            'unavailableVaccines',
            'hospitals'
        ));
    }

    /**
     * Store new vaccine in hospital inventory by Admin.
     */
    public function storeVaccine(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,hospital_id',
            'vaccine_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        HospitalVaccine::create([
            'hospital_id' => $request->hospital_id,
            'vaccine_name' => $request->vaccine_name,
            'description' => $request->description,
            'availability' => $request->availability,
        ]);

        Vaccine::firstOrCreate(
            ['vaccine_name' => $request->vaccine_name],
            ['description' => $request->description]
        );

        return redirect()->route('admin.vaccine-list')->with('success', 'Vaccine added to hospital inventory successfully.');
    }

    /**
     * Update hospital vaccine by Admin.
     */
    public function updateVaccine(Request $request, $id)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,hospital_id',
            'vaccine_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        $vaccine = HospitalVaccine::findOrFail($id);
        $vaccine->update([
            'hospital_id' => $request->hospital_id,
            'vaccine_name' => $request->vaccine_name,
            'description' => $request->description,
            'availability' => $request->availability,
        ]);

        return redirect()->route('admin.vaccine-list')->with('success', 'Vaccine updated successfully.');
    }

    /**
     * Delete vaccine by Admin.
     */
    public function destroyVaccine($id)
    {
        $vaccine = HospitalVaccine::findOrFail($id);
        $vaccine->delete();

        return redirect()->route('admin.vaccine-list')->with('success', 'Vaccine deleted from hospital inventory.');
    }

    /**
     * Parent Requests.
     */
    public function parentRequests()
    {
        $requests = ParentRequest::with(['parent', 'child', 'hospital', 'hospitalVaccine'])
            ->orderBy('request_id', 'desc')
            ->get();

        $totalRequests = $requests->count();
        $pendingRequests = $requests->where('status', 'Pending')->count();
        $approvedRequests = $requests->where('status', 'Approved')->count();
        $rejectedRequests = $requests->where('status', 'Rejected')->count();

        return view('admin.parent-requests', compact(
            'requests',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests'
        ));
    }

    /**
     * Process Parent Request (approve / reject).
     */
    public function processParentRequest(Request $request)
    {
        $adminId = Auth::guard('web')->id() ?? session('user_id');

        $request->validate([
            'request_id' => 'required|integer',
            'action' => 'required|in:approve,reject,approved,rejected',
        ]);

        $requestId = (int) $request->input('request_id');
        $action = str_starts_with($request->input('action'), 'app') ? 'Approved' : 'Rejected';

        $parentRequest = ParentRequest::where('request_id', $requestId)
            ->where('status', 'Pending')
            ->first();

        if (!$parentRequest) {
            return back()->with('message', 'This request is no longer pending or not found.')
                ->with('message_type', 'warning');
        }

        $parentRequest->update([
            'status' => $action,
            'reviewed_by' => $adminId,
            'reviewed_at' => now(),
        ]);

        return back()->with('message', "Request has been {$action} successfully.")
            ->with('message_type', 'success');
    }

    /**
     * Booking Details.
     */
    public function bookingDetails()
    {
        $requests = ParentRequest::with(['child', 'hospital', 'hospitalVaccine'])
            ->where('status', 'Approved')
            ->get();

        $directBookings = Booking::with(['child', 'hospital', 'vaccine'])
            ->whereIn('status', ['Confirmed', 'Completed'])
            ->get();

        $merged = collect();
        foreach ($requests as $r) {
            $merged->push((object) [
                'request_id' => $r->request_id,
                'child' => $r->child,
                'child_id' => $r->child_id,
                'hospital' => $r->hospital,
                'hospitalVaccine' => (object) ['vaccine_name' => $r->hospitalVaccine?->vaccine_name ?? 'Vaccine'],
                'request_date' => $r->request_date,
                'preferred_time' => $r->preferred_time,
                'status' => 'Approved',
            ]);
        }

        foreach ($directBookings as $b) {
            $merged->push((object) [
                'request_id' => $b->booking_id,
                'child' => $b->child,
                'child_id' => $b->child_id,
                'hospital' => $b->hospital,
                'hospitalVaccine' => (object) ['vaccine_name' => $b->vaccine?->vaccine_name ?? 'Vaccine'],
                'request_date' => $b->booking_date,
                'preferred_time' => $b->booking_time,
                'status' => $b->status,
            ]);
        }

        $bookings = $merged->sortByDesc(function ($item) {
            $d = $item->request_date ? (is_string($item->request_date) ? $item->request_date : $item->request_date->format('Y-m-d')) : '';
            return $d . '_' . ($item->preferred_time ?? '');
        })->values();

        $totalBookings = $bookings->count();

        return view('admin.booking-details', compact('bookings', 'totalBookings'));
    }

    /**
     * Vaccination Schedule by Date & Time.
     */
    public function vaccinationsDate()
    {
        $requests = ParentRequest::with(['child.parent.user', 'hospital', 'hospitalVaccine'])
            ->where('status', 'Approved')
            ->get();

        $bookings = Booking::with(['child.parent.user', 'hospital', 'vaccine'])
            ->whereIn('status', ['Confirmed', 'Pending'])
            ->get();

        $merged = collect();
        foreach ($requests as $r) {
            $merged->push((object) [
                'id' => $r->request_id,
                'child' => $r->child,
                'child_id' => $r->child_id,
                'hospital' => $r->hospital,
                'vaccine_name' => $r->hospitalVaccine?->vaccine_name ?? 'Vaccine',
                'request_date' => $r->request_date,
                'preferred_time' => $r->preferred_time,
                'status' => $r->status,
                'source' => 'Request',
            ]);
        }

        foreach ($bookings as $b) {
            $merged->push((object) [
                'id' => $b->booking_id,
                'child' => $b->child,
                'child_id' => $b->child_id,
                'hospital' => $b->hospital,
                'vaccine_name' => $b->vaccine?->vaccine_name ?? 'Vaccine',
                'request_date' => $b->booking_date,
                'preferred_time' => $b->booking_time,
                'status' => $b->status,
                'source' => 'Booking',
            ]);
        }

        $vaccinations = $merged->sortBy(function ($item) {
            $d = $item->request_date ? (is_string($item->request_date) ? $item->request_date : $item->request_date->format('Y-m-d')) : '9999-99-99';
            return $d . '_' . ($item->preferred_time ?? '00:00:00');
        })->values();

        $children = Child::with('parent.user')->orderBy('child_name')->get();
        $hospitals = Hospital::where('status', 'Active')->orderBy('hospital_name')->get();
        $hospitalVaccines = HospitalVaccine::where('availability', 'Available')->orderBy('vaccine_name')->get();

        return view('admin.vaccinations-date', compact('vaccinations', 'children', 'hospitals', 'hospitalVaccines'));
    }

    /**
     * Store a directly scheduled vaccination appointment by Admin.
     */
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,child_id',
            'hospital_id' => 'required|exists:hospitals,hospital_id',
            'hospital_vaccine_id' => 'required|exists:hospital_vaccines,id',
            'request_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
        ]);

        $child = Child::findOrFail($request->child_id);

        ParentRequest::create([
            'parent_id' => $child->parent_id,
            'child_id' => $request->child_id,
            'hospital_id' => $request->hospital_id,
            'hospital_vaccine_id' => $request->hospital_vaccine_id,
            'request_type' => 'Appointment Request',
            'request_date' => $request->request_date,
            'preferred_time' => $request->preferred_time,
            'message' => 'Directly scheduled by Admin.',
            'status' => 'Approved',
            'reviewed_by' => Auth::guard('web')->id() ?? session('user_id'),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.vaccinations-date')->with('success', 'Vaccination appointment scheduled successfully.');
    }

    /**
     * Vaccination Reports (child, date, vaccine wise).
     */
    public function vaccinationReport(Request $request)
    {
        $selectedVaccine = trim($request->query('vaccine', ''));
        $selectedDate = trim($request->query('date', ''));

        $vaccineList = Vaccine::orderBy('vaccine_name')->get();

        $query = Vaccination::with(['child.parent', 'vaccine', 'hospital']);

        if ($selectedVaccine !== '') {
            $query->whereHas('vaccine', function ($q) use ($selectedVaccine) {
                $q->where('vaccine_name', $selectedVaccine);
            });
        }

        if ($selectedDate !== '') {
            $query->whereDate('vaccination_date', $selectedDate);
        }

        $childReports = $query->orderBy('vaccination_date', 'desc')->get();

        // Date-wise grouping
        $dateSummary = Vaccination::selectRaw('vaccination_date, COUNT(*) as total, SUM(CASE WHEN status = "Completed" THEN 1 ELSE 0 END) as completed, SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending')
            ->groupBy('vaccination_date')
            ->orderBy('vaccination_date', 'desc')
            ->get();

        // Vaccine-wise summary
        $vaccineSummary = Vaccine::withCount(['vaccinations as total_given'])->get();
        foreach ($vaccineSummary as $vac) {
            $vac->available = HospitalVaccine::whereRaw('LOWER(TRIM(vaccine_name)) = ?', [strtolower(trim($vac->vaccine_name))])
                ->where('availability', 'Available')
                ->count();
            $vac->unavailable = HospitalVaccine::whereRaw('LOWER(TRIM(vaccine_name)) = ?', [strtolower(trim($vac->vaccine_name))])
                ->where('availability', 'Unavailable')
                ->count();
        }

        $totalRecords = $childReports->count();
        $completedRecords = $childReports->where('status', 'Completed')->count();
        $pendingRecords = $childReports->where('status', 'Pending')->count();
        $cancelledRecords = $childReports->where('status', 'Cancelled')->count();

        $reportDate = $selectedDate ? date('d M Y', strtotime($selectedDate)) : date('d M Y');

        return view('admin.vaccination-report', compact(
            'childReports',
            'dateSummary',
            'vaccineSummary',
            'vaccineList',
            'selectedVaccine',
            'selectedDate',
            'totalRecords',
            'completedRecords',
            'pendingRecords',
            'cancelledRecords',
            'reportDate'
        ));
    }

    /**
     * Export Vaccinations Report (CSV/Excel).
     */
    public function exportVaccinations(Request $request)
    {
        $filename = 'VacciCare_Vaccinations_Report_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Record ID',
                'Child ID',
                'Child Name',
                'Gender',
                'Date of Birth',
                'Parent Name',
                'Parent Phone',
                'Vaccine Name',
                'Healthcare Facility',
                'City',
                'Vaccinator',
                'Date Administered',
                'Time Administered',
                'Status',
                'Notes'
            ]);

            Vaccination::with(['child.parent.user', 'vaccine', 'hospital', 'vaccinator'])
                ->orderBy('vaccination_date', 'desc')
                ->chunk(100, function ($records) use ($handle) {
                    foreach ($records as $r) {
                        $parent = $r->child?->parent;
                        fputcsv($handle, [
                            $r->vaccination_id,
                            $r->child_id,
                            $r->child?->child_name ?? 'N/A',
                            $r->child?->gender ?? 'N/A',
                            $r->child?->date_of_birth ? date('Y-m-d', strtotime($r->child->date_of_birth)) : 'N/A',
                            $parent?->user?->name ?? ($parent?->parent_name ?? 'N/A'),
                            $r->child?->contact ?: ($parent?->phone ?: 'N/A'),
                            $r->vaccine?->vaccine_name ?? 'Vaccine',
                            $r->hospital?->hospital_name ?? 'Facility',
                            $r->hospital?->city ?? 'N/A',
                            $r->vaccinator?->vaccinator_name ?? 'Authorized Vaccinator',
                            $r->vaccination_date ? date('Y-m-d', strtotime($r->vaccination_date)) : 'N/A',
                            $r->vaccination_time ?: 'N/A',
                            $r->status,
                            $r->notes ?: 'None'
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Registered Children (CSV/Excel).
     */
    public function exportChildren(Request $request)
    {
        $filename = 'VacciCare_Children_Registry_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Child ID',
                'Child Name',
                'Date of Birth',
                'Age',
                'Gender',
                'Blood Group',
                'Emergency Contact',
                'Parent Name',
                'Parent Email',
                'Parent Phone',
                'Immunization Status',
                'Completed Doses',
                'Registered Date'
            ]);

            Child::with(['parent.user'])
                ->withCount(['vaccinations as completed_doses' => function ($q) {
                    $q->where('status', 'Completed');
                }])
                ->orderBy('child_id', 'desc')
                ->chunk(100, function ($children) use ($handle) {
                    foreach ($children as $c) {
                        $parent = $c->parent;
                        fputcsv($handle, [
                            $c->child_id,
                            $c->child_name,
                            $c->date_of_birth,
                            $c->age,
                            $c->gender,
                            $c->blood_group ?: 'N/A',
                            $c->contact ?: 'N/A',
                            $parent?->user?->name ?? ($parent?->parent_name ?? 'N/A'),
                            $parent?->user?->email ?? 'N/A',
                            $parent?->phone ?: 'N/A',
                            $c->vaccination_status,
                            $c->completed_doses,
                            $c->created_at ? $c->created_at->format('Y-m-d') : 'N/A'
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Hospitals & Inventory Directory (CSV/Excel).
     */
    public function exportHospitals(Request $request)
    {
        $filename = 'VacciCare_Hospitals_Directory_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Hospital ID',
                'Hospital Name',
                'Type',
                'License No',
                'City',
                'Address',
                'Latitude',
                'Longitude',
                'Phone',
                'Email',
                'Working Hours',
                'Status',
                'Total Vaccine Stock (Vials)',
                'Registered Vaccinators'
            ]);

            Hospital::with(['hospitalVaccines', 'vaccinators'])
                ->orderBy('city')
                ->orderBy('hospital_name')
                ->chunk(50, function ($hospitals) use ($handle) {
                    foreach ($hospitals as $h) {
                        $totalStock = $h->hospitalVaccines->sum('stock_quantity');
                        fputcsv($handle, [
                            $h->hospital_id,
                            $h->hospital_name,
                            $h->hospital_type,
                            $h->license_no,
                            $h->city,
                            $h->address,
                            $h->latitude,
                            $h->longitude,
                            $h->phone,
                            $h->email,
                            $h->working_hours,
                            $h->status,
                            $totalStock,
                            $h->vaccinators->count()
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export Bookings & Appointment Requests (CSV/Excel).
     */
    public function exportBookings(Request $request)
    {
        $filename = 'VacciCare_Bookings_Report_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Booking ID',
                'Child Name',
                'Parent Name',
                'Parent Phone',
                'Hospital Name',
                'City',
                'Vaccine Name',
                'Scheduled Date',
                'Scheduled Time',
                'Status',
                'Created At'
            ]);

            Booking::with(['child', 'parent.user', 'hospital', 'vaccine'])
                ->orderBy('booking_date', 'desc')
                ->chunk(100, function ($bookings) use ($handle) {
                    foreach ($bookings as $b) {
                        $parent = $b->parent;
                        fputcsv($handle, [
                            $b->booking_id,
                            $b->child?->child_name ?? 'N/A',
                            $parent?->user?->name ?? ($parent?->parent_name ?? 'N/A'),
                            $parent?->phone ?: 'N/A',
                            $b->hospital?->hospital_name ?? 'N/A',
                            $b->hospital?->city ?? 'N/A',
                            $b->vaccine?->vaccine_name ?? 'N/A',
                            $b->booking_date,
                            $b->booking_time,
                            $b->status,
                            $b->created_at ? $b->created_at->format('Y-m-d') : 'N/A'
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
