<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hospital Portal | VacciCare')</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/hospital-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-animations.css') }}">
    @include('partials.pwa')
    @stack('styles')
</head>

<body>
<div class="hospital-layout">

    <!-- SIDEBAR -->
    <aside class="hospital-sidebar" id="hospitalSidebar">
        <div class="sidebar-logo">
            <a href="{{ route('hospital.dashboard') }}" class="sidebar-logo-link">
                <span class="sidebar-logo-icon">
                    <i class="fa-solid fa-syringe" aria-hidden="true"></i>
                </span>
                <span class="sidebar-logo-copy">
                    <span class="sidebar-logo-text">Vacci<span>Care</span></span>
                    <span class="sidebar-logo-tagline">Vaccination Management System</span>
                </span>
            </a>
        </div>

        <div class="portal-badge">
            <i class="bi bi-hospital"></i>
            Hospital Portal
        </div>

        <nav class="hospital-nav">
            <a href="{{ route('hospital.dashboard') }}" class="hospital-nav-link {{ request()->routeIs('hospital.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('hospital.vaccine-status') }}" class="hospital-nav-link {{ request()->routeIs('hospital.vaccine-status') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Update Vaccine Status</span>
            </a>

            <a href="{{ route('hospital.add-vaccine') }}" class="hospital-nav-link {{ request()->routeIs('hospital.add-vaccine') ? 'active' : '' }}">
                <i class="bi bi-capsule"></i>
                <span>Add Vaccine</span>
            </a>

            <a href="{{ route('hospital.all-vaccines') }}" class="hospital-nav-link {{ request()->routeIs('hospital.all-vaccines') ? 'active' : '' }}">
                <i class="bi bi-capsule-pill"></i>
                <span>All Vaccines</span>
            </a>

            <a href="{{ route('hospital.appointments') }}" class="hospital-nav-link {{ request()->routeIs('hospital.appointments') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Appointments</span>
            </a>

            <a href="{{ route('hospital.vaccinators') }}" class="hospital-nav-link {{ request()->routeIs('hospital.vaccinators') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Vaccinators</span>
            </a>

            <a href="{{ route('hospital.profile') }}" class="hospital-nav-link {{ request()->routeIs('hospital.profile') || request()->routeIs('hospital.edit-profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Hospital Profile</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <a href="{{ route('logout', ['role' => 'hospital']) }}" class="hospital-nav-link logout-link">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="hospital-main">
        <header class="hospital-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Toggle hospital menu">
                    <i class="bi bi-list"></i>
                </button>

                <div class="hospital-page-title">
                    <h1>@yield('header_title', 'Hospital Panel')</h1>
                    <p>@yield('header_subtitle', 'Manage hospital vaccination services')</p>
                </div>
            </div>

            <div class="header-right">
                <div class="header-profile-wrapper" id="hospitalProfileWrapper">
                    <button type="button" class="header-profile-btn" id="hospitalProfileBtn" aria-haspopup="true" aria-expanded="false" aria-label="Hospital account menu">
                        <div class="header-profile-image">
                            <img src="{{ asset('images/profile/default-profile.avif') }}" alt="Hospital Profile"
                                 onerror="this.onerror=null; this.src='{{ asset('images/profile/default-profile.avif') }}';">
                        </div>
                        <div class="header-profile-info">
                            <span class="header-welcome">Welcome back</span>
                            <strong>{{ session('hospital_name', 'Hospital') }}</strong>
                        </div>
                        <i class="bi bi-chevron-down profile-arrow"></i>
                    </button>

                    <!-- Floating Dropdown Menu -->
                    <div class="profile-dropdown-menu" id="hospitalDropdownMenu">
                        <div class="dropdown-user-card">
                            <div class="dropdown-user-avatar">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <div class="dropdown-user-meta">
                                <strong>{{ session('hospital_name', 'Hospital') }}</strong>
                                <small>{{ session('email', 'hospital@vaccicare.test') }}</small>
                                <span class="role-pill">HOSPITAL</span>
                            </div>
                        </div>

                        <div class="profile-dropdown-divider"></div>

                        <a href="{{ route('hospital.profile') }}" class="dropdown-link-item">
                            <i class="bi bi-person-circle"></i>
                            <span>Hospital Profile</span>
                        </a>

                        <a href="{{ route('hospital.edit-profile') }}" class="dropdown-link-item">
                            <i class="bi bi-gear-fill"></i>
                            <span>Account Settings</span>
                        </a>

                        <a href="{{ route('hospital.dashboard') }}" class="dropdown-link-item">
                            <i class="bi bi-grid-1x2-fill"></i>
                            <span>Dashboard Home</span>
                        </a>

                        <div class="profile-dropdown-divider"></div>

                        <a href="{{ route('logout', ['role' => 'hospital']) }}" class="dropdown-link-item logout-item">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        @yield('content')
    </main>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("hospitalSidebar");
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("open");
        });
    }

    const profileWrapper = document.getElementById("hospitalProfileWrapper");
    const profileBtn = document.getElementById("hospitalProfileBtn");
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
