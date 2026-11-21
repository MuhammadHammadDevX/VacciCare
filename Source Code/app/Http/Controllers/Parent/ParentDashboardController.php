<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalVaccine;
use App\Models\ParentModel;
use App\Models\ParentRequest;
use App\Models\Vaccination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ParentDashboardController extends Controller
{
    /**
     * Get the logged-in parent model.
     */
    protected function getParent(): ParentModel
    {
        $userId = Auth::guard('web')->id() ?? session('user_id');
        $parent = ParentModel::where('user_id', $userId)->first();

        if (!$parent) {
            $user = User::find($userId);
            $parent = ParentModel::create([
                'user_id' => $userId,
                'parent_name' => $user ? $user->name : 'Parent',
                'phone' => '',
                'address' => '',
            ]);
        }

        return $parent;
    }

    /**
     * Parent main dashboard.
     */
    public function dashboard()
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;
        $parentName = $parent->parent_name ?: ($parent->user ? $parent->user->name : 'Parent');

        $childrenCount = Child::where('parent_id', $parentId)->count();

        $upcomingVaccinations = ParentRequest::where('parent_id', $parentId)
            ->where('request_type', 'Vaccination')
            ->where('status', 'Approved')
            ->where('request_date', '>=', now()->toDateString())
            ->count();

        $pendingRequests = ParentRequest::where('parent_id', $parentId)
            ->where('status', 'Pending')
            ->count();

        $completedVaccinations = Vaccination::whereHas('child', function ($query) use ($parentId) {
            $query->where('parent_id', $parentId);
        })->where('status', 'Completed')->count();

        $upcomingAppointmentsRaw = ParentRequest::with(['child', 'hospital', 'hospitalVaccine'])
            ->where('parent_id', $parentId)
            ->where('request_type', 'Vaccination')
            ->where('status', 'Approved')
            ->where('request_date', '>=', now()->toDateString())
            ->orderBy('request_date', 'asc')
            ->orderBy('preferred_time', 'asc')
            ->limit(5)
            ->get();

        $upcomingAppointments = $upcomingAppointmentsRaw->map(function ($item) {
            return [
                'request_id' => $item->request_id,
                'child_id' => $item->child_id,
                'child_name' => $item->child?->child_name ?? 'Child',
                'vaccine_name' => $item->hospitalVaccine?->vaccine_name ?? 'Vaccination',
                'hospital_name' => $item->hospital?->hospital_name ?? 'Hospital',
                'city' => $item->hospital?->city ?? '',
                'request_date' => $item->request_date ? (is_string($item->request_date) ? $item->request_date : $item->request_date->format('Y-m-d')) : '',
                'preferred_time' => $item->preferred_time,
                'status' => $item->status,
            ];
        })->toArray();

        $recentRequestsRaw = ParentRequest::with(['child', 'hospital', 'hospitalVaccine'])
            ->where('parent_id', $parentId)
            ->orderBy('request_id', 'desc')
            ->limit(5)
            ->get();

        $recentRequests = $recentRequestsRaw->map(function ($item) {
            return [
                'request_id' => $item->request_id,
                'child_id' => $item->child_id,
                'child_name' => $item->child?->child_name ?? 'Child',
                'vaccine_name' => $item->hospitalVaccine?->vaccine_name ?? 'Vaccination',
                'hospital_name' => $item->hospital?->hospital_name ?? '',
                'request_date' => $item->request_date ? (is_string($item->request_date) ? $item->request_date : $item->request_date->format('Y-m-d')) : '',
                'preferred_time' => $item->preferred_time,
                'status' => $item->status,
            ];
        })->toArray();

        return view('parent.dashboard', compact(
            'parent',
            'parentName',
            'childrenCount',
            'upcomingVaccinations',
            'pendingRequests',
            'completedVaccinations',
            'upcomingAppointments',
            'recentRequests'
        ));
    }

    /**
     * Parent profile view.
     */
    public function profile()
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;

        $childrenCount = Child::where('parent_id', $parentId)->count();
        $upcomingVaccinations = ParentRequest::where('parent_id', $parentId)
            ->where('request_type', 'Vaccination')
            ->where('status', 'Approved')
            ->where('request_date', '>=', now()->toDateString())
            ->count();
        $pendingRequests = ParentRequest::where('parent_id', $parentId)
            ->where('status', 'Pending')
            ->count();
        $completedVaccinations = Vaccination::whereHas('child', function ($query) use ($parentId) {
            $query->where('parent_id', $parentId);
        })->where('status', 'Completed')->count();

        $user = $parent->user ?? Auth::user();
        $parentName = $parent->parent_name ?: ($user?->name ?? 'Parent');
        $parentEmail = $user?->email ?? '';
        $parentPhone = $parent->phone ?: ($user?->phone ?? '');
        $parentAddress = $parent->address ?: '';

        return view('parent.profile', compact(
            'parent',
            'parentName',
            'parentEmail',
            'parentPhone',
            'parentAddress',
            'childrenCount',
            'upcomingVaccinations',
            'pendingRequests',
            'completedVaccinations'
        ));
    }

    /**
     * Show edit parent profile form.
     */
    public function editProfile()
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;

        $childrenCount = Child::where('parent_id', $parentId)->count();
        $upcomingVaccinations = ParentRequest::where('parent_id', $parentId)
            ->where('request_type', 'Vaccination')
            ->where('status', 'Approved')
            ->where('request_date', '>=', now()->toDateString())
            ->count();
        $pendingRequests = ParentRequest::where('parent_id', $parentId)
            ->where('status', 'Pending')
            ->count();
        $completedVaccinations = Vaccination::whereHas('child', function ($query) use ($parentId) {
            $query->where('parent_id', $parentId);
        })->where('status', 'Completed')->count();

        $user = $parent->user ?? Auth::user();
        $parentName = $parent->parent_name ?: ($user?->name ?? 'Parent');
        $parentEmail = $user?->email ?? '';
        $parentPhone = $parent->phone ?: ($user?->phone ?? '');
        $parentAddress = $parent->address ?: '';

        return view('parent.edit-profile', compact(
            'parent',
            'parentName',
            'parentEmail',
            'parentPhone',
            'parentAddress',
            'childrenCount',
            'upcomingVaccinations',
            'pendingRequests',
            'completedVaccinations'
        ));
    }

    /**
     * Update parent profile.
     */
    public function updateProfile(Request $request)
    {
        $parent = $this->getParent();
        $user = $parent->user;

        $request->validate([
            'parent_name' => 'required|string|max:100',
            'parent_email' => 'required|email|max:150|unique:users,email,' . $user->user_id . ',user_id',
            'parent_phone' => 'nullable|string|max:30',
            'parent_address' => 'nullable|string',
            'new_password' => 'nullable|min:8',
            'confirm_password' => 'nullable|same:new_password',
        ], [
            'parent_name.required' => 'Please enter your full name.',
            'parent_email.required' => 'Please enter your email address.',
            'parent_email.unique' => 'This email address is already registered.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'confirm_password.same' => 'New password and confirm password do not match.',
        ]);

        DB::beginTransaction();
        try {
            $parent->update([
                'parent_name' => trim($request->input('parent_name')),
                'phone' => trim($request->input('parent_phone', '')),
                'address' => trim($request->input('parent_address', '')),
            ]);

            $userData = [
                'name' => trim($request->input('parent_name')),
                'email' => trim($request->input('parent_email')),
            ];

            if ($request->filled('new_password')) {
                $userData['password'] = Hash::make($request->input('new_password'));
            }

            $user->update($userData);

            session([
                'name' => $user->name,
                'email' => $user->email,
                'parent_name' => $parent->parent_name,
            ]);

            DB::commit();

            return redirect()->route('parent.profile')->with('profile_success', 'Profile updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Profile update failed: ' . $e->getMessage());
        }
    }

    /**
     * List children of parent.
     */
    public function children()
    {
        $parent = $this->getParent();
        $children = Child::where('parent_id', $parent->parent_id)->orderBy('child_id', 'desc')->get();

        $upToDateCount = $children->where('vaccination_status', 'Up to Date')->count();
        $pendingCount = $children->where('vaccination_status', 'Pending')->count();
        $partialCount = $children->where('vaccination_status', 'Partially Vaccinated')->count();

        return view('parent.children', compact('parent', 'children', 'upToDateCount', 'pendingCount', 'partialCount'));
    }

    /**
     * Store new child.
     */
    public function storeChild(Request $request)
    {
        $parent = $this->getParent();

        $request->validate([
            'child_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:5',
            'contact' => 'nullable|string|max:30',
            'additional_notes' => 'nullable|string',
        ], [
            'child_name.required' => "Child's name is required.",
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before_or_equal' => 'Date of birth cannot be in the future.',
            'gender.required' => 'Please select a valid gender.',
        ]);

        Child::create([
            'parent_id' => $parent->parent_id,
            'child_name' => trim($request->input('child_name')),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'blood_group' => $request->input('blood_group'),
            'contact' => $request->input('contact'),
            'additional_notes' => $request->input('additional_notes'),
            'vaccination_status' => 'Pending',
        ]);

        return redirect()->route('parent.children')->with('child_success', 'Child added successfully.');
    }

    /**
     * Edit child form.
     */
    public function editChild($id)
    {
        $parent = $this->getParent();
        $child = Child::where('child_id', $id)->where('parent_id', $parent->parent_id)->firstOrFail();

        return view('parent.edit-child', compact('parent', 'child'));
    }

    /**
     * Update child details.
     */
    public function updateChild(Request $request, $id = null)
    {
        $parent = $this->getParent();
        $childId = $id ?? $request->input('child_id');

        $child = Child::where('child_id', $childId)->where('parent_id', $parent->parent_id)->firstOrFail();

        $request->validate([
            'child_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:5',
            'contact' => 'nullable|string|max:30',
            'additional_notes' => 'nullable|string',
        ], [
            'child_name.required' => "Child's name is required.",
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before_or_equal' => 'Date of birth cannot be in the future.',
        ]);

        $child->update([
            'child_name' => trim($request->input('child_name')),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'blood_group' => $request->input('blood_group'),
            'contact' => $request->input('contact'),
            'additional_notes' => $request->input('additional_notes'),
        ]);

        return redirect()->route('parent.children')->with('child_success', 'Child details updated successfully.');
    }

    /**
     * Delete child.
     */
    public function destroyChild(Request $request, $id = null)
    {
        $parent = $this->getParent();
        $childId = $id ?? $request->input('child_id');

        $child = Child::where('child_id', $childId)->where('parent_id', $parent->parent_id)->firstOrFail();
        $child->delete();

        return redirect()->route('parent.children')->with('child_success', 'Child removed successfully.');
    }

    /**
     * Vaccination schedule page.
     */
    public function schedule(Request $request)
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;

        $children = Child::where('parent_id', $parentId)->orderBy('child_name')->get();

        $selectedChildId = (int) $request->query('child_id', $children->first()?->child_id ?? 0);
        $selectedChild = $children->firstWhere('child_id', $selectedChildId);

        $completedVaccinations = collect();
        $upcomingVaccinations = collect();
        $timeline = [];
        $progressPercentage = 0;

        if ($selectedChild) {
            $completedVaccinations = Vaccination::with(['vaccine', 'hospital'])
                ->where('child_id', $selectedChild->child_id)
                ->where('status', 'Completed')
                ->orderBy('vaccination_date', 'desc')
                ->orderBy('vaccination_time', 'desc')
                ->get();

            $upcomingVaccinations = ParentRequest::with(['hospitalVaccine', 'hospital'])
                ->where('parent_id', $parentId)
                ->where('child_id', $selectedChild->child_id)
                ->where('request_type', 'Vaccination')
                ->where('status', 'Approved')
                ->where('request_date', '>=', now()->toDateString())
                ->orderBy('request_date', 'asc')
                ->orderBy('preferred_time', 'asc')
                ->get();

            $total = $completedVaccinations->count() + $upcomingVaccinations->count();
            if ($total > 0) {
                $progressPercentage = (int) round(($completedVaccinations->count() / $total) * 100);
            }

            foreach ($completedVaccinations as $v) {
                $timeline[] = [
                    'type' => 'completed',
                    'title' => $v->vaccine?->vaccine_name ?? 'Vaccination',
                    'vaccine_name' => $v->vaccine?->vaccine_name ?? 'Vaccination',
                    'badge' => 'Completed',
                    'date' => $v->vaccination_date ? $v->vaccination_date->format('Y-m-d') : '',
                    'time' => $v->vaccination_time,
                    'hospital_name' => $v->hospital?->hospital_name,
                    'city' => $v->hospital?->city,
                    'notes' => $v->notes,
                    'description' => $v->notes,
                    'sort_date' => $v->vaccination_date ? $v->vaccination_date->format('Y-m-d') : '',
                ];
            }

            foreach ($upcomingVaccinations as $r) {
                $timeline[] = [
                    'type' => 'upcoming',
                    'title' => $r->hospitalVaccine?->vaccine_name ?? 'Vaccination',
                    'vaccine_name' => $r->hospitalVaccine?->vaccine_name ?? 'Vaccination',
                    'badge' => 'Upcoming',
                    'date' => $r->request_date ? $r->request_date->format('Y-m-d') : '',
                    'time' => $r->preferred_time,
                    'hospital_name' => $r->hospital?->hospital_name,
                    'city' => $r->hospital?->city,
                    'notes' => $r->message,
                    'description' => $r->message,
                    'sort_date' => $r->request_date ? $r->request_date->format('Y-m-d') : '',
                ];
            }

            usort($timeline, function ($a, $b) {
                return strcmp($b['sort_date'], $a['sort_date']);
            });
        }

        $upcomingCount = $upcomingVaccinations->count();
        $completedCount = $completedVaccinations->count();
        $totalVaccinations = $upcomingCount + $completedCount;

        $smartSchedule = null;
        if ($selectedChild) {
            $smartSchedule = app(\App\Services\VaccineScheduleService::class)->generateForChild($selectedChild);
        }

        return view('parent.schedule', compact(
            'parent',
            'children',
            'selectedChild',
            'selectedChildId',
            'completedVaccinations',
            'upcomingVaccinations',
            'upcomingCount',
            'completedCount',
            'totalVaccinations',
            'timeline',
            'progressPercentage',
            'smartSchedule'
        ));
    }

    /**
     * Book hospital selection and appointment form.
     */
    public function bookHospital(Request $request)
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;

        $children = Child::where('parent_id', $parentId)->orderBy('child_name')->get();
        $hospitals = Hospital::where('status', 'Active')->orderBy('city')->orderBy('hospital_name')->get();

        $selectedHospitalId = (int) $request->query('hospital_id', 0);
        $selectedHospital = null;
        $hospitalVaccines = collect();

        if ($selectedHospitalId > 0) {
            $selectedHospital = Hospital::where('hospital_id', $selectedHospitalId)->where('status', 'Active')->first();
            if ($selectedHospital) {
                $hospitalVaccines = HospitalVaccine::where('hospital_id', $selectedHospital->hospital_id)
                    ->where('availability', 'Available')
                    ->orderBy('vaccine_name')
                    ->get();
            }
        }

        return view('parent.book-hospital', compact(
            'parent',
            'children',
            'hospitals',
            'selectedHospital',
            'selectedHospitalId',
            'hospitalVaccines'
        ));
    }

    /**
     * Submit hospital booking request.
     */
    public function storeBookHospital(Request $request)
    {
        $parent = $this->getParent();

        $request->validate([
            'child_id' => 'required|integer|min:1',
            'hospital_id' => 'required|integer|min:1',
            'hospital_vaccine_id' => 'required|integer|min:1',
            'appointment_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ], [
            'child_id.min' => 'Please select a child.',
            'hospital_id.min' => 'Please select a hospital.',
            'hospital_vaccine_id.min' => 'Please select an available vaccine.',
            'appointment_date.after_or_equal' => 'Appointment date cannot be in the past.',
        ]);

        $child = Child::where('child_id', $request->input('child_id'))->where('parent_id', $parent->parent_id)->firstOrFail();
        $hospital = Hospital::where('hospital_id', $request->input('hospital_id'))->where('status', 'Active')->firstOrFail();
        $vaccine = HospitalVaccine::where('id', $request->input('hospital_vaccine_id'))->where('hospital_id', $hospital->hospital_id)->firstOrFail();

        ParentRequest::create([
            'parent_id' => $parent->parent_id,
            'child_id' => $child->child_id,
            'hospital_id' => $hospital->hospital_id,
            'hospital_vaccine_id' => $vaccine->id,
            'request_type' => 'Vaccination',
            'request_date' => $request->input('appointment_date'),
            'preferred_time' => $request->input('preferred_time'),
            'message' => $request->input('notes'),
            'status' => 'Pending',
        ]);

        return redirect()->route('parent.book-hospital', ['hospital_id' => $hospital->hospital_id])
            ->with('message', 'Appointment Request Submitted!')
            ->with('messageType', 'success');
    }

    /**
     * Track requests sent to hospitals.
     */
    public function requests()
    {
        $parent = $this->getParent();
        $requestHistory = ParentRequest::with(['child', 'hospital', 'hospitalVaccine'])
            ->where('parent_id', $parent->parent_id)
            ->orderBy('request_id', 'desc')
            ->get();

        $requests = $requestHistory;
        $totalRequests = $requestHistory->count();
        $pendingRequests = $requestHistory->where('status', 'Pending')->count();
        $approvedRequests = $requestHistory->where('status', 'Approved')->count();
        $rejectedRequests = $requestHistory->where('status', 'Rejected')->count();

        return view('parent.requests', compact(
            'parent',
            'requests',
            'requestHistory',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests'
        ));
    }

    /**
     * Vaccination report for parent.
     */
    public function report()
    {
        $parent = $this->getParent();
        $parentId = $parent->parent_id;

        $vaccinations = Vaccination::with(['child', 'vaccine', 'hospital'])
            ->whereHas('child', function ($query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })
            ->where('status', 'Completed')
            ->orderBy('vaccination_date', 'desc')
            ->orderBy('vaccination_id', 'desc')
            ->get();

        $totalVaccinations = $vaccinations->count();
        $totalChildren = $vaccinations->pluck('child_id')->unique()->count();
        $currentYear = date('Y');
        $thisYearVaccinations = $vaccinations->filter(function ($v) use ($currentYear) {
            return $v->vaccination_date && $v->vaccination_date->format('Y') === $currentYear;
        })->count();

        $user = $parent->user ?? Auth::user();
        $parentName = $parent->parent_name ?: ($user?->name ?? 'Parent');

        return view('parent.report', compact(
            'parent',
            'parentName',
            'vaccinations',
            'totalVaccinations',
            'totalChildren',
            'thisYearVaccinations'
        ));
    }
}
