@extends('layouts.admin')

@section('title', 'All Children | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-children.css') }}">
@endpush

@section('content')
<div class="admin-children-page">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-check-circle-fill" style="font-size:18px;"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size:18px;"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- PAGE HEADER -->
    <section class="children-page-header">
        <div>
            <span class="page-eyebrow">
                <i class="bi bi-people-fill"></i>
                CHILDREN MANAGEMENT
            </span>
            <h1>All Children</h1>
            <p>View all registered children, parents and vaccination status.</p>
        </div>
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <button type="button" class="btn-add-primary" data-toggle="modal" data-target="#addChildModal">
                <i class="bi bi-plus-circle-fill"></i> Register Child
            </button>
            <a href="{{ route('admin.export.children') }}" style="background:#10b981; color:#fff; border-radius:10px; padding:10px 18px; font-weight:700; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(16,185,129,0.2);">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Children (CSV)
            </a>
        </div>
    </section>

    <!-- STATS STRIP -->
    <section class="children-stats-strip">
        <!-- TOTAL -->
        <div class="mini-stat">
            <div class="mini-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <span>Total Children</span>
                <strong>{{ $totalChildren }}</strong>
            </div>
        </div>

        <!-- UP TO DATE -->
        <div class="mini-stat">
            <div class="mini-icon green">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <span>Up to Date</span>
                <strong>{{ $upToDateCount }}</strong>
            </div>
        </div>

        <!-- PENDING -->
        <div class="mini-stat">
            <div class="mini-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <span>Pending</span>
                <strong>{{ $pendingCount }}</strong>
            </div>
        </div>

        <!-- PARTIALLY VACCINATED -->
        <div class="mini-stat">
            <div class="mini-icon purple">
                <i class="bi bi-capsule-pill"></i>
            </div>
            <div>
                <span>Partially Vaccinated</span>
                <strong>{{ $partiallyVaccinatedCount ?? 0 }}</strong>
            </div>
        </div>
    </section>

    <!-- CHILDREN TABLE -->
    <section class="children-table-card">
        <div class="table-card-header">
            <div>
                <span class="card-eyebrow">REGISTERED CHILDREN</span>
                <h2>Children Records</h2>
                <p>Complete list of children registered in VacciCare.</p>
            </div>
            <div class="record-count">
                <i class="bi bi-database"></i>
                {{ $totalChildren }} Records
            </div>
        </div>

        <div class="children-table-wrapper">
            <table class="children-table">
                <thead>
                    <tr>
                        <th>Child</th>
                        <th>Parent Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Contact</th>
                        <th>Vaccination Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($children as $child)
                        @php
                            $dob = $child->date_of_birth;
                            $formattedDob = $dob ? date('d F Y', strtotime($dob)) : 'N/A';

                            $age = 'N/A';
                            if ($dob) {
                                try {
                                    $birth = new DateTime($dob);
                                    $now = new DateTime();
                                    $diff = $birth->diff($now);
                                    if ($diff->y > 0) {
                                        $age = $diff->y . ' ' . ($diff->y == 1 ? 'Year' : 'Years');
                                    } elseif ($diff->m > 0) {
                                        $age = $diff->m . ' ' . ($diff->m == 1 ? 'Month' : 'Months');
                                    } else {
                                        $age = 'Less than 1 Month';
                                    }
                                } catch (\Exception $e) {}
                            }

                            $status = trim($child->vaccination_status ?? 'Pending');
                            $statusClass = 'pending';
                            if ($status === 'Up to Date') {
                                $statusClass = 'up-to-date';
                            } elseif ($status === 'Partially Vaccinated') {
                                $statusClass = 'partial';
                            }

                            $parentName = $child->parent->parent_name ?? ($child->parent->user->name ?? 'Parent');
                        @endphp
                        <tr>
                            <!-- CHILD -->
                            <td>
                                <div class="child-person">
                                    <div class="child-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $child->child_name }}</strong>
                                        <small>Child Record #{{ $child->child_id }}</small>
                                    </div>
                                </div>
                            </td>

                            <!-- PARENT -->
                            <td>
                                <div class="parent-name">
                                    <i class="bi bi-person-heart"></i>
                                    <span>{{ $parentName }}</span>
                                </div>
                            </td>

                            <!-- DOB -->
                            <td>
                                <div class="table-detail">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $formattedDob }}
                                </div>
                            </td>

                            <!-- GENDER -->
                            <td>
                                <span class="gender-badge">
                                    @if($child->gender === 'Female')
                                        <i class="bi bi-gender-female"></i>
                                    @elseif($child->gender === 'Male')
                                        <i class="bi bi-gender-male"></i>
                                    @else
                                        <i class="bi bi-gender-ambiguous"></i>
                                    @endif
                                    {{ $child->gender ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- AGE -->
                            <td>
                                <span class="age-text">{{ $age }}</span>
                            </td>

                            <!-- CONTACT -->
                            <td>
                                <div class="contact-detail">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span>{{ $child->contact ?: ($child->parent->phone ?? 'Not Provided') }}</span>
                                </div>
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="vaccination-status {{ $statusClass }}">
                                    @if($status === 'Up to Date')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($status === 'Partially Vaccinated')
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                    @else
                                        <i class="bi bi-clock-fill"></i>
                                    @endif
                                    {{ $status }}
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td style="white-space:nowrap; text-align:right;">
                                <div class="table-action-btns">
                                    <a href="{{ route('admin.child-details', $child->child_id) }}" class="action-btn-circle view-btn" title="View Full Details">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button type="button" class="action-btn-circle edit-btn" data-toggle="modal" data-target="#editChildModal{{ $child->child_id }}" title="Edit Child Record">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('admin.children.destroy', $child->child_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete child record for {{ addslashes($child->child_name) }}?');">
                                        @csrf
                                        <button type="submit" class="action-btn-circle delete-btn" title="Delete Child Record">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:30px;">
                                No children records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection