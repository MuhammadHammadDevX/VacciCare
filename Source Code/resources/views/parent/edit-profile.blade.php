@extends('layouts.parent')

@section('title', 'Edit Profile | VacciCare')

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
                <h2>Edit Profile</h2>
                <p>Update your personal information and account details securely.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="profile-error-message">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <section class="profile-hero">
            <div class="profile-hero-left">
                <div class="profile-photo-wrapper">
                    <div class="profile-photo">
                        <img id="profilePreview" src="{{ asset('images/profile/default-profile.avif') }}" alt="Parent Profile" onerror="this.onerror=null; this.src='{{ asset('images/profile/default-profile.avif') }}';">
                    </div>
                    <label for="profileImageInput" class="profile-camera-btn" title="Change profile picture">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                </div>

                <div class="profile-hero-info">
                    <span class="profile-role">PARENT ACCOUNT</span>
                    <h2>{{ $parentName }}</h2>
                    <p><i class="bi bi-envelope-fill"></i> {{ $parentEmail }}</p>
                </div>
            </div>

            <div class="profile-status">
                <div class="status-icon"><i class="bi bi-shield-check"></i></div>
                <div class="status-content">
                    <strong>Account Protected</strong>
                    <span>Your information is secure</span>
                </div>
            </div>
        </section>

        <section class="profile-card">
            <div class="card-heading">
                <div class="heading-icon"><i class="bi bi-person-vcard"></i></div>
                <div>
                    <h3>Personal Information</h3>
                    <p>Keep your contact information up to date.</p>
                </div>
            </div>

            <form action="{{ route('parent.update-profile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="parentName">Full Name <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-person"></i>
                            <input type="text" id="parentName" name="parent_name" value="{{ old('parent_name', $parentName) }}" placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parentEmail">Email Address <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="parentEmail" name="parent_email" value="{{ old('parent_email', $parentEmail) }}" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parentPhone">Phone Number</label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone"></i>
                            <input type="tel" id="parentPhone" name="parent_phone" value="{{ old('parent_phone', $parentPhone) }}" placeholder="+92 XXX XXXXXXX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="newPassword" name="new_password" placeholder="Enter new password" minlength="8" autocomplete="new-password">
                        </div>
                        <small class="form-help">Leave blank if you do not want to change your password.</small>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-shield-lock"></i>
                            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm new password" minlength="8" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="parentAddress">Address</label>
                        <div class="input-wrapper textarea-wrapper">
                            <i class="bi bi-geo-alt"></i>
                            <textarea id="parentAddress" name="parent_address" rows="3" placeholder="Enter your residential address">{{ old('parent_address', $parentAddress) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="profileImageInput">Profile Picture</label>
                        <div class="input-wrapper">
                            <i class="bi bi-image"></i>
                            <input type="file" id="profileImageInput" name="profile_image" accept="image/jpeg,image/png,image/webp">
                        </div>
                        <small class="form-help">JPG, PNG or WEBP. Maximum size 2MB.</small>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('parent.profile') }}" class="cancel-btn">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="save-btn">
                        <i class="bi bi-check2"></i> Save Changes
                    </button>
                </div>
            </form>
        </section>

        <section class="profile-card">
            <div class="card-heading">
                <div class="heading-icon"><i class="bi bi-grid"></i></div>
                <div>
                    <h3>Account Overview</h3>
                    <p>Quick summary of your vaccination account.</p>
                </div>
            </div>

            <div class="overview-grid">
                <a href="{{ route('parent.children') }}" class="overview-item">
                    <div class="overview-icon blue"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <span>My Children</span>
                        <strong>{{ $childrenCount }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.schedule') }}" class="overview-item">
                    <div class="overview-icon green"><i class="bi bi-calendar-check-fill"></i></div>
                    <div>
                        <span>Upcoming</span>
                        <strong>{{ $upcomingVaccinations }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.requests') }}" class="overview-item">
                    <div class="overview-icon orange"><i class="bi bi-clipboard-check-fill"></i></div>
                    <div>
                        <span>Pending Requests</span>
                        <strong>{{ $pendingRequests }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('parent.report') }}" class="overview-item">
                    <div class="overview-icon purple"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <span>Vaccinations Taken</span>
                        <strong>{{ $completedVaccinations }}</strong>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </section>

        <div class="security-notice">
            <div class="security-notice-icon"><i class="bi bi-shield-lock-fill"></i></div>
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
