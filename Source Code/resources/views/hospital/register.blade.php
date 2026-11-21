<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hospital Registration | VacciCare</title>

    <!-- Bootstrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Hospital Register CSS -->
    <link rel="stylesheet" href="{{ asset('css/hospital-register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-unified.css') }}">
</head>

<body>

<div class="hospital-register-page">

    <div class="bg-shape shape-one"></div>
    <div class="bg-shape shape-two"></div>
    <div class="bg-dots"></div>

    <div class="register-container">
        <!-- LEFT INFO PANEL -->
        <div class="register-info-panel">
            
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


            <div class="info-content">
                <span class="info-badge">
                    <i class="bi bi-hospital"></i> HOSPITAL PORTAL
                </span>
                <h1>Join the <span>VacciCare</span> Network</h1>
                <p>Register your hospital with VacciCare and help provide better vaccination and child healthcare services.</p>
            </div>

            <div class="benefits-list">
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <strong>Secure Platform</strong>
                        <span>Your hospital information stays protected.</span>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <div>
                        <strong>Vaccination Management</strong>
                        <span>Manage vaccination records efficiently.</span>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-icon"><i class="bi bi-people"></i></div>
                    <div>
                        <strong>Connect With Families</strong>
                        <span>Coordinate vaccination services with parents.</span>
                    </div>
                </div>
            </div>

            <div class="info-footer">
                <i class="bi bi-heart-pulse-fill"></i>
                <span>Better healthcare through connected care.</span>
            </div>
        </div>

        <!-- RIGHT FORM PANEL -->
        <div class="register-form-panel">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-hospital"></i>
                </div>
                <div>
                    <span class="form-label">HOSPITAL REGISTRATION</span>
                    <h2>Create Hospital Account</h2>
                    <p>Enter your hospital details to get started.</p>
                </div>
            </div>

            @if(session('errorMessage'))
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill mr-2"></i>
                    {{ session('errorMessage') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form id="hospitalRegisterForm" action="{{ route('hospital.register.post') }}" method="POST">
                @csrf

                <!-- SECTION 1 -->
                <div class="form-section-title">
                    <span class="section-number">01</span>
                    <div>
                        <h3>Hospital Information</h3>
                        <p>Provide your hospital's basic details.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hospitalName">Hospital Name <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-building"></i>
                        <input type="text" id="hospitalName" name="hospital_name" value="{{ old('hospital_name') }}" placeholder="Enter hospital name" required>
                    </div>
                </div>

                <div class="form-row-custom">
                    <div class="form-group">
                        <label for="hospitalType">Hospital Type <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-hospital"></i>
                            <select id="hospitalType" name="hospital_type" required>
                                <option value="" disabled {{ old('hospital_type') ? '' : 'selected' }}>Select type</option>
                                <option value="Government" {{ old('hospital_type') === 'Government' ? 'selected' : '' }}>Government</option>
                                <option value="Private" {{ old('hospital_type') === 'Private' ? 'selected' : '' }}>Private</option>
                                <option value="Semi-Government" {{ old('hospital_type') === 'Semi-Government' ? 'selected' : '' }}>Semi-Government</option>
                                <option value="Trust" {{ old('hospital_type') === 'Trust' ? 'selected' : '' }}>Trust</option>
                                <option value="Charity" {{ old('hospital_type') === 'Charity' ? 'selected' : '' }}>Charity</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registrationNumber">Registration / License No.</label>
                        <div class="input-wrapper">
                            <i class="bi bi-card-text"></i>
                            <input type="text" id="registrationNumber" name="registration_number" value="{{ old('registration_number') }}" placeholder="Optional">
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 -->
                <div class="form-section-title second-section">
                    <span class="section-number">02</span>
                    <div>
                        <h3>Contact Information</h3>
                        <p>How can families contact your hospital?</p>
                    </div>
                </div>

                <div class="form-row-custom">
                    <div class="form-group">
                        <label for="hospitalEmail">Hospital Email <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="hospitalEmail" name="email" value="{{ old('email') }}" placeholder="hospital@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hospitalPhone">Phone Number <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone"></i>
                            <input type="tel" id="hospitalPhone" name="phone" value="{{ old('phone') }}" placeholder="03XX XXXXXXX" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hospitalAddress">Complete Address <span>*</span></label>
                    <div class="input-wrapper textarea-wrapper">
                        <i class="bi bi-geo-alt"></i>
                        <textarea id="hospitalAddress" name="address" rows="3" placeholder="Enter complete hospital address" required>{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="form-row-custom">
                    <div class="form-group">
                        <label for="hospitalCity">City <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-geo"></i>
                            <select id="hospitalCity" name="city" required>
                                <option value="" disabled {{ old('city') ? '' : 'selected' }}>Select city</option>
                                <option {{ old('city') === 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                <option {{ old('city') === 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                <option {{ old('city') === 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                <option {{ old('city') === 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                <option {{ old('city') === 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                <option {{ old('city') === 'Multan' ? 'selected' : '' }}>Multan</option>
                                <option {{ old('city') === 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                <option {{ old('city') === 'Quetta' ? 'selected' : '' }}>Quetta</option>
                                <option {{ old('city') === 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                <option {{ old('city') === 'Gujranwala' ? 'selected' : '' }}>Gujranwala</option>
                                <option {{ old('city') === 'Sialkot' ? 'selected' : '' }}>Sialkot</option>
                                <option {{ old('city') === 'Sukkur' ? 'selected' : '' }}>Sukkur</option>
                                <option {{ old('city') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hospitalProvince">Province / Region <span>*</span></label>
                        <div class="input-wrapper">
                            <i class="bi bi-map"></i>
                            <select id="hospitalProvince" name="province" required>
                                <option value="" disabled {{ old('province') ? '' : 'selected' }}>Select province</option>
                                <option {{ old('province') === 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option {{ old('province') === 'Sindh' ? 'selected' : '' }}>Sindh</option>
                                <option {{ old('province') === 'Khyber Pakhtunkhwa' ? 'selected' : '' }}>Khyber Pakhtunkhwa</option>
                                <option {{ old('province') === 'Balochistan' ? 'selected' : '' }}>Balochistan</option>
                                <option {{ old('province') === 'Islamabad Capital Territory' ? 'selected' : '' }}>Islamabad Capital Territory</option>
                                <option {{ old('province') === 'Gilgit-Baltistan' ? 'selected' : '' }}>Gilgit-Baltistan</option>
                                <option {{ old('province') === 'Azad Jammu & Kashmir' ? 'selected' : '' }}>Azad Jammu & Kashmir</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3 -->
                <div class="form-section-title second-section">
                    <span class="section-number">03</span>
                    <div>
                        <h3>Account Security</h3>
                        <p>Create a secure password for your account.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hospitalPassword">Password <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="hospitalPassword" name="password" placeholder="Create a strong password (min 8 chars)" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-shield-lock"></i>
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" required>
                    </div>
                </div>

                <!-- Terms -->
                <div class="terms-row">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="termsCheck" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }}>
                        <span class="checkmark"><i class="bi bi-check"></i></span>
                        <span class="terms-text">
                            I agree to VacciCare's <a href="#" onclick="return false;">Terms &amp; Conditions</a> and <a href="#" onclick="return false;">Privacy Policy</a>.
                        </span>
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-btn" id="registerBtn">
                    <span class="button-text">Create Hospital Account</span>
                    <i class="bi bi-arrow-right"></i>
                </button>

                <div class="login-link">
                    <span>Already have a hospital account?</span>
                    <a href="{{ route('hospital.login') }}">
                        Sign In <i class="bi bi-arrow-right"></i>
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

            </form>

            <div class="form-security">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Your information is protected by VacciCare.</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>