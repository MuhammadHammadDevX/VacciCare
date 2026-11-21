@extends('layouts.hospital')

@section('title', 'Hospital Profile | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/hospital-profile.css') }}">
@endpush

@section('content')
<!-- Hospital Profile Page -->
<section class="hospital-profile-page">
    <div class="hospital-profile-container">

        @if(session('success_message') || session('success'))
            <div class="alert alert-success" style="background:#d1e7dd; color:#0f5132; padding:14px 18px; border-radius:10px; margin-bottom:20px;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success_message') ?? session('success') }}
            </div>
        @endif

        <div class="profile-top">
            <div class="profile-top-content">
                <div class="profile-label">
                    <i class="bi bi-hospital"></i>
                    HOSPITAL PORTAL
                </div>
                <h1>Hospital Profile</h1>
                <p>View and manage your hospital information.</p>
            </div>
            <div class="profile-top-icon">
                <i class="bi bi-building"></i>
            </div>
        </div>

        <!-- =========================
             MAIN PROFILE CARD
        ========================== -->
        <div class="hospital-profile-card">
            <!-- Card Header -->
            <div class="profile-card-head">
                <div class="hospital-profile-title">
                    <div class="hospital-profile-icon">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div>
                        <h2>Hospital Information</h2>
                        <p>Your registered hospital details</p>
                    </div>
                </div>

                <div class="verified-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Verified
                </div>
            </div>

            <!-- =========================
                 BASIC INFORMATION
            ========================== -->
            <div class="profile-card-body">
                <div class="profile-section-title">
                    <div class="section-number">01</div>
                    <div>
                        <h3>Basic Information</h3>
                        <p>General information about your hospital.</p>
                    </div>
                </div>

                <div class="profile-fields">
                    <!-- Hospital Name -->
                    <div class="profile-field">
                        <label>Hospital Name</label>
                        <div class="profile-value">
                            <i class="bi bi-hospital"></i>
                            <span>{{ $hospitalUser->hospital_name ?? $hospital->hospital_name ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Hospital Type -->
                    <div class="profile-field">
                        <label>Hospital Type</label>
                        <div class="profile-value">
                            <i class="bi bi-building"></i>
                            <span>{{ $hospitalUser->hospital_type ?? $hospital->hospital_type ?? 'General Hospital' }}</span>
                        </div>
                    </div>

                    <!-- Registration -->
                    <div class="profile-field">
                        <label>Registration / License No.</label>
                        <div class="profile-value">
                            <i class="bi bi-card-text"></i>
                            <span>{{ $hospitalUser->registration_number ?? $hospital->license_no ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="profile-field">
                        <label>Hospital Email</label>
                        <div class="profile-value">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $hospitalUser->email ?? $hospital->email ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="profile-field">
                        <label>Phone Number</label>
                        <div class="profile-value">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $hospitalUser->phone ?? $hospital->phone ?? '' }}</span>
                        </div>
                    </div>

                    <!-- City -->
                    <div class="profile-field">
                        <label>City</label>
                        <div class="profile-value">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $hospitalUser->city ?? $hospital->city ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- =========================
                     CONTACT INFORMATION
                ========================== -->
                <div class="profile-section-title second-section">
                    <div class="section-number">02</div>
                    <div>
                        <h3>Contact Information</h3>
                        <p>Hospital location and contact details.</p>
                    </div>
                </div>

                <div class="profile-fields">
                    <!-- Address -->
                    <div class="profile-field full-field">
                        <label>Hospital Address</label>
                        <div class="profile-value">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $hospitalUser->address ?? $hospital->address ?? '' }}</span>
                        </div>
                    </div>

                    <div class="profile-field">
                        <label>Province</label>
                        <div class="profile-value">
                            <i class="bi bi-map"></i>
                            <span>{{ $hospitalUser->province ?? 'Punjab' }}</span>
                        </div>
                    </div>
                </div>

                <!-- =========================
                     ACCOUNT STATUS
                ========================== -->
                <div class="account-status-box">
                    <div class="account-status-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="account-status-text">
                        <h3>Account Active</h3>
                        <p>Your hospital account is active and available for vaccination management.</p>
                    </div>
                    <div class="active-badge">Active</div>
                </div>
            </div>

            <!-- =========================
                 CARD FOOTER
            ========================== -->
            <div class="profile-card-footer">
                <div class="profile-footer-info">
                    <i class="bi bi-info-circle"></i>
                    <span>Hospital information is securely maintained.</span>
                </div>

                <a href="{{ route('hospital.edit-profile') }}" class="edit-profile-btn">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/hospital-profile.js') }}"></script>
@endpush
