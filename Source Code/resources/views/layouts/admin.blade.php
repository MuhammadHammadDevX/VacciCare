<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VacciCare | Admin Panel')</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-animations.css') }}">
    @include('partials.pwa')
    @stack('styles')
</head>

<body>
<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-logo">
            <a href="{{ route('admin.dashboard') }}" class="admin-logo-link">
                <span class="admin-logo-icon">
                    <i class="fa-solid fa-syringe" aria-hidden="true"></i>
                </span>
                <span class="admin-logo-copy">
                    <span class="admin-logo-text">Vacci<span>Care</span></span>
                    <span class="admin-logo-tagline">Vaccination Management System</span>
                </span>
            </a>
        </div>

        <div class="admin-panel-label">
            ADMIN PANEL
        </div>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.children') }}" class="admin-nav-link {{ request()->routeIs('admin.children') || request()->routeIs('admin.child-details') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>All Children</span>
            </a>

            <a href="{{ route('admin.vaccinations-date') }}" class="admin-nav-link {{ request()->routeIs('admin.vaccinations-date') ? 'active' : '' }}">
                <i class="bi bi-shield-plus"></i>
                <span>Vaccination Date & time</span>
            </a>

            <div class="admin-nav-dropdown {{ request()->routeIs('admin.vaccination-report') ? 'open' : '' }}">
                <button type="button" class="admin-nav-link reports-dropdown-btn" id="reportsDropdownBtn">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span>Report of vaccination</span>
                    <i class="bi bi-chevron-down reports-chevron"></i>
                </button>

                <div class="reports-dropdown-menu" id="reportsDropdownMenu">
                    <a href="{{ route('admin.vaccination-report') }}#childReport">
                        <i class="bi bi-person-vcard-fill"></i>
                        <span>Child-wise Report</span>
                    </a>
                    <a href="{{ route('admin.vaccination-report') }}#dateReport">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Date-wise Report</span>
                    </a>
                    <a href="{{ route('admin.vaccination-report') }}#vaccineReport">
                        <i class="bi bi-capsule-pill"></i>
                        <span>Vaccine-wise Report</span>
                    </a>
                    <a href="{{ route('admin.vaccination-report') }}">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>All Reports</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.vaccine-list') }}" class="admin-nav-link {{ request()->routeIs('admin.vaccine-list') ? 'active' : '' }}">
                <i class="bi bi-capsule-pill"></i>
                <span>List of vaccine</span>
            </a>

            <a href="{{ route('admin.parent-requests') }}" class="admin-nav-link {{ request()->routeIs('admin.parent-requests') ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i>
                <span>Parent Requests</span>
            </a>

            <a href="{{ route('admin.add-hospital') }}" class="admin-nav-link {{ request()->routeIs('admin.add-hospital') ? 'active' : '' }}">
                <i class="bi bi-hospital-fill"></i>
                <span>Add Hospitals</span>
            </a>

            <a href="{{ route('admin.hospital-list') }}" class="admin-nav-link {{ request()->routeIs('admin.hospital-list') || request()->routeIs('admin.view-hospital') || request()->routeIs('admin.edit-hospital') ? 'active' : '' }}">
                <i class="bi bi-hospital"></i>
                <span>List Of Hospital</span>
            </a>

            <a href="{{ route('admin.booking-details') }}" class="admin-nav-link {{ request()->routeIs('admin.booking-details') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check-fill"></i>
                <span>Booking Details</span>
            </a>
        </nav>

        <div class="admin-sidebar-bottom">
            <a href="{{ route('admin.profile') }}" class="admin-nav-link {{ request()->routeIs('admin.profile') || request()->routeIs('admin.edit-profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Admin Profile</span>
            </a>

            <a href="{{ route('logout', ['role' => 'admin']) }}" class="admin-nav-link admin-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <main class="admin-main">
        <header class="admin-header">
            <div class="admin-header-left">
                <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="admin-page-title">
                    <h1>Admin Panel</h1>
                    <p>Manage VacciCare vaccination services</p>
                </div>
            </div>

            <div class="header-profile-wrapper" id="headerProfileWrapper">
                <button type="button" class="header-profile-btn" id="headerProfileBtn" aria-haspopup="true" aria-expanded="false" aria-label="User account menu">
                    <div class="header-profile-image">
                        <img src="{{ asset('images/profile/default-profile.avif') }}" alt="Admin Profile"
                             onerror="this.onerror=null; this.src='{{ asset('images/profile/default-profile.avif') }}';">
                    </div>
                    <div class="header-profile-info">
                        <span class="header-welcome">Welcome back</span>
                        <strong>{{ session('admin_name', session('name', 'Administrator')) }}</strong>
                    </div>
                    <i class="bi bi-chevron-down profile-arrow"></i>
                </button>

                <!-- Floating Dropdown Menu -->
                <div class="profile-dropdown-menu" id="profileDropdownMenu">
                    <div class="dropdown-user-card">
                        <div class="dropdown-user-avatar">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div class="dropdown-user-meta">
                            <strong>{{ session('admin_name', session('name', 'Administrator')) }}</strong>
                            <small>{{ session('admin_email', session('email', 'admin@vaccicare.test')) }}</small>
                            <span class="role-pill">SUPER ADMIN</span>
                        </div>
                    </div>

                    <div class="profile-dropdown-divider"></div>

                    <a href="{{ route('admin.profile') }}" class="dropdown-link-item">
                        <i class="bi bi-person-circle"></i>
                        <span>Admin Profile</span>
                    </a>

                    <a href="{{ route('admin.edit-profile') }}" class="dropdown-link-item">
                        <i class="bi bi-gear-fill"></i>
                        <span>Account Settings</span>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="dropdown-link-item">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard Home</span>
                    </a>

                    <div class="profile-dropdown-divider"></div>

                    <a href="{{ route('logout', ['role' => 'admin']) }}" class="dropdown-link-item logout-item">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </header>

        <div class="admin-content">
            @yield('content')
        </div>
    </main>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const reportsBtn = document.getElementById("reportsDropdownBtn");
    const reportsDropdown = document.querySelector(".admin-nav-dropdown");
    if (reportsBtn && reportsDropdown) {
        reportsBtn.addEventListener("click", function (event) {
            event.preventDefault();
            reportsDropdown.classList.toggle("open");
        });
    }

    const toggleBtn = document.getElementById("adminSidebarToggle");
    const sidebar = document.getElementById("adminSidebar");
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("open");
        });
    }

    const profileWrapper = document.getElementById("headerProfileWrapper");
    const profileBtn = document.getElementById("headerProfileBtn");
    if (profileBtn && profileWrapper) {
        profileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            const isOpen = profileWrapper.classList.contains("open");
            profileWrapper.classList.toggle("open", !isOpen);
            profileBtn.setAttribute("aria-expanded", !isOpen);
        });

        document.addEventListener("click", function (e) {
            if (!profileWrapper.contains(e.target)) {
                profileWrapper.classList.remove("open");
                profileBtn.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && profileWrapper.classList.contains("open")) {
                profileWrapper.classList.remove("open");
                profileBtn.setAttribute("aria-expanded", "false");
            }
        });
    }

});
</script>
<script src="{{ asset('js/premium-animations.js') }}"></script>
@stack('scripts')
</body>
</html>
