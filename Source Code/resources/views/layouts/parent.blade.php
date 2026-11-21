<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Parent Panel | VacciCare')</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/parent-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-animations.css') }}">
    @include('partials.pwa')
    @stack('styles')
</head>

<body>

<!-- HEADER -->
<header class="dashboard-header">
    <div class="header-left">
        <div class="header-page-title">
            <h1>Parent Panel</h1>
            <p>Manage your children's vaccination services</p>
        </div>
        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open dashboard menu">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="header-right">
        <div class="header-profile-wrapper" id="parentProfileWrapper">
            <button type="button" class="header-profile-btn" id="parentProfileBtn" aria-haspopup="true" aria-expanded="false" aria-label="Parent account menu">
                <div class="header-profile-image">
                    <img src="{{ asset('images/profile/default-profile.avif') }}" alt="Parent Profile"
                         onerror="this.onerror=null; this.src='{{ asset('images/profile/default-profile.avif') }}';">
                </div>
                <div class="header-profile-info">
                    <span class="header-welcome">Welcome back</span>
                    <strong>{{ session('parent_name', session('name', 'Parent')) }}</strong>
                </div>
                <i class="bi bi-chevron-down profile-arrow"></i>
            </button>

            <!-- Floating Dropdown Menu -->
            <div class="profile-dropdown-menu" id="parentDropdownMenu">
                <div class="dropdown-user-card">
                    <div class="dropdown-user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="dropdown-user-meta">
                        <strong>{{ session('parent_name', session('name', 'Parent')) }}</strong>
                        <small>{{ session('email', 'parent@vaccicare.test') }}</small>
                        <span class="role-pill">PARENT</span>
                    </div>
                </div>

                <div class="profile-dropdown-divider"></div>

                <a href="{{ route('parent.profile') }}" class="dropdown-link-item">
                    <i class="bi bi-person-circle"></i>
                    <span>My Profile</span>
                </a>

                <a href="{{ route('parent.edit-profile') }}" class="dropdown-link-item">
                    <i class="bi bi-gear-fill"></i>
                    <span>Account Settings</span>
                </a>

                <a href="{{ route('parent.dashboard') }}" class="dropdown-link-item">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard Home</span>
                </a>

                <div class="profile-dropdown-divider"></div>

                <a href="{{ route('logout', ['role' => 'parent']) }}" class="dropdown-link-item logout-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="sidebar-logo-link">
                <span class="sidebar-logo-icon">
                    <i class="fa-solid fa-syringe" aria-hidden="true"></i>
                </span>
                <span class="sidebar-logo-copy">
                    <span class="sidebar-logo-text">Vacci<span>Care</span></span>
                    <span class="sidebar-logo-tagline">Vaccination Management System</span>
                </span>
            </a>
        </div>

        <nav class="dashboard-nav">
            <a href="{{ route('parent.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('parent.profile') }}" class="dashboard-nav-link {{ request()->routeIs('parent.profile') || request()->routeIs('parent.edit-profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>My Profile</span>
            </a>

            <a href="{{ route('parent.children') }}" class="dashboard-nav-link {{ request()->routeIs('parent.children') || request()->routeIs('parent.edit-child') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Details of child</span>
            </a>

            <a href="{{ route('parent.schedule') }}" class="dashboard-nav-link {{ request()->routeIs('parent.schedule') ? 'active' : '' }}">
                <i class="bi bi-calendar2-week-fill"></i>
                <span>Vaccination Schedule</span>
            </a>

            <a href="{{ route('parent.book-hospital') }}" class="dashboard-nav-link {{ request()->routeIs('parent.book-hospital') ? 'active' : '' }}">
                <i class="bi bi-calendar2-plus-fill"></i>
                <span>Book Hospital</span>
            </a>

            <a href="{{ route('parent.requests') }}" class="dashboard-nav-link {{ request()->routeIs('parent.requests') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check-fill"></i>
                <span>Request Hospital</span>
            </a>

            <a href="{{ route('parent.report') }}" class="dashboard-nav-link {{ request()->routeIs('parent.report') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Report of vaccination</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <a href="{{ route('logout', ['role' => 'parent']) }}" class="dashboard-nav-link logout-link">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- PAGE CONTENT -->
    @yield('content')

</div>

<div class="dashboard-overlay" id="dashboardOverlay"></div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/parent_dashboard.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const profileWrapper = document.getElementById("parentProfileWrapper");
    const profileBtn = document.getElementById("parentProfileBtn");
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
