<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Logout | VacciCare</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}">
</head>

<body>

<section class="logout-page">
    <div class="logout-card">
        <aside class="logout-left">
            <a href="{{ route('home') }}" class="logout-brand">
                <span class="logout-brand-icon">
                    <i class="bi bi-shield-plus"></i>
                </span>
                <span>
                    <span class="logout-brand-name">Vacci<span>Care</span></span>
                    <span class="logout-brand-tagline">Vaccination Management System</span>
                </span>
            </a>

            <div class="logout-info">
                <span class="logout-info-badge">
                    <i class="bi {{ $logoutPage['icon'] }}"></i>
                    {{ $logoutPage['label'] }}
                </span>

                <h1>
                    Secure sign out for your
                    <span>{{ $logoutPage['panel_title'] }}</span>
                </h1>

                <p>
                    {{ $logoutPage['panel_copy'] }}
                </p>

                <div class="logout-benefits">
                    <div class="logout-benefit">
                        <span>01</span>
                        <strong>Protected account access</strong>
                    </div>
                    <div class="logout-benefit">
                        <span>02</span>
                        <strong>Safe return to dashboard</strong>
                    </div>
                    <div class="logout-benefit">
                        <span>03</span>
                        <strong>Ready for your next sign in</strong>
                    </div>
                </div>
            </div>

            <div class="logout-trust">
                <i class="bi bi-patch-check-fill"></i>
                Trusted vaccination management platform
            </div>
        </aside>

        <main class="logout-right">
            <div class="logout-confirm">
                <div class="logout-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>

                <div class="logout-content">
                    <span class="logout-label">
                        <i class="bi bi-shield-check"></i>
                        SIGN OUT CONFIRMATION
                    </span>

                    <h2>Ready to Log Out?</h2>

                    <p>
                        Are you sure you want to log out of your
                        <strong>VacciCare</strong> {{ $logoutPage['account'] }}?
                    </p>

                    <span class="logout-note">
                        {{ $logoutPage['note'] }}
                    </span>
                </div>

                <div class="logout-actions">
                    <a href="{{ $logoutPage['dashboard'] }}" class="btn-stay" id="stayBtn">
                        <i class="bi bi-arrow-left"></i>
                        Stay Logged In
                    </a>

                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">
                        <button type="submit" class="btn-logout" id="logoutBtn" style="border:none; cursor:pointer;">
                            <i class="bi bi-box-arrow-right"></i>
                            Log Out
                        </button>
                    </form>
                </div>

                <div class="security-message">
                    <i class="bi bi-lock-fill"></i>
                    <span>Your account information is protected and secure.</span>
                </div>
            </div>
        </main>
    </div>
</section>

<script src="{{ asset('js/logout.js') }}"></script>
</body>
</html>
