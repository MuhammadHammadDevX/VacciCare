@extends('layouts.hospital')

@section('title', 'Edit Hospital Profile | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/hospital-profile.css') }}">
@endpush

@section('content')
<section class="hospital-profile-page">
    <div class="hospital-profile-container">

        <div class="profile-top">
            <div class="profile-top-content">
                <div class="profile-label">
                    <i class="bi bi-hospital"></i>
                    HOSPITAL PORTAL
                </div>
                <h1>Edit Hospital Profile</h1>
                <p>Update your registered hospital information.</p>
            </div>
            <div class="profile-top-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
        </div>

        <div class="hospital-profile-card">
            <!-- CARD HEADER -->
            <div class="profile-card-head">
                <div class="hospital-profile-title">
                    <div class="hospital-profile-icon">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div>
                        <h2>Hospital Information</h2>
                        <p>Update your hospital details below.</p>
                    </div>
                </div>

                <div class="verified-badge">
                    <i class="bi bi-shield-check"></i>
                    Secure
                </div>
            </div>

            <div class="profile-card-body">
                @if(session('success_message') || session('success'))
                    <div class="account-status-box" style="border-left: 4px solid #198754; background: #e8f5e9;">
                        <div class="account-status-icon" style="color: #198754;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="account-status-text">
                            <h3>Success</h3>
                            <p>{{ session('success_message') ?? session('success') }}</p>
                        </div>
                        <div class="active-badge" style="background:#198754;">Updated</div>
                    </div>
                @endif

                @if($errors->any() || session('error'))
                    <div class="account-status-box" style="border-left: 4px solid #dc3545; background: #ffebee;">
                        <div class="account-status-icon" style="color: #dc3545;">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="account-status-text">
                            <h3>Error</h3>
                            <p>
                                @if(session('error'))
                                    {{ session('error') }}
                                @else
                                    {{ $errors->first() }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <div class="profile-section-title">
                    <div class="section-number">01</div>
                    <div>
                        <h3>Basic Information</h3>
                        <p>Update your hospital's basic information.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('hospital.update-profile') }}" class="hospital-edit-form">
                    @csrf

                    <div class="profile-fields">
                        <!-- Hospital Name -->
                        <div class="profile-field">
                            <label for="hospital_name">Hospital Name</label>
                            <div class="profile-value">
                                <i class="bi bi-hospital"></i>
                                <input
                                    type="text"
                                    id="hospital_name"
                                    name="hospital_name"
                                    value="{{ old('hospital_name', $hospitalUser->hospital_name ?? $hospital->hospital_name ?? '') }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Hospital Type -->
                        <div class="profile-field">
                            <label for="hospital_type">Hospital Type</label>
                            <div class="profile-value">
                                <i class="bi bi-building"></i>
                                @php
                                    $currentType = old('hospital_type', $hospitalUser->hospital_type ?? $hospital->hospital_type ?? '');
                                @endphp
                                <select id="hospital_type" name="hospital_type" required>
                                    <option value="Private Hospital" {{ $currentType === 'Private Hospital' ? 'selected' : '' }}>Private Hospital</option>
                                    <option value="Government Hospital" {{ $currentType === 'Government Hospital' ? 'selected' : '' }}>Government Hospital</option>
                                    <option value="Public Hospital" {{ $currentType === 'Public Hospital' ? 'selected' : '' }}>Public Hospital</option>
                                    <option value="Clinic" {{ $currentType === 'Clinic' ? 'selected' : '' }}>Clinic</option>
                                    <option value="Other" {{ $currentType === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Registration Number -->
                        <div class="profile-field">
                            <label for="registration_number">Registration / License No.</label>
                            <div class="profile-value">
                                <i class="bi bi-card-text"></i>
                                <input
                                    type="text"
                                    id="registration_number"
                                    name="registration_number"
                                    value="{{ old('registration_number', $hospitalUser->registration_number ?? $hospital->license_no ?? '') }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="profile-field">
                            <label for="email">Hospital Email</label>
                            <div class="profile-value">
                                <i class="bi bi-envelope"></i>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $hospitalUser->email ?? $hospital->email ?? '') }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="profile-field">
                            <label for="phone">Phone Number</label>
                            <div class="profile-value">
                                <i class="bi bi-telephone"></i>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $hospitalUser->phone ?? $hospital->phone ?? '') }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- City -->
                        <div class="profile-field">
                            <label for="city">City</label>
                            <div class="profile-value">
                                <i class="bi bi-geo-alt"></i>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    value="{{ old('city', $hospitalUser->city ?? $hospital->city ?? '') }}"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="profile-section-title second-section">
                        <div class="section-number">02</div>
                        <div>
                            <h3>Contact Information</h3>
                            <p>Update your hospital location details.</p>
                        </div>
                    </div>

                    <div class="profile-fields">
                        <!-- Address -->
                        <div class="profile-field full-field">
                            <label for="address">Hospital Address</label>
                            <div class="profile-value">
                                <i class="bi bi-geo-alt"></i>
                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address', $hospitalUser->address ?? $hospital->address ?? '') }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Province -->
                        <div class="profile-field">
                            <label for="province">Province</label>
                            <div class="profile-value">
                                <i class="bi bi-map"></i>
                                <input
                                    type="text"
                                    id="province"
                                    name="province"
                                    value="{{ old('province', $hospitalUser->province ?? 'Punjab') }}"
                                    required
                                >
                            </div>
                        </div>
                    </div>

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

                    <div class="profile-card-footer">
                        <div class="profile-footer-info">
                            <i class="bi bi-info-circle"></i>
                            <span>Changes will be saved securely to your hospital account.</span>
                        </div>

                        <div class="profile-footer-actions">
                            <a href="{{ route('hospital.profile') }}" class="edit-profile-btn" style="background: #6c757d; border-color: #6c757d;">
                                <i class="bi bi-x-circle"></i>
                                Cancel
                            </a>

                            <button type="submit" class="edit-profile-btn">
                                <i class="bi bi-check-circle"></i>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/hospital-profile.js') }}"></script>
@endpush
