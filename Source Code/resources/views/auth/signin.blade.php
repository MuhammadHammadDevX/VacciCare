<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>
        Sign In | VacciCare
    </title>



    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    >


    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >


    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >


    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="{{ asset('css/public-animate.css') }}"
    >


    <link
        rel="stylesheet"
        href="{{ asset('css/auth-unified.css') }}"
    >


    <style>


        /* =====================================================
           GENERAL
        ====================================================== */

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            font-family:
                'Poppins',
                sans-serif;

            color: #222;

            background: #f7faff;

        }



        /* =====================================================
           SIGN IN PAGE
        ====================================================== */

        .signin-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 45px 20px;

            background:

                radial-gradient(
                    circle at top right,
                    rgba(37, 117, 252, 0.10),
                    transparent 35%
                ),

                radial-gradient(
                    circle at bottom left,
                    rgba(37, 117, 252, 0.08),
                    transparent 35%
                ),

                #f7faff;

        }



        /* =====================================================
           MAIN CARD
        ====================================================== */

        .signin-card {

            width: 100%;

            max-width: 1000px;

            min-height: 610px;

            background: #ffffff;

            border-radius: 24px;

            overflow: hidden;

            display: flex;

            box-shadow:
                0 20px 60px
                rgba(31, 60, 100, 0.12);

        }



        /* =====================================================
           LEFT PANEL
        ====================================================== */

        .signin-left {

            width: 45%;

            padding: 55px 48px;

            color: #ffffff;

            background:
                linear-gradient(
                    145deg,
                    #2575fc 0%,
                    #1e63d6 100%
                );

            display: flex;

            flex-direction: column;

            justify-content: center;

        }



        /* =====================================================
           BRAND
        ====================================================== */

        .brand {

            display: flex;

            align-items: center;

            margin-bottom: 38px;

        }


        .brand-icon {

            width: 52px;

            height: 52px;

            border-radius: 15px;

            background:
                rgba(255,255,255,0.15);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 27px;

            margin-right: 14px;

        }


        .brand-name {

            font-size: 27px;

            font-weight: 700;

            letter-spacing: -0.5px;

        }


        .brand-tagline {

            display: block;

            font-size: 11px;

            opacity: 0.85;

            margin-top: -3px;

        }



        /* =====================================================
           LEFT HEADING
        ====================================================== */

        .signin-left h1 {

            font-size: 36px;

            line-height: 1.25;

            font-weight: 700;

            margin-bottom: 18px;

        }


        .signin-left > p {

            font-size: 14px;

            line-height: 1.9;

            color:
                rgba(255,255,255,0.86);

            margin-bottom: 35px;

        }



        /* =====================================================
           FEATURE ITEMS
        ====================================================== */

        .feature {

            display: flex;

            align-items: flex-start;

            margin-bottom: 20px;

        }


        .feature-icon {

            width: 40px;

            height: 40px;

            flex-shrink: 0;

            border-radius: 12px;

            background:
                rgba(255,255,255,0.14);

            display: flex;

            align-items: center;

            justify-content: center;

            margin-right: 13px;

            font-size: 18px;

        }


        .feature strong {

            display: block;

            font-size: 14px;

            font-weight: 600;

            margin-bottom: 3px;

        }


        .feature span {

            display: block;

            font-size: 11px;

            line-height: 1.5;

            color:
                rgba(255,255,255,0.75);

        }



        /* =====================================================
           RIGHT PANEL
        ====================================================== */

        .signin-right {

            width: 55%;

            padding: 60px 65px;

            display: flex;

            flex-direction: column;

            justify-content: center;

        }



        /* =====================================================
           FORM HEADER
        ====================================================== */

        .form-header {

            margin-bottom: 32px;

        }


        .form-label-small {

            display: inline-block;

            color: #2575fc;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 2px;

            margin-bottom: 8px;

        }


        .form-header h2 {

            font-size: 30px;

            font-weight: 700;

            margin-bottom: 8px;

        }


        .form-header p {

            color: #888;

            font-size: 13px;

            margin: 0;

        }



        /* =====================================================
           FORM
        ====================================================== */

        .form-group {

            margin-bottom: 22px;

        }


        .form-group label {

            display: block;

            font-size: 12px;

            font-weight: 600;

            color: #444;

            margin-bottom: 8px;

        }


        .form-control {

            height: 52px;

            border: 1px solid #e4e8ef;

            border-radius: 11px;

            padding: 0 15px;

            font-family:
                'Poppins',
                sans-serif;

            font-size: 13px;

            box-shadow: none !important;

            transition: all 0.25s ease;

        }


        .form-control:focus {

            border-color: #2575fc;

            box-shadow:
                0 0 0 3px
                rgba(37,117,252,0.08)
                !important;

        }


        .form-control::placeholder {

            color: #aaa;

        }



        /* =====================================================
           PASSWORD
        ====================================================== */

        .password-wrapper {

            position: relative;

        }


        .password-wrapper .form-control {

            padding-right: 50px;

        }


        .password-toggle {

            position: absolute;

            right: 15px;

            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            color: #888;

            cursor: pointer;

            font-size: 15px;

            padding: 0;

        }


        .password-toggle:focus {

            outline: none;

        }



        /* =====================================================
           OPTIONS
        ====================================================== */

        .login-options {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: -5px;

            margin-bottom: 25px;

        }


        .remember-me {

            display: flex;

            align-items: center;

            margin: 0;

        }


        .remember-me input {

            margin-right: 8px;

        }


        .remember-me span {

            font-size: 11px;

            color: #777;

        }


        .forgot-password {

            font-size: 11px;

            color: #2575fc;

            font-weight: 600;

            text-decoration: none;

        }


        .forgot-password:hover {

            text-decoration: underline;

        }



        /* =====================================================
           SIGN IN BUTTON
        ====================================================== */

        .signin-btn {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 11px;

            background: #2575fc;

            color: #ffffff;

            font-family:
                'Poppins',
                sans-serif;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            transition: all 0.3s ease;

        }


        .signin-btn:hover {

            background: #1d64dc;

            transform:
                translateY(-1px);

            box-shadow:
                0 10px 25px
                rgba(37,117,252,0.22);

        }



        /* =====================================================
           SIGN UP LINK
        ====================================================== */

        .signup-text {

            text-align: center;

            font-size: 12px;

            color: #888;

            margin-top: 24px;

            margin-bottom: 0;

        }


        .signup-text a {

            color: #2575fc;

            font-weight: 600;

            text-decoration: none;

        }


        .signup-text a:hover {

            text-decoration: underline;

        }



        /* =====================================================
           SECURITY NOTE
        ====================================================== */

        .security-note {

            text-align: center;

            margin-top: 22px;

            font-size: 10px;

            color: #aaa;

        }



        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .signin-card {

                max-width: 600px;

            }


            .signin-left {

                display: none;

            }


            .signin-right {

                width: 100%;

                padding: 50px 45px;

            }

        }


        @media (max-width: 500px) {

            .signin-page {

                padding: 20px 12px;

            }


            .signin-right {

                padding: 35px 22px;

            }


            .form-header h2 {

                font-size: 25px;

            }


            .login-options {

                flex-direction: column;

                align-items: flex-start;

                gap: 10px;

            }

        }


    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>



<body>




<section class="signin-page">


    <div class="signin-card">



        <div class="signin-left">


            <!-- BRAND -->

            
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




            <!-- HEADING -->

            <h1>

                Welcome Back!

            </h1>


            <p>

                Sign in to your VacciCare account and manage
                your children's vaccination appointments,
                schedules and records with ease.

            </p>



            <!-- FEATURE 1 -->

            <div class="feature">


                <div class="feature-icon">

                    👶

                </div>


                <div>

                    <strong>

                        Manage Your Children

                    </strong>


                    <span>

                        Keep children's vaccination details
                        organized in one place.

                    </span>

                </div>


            </div>



            <!-- FEATURE 2 -->

            <div class="feature">


                <div class="feature-icon">

                    📅

                </div>


                <div>

                    <strong>

                        Manage Appointments

                    </strong>


                    <span>

                        View and manage your vaccination
                        appointment requests.

                    </span>

                </div>


            </div>



            <!-- FEATURE 3 -->

            <div class="feature">


                <div class="feature-icon">

                    🛡️

                </div>


                <div>

                    <strong>

                        Track Vaccination History

                    </strong>


                    <span>

                        Easily access previous vaccination
                        records and upcoming schedules.

                    </span>

                </div>


            </div>


        </div>



        <!-- =================================================
             RIGHT LOGIN PANEL
        ================================================== -->

        <div class="signin-right">


            <!-- FORM HEADER -->

            <div class="form-header">


                <span class="form-label-small">

                    SECURE ACCOUNT LOGIN

                </span>


                <h2>

                    Sign In

                </h2>


                <p>

                    Enter your account details to continue.

                </p>


            </div>




                        @if(session('error'))
                <div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info" style="border-radius: 8px; margin-bottom: 20px;">
                    {{ session('info') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 20px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
<form
                id="signinForm"
                action="{{ route('signin.post') }}"
                method="post"
            >
            @csrf


                <!-- EMAIL -->

                <div class="form-group">


                    <label for="email">

                        Email Address

                    </label>


                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter your email address"
                        autocomplete="email"
                        required
                    >


                </div>



                <!-- PASSWORD -->

                <div class="form-group">


                    <label for="password">

                        Password

                    </label>


                    <div class="password-wrapper">


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                            aria-label="Show password"
                        >

                            👁

                        </button>


                    </div>


                </div>



                <!-- REMEMBER + FORGOT -->

                <div class="login-options">


                    <label class="remember-me">


                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >


                        <span>

                            Remember me

                        </span>


                    </label>


                    <a
                        href="#"
                        class="forgot-password"
                    >

                        Forgot Password?

                    </a>


                </div>



                <!-- SUBMIT -->

                <button
                    type="submit"
                    name="submit"
                    class="signin-btn"
                >

                    Sign In

                    <span style="margin-left: 8px;">

                        →

                    </span>

                </button>


            </form>




            <p class="signup-text">

                Don't have a parent account?

                <a href="{{ route('register.parent') }}">

                    Create Parent Account

                </a>

            </p>




            <p class="signup-text">

                Hospital?

                <a href="{{ route('hospital.register') }}">

                    Register Hospital

                </a>

            </p>




            <p class="signup-text">

                Admin?

                <a href="{{ route('admin.create-admin') }}">

                    Admin

                </a>

            </p>



            
            <div class="auth-home-link-wrap">
                <a href="{{ route('home') }}" class="auth-home-link">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Return to Home Page</span>
                </a>
            </div>

<div class="security-note">

                🔒 Your account information is securely protected.

            </div>


        </div>


    </div>


</section>




<script>



    function togglePassword() {


        const password =
            document.getElementById("password");


        const button =
            document.querySelector(".password-toggle");


        if (
            password.type === "password"
        ) {


            password.type = "text";

            button.textContent = "🙈";


        } else {


            password.type = "password";

            button.textContent = "👁";

        }

    }


</script>


<script
    src="{{ asset('js/public-scroll-animate.js') }}"
></script>


</body>

</html>
