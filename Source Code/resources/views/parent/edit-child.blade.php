@extends('layouts.parent')

@section('title', 'Edit Child | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my-children.css') }}">
@endpush

@section('content')
<main class="dashboard-main">
    <section class="children-content">
        <div class="children-intro">
            <div class="intro-text">
                <span class="section-label">
                    <i class="bi bi-people-fill"></i>
                    FAMILY MANAGEMENT
                </span>
                <h2>Edit Child</h2>
                <p>Update your child's vaccination information.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mt-3" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="child-modal-overlay show" id="editChildModal" style="position:relative; background:none; z-index:1; padding:0; display:flex;">
            <div class="child-modal" style="box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin: 0 auto; max-width: 650px; width: 100%;">
                <div class="modal-header-custom">
                    <div class="modal-title-area">
                        <div class="modal-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h3>Edit Child Details</h3>
                            <p>Update your child's basic information</p>
                        </div>
                    </div>
                    <a href="{{ route('parent.children') }}" class="modal-close" title="Close">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

                <form id="editChildForm" method="POST" action="{{ route('parent.children.update', $child->child_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row-custom">
                        <div class="form-group-custom">
                            <label for="childName">Child's Full Name</label>
                            <div class="input-wrapper">
                                <i class="bi bi-person"></i>
                                <input type="text" id="childName" name="child_name" placeholder="Enter child's name" maxlength="100" required value="{{ old('child_name', $child->child_name) }}">
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label for="childDob">Date of Birth</label>
                            <div class="input-wrapper">
                                <i class="bi bi-calendar3"></i>
                                <input type="date" id="childDob" name="date_of_birth" required value="{{ old('date_of_birth', $child->date_of_birth) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row-custom">
                        <div class="form-group-custom">
                            <label for="childGender">Gender</label>
                            <div class="input-wrapper">
                                <i class="bi bi-gender-ambiguous"></i>
                                <select id="childGender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Female" {{ old('gender', $child->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Male" {{ old('gender', $child->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Other" {{ old('gender', $child->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label for="bloodGroup">Blood Group</label>
                            <div class="input-wrapper">
                                <i class="bi bi-droplet"></i>
                                <select id="bloodGroup" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    @php
                                        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                    @endphp
                                    @foreach($bloodGroups as $group)
                                        <option value="{{ $group }}" {{ old('blood_group', $child->blood_group) === $group ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label for="childContact">Contact Number <span>(Optional)</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone"></i>
                            <input type="text" id="childContact" name="contact" placeholder="Enter contact number" maxlength="30" value="{{ old('contact', $child->contact) }}">
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label for="childNotes">Additional Notes <span>(Optional)</span></label>
                        <textarea id="childNotes" name="additional_notes" rows="3" placeholder="Add any additional information...">{{ old('additional_notes', $child->additional_notes) }}</textarea>
                    </div>

                    <div class="modal-footer-custom">
                        <a href="{{ route('parent.children') }}" class="cancel-btn">Cancel</a>
                        <button type="submit" class="save-child-btn" id="updateChildBtn">
                            <i class="bi bi-check-lg"></i>
                            <span>Update Child</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
