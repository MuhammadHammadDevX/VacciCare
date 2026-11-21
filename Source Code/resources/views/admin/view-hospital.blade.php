@extends('layouts.admin')

@section('title', 'View Hospital | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/add-hospital.css') }}">
@endpush

@section('content')
<main class="add-hospital-page">

    <!-- PAGE HEADER -->
    <section class="add-hospital-header">
        <div class="header-content">
            <span class="page-eyebrow">
                <i class="bi bi-hospital-fill"></i>
                HOSPITAL MANAGEMENT
            </span>
            <h1>Hospital Details</h1>
            <p>View complete information of the registered hospital.</p>
        </div>

        <div class="header-badge">
            <i class="bi bi-eye-fill"></i>
            <div>
                <strong>Admin Portal</strong>
                <span>Hospital Details</span>
            </div>
        </div>
    </section>

    <!-- HOSPITAL DETAILS CARD -->
    <section class="hospital-form-card">
        <div class="form-card-header">
            <div class="form-title-icon">
                <i class="bi bi-hospital-fill"></i>
            </div>
            <div>
                <span class="section-eyebrow">REGISTERED HOSPITAL</span>
                <h2>{{ $hospital->hospital_name }}</h2>
                <p>Hospital ID: HSP-{{ $hospital->hospital_id }}</p>
            </div>
        </div>

        <div class="form-grid">
            <!-- Hospital Name -->
            <div class="form-group">
                <label>Hospital Name</label>
                <div class="input-wrapper">
                    <i class="bi bi-hospital"></i>
                    <input type="text" value="{{ $hospital->hospital_name }}" readonly>
                </div>
            </div>

            <!-- Hospital Type -->
            <div class="form-group">
                <label>Hospital Type</label>
                <div class="input-wrapper">
                    <i class="bi bi-building"></i>
                    <input type="text" value="{{ $hospital->hospital_type }}" readonly>
                </div>
            </div>

            <!-- License -->
            <div class="form-group">
                <label>License Number</label>
                <div class="input-wrapper">
                    <i class="bi bi-card-text"></i>
                    <input type="text" value="{{ $hospital->license_no }}" readonly>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope"></i>
                    <input type="text" value="{{ $hospital->email }}" readonly>
                </div>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label>Contact Number</label>
                <div class="input-wrapper">
                    <i class="bi bi-telephone"></i>
                    <input type="text" value="{{ $hospital->phone }}" readonly>
                </div>
            </div>

            <!-- City -->
            <div class="form-group">
                <label>Location / City</label>
                <div class="input-wrapper">
                    <i class="bi bi-geo-alt"></i>
                    <input type="text" value="{{ $hospital->city }}" readonly>
                </div>
            </div>

            <!-- Contact Person -->
            <div class="form-group">
                <label>Contact Person</label>
                <div class="input-wrapper">
                    <i class="bi bi-person"></i>
                    <input type="text" value="{{ $hospital->contact_person ?: 'Not specified' }}" readonly>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="form-group">
                <label>Working Hours</label>
                <div class="input-wrapper">
                    <i class="bi bi-clock"></i>
                    <input type="text" value="{{ $hospital->working_hours ?: '24 Hours' }}" readonly>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label>Account Status</label>
                <div class="input-wrapper">
                    <i class="bi bi-toggle-on"></i>
                    <input type="text" value="{{ $hospital->status }}" readonly>
                </div>
            </div>

            <!-- Address -->
            <div class="form-group full">
                <label>Address</label>
                <div class="input-wrapper textarea-wrapper">
                    <i class="bi bi-geo"></i>
                    <textarea rows="3" readonly>{{ $hospital->address }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.edit-hospital', $hospital->hospital_id) }}" class="submit-button">
                <i class="bi bi-pencil-square"></i> Edit Hospital
            </a>
            <a href="{{ route('admin.hospital-list') }}" class="cancel-button">
                Back to Hospital List
            </a>
        </div>
    </section>
</main>
@endsection