<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title', 'VacciCare | Vaccination Management System')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/public-enhance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public-animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-animations.css') }}">
    @include('partials.pwa')
    @stack('styles')
  </head>
  <body @if(request()->routeIs('home')) data-spy="scroll" data-target=".site-navbar-target" data-offset="300" @endif>
  	<div class="py-1 bg-black top d-none d-lg-block">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+92 300 1234567</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">info@vaccicare.com</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right justify-content-end">
						    <p class="mb-0 register-link">
                                @if(session('role') === 'parent')
                                    <a href="{{ route('parent.dashboard') }}" class="mr-3">Dashboard</a>
                                    <a href="{{ route('logout') }}">Sign Out</a>
                                @elseif(session('role') === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="mr-3">Admin Panel</a>
                                    <a href="{{ route('logout') }}">Sign Out</a>
                                @elseif(session('role') === 'hospital')
                                    <a href="{{ route('hospital.dashboard') }}" class="mr-3">Hospital Portal</a>
                                    <a href="{{ route('logout') }}">Sign Out</a>
                                @else
                                    <a href="{{ route('register.select') }}" class="mr-3">Register</a>
                                    <a href="{{ route('signin') }}">Sign In</a>
                                @endif
                            </p>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <span class="brand-icon-badge mr-2">
                <i class="fa-solid fa-syringe" aria-hidden="true"></i>
            </span>
            <span class="brand-text-wrap d-flex flex-column">
                <span class="brand-name"><span class="brand-name-dark">Vacci</span><span class="brand-name-accent">Care</span></span>
                <span class="brand-tagline d-none d-sm-inline-block">Vaccination Management System</span>
            </span>
          </a>
          
	      <button class="navbar-toggler vc-hamburger-btn" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="vc-hamburger-box">
                <span class="vc-hamburger-line"></span>
                <span class="vc-hamburger-line"></span>
                <span class="vc-hamburger-line"></span>
            </span>
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav nav ml-auto">
	          <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#home-section' : route('home') . '#home-section' }}" class="nav-link"><span>Home</span></a></li>
	          <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#about-section' : route('home') . '#about-section' }}" class="nav-link"><span>About</span></a></li>

	          <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="vaccinesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Vaccines
                </a>
                <div class="dropdown-menu" aria-labelledby="vaccinesDropdown">
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#bcg" data-target="body">BCG</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#polio" data-target="body">Polio</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#hepatitis-b" data-target="body">Hepatitis B</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#dtp" data-target="body">DTP</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#hib" data-target="body">Hib</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#measles" data-target="body">Measles</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#mmr" data-target="body">MMR</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#rotavirus" data-target="body">Rotavirus</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#pneumococcal" data-target="body">Pneumococcal</a>
                    <a class="dropdown-item" href="{{ route('home.vaccines') }}#covid-19" data-target="body">COVID-19</a>
                </div>
              </li>
	          <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#hospital-section' : route('home') . '#hospital-section' }}" class="nav-link"><span>Hospitals</span></a></li>
	          <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#how-it-works-section' : route('home') . '#how-it-works-section' }}" class="nav-link"><span>How It Works</span></a></li>
			  <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#faq-section' : route('home') . '#faq-section' }}" class="nav-link"><span>FAQ</span></a></li>
	          <li class="nav-item"><a href="{{ request()->routeIs('home') ? '#contact-section' : route('home') . '#contact-section' }}" class="nav-link"><span>Contact</span></a></li>
	          <li class="nav-item cta mr-md-2"><a href="{{ route('appointment') }}" class="nav-link" data-target="body">Book Vaccination</a></li>
	        </ul>

            {{-- Mobile Quick Auth CTA in Drawer --}}
            <div class="mobile-auth-cta d-lg-none mt-3 pt-3 border-top border-secondary">
                @if(session('role') === 'parent')
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-light btn-block mb-2 text-white"><i class="fa-solid fa-gauge mr-2"></i>Parent Dashboard</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-block"><i class="fa-solid fa-right-from-bracket mr-2"></i>Sign Out</a>
                @elseif(session('role') === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-block mb-2 text-white"><i class="fa-solid fa-gauge mr-2"></i>Admin Panel</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-block"><i class="fa-solid fa-right-from-bracket mr-2"></i>Sign Out</a>
                @elseif(session('role') === 'hospital')
                    <a href="{{ route('hospital.dashboard') }}" class="btn btn-outline-light btn-block mb-2 text-white"><i class="fa-solid fa-gauge mr-2"></i>Hospital Portal</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-block"><i class="fa-solid fa-right-from-bracket mr-2"></i>Sign Out</a>
                @else
                    <div class="row no-gutters">
                        <div class="col-6 pr-1">
                            <a href="{{ route('signin') }}" class="btn btn-outline-light btn-block text-white">Sign In</a>
                        </div>
                        <div class="col-6 pl-1">
                            <a href="{{ route('register.select') }}" class="btn btn-primary btn-block">Register</a>
                        </div>
                    </div>
                @endif
            </div>
	      </div>
	    </div>
	</nav>

    @yield('content')

    <footer class="ftco-footer ftco-section img" style="background-image: url('{{ asset('images/footer-bg.jpg') }}');">
        <div class="overlay"></div>
        <div class="container-fluid px-md-5">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">VacciCare</h2>
                        <p>
                            VacciCare is a vaccination management platform designed
                            to help families manage vaccination schedules, find
                            registered hospitals, and book vaccination appointments easily.
                        </p>
                        <ul class="ftco-footer-social list-unstyled mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Quick Links</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}#home-section"><span class="icon-long-arrow-right mr-2"></span>Home</a></li>
                            <li><a href="{{ route('home') }}#about-section"><span class="icon-long-arrow-right mr-2"></span>About Us</a></li>
                            <li><a href="{{ route('home') }}#department-section"><span class="icon-long-arrow-right mr-2"></span>Services</a></li>
                            <li><a href="{{ route('home') }}#doctor-section"><span class="icon-long-arrow-right mr-2"></span>Vaccination Specialists</a></li>
                            <li><a href="{{ route('home') }}#contact-section"><span class="icon-long-arrow-right mr-2"></span>Contact</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Vaccination Services</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('appointment') }}"><span class="icon-long-arrow-right mr-2"></span>Vaccination Booking</a></li>
                            <li><a href="{{ route('home') }}#hospital-section"><span class="icon-long-arrow-right mr-2"></span>Registered Hospitals</a></li>
                            <li><a href="{{ route('home') }}#department-section"><span class="icon-long-arrow-right mr-2"></span>Vaccination Records</a></li>
                            <li><a href="{{ route('home') }}#department-section"><span class="icon-long-arrow-right mr-2"></span>Vaccination Reminders</a></li>
                            <li><a href="{{ route('home') }}#how-it-works-section"><span class="icon-long-arrow-right mr-2"></span>How It Works</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Question?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">Karachi, Pakistan</span></li>
                                <li><a href="tel:+923001234567"><span class="icon icon-phone"></span><span class="text">+92 300 1234567</span></a></li>
                                <li><a href="mailto:info@vaccicare.com"><span class="icon icon-envelope"></span><span class="text">info@vaccicare.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">
                        Copyright &copy; <script>document.write(new Date().getFullYear());</script>
                        <strong>VacciCare</strong> | Vaccination Management System
                    </p>
                    <p class="mt-2 mb-0">Protecting families through timely and organized vaccination.</p>
                </div>
            </div>
        </div>
    </footer>

    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/public-scroll-animate.js') }}"></script>
    <script src="{{ asset('js/premium-animations.js') }}"></script>
    @stack('scripts')
  </body>
</html>
