@extends('layouts.admin')

@section('title', 'Admin Profile | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-profile.css') }}">
@endpush

@section('content')
<main class="admin-profile-page">
    <section class="profile-page-header">
        <div>
            <span class="page-eyebrow">
                <i class="bi bi-person-badge-fill"></i>
                ADMIN ACCOUNT
            </span>
            <h1>Admin Profile</h1>
            <p>View and manage your administrator profile information.</p>
        </div>
    </section>

    @if(session('successMessage'))
        <div class="alert alert-success mb-4" role="alert">
            <i class="bi bi-check-circle-fill mr-2"></i>
            {{ session('successMessage') }}
        </div>
    @endif

    <section class="profile-card">
        <div class="profile-top">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="profile-heading">
                <div class="profile-name-row">
                    <h2>{{ $admin->name ?? session('admin_name', 'Administrator') }}</h2>
                    <span class="verified-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        Verified
                    </span>
                </div>
                <p>{{ ucfirst($admin->role ?? 'admin') }}</p>
            </div>

            <div class="account-status">
                <span class="status-dot"></span>
                {{ ucfirst($admin->status ?? 'Active') }}
            </div>
        </div>

        <div class="profile-section">
            <div class="section-title">
                <span class="section-icon">
                    <i class="bi bi-person-vcard-fill"></i>
                </span>
                <div>
                    <span class="section-eyebrow">ACCOUNT INFORMATION</span>
                    <h3>Admin Information</h3>
                </div>
            </div>

            <div class="information-grid">
                <!-- ADMIN NAME -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-person-fill"></i>
                        Admin Name
                    </span>
                    <strong>{{ $admin->name ?? 'Administrator' }}</strong>
                </div>

                <!-- EMAIL -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-envelope-fill"></i>
                        Email Address
                    </span>
                    <strong>{{ $admin->email ?? 'admin@vaccicare.pk' }}</strong>
                </div>

                <!-- PHONE -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-telephone-fill"></i>
                        Phone
                    </span>
                    <strong>Not available</strong>
                </div>

                <!-- ROLE -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-shield-check"></i>
                        Role
                    </span>
                    <strong>{{ ucfirst($admin->role ?? 'admin') }}</strong>
                </div>

                <!-- ACCOUNT STATUS -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-toggle-on"></i>
                        Account Status
                    </span>
                    <strong class="active-text">
                        <span class="mini-status-dot"></span>
                        {{ ucfirst($admin->status ?? 'active') }}
                    </strong>
                </div>

                <!-- LAST LOGIN -->
                <div class="info-box">
                    <span class="info-label">
                        <i class="bi bi-clock-history"></i>
                        Last Login
                    </span>
                    <strong>Current session</strong>
                </div>
            </div>
        </div>

        <div class="profile-footer">
            <div class="brand-mini">
                <div class="brand-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div>
                    <strong>VacciCare</strong>
                    <span>Vaccination Management System</span>
                </div>
            </div>

            <span class="security-text">
                <i class="bi bi-shield-lock-fill"></i>
                Secure Admin Account
            </span>
        </div>

        <div class="profile-actions">
            <a href="{{ route('admin.edit-profile') }}" class="edit-profile-btn">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </a>
        </div>
    </section>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin-profile.js') }}"></script>
@endpush