@extends('layouts.admin')

@section('title', 'Child Details | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-child-details.css') }}">
@endpush

@section('content')
@php
    $dob = $child->date_of_birth;
    $formattedDob = $dob ? date('d F Y', strtotime($dob)) : 'N/A';

    $childAge = 'N/A';
    if ($dob) {
        try {
            $birth = new DateTime($dob);
            $now = new DateTime();
            $diff = $birth->diff($now);
            if ($diff->y > 0) {
                $childAge = $diff->y . ' ' . ($diff->y == 1 ? 'Year' : 'Years');
            } elseif ($diff->m > 0) {
                $childAge = $diff->m . ' ' . ($diff->m == 1 ? 'Month' : 'Months');
            } else {
                $childAge = 'Less than 1 Month';
            }
        } catch (\Exception $e) {}
    }

    $status = trim($child->vaccination_status ?? 'Pending');
    $statusClass = 'pending';
    $statusIcon = 'bi-clock-fill';
    if ($status === 'Up to Date') {
        $statusClass = 'up-to-date';
        $statusIcon = 'bi-check-circle-fill';
    } elseif ($status === 'Partially Vaccinated') {
        $statusClass = 'partial';
        $statusIcon = 'bi-exclamation-circle-fill';
    }

    $parent = $child->parent;
    $parentUser = $parent ? $parent->user : null;
    $parentName = $parent->parent_name ?? ($parentUser->name ?? 'Parent');
    $parentEmail = $parentUser->email ?? 'N/A';
    $parentPhone = $parent->phone ?? 'Not Provided';
    $parentAddress = $parent->address ?? 'Not Provided';
@endphp

<div class="admin-details-page">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-check-circle-fill" style="font-size:18px;"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- PAGE HEADER -->
    <section class="details-page-header">
        <div class="details-header-left">
            <a href="{{ route('admin.children') }}" class="back-button">
                <i class="bi bi-arrow-left"></i> Back to Children
            </a>
            <span class="page-eyebrow">
                <i class="bi bi-person-vcard-fill"></i> CHILD DETAILS
            </span>
            <h1>{{ $child->child_name }}</h1>
            <p>Complete vaccination and parent information for this child.</p>
        </div>

        <div class="child-record-number" style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span>Child Record</span>
                <strong>#{{ $child->child_id }}</strong>
            </div>
            <div style="display:flex; align-items:center; gap:8px; margin-top:4px; flex-wrap:wrap;">
                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#editChildDetailsModal" style="border-radius:8px; font-weight:700; font-size:12px; display:inline-flex; align-items:center; gap:5px;">
                    <i class="bi bi-pencil-fill"></i> Edit
                </button>
                <form action="{{ route('admin.children.destroy', $child->child_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this child record?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px; font-weight:700; font-size:12px; display:inline-flex; align-items:center; gap:5px;">
                        <i class="bi bi-trash3-fill"></i> Delete
                    </button>
                </form>
                <a href="{{ route('admin.certificate.download', $child->child_id) }}" style="background:#0284c7; color:#fff; border-radius:8px; padding:6px 12px; text-decoration:none; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;" title="Download Official Certificate">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Certificate
                </a>
            </div>
        </div>
    </section>

    <!-- BASIC INFORMATION -->
    <section class="details-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">CHILD INFORMATION</span>
                <h2>Basic Details</h2>
            </div>
            <div class="child-avatar-large">
                <i class="bi bi-person-fill"></i>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-person-fill"></i> Child Name</span>
                <strong>{{ $child->child_name }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-calendar3"></i> Date of Birth</span>
                <strong>{{ $formattedDob }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-hourglass-split"></i> Age</span>
                <strong>{{ $childAge }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-gender-ambiguous"></i> Gender</span>
                <strong>{{ $child->gender ?? 'N/A' }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-droplet-fill"></i> Blood Group</span>
                <strong>{{ $child->blood_group ?: 'Not Provided' }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-telephone-fill"></i> Contact</span>
                <strong>{{ $child->contact ?: $parentPhone }}</strong>
            </div>
        </div>
    </section>

    <!-- VACCINATION STATUS -->
    <section class="details-card vaccination-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">VACCINATION STATUS</span>
                <h2>Current Status</h2>
            </div>
            <div class="status-icon {{ $statusClass }}">
                <i class="bi {{ $statusIcon }}"></i>
            </div>
        </div>

        <div class="vaccination-status-box">
            <span>Current Vaccination Status</span>
            <strong class="vaccination-status {{ $statusClass }}">
                <i class="bi {{ $statusIcon }}"></i> {{ $status }}
            </strong>
        </div>
    </section>

    <!-- PARENT INFORMATION -->
    <section class="details-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">PARENT INFORMATION</span>
                <h2>Parent Details</h2>
            </div>
            <div class="parent-avatar-large">
                <i class="bi bi-person-heart"></i>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-person-heart"></i> Parent Name</span>
                <strong>{{ $parentName }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-envelope-fill"></i> Email Address</span>
                <strong>{{ $parentEmail }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-telephone-fill"></i> Parent Phone</span>
                <strong>{{ $parentPhone }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-hash"></i> Parent ID</span>
                <strong>#{{ $child->parent_id }}</strong>
            </div>

            <div class="detail-item detail-item-full">
                <span class="detail-label"><i class="bi bi-geo-alt-fill"></i> Address</span>
                <strong>{!! nl2br(e($parentAddress)) !!}</strong>
            </div>
        </div>
    </section>

    <!-- VACCINATION HISTORY -->
    <section class="details-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">VACCINATION HISTORY</span>
                <h2>Administered Vaccines</h2>
            </div>
            <div class="notes-icon">
                <i class="bi bi-shield-check"></i>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vaccine</th>
                        <th>Hospital</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($child->vaccinations as $vax)
                        <tr>
                            <td><strong>{{ $vax->vaccine->vaccine_name ?? 'Vaccine' }}</strong></td>
                            <td>{{ $vax->hospital->hospital_name ?? 'Hospital' }}</td>
                            <td>{{ $vax->vaccination_date ? date('d M Y', strtotime($vax->vaccination_date)) : 'N/A' }}</td>
                            <td>{{ $vax->vaccination_time ?: 'N/A' }}</td>
                            <td>
                                <span class="badge badge-success">{{ $vax->status }}</span>
                            </td>
                            <td>{{ $vax->notes ?: 'None' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">
                                No vaccination history recorded yet for this child.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- ADDITIONAL NOTES -->
    <section class="details-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">ADDITIONAL INFORMATION</span>
                <h2>Notes</h2>
            </div>
            <div class="notes-icon">
                <i class="bi bi-sticky-fill"></i>
            </div>
        </div>

        <div class="notes-box">
            <p>{!! nl2br(e($child->additional_notes ?: 'No additional notes provided for this child record.')) !!}</p>
        </div>
    </section>

    <!-- RECORD INFORMATION -->
    <section class="details-card record-info-card">
        <div class="details-card-header">
            <div>
                <span class="card-eyebrow">RECORD INFORMATION</span>
                <h2>Database Record</h2>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-database"></i> Child ID</span>
                <strong>#{{ $child->child_id }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-person-badge-fill"></i> Parent ID</span>
                <strong>#{{ $child->parent_id }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-clock-fill"></i> Child Registered</span>
                <strong>{{ $child->created_at ? date('d M Y, h:i A', strtotime($child->created_at)) : 'N/A' }}</strong>
            </div>

            <div class="detail-item">
                <span class="detail-label"><i class="bi bi-calendar-check-fill"></i> Parent Registered</span>
                <strong>{{ $parent && $parent->created_at ? date('d M Y, h:i A', strtotime($parent->created_at)) : 'N/A' }}</strong>
            </div>
        </div>
    </section>
</div>
@endsection