@extends('layouts.hospital')

@section('title', 'Hospital Dashboard | VacciCare')
@section('header_title', 'Hospital Dashboard')
@section('header_subtitle', 'Manage vaccination records and appointments')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hospital-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
@endpush

@section('content')
<section class="dashboard-content">

    <div class="dash-atmosphere" aria-hidden="true">
        <span class="dash-orb dash-orb-1"></span>
        <span class="dash-orb dash-orb-2"></span>
        <span class="dash-orb dash-orb-3"></span>
    </div>

    <!-- WELCOME SECTION -->
    <div class="welcome-section">
        <div class="welcome-glow" aria-hidden="true"></div>
        <div>
            <span class="section-tag">
                <i class="bi bi-heart-pulse-fill"></i>
                VACCINATION MANAGEMENT
            </span>
            <h2>Welcome, {{ $hospitalUser->hospital_name ?? ($hospital->hospital_name ?? 'Hospital') }}</h2>
            <p>Manage vaccination records and keep children's vaccine status up to date.</p>
        </div>
        <div class="welcome-icon">
            <i class="bi bi-hospital"></i>
        </div>
    </div>

    @if(($lowStockCount ?? 0) > 0 || ($outOfStockCount ?? 0) > 0 || ($expiringSoonCount ?? 0) > 0)
        <div style="background:#fffbeb; border:1px solid #fcd34d; border-radius:14px; padding:16px 20px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; box-shadow:0 2px 8px rgba(245,158,11,0.08);">
            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:44px; height:44px; background:#fef3c7; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#b45309; font-size:22px;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    <strong style="color:#92400e; font-size:15px; display:block;">Vaccine Inventory Alerts</strong>
                    <span style="font-size:13px; color:#78350f;">
                        @if(($lowStockCount ?? 0) > 0) <strong>{{ $lowStockCount }}</strong> low stock &bull; @endif
                        @if(($outOfStockCount ?? 0) > 0) <strong>{{ $outOfStockCount }}</strong> out of stock &bull; @endif
                        @if(($expiringSoonCount ?? 0) > 0) <strong>{{ $expiringSoonCount }}</strong> expiring within 30 days @endif
                    </span>
                </div>
            </div>
            <a href="{{ route('hospital.all-vaccines') }}" style="background:#b45309; color:#fff; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none;">
                Manage Inventory
            </a>
        </div>
    @endif

    <!-- STATS GRID -->
    <div class="stats-grid">
        <!-- TOTAL CHILDREN -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-info">
                <span>Total Children</span>
                <strong>{{ $totalChildren }}</strong>
                <small>Registered records</small>
            </div>
        </div>

        <!-- VACCINES UPDATED -->
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="stat-info">
                <span>Vaccines Updated</span>
                <strong>{{ $vaccinesUpdated }}</strong>
                <small>Completed records</small>
            </div>
        </div>

        <!-- PENDING -->
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <span>Pending Updates</span>
                <strong>{{ $pendingUpdates }}</strong>
                <small>Need attention</small>
            </div>
        </div>

        <!-- TOTAL STOCK -->
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff; color:#0284c7;">
                <i class="bi bi-boxes"></i>
            </div>
            <div class="stat-info">
                <span>Vaccine Stock</span>
                <strong>{{ $totalStock ?? 0 }}</strong>
                <small>Vials in stock</small>
            </div>
        </div>
    </div>

    <!-- ACTION CARD -->
    <div class="update-card">
        <div class="update-card-content">
            <div class="update-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="update-text">
                <span class="small-label">VACCINATION RECORDS</span>
                <h3>Update Vaccine Status</h3>
                <p>Record completed vaccinations and update the vaccine status of children.</p>
            </div>
        </div>
        <a href="{{ route('hospital.vaccine-status') }}" class="update-btn">
            Update Vaccine Status <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <!-- RECENT UPDATES -->
    <div class="recent-section">
        <div class="section-heading">
            <div>
                <span class="small-label">VACCINATION RECORDS</span>
                <h3>Recent Updates</h3>
            </div>
            <a href="{{ route('hospital.vaccine-status') }}">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="updates-card">
            @if(count($recentUpdates) > 0)
                @foreach($recentUpdates as $update)
                    @php
                        $childName = $update->child->child_name ?? ($update['child_name'] ?? 'Unknown Child');
                        $vaccineName = $update->vaccine->vaccine_name ?? ($update['vaccine_name'] ?? 'Vaccination');
                        $status = $update->status ?? ($update['status'] ?? 'Pending');
                        $date = $update->vaccination_date ?? ($update['vaccination_date'] ?? '');

                        $words = preg_split('/\s+/', trim($childName));
                        $initials = '';
                        if (!empty($words[0])) {
                            $initials .= strtoupper(substr($words[0], 0, 1));
                        }
                        if (count($words) > 1 && !empty($words[1])) {
                            $initials .= strtoupper(substr($words[1], 0, 1));
                        }
                        if ($initials === '') {
                            $initials = 'CH';
                        }
                    @endphp
                    <div class="update-row">
                        <!-- AVATAR -->
                        <div class="child-avatar">
                            {{ $initials }}
                        </div>

                        <!-- CHILD DETAILS -->
                        <div class="child-details">
                            <strong>{{ $childName }}</strong>
                            <span>{{ $vaccineName }}</span>
                        </div>

                        <!-- STATUS -->
                        @if($status === 'Completed')
                            <span class="status completed">
                                <i class="bi bi-check-circle-fill"></i>
                                Completed
                            </span>
                        @elseif($status === 'Cancelled')
                            <span class="status pending">
                                <i class="bi bi-x-circle-fill"></i>
                                Cancelled
                            </span>
                        @else
                            <span class="status pending">
                                <i class="bi bi-clock-fill"></i>
                                Pending
                            </span>
                        @endif

                        <!-- DATE -->
                        <span class="update-date">
                            {{ !empty($date) ? date('d M Y', strtotime($date)) : 'N/A' }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-dashboard-update" style="padding: 30px; text-align: center;">
                    <i class="bi bi-clipboard2-check" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                    <strong>No vaccination updates yet</strong>
                    <p>Completed vaccination records will appear here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- SECURITY NOTE -->
    <div class="security-note">
        <div class="security-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div>
            <strong>Secure Hospital Portal</strong>
            <p>Vaccination records are managed securely through the VacciCare platform.</p>
        </div>
    </div>

</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/hospital-dashboard.js') }}"></script>
@endpush
