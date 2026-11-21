@extends('layouts.parent')

@section('title', 'Hospital Requests | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-hospital.css') }}">
@endpush

@section('content')
<main class="request-main">
    <section class="request-page-header">
        <div class="page-header-content">
            <div class="page-header-text">
                <span class="page-eyebrow">
                    <i class="bi bi-clock-history"></i>
                    HOSPITAL REQUESTS
                </span>
                <h1>My Hospital Requests</h1>
                <p>Track the status of your vaccination appointment requests submitted through Book Hospital.</p>
            </div>
            <div class="page-header-icon">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
        </div>
    </section>

    <section class="request-stats-section">
        <div class="request-stats">
            <!-- TOTAL -->
            <div class="request-stat-card">
                <div class="request-stat-icon total"><i class="bi bi-calendar2-week"></i></div>
                <div>
                    <span>Total Requests</span>
                    <strong>{{ $totalRequests }}</strong>
                </div>
            </div>

            <!-- PENDING -->
            <div class="request-stat-card">
                <div class="request-stat-icon pending"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <span>Pending</span>
                    <strong>{{ $pendingRequests }}</strong>
                </div>
            </div>

            <!-- APPROVED -->
            <div class="request-stat-card">
                <div class="request-stat-icon approved"><i class="bi bi-check-circle-fill"></i></div>
                <div>
                    <span>Approved</span>
                    <strong>{{ $approvedRequests }}</strong>
                </div>
            </div>

            <!-- REJECTED -->
            <div class="request-stat-card">
                <div class="request-stat-icon rejected"><i class="bi bi-x-circle-fill"></i></div>
                <div>
                    <span>Rejected</span>
                    <strong>{{ $rejectedRequests }}</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="request-history-section">
        <div class="request-card">
            <div class="request-card-header">
                <div class="request-card-title">
                    <div class="title-icon"><i class="bi bi-list-check"></i></div>
                    <div>
                        <h2>Request Status</h2>
                        <p>View the current status of your hospital vaccination requests.</p>
                    </div>
                </div>
                <div class="request-count-badge">
                    {{ $totalRequests }} {{ $totalRequests === 1 ? 'Request' : 'Requests' }}
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover request-table">
                    <thead>
                        <tr>
                            <th>Request</th>
                            <th>Child</th>
                            <th>Hospital</th>
                            <th>Vaccine</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            @php
                                $status = trim($request->status ?? 'Pending');
                            @endphp
                            <tr>
                                <td>
                                    <div class="request-id-cell">
                                        <span class="request-id">#{{ $request->request_id }}</span>
                                        <small>{{ $request->request_type ?? 'Vaccination' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="child-cell">
                                        <div class="child-icon"><i class="bi bi-person-fill"></i></div>
                                        <div>
                                            <strong>{{ $request->child->child_name ?? 'N/A' }}</strong>
                                            <small>Child ID: {{ $request->child_id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="hospital-cell">
                                        <i class="bi bi-hospital-fill"></i>
                                        <div>
                                            <span>{{ $request->hospital->hospital_name ?? 'N/A' }}</span>
                                            @if(!empty($request->hospital->city))
                                                <small>{{ $request->hospital->city }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="vaccine-cell">
                                        <i class="bi bi-shield-plus"></i>
                                        <span>{{ $request->hospitalVaccine->vaccine_name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <i class="bi bi-calendar3"></i>
                                        {{ !empty($request->request_date) ? date('d M Y', strtotime($request->request_date)) : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="time-cell">
                                        <i class="bi bi-clock-fill"></i>
                                        {{ !empty($request->preferred_time) ? date('h:i A', strtotime($request->preferred_time)) : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @if(strcasecmp($status, 'Pending') === 0)
                                        <span class="request-status pending">
                                            <span class="status-dot"></span>
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        </span>
                                    @elseif(strcasecmp($status, 'Approved') === 0)
                                        <span class="request-status approved">
                                            <span class="status-dot"></span>
                                            <i class="bi bi-check-circle-fill"></i> Approved
                                        </span>
                                    @else
                                        <span class="request-status rejected">
                                            <span class="status-dot"></span>
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="request-empty-state">
                                        <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                                        <h3>No Hospital Requests</h3>
                                        <p>You have not submitted any hospital vaccination requests yet.</p>
                                        <a href="{{ route('parent.book-hospital') }}" class="btn btn-primary">
                                            <i class="bi bi-calendar-plus"></i> Book Hospital
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection
