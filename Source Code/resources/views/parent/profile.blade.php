@extends('layouts.parent')

@section('title', 'My Profile | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/parent-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
@endpush

@section('content')
<main class="dashboard-main">
    <div class="profile-content">
        <div class="profile-page-heading">
            <div>
                <span class="section-label">ACCOUNT SETTINGS</span>
                <h2>Personal Profile</h2>
                <p>Manage your personal information and profile details securely.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="profile-success-message">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        <section class="profile-hero">
            <div class="profile-hero-left">
                <div class="profile-photo-wrapper">
                    <div class="profile-photo">
                        <img id="profilePreview" src="{{ asset('images/profile/default-profile.avif') }}" alt="Parent Profile" onerror="this.onerror=null; this.src='{{ asset('images/profile/default-profile.avif') }}';">
                    </div>
                    <a href="{{ route('parent.edit-profile') }}" class="profile-camera-btn" title="Edit profile">
                        <i class="bi bi-camera-fill"></i>
                    </a>
                </div>

                <div class="profile-hero-info">
                    <span class="profile-role">PARENT ACCOUNT</span>
                    <h2>{{ $parentName }}</h2>
                    <p><i class="bi bi-envelope-fill"></i> {{ $parentEmail }}</p>
                    @if(!empty($parentPhone))
                        <p><i class="bi bi-telephone-fill"></i> {{ $parentPhone }}</p>
                    @endif
                </div>
            </div>

            <div class="profile-hero-actions">
                <a href="{{ route('parent.edit-profile') }}" class="profile-edit-btn">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </a>
            </div>
        </section>

        <section class="profile-card">
            <div class="card-heading">
                <div class="heading-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <div>
                    <h3>Contact Information</h3>
                    <p>Details linked to your account.</p>
                </div>
            </div>

            <div class="profile-details-grid">
                <div class="detail-item">
                    <label>Full Name</label>
                    <p>{{ $parentName }}</p>
                </div>
                <div class="detail-item">
                    <label>Email Address</label>
                    <p>{{ $parentEmail }}</p>
                </div>
                <div class="detail-item">
                    <label>Phone Number</label>
                    <p>{{ $parentPhone ?: 'Not provided' }}</p>
                </div>
                <div class="detail-item full-width">
                    <label>Residential Address</label>
                    <p>{{ $parentAddress ?: 'Not provided' }}</p>
                </div>
            </div>
        </section>

        <section class="profile-card">
            <div class="card-heading">
                <div class="heading-icon">
                    <i class="bi bi-grid"></i>
                </div>
                <div>
                    <h3>Account Overview</h3>
                    <p>Quick summary of your vaccination account.</p>
                </div>
            </div>

            <div class="overview-grid">
                <a href="{{ route('parent.children') }}" class="overview-item">
                    <div class="overview-icon blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <span>My Children</span>
                        <strong>{{ $childrenCount }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.schedule') }}" class="overview-item">
                    <div class="overview-icon green">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <span>Upcoming</span>
                        <strong>{{ $upcomingVaccinations }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.requests') }}" class="overview-item">
                    <div class="overview-icon orange">
                        <i class="bi bi-clipboard-check-fill"></i>
                    </div>
                    <div>
                        <span>Pending Requests</span>
                        <strong>{{ $pendingRequests }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.report') }}" class="overview-item">
                    <div class="overview-icon purple">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <span>Vaccinations Taken</span>
                        <strong>{{ $completedVaccinations }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </section>

        <div class="security-notice">
            <div class="security-notice-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <strong>Your privacy matters</strong>
                <p>Your personal information is used only to manage your vaccination services and account.</p>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/parent-profile.js') }}"></script>
@endpush
