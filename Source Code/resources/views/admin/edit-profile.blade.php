@extends('layouts.admin')

@section('title', 'Edit Admin Profile | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-profile.css') }}">
    <style>
        .edit-profile-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 32px;
            margin-top: 20px;
        }
        .form-row-custom {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group-custom label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }
        .form-group-custom input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s ease;
        }
        .form-group-custom input:focus {
            border-color: #1688d8;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(22, 136, 216, 0.15);
        }
        .section-separator {
            border-top: 1px solid #f1f5f9;
            margin: 28px 0;
            padding-top: 20px;
        }
        .section-separator h4 {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }
        .section-separator p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 16px;
        }
        .submit-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }
        .save-btn {
            background: #1688d8;
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .save-btn:hover {
            background: #116cb0;
        }
        .cancel-btn {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .cancel-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
<main class="admin-profile-page">
    <section class="profile-page-header">
        <div>
            <span class="page-eyebrow">
                <i class="bi bi-pencil-square"></i>
                ADMIN SETTINGS
            </span>
            <h1>Edit Admin Profile</h1>
            <p>Update administrator name, email and password credentials.</p>
        </div>
    </section>

    @if(session('errorMessage'))
        <div class="alert alert-danger mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill mr-2"></i>
            {{ session('errorMessage') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4" role="alert">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="edit-profile-card">
        <form action="{{ route('admin.update-profile') }}" method="POST">
            @csrf

            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label for="name">Admin Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                </div>

                <div class="form-group-custom">
                    <label for="email">Admin Email Address <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                </div>
            </div>

            <div class="section-separator">
                <h4>Change Password (Optional)</h4>
                <p>Leave these fields blank if you do not wish to update your administrator password.</p>

                <div class="form-row-custom">
                    <div class="form-group-custom">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                    </div>

                    <div class="form-group-custom">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="At least 6 characters">
                    </div>

                    <div class="form-group-custom">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
                    </div>
                </div>
            </div>

            <div class="submit-actions">
                <button type="submit" class="save-btn">
                    <i class="bi bi-check2-circle mr-1"></i> Save Changes
                </button>
                <a href="{{ route('admin.profile') }}" class="cancel-btn">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>
@endsection