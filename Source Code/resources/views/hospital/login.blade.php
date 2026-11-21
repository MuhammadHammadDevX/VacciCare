<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hospital Login | VacciCare</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Hospital Login CSS -->
    <link rel="stylesheet" href="{{ asset('css/hospital-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="hospital-login-page">

    <!-- Decorative Background -->
    <div class="bg-shape bg-shape-one"></div>
    <div class="bg-shape bg-shape-two"></div>

    <!-- MAIN LOGIN CONTAINER -->
    <div class="hospital-login-container">

        <!-- LEFT INFORMATION PANEL -->
        <section class="login-info-panel">
            
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


            <div class="portal-badge">
                <i class="bi bi-hospital"></i>
                <span>HOSPITAL PORTAL</span>
            </div>

            <div class="info-heading">
                <h1>Better care starts <span>with better records.</span></h1>
                <p>Sign in to your hospital account and manage vaccination services with ease.</p>
            </div>

            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div class="feature-text">
                        <strong>Secure Access</strong>
                        <span>Protected hospital portal</span>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <div class="feature-text">
                        <strong>Vaccine Management</strong>
                        <span>Manage vaccination records</span>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-heart-pulse"></i></div>
                    <div class="feature-text">
                        <strong>Better Healthcare</strong>
                        <span>Support children and families</span>
                    </div>
                </div>
            </div>

            <div class="trusted-platform">
                <i class="bi bi-patch-check-fill"></i>
                <span>Trusted vaccination management platform</span>
            </div>
        </section>

        <!-- RIGHT LOGIN PANEL -->
        <section class="login-form-panel">
            <div class="login-form-wrapper">
                <div class="login-icon">
                    <i class="bi bi-hospital"></i>
                </div>

                <div class="login-heading">
                    <span class="login-label">HOSPITAL ACCOUNT</span>
                    <h2>Welcome back</h2>
                    <p>Sign in to continue to your hospital portal.</p>
                </div>

                @if(session('loginError'))
                    <div class="login-error-message" style="display:flex; align-items:center; gap:8px; background:#fee2e2; color:#b91c1c; padding:12px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ session('loginError') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="login-error-message" style="display:flex; align-items:center; gap:8px; background:#fee2e2; color:#b91c1c; padding:12px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form id="hospitalLoginForm" action="{{ route('hospital.login.post') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="hospitalEmail">Hospital Email <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="hospitalEmail" name="hospitalEmail" value="{{ old('hospitalEmail') }}" placeholder="hospital@example.com" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="hospitalPassword">Password <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="hospitalPassword" name="hospitalPassword" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="login-options">
                        <label class="remember-option">
                            <input type="checkbox" id="rememberMe" name="remember">
                            <span class="custom-checkbox"></span>
                            <span>Remember me</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-button">
                        <span>Sign In</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="login-divider"></div>

                <!-- Register -->
                <div class="register-text">
                    <span>Don't have a hospital account?</span>
                    <a href="{{ route('hospital.register') }}">
                        Register Hospital <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>

            <div class="auth-home-link-wrap">
                <a href="{{ route('home') }}" class="auth-home-link">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Return to Home Page</span>
                </a>
            </div>


                <!-- Security Message -->
                <div class="security-message">
                    <i class="bi bi-shield-fill-check"></i>
                    <span>Your hospital information is protected and securely managed.</span>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('passwordToggle');
    const pwd = document.getElementById('hospitalPassword');
    if (toggle && pwd) {
        toggle.addEventListener('click', function () {
            const isPassword = pwd.getAttribute('type') === 'password';
            pwd.setAttribute('type', isPassword ? 'text' : 'password');
            const icon = toggle.querySelector('i');
            if (icon) {
                icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        });
    }
});
</script>
</body>
</html>