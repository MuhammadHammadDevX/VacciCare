@extends('layouts.parent')

@section('title', 'Parent Dashboard | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/parent-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
@endpush

@section('content')
<main class="dashboard-main">
    <div class="dashboard-content">
        <!-- BACKGROUND EFFECT -->
        <div class="dash-atmosphere" aria-hidden="true">
            <span class="dash-orb dash-orb-1"></span>
            <span class="dash-orb dash-orb-2"></span>
            <span class="dash-orb dash-orb-3"></span>
        </div>

        <section class="welcome-banner">
            <div class="virus-decoration" aria-hidden="true">
                <span class="virus virus-1">
                    <i></i><i></i><i></i><i></i><i></i><i></i>
                </span>
                <span class="virus virus-2">
                    <i></i><i></i><i></i><i></i><i></i>
                </span>
                <span class="virus virus-3">
                    <i></i><i></i><i></i><i></i><i></i><i></i>
                </span>
                <span class="virus-circle circle-1"></span>
                <span class="virus-circle circle-2"></span>
                <span class="virus-circle circle-3"></span>
                <span class="virus-dot dot-1"></span>
                <span class="virus-dot dot-2"></span>
                <span class="virus-dot dot-3"></span>
            </div>

            <div class="welcome-content">
                <span class="banner-label">WELCOME, {{ $parentName }}</span>
                <h1>Keep Your Family Protected.</h1>
                <p>Manage your children's vaccination records, upcoming schedules and appointments from one secure place.</p>
                <a href="{{ route('appointment') }}" class="primary-banner-btn">
                    <i class="bi bi-calendar2-plus"></i>
                    Book Vaccination
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="welcome-visual">
                <div class="banner-image-wrapper">
                    <img src="{{ asset('images/dashboard/vaccination-banner.png') }}" alt="Child vaccination healthcare" class="vaccination-banner-image">
                </div>
                <div class="protected-badge">
                    <i class="bi bi-shield-check"></i>
                    <span>Vaccination Protected</span>
                </div>
                <div class="upcoming-badge">
                    <i class="bi bi-calendar-event"></i>
                    <span>{{ $upcomingVaccinations }} Upcoming</span>
                </div>
            </div>
        </section>

        <section class="dashboard-stats">
            <div class="dashboard-stat-card">
                <div class="stat-icon children-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-content">
                    <span>MY CHILDREN</span>
                    <strong>{{ $childrenCount }}</strong>
                </div>
                <i class="bi bi-arrow-up-right stat-arrow"></i>
            </div>

            <div class="dashboard-stat-card">
                <div class="stat-icon schedule-icon">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div class="stat-content">
                    <span>UPCOMING</span>
                    <strong>{{ $upcomingVaccinations }}</strong>
                </div>
                <i class="bi bi-arrow-up-right stat-arrow"></i>
            </div>

            <div class="dashboard-stat-card">
                <div class="stat-icon request-icon">
                    <i class="bi bi-clipboard2-check-fill"></i>
                </div>
                <div class="stat-content">
                    <span>PENDING REQUESTS</span>
                    <strong>{{ $pendingRequests }}</strong>
                </div>
                <i class="bi bi-arrow-up-right stat-arrow"></i>
            </div>

            <div class="dashboard-stat-card">
                <div class="stat-icon history-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stat-content">
                    <span>VACCINATIONS TAKEN</span>
                    <strong>{{ $completedVaccinations }}</strong>
                </div>
                <i class="bi bi-arrow-up-right stat-arrow"></i>
            </div>
        </section>

        <section class="dashboard-section">
            <div class="section-heading">
                <div>
                    <span class="section-label">QUICK ACTIONS</span>
                    <h2>Manage Vaccination</h2>
                </div>
            </div>

            <div class="quick-action-grid">
                <a href="{{ route('parent.children') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h3>My Children</h3>
                        <p>Add and manage child records.</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('appointment') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-calendar2-plus-fill"></i>
                    </div>
                    <div>
                        <h3>Book Vaccination</h3>
                        <p>Select vaccine, hospital and time.</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('parent.schedule') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-calendar2-week-fill"></i>
                    </div>
                    <div>
                        <h3>Vaccination Schedule</h3>
                        <p>Check upcoming vaccination dates.</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('parent.report') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-file-medical-fill"></i>
                    </div>
                    <div>
                        <h3>Vaccination History</h3>
                        <p>View previous vaccination records.</p>
                    </div>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section>

        <section class="dashboard-section">
            <div class="section-heading">
                <div>
                    <span class="section-label">VACCINATION SCHEDULE</span>
                    <h2>Upcoming Vaccinations</h2>
                </div>
                <a href="{{ route('parent.schedule') }}" class="view-all-btn">
                    View Schedule <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if(count($upcomingAppointments) > 0)
                <div class="upcoming-dashboard-list">
                    @foreach($upcomingAppointments as $appointment)
                        <div class="appointment-dashboard-card">
                            <div class="appointment-icon">
                                <i class="bi bi-calendar2-check-fill"></i>
                            </div>
                            <div class="appointment-info">
                                <span class="appointment-label">UPCOMING VACCINATION</span>
                                <h3>{{ $appointment['vaccine_name'] ?: 'Vaccination' }}</h3>
                                <p><i class="bi bi-person-fill"></i> {{ $appointment['child_name'] }}</p>
                                <p><i class="bi bi-hospital-fill"></i> {{ $appointment['hospital_name'] ?: 'Hospital' }} {{ !empty($appointment['city']) ? ' - ' . $appointment['city'] : '' }}</p>
                            </div>
                            <div class="appointment-date">
                                <strong>{{ date('d', strtotime($appointment['request_date'])) }}</strong>
                                <span>{{ strtoupper(date('M Y', strtotime($appointment['request_date']))) }}</span>
                                @if(!empty($appointment['preferred_time']))
                                    <small><i class="bi bi-clock"></i> {{ date('h:i A', strtotime($appointment['preferred_time'])) }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-dashboard-card">
                    <div class="empty-icon"><i class="bi bi-calendar2-check"></i></div>
                    <h3>No Upcoming Vaccinations</h3>
                    <p>Your approved upcoming vaccination appointments will appear here.</p>
                    <a href="{{ route('appointment') }}" class="secondary-action-btn">Book Vaccination</a>
                </div>
            @endif
        </section>

        <section class="dashboard-section">
            <div class="section-heading">
                <div>
                    <span class="section-label">APPOINTMENTS</span>
                    <h2>Recent Requests</h2>
                </div>
                <a href="{{ route('parent.requests') }}" class="view-all-btn">
                    View Requests <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if(count($recentRequests) > 0)
                <div class="requests-dashboard-card">
                    @foreach($recentRequests as $request)
                        <div class="request-dashboard-row">
                            <div class="request-dashboard-icon">
                                @if($request['status'] === 'Approved')
                                    <i class="bi bi-check-circle-fill"></i>
                                @elseif($request['status'] === 'Rejected')
                                    <i class="bi bi-x-circle-fill"></i>
                                @else
                                    <i class="bi bi-clock-fill"></i>
                                @endif
                            </div>
                            <div class="request-dashboard-info">
                                <strong>{{ $request['child_name'] }}</strong>
                                <span>{{ $request['vaccine_name'] ?: 'Vaccination' }} {{ !empty($request['hospital_name']) ? ' • ' . $request['hospital_name'] : '' }}</span>
                            </div>
                            <div class="request-dashboard-date">
                                <strong>{{ date('d M Y', strtotime($request['request_date'])) }}</strong>
                                @if(!empty($request['preferred_time']))
                                    <small>{{ date('h:i A', strtotime($request['preferred_time'])) }}</small>
                                @endif
                            </div>
                            <span class="request-status {{ strtolower($request['status']) }}">
                                {{ $request['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-dashboard-card compact">
                    <div class="empty-icon"><i class="bi bi-clipboard2-check"></i></div>
                    <h3>No Appointment Requests</h3>
                    <p>Your vaccination booking requests will appear here.</p>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/parent_dashboard.js') }}"></script>
@endpush
