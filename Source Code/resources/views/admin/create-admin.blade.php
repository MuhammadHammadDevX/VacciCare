<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Admin Account | VacciCare</title>

    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<main class="admin-login-page">

    <!-- LEFT SIDE -->
    <section class="login-intro">
        <div class="intro-content">
            <!-- LOGO -->
            
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


            <!-- PORTAL BADGE -->
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

            <!-- MAIN HEADING -->
            <h1>
                Primary Setup.<br>
                <span>Protect every child.</span>
            </h1>

            <p class="intro-description">
                Create the primary VacciCare administrator account
                to securely manage vaccination services, hospitals,
                parents and healthcare records.
            </p>

            <!-- FEATURES -->
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
                        <strong>Centralized Control</strong>
                        <span>Manage the complete healthcare network</span>
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
                        <strong>Reliable Management</strong>
                        <span>Keep vaccination services organized and secure</span>
                    </div>
                </div>
            </div>

            <div class="trust-line">
                <span class="trust-dot"></span>
                Trusted vaccination management platform
            </div>
        </div>

        <!-- DECORATIVE CIRCLES -->
        <div class="circle circle-one"></div>
        <div class="circle circle-two"></div>
    </section>

    <!-- RIGHT SIDE -->
    <section class="login-area">
        <div class="login-card">
            <!-- TOP ICON -->
            <div class="login-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 3l8 4v5c0 4.5-3.1 7.8-8 9-4.9-1.2-8-4.5-8-9V7z"/>
                    <path d="M12 8v8"/>
                    <path d="M8 12h8"/>
                </svg>
            </div>

            <!-- HEADING -->
            <div class="login-heading">
                <div class="small-heading">ADMIN ACCOUNT</div>
                <h2>Create account</h2>
                <p>Set up the primary VacciCare administrator account.</p>
            </div>

            @if($adminExists)
                <div class="account-message error-box" style="background:#fee2e2; border:1px solid #ef4444; border-radius:8px; padding:15px; margin-bottom:20px; text-align:center;">
                    <strong style="display:block; color:#b91c1c; font-size:16px; margin-bottom:5px;">
                        Admin account already exists.
                    </strong>
                    <span style="display:block; color:#7f1d1d; font-size:14px; margin-bottom:15px;">
                        Please sign in using the existing administrator account.
                    </span>
                    <a href="{{ route('admin.login') }}" class="message-button" style="display:inline-block; background:#0d6efd; color:#fff; padding:8px 18px; border-radius:6px; text-decoration:none; font-weight:500;">
                        Go to Admin Login
                    </a>
                </div>
            @else
                @if(session('success'))
                    <div class="account-message success-box" style="background:#dcfce7; border:1px solid #22c55e; border-radius:8px; padding:15px; margin-bottom:20px; text-align:center;">
                        <strong style="display:block; color:#15803d; font-size:16px; margin-bottom:5px;">
                            Account Created Successfully
                        </strong>
                        <span style="display:block; color:#166534; font-size:14px; margin-bottom:15px;">
                            Your administrator account has been created. You can now sign in to VacciCare.
                        </span>
                        <a href="{{ route('admin.login') }}" class="message-button" style="display:inline-block; background:#16a34a; color:#fff; padding:8px 18px; border-radius:6px; text-decoration:none; font-weight:500;">
                            Go to Admin Login
                        </a>
                    </div>
                @endif

                @if($errors->any())
                    <div class="account-message error-box" style="background:#fee2e2; border:1px solid #ef4444; border-radius:8px; padding:12px; margin-bottom:20px; color:#b91c1c; font-size:14px;">
                        <ul style="margin:0; padding-left:20px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="createAdminForm" action="{{ route('admin.create-admin.post') }}" method="POST" novalidate>
                    @csrf

                    <!-- NAME -->
                    <div class="form-group">
                        <label for="adminName">Admin Name <span>*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input type="text" id="adminName" name="admin_name" value="{{ old('admin_name') }}" placeholder="Administrator" required>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="adminEmail">Admin Email <span>*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path d="M3 7l9 6 9-6"/>
                                </svg>
                            </span>
                            <input type="email" id="adminEmail" name="admin_email" value="{{ old('admin_email') }}" placeholder="admin@vaccicare.pk" required>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="form-group">
                        <label for="adminPassword">Password <span>*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                </svg>
                            </span>
                            <input type="password" id="adminPassword" name="admin_password" placeholder="At least 8 characters" required>
                        </div>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password <span>*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                </svg>
                            </span>
                            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="login-button">
                        <span>Create Admin Account</span>
                        <svg viewBox="0 0 24 24">
                            <path d="M5 12h13"/>
                            <path d="M13 6l6 6-6 6"/>
                        </svg>
                    </button>

                    <div style="text-align: center; margin-top: 15px;">
                        <a href="{{ route('admin.login') }}" style="color: #0d6efd; font-size: 13px; text-decoration: none;">Already have an administrator account? Sign in</a>
                    </div>
                </form>
            @endif

            <!-- DIVIDER -->
            
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

            <!-- FOOTER -->
            <div class="login-footer">
                <span>© 2026 VacciCare</span>
                <span class="footer-dot">•</span>
                <span>Admin Portal</span>
            </div>
        </div>
    </section>
</main>
</body>
</html>