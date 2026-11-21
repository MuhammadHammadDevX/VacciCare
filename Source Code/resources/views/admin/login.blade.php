<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login | VacciCare</title>

    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <main class="admin-login-page">

        <!-- LEFT SIDE -->
        <section class="login-intro">
            <div class="intro-content">
                <!-- Logo -->
                
                <!-- Main Navbar Style Linked Logo -->
                <a class="auth-brand-link" href="{{ route('home') }}" title="Return to VacciCare Homepage">
                    <span class="brand-icon-badge">
                        <i class="fa-solid fa-syringe" aria-hidden="true"></i>
                    </span>
                    <span class="brand-text-wrap">
                        <span class="brand-name">
                            <span class="brand-name-white">Vacci</span><span class="brand-name-accent">Care</span>
                        </span>
                        <span class="brand-tagline">Vaccination Management System</span>
                    </span>
                </a>


                <!-- Portal Badge -->
                <div class="portal-badge">
                    <span class="badge-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 21V7l8-4 8 4v14"/>
                            <path d="M8 21v-6h8v6"/>
                            <path d="M9 10h1"/>
                            <path d="M14 10h1"/>
                            <path d="M9 13h1"/>
                            <path d="M14 13h1"/>
                        </svg>
                    </span>
                    ADMIN PORTAL
                </div>

                <!-- Main Heading -->
                <h1>
                    Manage care.<br>
                    <span>Protect every child.</span>
                </h1>

                <p class="intro-description">
                    Access the VacciCare administration portal to manage
                    vaccination services, hospitals, parents and healthcare records.
                </p>

                <!-- Features -->
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 3l8 4v5c0 4.5-3.1 7.8-8 9-4.9-1.2-8-4.5-8-9V7z"/>
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Secure Administration</strong>
                            <span>Protected access for authorized administrators</span>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 9h8"/>
                                <path d="M8 13h5"/>
                                <path d="M8 17h3"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Vaccination Management</strong>
                            <span>Monitor vaccination records and services</span>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 11a8 8 0 1 0 1 4"/>
                                <path d="M20 5v6h-6"/>
                                <path d="M12 8v4l3 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Centralized Control</strong>
                            <span>Manage the complete healthcare network</span>
                        </div>
                    </div>
                </div>

                <div class="trust-line">
                    <span class="trust-dot"></span>
                    Trusted vaccination management platform
                </div>
            </div>

            <!-- Decorative Shapes -->
            <div class="circle circle-one"></div>
            <div class="circle circle-two"></div>
        </section>

        <!-- RIGHT SIDE -->
        <section class="login-area">
            <div class="login-card">
                <!-- Top Icon -->
                <div class="login-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 3l8 4v5c0 4.5-3.1 7.8-8 9-4.9-1.2-8-4.5-8-9V7z"/>
                        <path d="M12 8v5"/>
                        <path d="M12 16h.01"/>
                    </svg>
                </div>

                <div class="login-heading">
                    <div class="small-heading">ADMIN ACCOUNT</div>
                    <h2>Welcome back</h2>
                    <p>Sign in to continue to your VacciCare admin portal.</p>
                </div>

                @if(session('loginError'))
                    <div class="server-error" style="color: #dc3545; background: #ffe6e6; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center;">
                        {{ session('loginError') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="server-success" style="color: #198754; background: #e8f5e9; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="server-info" style="color: #0d6efd; background: #e7f1ff; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center;">
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form id="adminLoginForm" action="{{ route('admin.login.post') }}" method="post" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="adminEmail">
                            Admin Email <span>*</span>
                        </label>

                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path d="M3 7l9 6 9-6"/>
                                </svg>
                            </span>

                            <input
                                type="email"
                                id="adminEmail"
                                name="admin_email"
                                value="{{ old('admin_email') }}"
                                placeholder="admin@example.com"
                                autocomplete="email"
                                required
                            >
                        </div>

                        @error('admin_email')
                            <small class="error-message" style="color: #dc3545; display: block; margin-top: 5px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="label-row">
                            <label for="adminPassword">
                                Password <span>*</span>
                            </label>
                        </div>

                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                </svg>
                            </span>

                            <input
                                type="password"
                                id="adminPassword"
                                name="admin_password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                id="passwordToggle"
                                aria-label="Show password"
                            >
                                <svg id="eyeIcon" viewBox="0 0 24 24">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"/>
                                    <circle cx="12" cy="12" r="2.5"/>
                                </svg>
                            </button>
                        </div>

                        @error('admin_password')
                            <small class="error-message" style="color: #dc3545; display: block; margin-top: 5px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="login-options">
                        <label class="remember-label">
                            <input
                                type="checkbox"
                                id="rememberMe"
                                name="remember"
                            >
                            <span class="custom-checkbox"></span>
                            <span>Remember me</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" name="submit" class="login-button">
                        <span>Sign In</span>
                        <svg viewBox="0 0 24 24">
                            <path d="M5 12h13"/>
                            <path d="M13 6l6 6-6 6"/>
                        </svg>
                    </button>

                    <div style="text-align: center; margin-top: 15px;">
                        <a href="{{ route('admin.create-admin') }}" style="color: #0d6efd; font-size: 13px; text-decoration: none;">Need to set up the first administrator account?</a>
                    </div>
                </form>

                <!-- Divider -->
                
            <div class="auth-home-link-wrap">
                <a href="{{ route('home') }}" class="auth-home-link">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Return to Home Page</span>
                </a>
            </div>

<div class="divider">
                    <span></span>
                    <small>VACCICARE</small>
                    <span></span>
                </div>

                <!-- Footer -->
                <div class="login-footer">
                    <span>© 2026 VacciCare</span>
                    <span class="footer-dot">•</span>
                    <span>Admin Portal</span>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('adminPassword');
            if (toggle && passwordInput) {
                toggle.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                });
            }
        });
    </script>
</body>
</html>