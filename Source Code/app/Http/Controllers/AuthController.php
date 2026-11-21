<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel;
use App\Models\HospitalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Show general sign-in page.
     */
    public function showSignIn()
    {
        return view('auth.signin');
    }

    /**
     * Process general sign-in.
     */
    public function postSignIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);

        $email = trim($request->input('email'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 1. Check hospital_users table
        $hospital = HospitalUser::where('email', $email)->first();
        if ($hospital && Hash::check($password, $hospital->password)) {
            $request->session()->regenerate();

            session([
                'user_id' => $hospital->id,
                'hospital_id' => $hospital->id,
                'hospital_name' => $hospital->hospital_name,
                'hospital_email' => $hospital->email,
                'role' => 'hospital',
            ]);

            Auth::guard('hospital')->login($hospital, $remember);

            return redirect()->route('hospital.dashboard');
        }

        // 2. Check users table
        $user = User::where('email', $email)->first();
        if ($user) {
            if (strtolower($user->status) !== 'active') {
                return back()->withInput($request->only('email'))->with('error', 'Your account is inactive.');
            }

            if (Hash::check($password, $user->password)) {
                $request->session()->regenerate();

                Auth::guard('web')->login($user, $remember);

                session([
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]);

                if ($user->role === 'parent') {
                    $parent = ParentModel::where('user_id', $user->user_id)->first();
                    $parentId = $parent ? $parent->parent_id : $user->user_id;
                    $parentName = $parent && !empty($parent->parent_name) ? $parent->parent_name : $user->name;

                    session([
                        'parent_id' => $parentId,
                        'parent_name' => $parentName,
                    ]);

                    return redirect()->route('parent.dashboard');
                } elseif ($user->role === 'admin') {
                    session([
                        'admin_id' => $user->user_id,
                        'admin_name' => $user->name,
                        'admin_email' => $user->email,
                    ]);

                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'vaccinator') {
                    return redirect()->route('hospital.dashboard');
                }

                return redirect()->route('home');
            }
        }

        return back()->withInput($request->only('email'))->with('error', 'Invalid email or password.');
    }

    /**
     * Show Registration Type selection.
     */
    public function showRegisterSelect()
    {
        return view('auth.register-select');
    }

    /**
     * Show parent registration form.
     */
    public function showRegisterParent()
    {
        return view('auth.register-parent');
    }

    /**
     * Process parent registration.
     */
    public function postRegisterParent(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
            'terms' => 'accepted',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter your phone number.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'An account with this email already exists.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must contain at least 8 characters.',
            'confirm_password.same' => 'Passwords do not match.',
            'terms.accepted' => 'You must agree to the Terms & Conditions.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => trim($request->input('full_name')),
                'email' => trim($request->input('email')),
                'password' => Hash::make($request->input('password')),
                'role' => 'parent',
                'status' => 'active',
            ]);

            $parent = ParentModel::create([
                'user_id' => $user->user_id,
                'parent_name' => $user->name,
                'phone' => trim($request->input('phone')),
                'address' => '',
            ]);

            DB::commit();

            Auth::guard('web')->login($user);

            session([
                'user_id' => $user->user_id,
                'parent_id' => $parent->parent_id,
                'name' => $user->name,
                'email' => $user->email,
                'parent_name' => $user->name,
                'role' => 'parent',
            ]);

            return redirect()->route('parent.dashboard');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Unable to create parent account: ' . $e->getMessage());
        }
    }

    /**
     * Logout action.
     */
    public function logout(Request $request)
    {
        $role = strtolower($request->query('role', session('role', 'parent')));

        // If it's a GET request without confirm=1, display the custom logout confirmation screen from original project
        if ($request->isMethod('get') && !$request->has('confirm')) {
            $logoutPages = [
                'parent' => [
                    'label' => 'PARENT SESSION',
                    'panel_title' => 'Parent Portal',
                    'panel_copy' => "Keep every child's vaccine journey organized, protected, and easy to return to.",
                    'icon' => 'bi-people-fill',
                    'account' => 'parent account',
                    'dashboard' => route('parent.dashboard'),
                    'login' => route('signin'),
                    'note' => "You can safely sign in again whenever you need to manage your children's vaccination records.",
                ],
                'hospital' => [
                    'label' => 'HOSPITAL SESSION',
                    'panel_title' => 'Hospital Portal',
                    'panel_copy' => 'Manage vaccine updates and child vaccination records with a secure hospital workspace.',
                    'icon' => 'bi-hospital',
                    'account' => 'hospital account',
                    'dashboard' => route('hospital.dashboard'),
                    'login' => route('signin'),
                    'note' => 'You can safely sign in again whenever you need to manage hospital vaccination services.',
                ],
                'admin' => [
                    'label' => 'ADMIN SESSION',
                    'panel_title' => 'Admin Portal',
                    'panel_copy' => 'Review hospitals, requests, vaccines, and platform records from one protected admin area.',
                    'icon' => 'bi-shield-lock-fill',
                    'account' => 'admin account',
                    'dashboard' => route('admin.dashboard'),
                    'login' => route('signin'),
                    'note' => 'You can safely sign in again whenever you need to manage the VacciCare administration portal.',
                ],
            ];

            if (!isset($logoutPages[$role])) {
                $role = 'parent';
            }

            $logoutPage = $logoutPages[$role];

            return view('auth.logout', compact('logoutPage', 'role'));
        }

        // Perform actual logout
        Auth::guard('web')->logout();
        Auth::guard('hospital')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}
