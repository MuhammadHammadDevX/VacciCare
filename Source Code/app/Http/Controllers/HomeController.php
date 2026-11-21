<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\HospitalVaccine;
use App\Models\ParentModel;
use App\Models\ParentRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Home landing page.
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Vaccines information catalog.
     */
    public function vaccines()
    {
        return view('home.vaccines');
    }

    /**
     * Direct book vaccination appointment page.
     */
    public function appointment()
    {
        $user = Auth::guard('web')->user();

        if (!$user || $user->role !== 'parent') {
            return redirect()->route('signin')->with('error', 'Please log in as a parent to book an appointment.');
        }

        $parent = ParentModel::where('user_id', $user->user_id)->first();
        if (!$parent) {
            return redirect()->route('signin')->with('error', 'Parent profile not found.');
        }

        $children = Child::where('parent_id', $parent->parent_id)->orderBy('child_name')->get();

        $hospitals = HospitalUser::where('role', 'hospital')->orderBy('hospital_name')->get();

        $hospitalVaccines = HospitalVaccine::join('hospital_users', 'hospital_users.id', '=', 'hospital_vaccines.hospital_id')
            ->where('hospital_users.role', 'hospital')
            ->select('hospital_vaccines.*')
            ->orderBy('hospital_vaccines.vaccine_name')
            ->get();

        $vaccines = $hospitalVaccines;

        return view('home.appointment', compact('parent', 'children', 'hospitals', 'hospitalVaccines', 'vaccines'));
    }

    /**
     * Store vaccination appointment request.
     */
    public function storeAppointment(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'parent') {
            return redirect()->route('signin');
        }

        $parent = ParentModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'child_id' => 'required',
            'child_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other,Male,Female,Other',
            'hospital_id' => 'required|integer',
            'hospital_vaccine_id' => 'required|integer',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'parent_name' => 'required|string',
            'phone' => ['required', 'regex:/^\+92[0-9]{10}$/'],
            'email' => 'required|email',
        ], [
            'phone.regex' => 'Please enter a valid Pakistani phone number in the format +923001234567.',
            'appointment_date.after_or_equal' => 'Appointment date cannot be in the past.',
        ]);

        $childId = (int) $request->input('child_id');

        // If new child (child_id == 0), auto create child
        if ($childId <= 0) {
            $child = Child::create([
                'parent_id' => $parent->parent_id,
                'child_name' => trim($request->input('child_name')),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => ucfirst(strtolower($request->input('gender'))),
                'blood_group' => null,
                'contact' => trim($request->input('phone')),
                'additional_notes' => 'Registered via appointment booking',
                'vaccination_status' => 'Pending',
            ]);
            $childId = $child->child_id;
        }

        // Verify hospital exists
        $hospitalUser = HospitalUser::findOrFail($request->input('hospital_id'));
        $vaccine = HospitalVaccine::where('id', $request->input('hospital_vaccine_id'))
            ->where('hospital_id', $hospitalUser->id)
            ->firstOrFail();

        // Find linked hospital in hospitals table for ID mapping if needed
        $hospitalTableRecord = Hospital::whereRaw('LOWER(TRIM(email)) = ?', [strtolower(trim($hospitalUser->email))])->first();
        $targetHospitalId = $hospitalTableRecord ? $hospitalTableRecord->hospital_id : $hospitalUser->id;

        $parentRequest = ParentRequest::create([
            'parent_id' => $parent->parent_id,
            'child_id' => $childId,
            'hospital_id' => $targetHospitalId,
            'hospital_vaccine_id' => $vaccine->id,
            'request_type' => 'Vaccination',
            'request_date' => $request->input('appointment_date'),
            'preferred_time' => $request->input('appointment_time'),
            'message' => $request->input('message', 'Vaccination booking appointment request.'),
            'status' => 'Pending',
        ]);

        // Notifications
        Notification::create([
            'recipient_type' => 'admin',
            'recipient_id' => 0,
            'title' => 'New Vaccination Appointment Request',
            'message' => "A new booking request #{$parentRequest->request_id} has been submitted for {$request->input('child_name')}.",
            'type' => 'info',
            'link' => route('admin.parent-requests'),
            'is_read' => 0,
        ]);

        return back()->with('success', 'Your appointment request has been submitted successfully and is pending hospital approval.');
    }
}
