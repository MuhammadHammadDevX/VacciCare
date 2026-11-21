<!DOCTYPE html>
<html lang="en"> 

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Sign Up | VacciCare</title>

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Google Font -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/public-animate.css') }}">


    <style>


        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: #f7faff;
            color: #222;
        }



        .signup-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px 20px;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(37, 117, 252, 0.10),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(37, 117, 252, 0.08),
                    transparent 35%
                ),
                #f7faff;
        }


        /* =====================================================
           MAIN CARD
        ====================================================== */

        .signup-card {
            width: 100%;
            max-width: 1050px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;

            display: flex;

            box-shadow:
                0 20px 60px rgba(31, 60, 100, 0.12);
        }


        /* =====================================================
           LEFT SIDE
        ====================================================== */

        .signup-left {
            width: 42%;
            padding: 55px 45px;

            background:
                linear-gradient(
                    145deg,
                    #2575fc 0%,
                    #1e63d6 100%
                );

            color: #ffffff;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 35px;
        }


        .brand-icon {
            width: 52px;
            height: 52px;

            border-radius: 15px;

            background: rgba(255,255,255,0.15);

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


        .signup-left h1 {
            font-size: 36px;
            line-height: 1.25;

            font-weight: 700;

            margin-bottom: 18px;
        }


        .signup-left > p {
            font-size: 14px;
            line-height: 1.9;

            color: rgba(255,255,255,0.86);

            margin-bottom: 35px;
        }


        /* =====================================================
           BENEFITS
        ====================================================== */

        .benefit {
            display: flex;
            align-items: flex-start;

            margin-bottom: 20px;
        }


        .benefit-icon {
            width: 40px;
            height: 40px;

            flex-shrink: 0;

            border-radius: 12px;

            background: rgba(255,255,255,0.14);

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 13px;

            font-size: 18px;
        }


        .benefit strong {
            display: block;

            font-size: 14px;

            font-weight: 600;

            margin-bottom: 3px;
        }


        .benefit span {
            display: block;

            font-size: 11px;

            line-height: 1.5;

            color: rgba(255,255,255,0.75);
        }


        /* =====================================================
           RIGHT SIDE
        ====================================================== */

        .signup-right {
            width: 58%;

            padding: 50px 55px;
        }


        .form-header {
            margin-bottom: 30px;
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
            font-size: 28px;

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
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;

            font-size: 12px;

            font-weight: 600;

            color: #444;

            margin-bottom: 8px;
        }


        .form-control {
            height: 50px;

            border: 1px solid #e4e8ef;

            border-radius: 11px;

            padding: 0 15px;

            font-family: 'Poppins', sans-serif;

            font-size: 13px;

            box-shadow: none !important;

            transition: all 0.25s ease;
        }


        .form-control:focus {
            border-color: #2575fc;

            box-shadow:
                0 0 0 3px rgba(37,117,252,0.08) !important;
        }


        .form-control::placeholder {
            color: #aaa;
        }


        /* =====================================================
           PASSWORD FIELD
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

            transform: translateY(-50%);

            border: none;

            background: transparent;

            color: #888;

            cursor: pointer;

            font-size: 15px;
        }


        /* =====================================================
           TERMS
        ====================================================== */

        .terms {
            display: flex;

            align-items: flex-start;

            margin-top: 5px;

            margin-bottom: 22px;
        }


        .terms input {
            margin-top: 4px;

            margin-right: 9px;
        }


        .terms label {
            font-size: 11px;

            line-height: 1.6;

            color: #777;

            margin: 0;
        }


        .terms a {
            color: #2575fc;

            text-decoration: none;

            font-weight: 600;
        }


        /* =====================================================
           SIGNUP BUTTON
        ====================================================== */

        .signup-btn {
            width: 100%;

            height: 52px;

            border: none;

            border-radius: 11px;

            background: #2575fc;

            color: #ffffff;

            font-family: 'Poppins', sans-serif;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            transition: all 0.3s ease;
        }


        .signup-btn:hover {
            background: #1d64dc;

            transform: translateY(-1px);

            box-shadow:
                0 10px 25px rgba(37,117,252,0.22);
        }


        /* =====================================================
           LOGIN LINK
        ====================================================== */

        .login-text {
            text-align: center;

            font-size: 12px;

            color: #888;

            margin-top: 22px;
        }


        .login-text a {
            color: #2575fc;

            font-weight: 600;

            text-decoration: none;
        }


        .login-text a:hover {
            text-decoration: underline;
        }


        /* =====================================================
           SUCCESS MESSAGE
        ====================================================== */

        .success-message {
            display: none;

            padding: 12px 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            background: #eaf8f0;

            border: 1px solid #c9ecd8;

            color: #21844d;

            font-size: 12px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .signup-card {
                max-width: 650px;
            }

            .signup-left {
                display: none;
            }

            .signup-right {
                width: 100%;
                padding: 45px 40px;
            }
        }


        @media (max-width: 500px) {

            .signup-page {
                padding: 20px 12px;
            }

            .signup-right {
                padding: 35px 22px;
            }

            .form-header h2 {
                font-size: 24px;
            }

        }

    </style>

    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>


<body>





<section class="signup-page">

    <div class="signup-card">


       

        <div class="signup-left">


            <!-- Brand -->

            
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



            <!-- Heading -->

            <h1>
                Protect Your Family,
                Stay Vaccinated.
            </h1>


            <p>
                Create your parent account to manage your
                children's vaccination records, appointments
                and vaccination schedules in one place.
            </p>


            <!-- Benefit 1 -->

            <div class="benefit">

                <div class="benefit-icon">
                    👶
                </div>

                <div>

                    <strong>
                        Manage Children
                    </strong>

                    <span>
                        Keep your children's vaccination
                        information organized.
                    </span>

                </div>

            </div>


            <!-- Benefit 2 -->

            <div class="benefit">

                <div class="benefit-icon">
                    📅
                </div>

                <div>

                    <strong>
                        Book Appointments
                    </strong>

                    <span>
                        Select vaccines, hospitals, dates
                        and convenient time slots.
                    </span>

                </div>

            </div>


            <!-- Benefit 3 -->

            <div class="benefit">

                <div class="benefit-icon">
                    🛡️
                </div>

                <div>

                    <strong>
                        Track Vaccination
                    </strong>

                    <span>
                        View vaccination schedules and
                        previous vaccination history.
                    </span>

                </div>

            </div>


        </div>




        <div class="signup-right">


            <!-- Form Header -->

            <div class="form-header">

                <span class="form-label-small">
                    PARENT ACCOUNT
                </span>

                <h2>
                    Create Your Account
                </h2>

                <p>
                    Register to access your VacciCare dashboard.
                </p>

            </div>


            

            <!-- =================================================
                 SIGN UP FORM
            ================================================== -->

                        @if(session('error'))
                <div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 20px;">
                    {{ session('error') }}
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
<form id="signupForm"
                  action="{{ route('register.parent.post') }}"
                  method="post">
            @csrf


                <div class="row">


                    <!-- Full Name -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="full_name">
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                class="form-control"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                required>

                        </div>

                    </div>


                    <!-- Phone -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="phone">
                                Contact Number
                            </label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="form-control"
                                placeholder="+92 300 1234567"
                                pattern="^\+92[0-9]{10}$"
                                autocomplete="tel"
                                required>

                        </div>

                    </div>


                    <!-- Email -->

                    <div class="col-md-12">

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
                                required>

                        </div>

                    </div>


                    <!-- Password -->

                    <div class="col-md-6">

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
                                    placeholder="Create password"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password', this)"
                                    aria-label="Show password">

                                    👁

                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- Confirm Password -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="confirm_password">
                                Confirm Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    class="form-control"
                                    placeholder="Confirm password"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('confirm_password', this)"
                                    aria-label="Show password">

                                    👁

                                </button>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- Terms -->

                <div class="terms">

                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        required>

                    <label for="terms">

                        I agree to the
                        <a href="#">
                            Terms & Conditions
                        </a>
                        and
                        <a href="#">
                            Privacy Policy
                        </a>.

                    </label>

                </div>


                <!-- Submit -->

                <button
                    type="submit"
                    name="submit"
                    class="signup-btn">

                    Create Parent Account
                    <span style="margin-left: 8px;">
                        →
                    </span>

                </button>

     
            </form>


            <!-- Login -->

            <div class="login-text">

                Already have an account?

                <a href="{{ route('signin') }}">
                    Sign In
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



        </div>

    </div>

</section>



<script>


    // =====================================================
    // PASSWORD SHOW / HIDE
    // =====================================================

    function togglePassword(fieldId, button) {

        const field = document.getElementById(fieldId);

        if (field.type === "password") {

            field.type = "text";

            button.textContent = "🙈";

        } else {

            field.type = "password";

            button.textContent = "👁";

        }

    }



    document.getElementById("signupForm")
        .addEventListener("submit", function(event) {

            const password =
                document.getElementById("password").value;

            const confirmPassword =
                document.getElementById("confirm_password").value;


            if (password !== confirmPassword) {

                event.preventDefault();

                alert("Password and Confirm Password do not match.");

                return;

            }


           

        });

</script>

<script src="{{ asset('js/public-scroll-animate.js') }}"></script>

</body>

</html>
