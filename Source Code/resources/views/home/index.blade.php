@extends('layouts.app')

@section('title', 'VacciCare | Vaccination Management System')

@section('content')
<section class="hero-wrap vc-video-hero"
    data-section="home"
    id="home-section">

    <video
        class="hero-video"
        autoplay
        muted
        loop
        playsinline
        preload="metadata"
        aria-hidden="true">
        <source src="{{ asset('video/video%20animation.mp4') }}" type="video/mp4">
    </video>

    <div class="hero-video-overlay"></div>
    <div class="hero-motion-glow hero-motion-glow-one"></div>
    <div class="hero-motion-glow hero-motion-glow-two"></div>

    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-start"
            data-scrollax-parent="true">

            <div class="col-lg-7 col-md-11 ftco-animate">
                <div class="vc-hero-copy">

                    <div class="hero-pill-badge mb-3">
                        <span class="badge-dot"></span>
                        <span class="badge-text">Intelligent Child Vaccination Platform</span>
                        <span class="badge-tag">WHO Certified</span>
                    </div>

                    <h1 class="mb-4 hero-headline">
                        Protect Your Child With<br>
                        <span class="hero-gradient-text">Timely Vaccination</span>
                    </h1>

                    <p class="mb-4 hero-lead">
                        Keep your child's immunization schedule organized,
                        locate accredited hospitals, and book guaranteed vaccination
                        appointments seamlessly — all in one unified platform.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('appointment') }}"
                           class="btn btn-primary hero-btn-main py-3 px-4">
                            <i class="fa-solid fa-calendar-check mr-2"></i> Book Vaccination
                        </a>

                        <a href="{{ route('register.select') }}"
                           class="btn hero-btn-glass py-3 px-4">
                            <i class="fa-solid fa-user-plus mr-2"></i> Get Started Free
                        </a>
                    </div>

                    <div class="hero-3d-metrics-row" aria-label="VacciCare highlights">
                        <div class="hero-metric-card vc-3d-card vc-floating">
                            <div class="metric-icon-wrap"><i class="fa-solid fa-clock"></i></div>
                            <div class="metric-content">
                                <strong class="hero-stat-badge no-count">24/7</strong>
                                <span>Schedule Access</span>
                            </div>
                        </div>

                        <div class="hero-metric-card vc-3d-card vc-floating-alt">
                            <div class="metric-icon-wrap"><i class="fa-solid fa-hospital"></i></div>
                            <div class="metric-content">
                                <strong class="stat-number">80+</strong>
                                <span>Verified Centers</span>
                            </div>
                        </div>

                        <div class="hero-metric-card vc-3d-card vc-floating">
                            <div class="metric-icon-wrap"><i class="fa-solid fa-shield-halved"></i></div>
                            <div class="metric-content">
                                <strong class="stat-number">100%</strong>
                                <span>Secure Records</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<section class="ftco-counter img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
    <div class="container">
        <div class="row d-flex">

            <!-- About Image -->
            <div class="col-md-6 col-lg-5 d-flex">
                <div class="img d-flex align-self-stretch align-items-center"
                    style="background-image:url({{ asset('images/about.png') }});">
                </div>
            </div>

            <!-- About Content -->
            <div class="col-md-6 col-lg-7 pl-lg-5 py-md-5">
                <div class="py-md-5">

                    <div class="row justify-content-start pb-3">

                        <div class="col-md-12 heading-section ftco-animate p-4 p-lg-5">

                            <span class="subheading">About VacciCare</span>

                            <h2 class="mb-4">
                                Making <span>Vaccination Management</span> Simple & Accessible
                            </h2>

                            <p>
                                VacciCare is a vaccination management system designed to help
                                parents manage their children's vaccination schedules, find
                                registered hospitals, and book vaccination appointments easily.
                            </p>

                            <p>
                                Our platform connects parents, hospitals, and administrators
                                on one system, making vaccine information, appointments,
                                vaccination records, and reports easier to manage.
                            </p>

                            <p>
                                <a href="#department-section"
                                   class="btn btn-primary py-3 px-4">
                                    Explore Vaccines
                                </a>

                                <a href="{{ route('appointment') }}"
                                   class="btn btn-secondary py-3 px-4">
                                    Book Vaccination
                                </a>
                            </p>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>



<section class="ftco-intro img" style="background-image: url('images/bg_2.png');">
    <div class="overlay"></div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-9 text-center">

                <span class="subheading">VACCICARE</span>

                <h2>Protect Your Family with Timely Vaccination</h2>

                <p>
                    Keep your family's vaccination schedule organized,
                    find registered hospitals, and book vaccination
                    appointments easily in one place.
                </p>

                <p class="mb-0">
                    <a href="#appointment-section"
                       class="btn btn-white px-4 py-3">
                        Book Vaccination
                    </a>

                    <a href="#hospitals-section"
                       class="btn btn-primary px-4 py-3 ml-2">
                        Find Hospitals
                    </a>
                </p>

            </div>

        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb" id="vaccines-section">

    <div class="container-fluid px-md-3 py-3">

        <div class="row no-gutters">

            <!-- LEFT SIDE IMAGE -->
            <div class="col-md-4 d-flex">
                <div class="img img-dept align-self-stretch w-100"
                     style="background-image: url('{{ asset('images/bg_3.png') }}'); min-height: 520px;">
                </div>
            </div>


            <!-- RIGHT SIDE SERVICES -->
            <div class="col-md-8">

                <div class="row no-gutters">

                    <!-- COLUMN 1 -->
                    <div class="col-md-4">

                        <!-- Vaccination Booking -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-stethoscope"></span>
                                </div>

                                <h3>
                                    <a href="#">Vaccination Booking</a>
                                </h3>

                                <p>
                                    Book vaccination appointments easily
                                    at registered hospitals and centers.
                                </p>

                            </div>
                        </div>


                        <!-- Registered Hospitals -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-doctor"></span>
                                </div>

                                <h3>
                                    <a href="#">Registered Hospitals</a>
                                </h3>

                                <p>
                                    Find trusted hospitals and registered
                                    vaccination centers near you.
                                </p>

                            </div>
                        </div>


                        <!-- Vaccination Records -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-stethoscope"></span>
                                </div>

                                <h3>
                                    <a href="#">Vaccination Records</a>
                                </h3>

                                <p>
                                    Keep your child's vaccination records
                                    organized and easy to access.
                                </p>

                            </div>
                        </div>

                    </div>


                    <!-- COLUMN 2 -->
                    <div class="col-md-4">

                        <!-- Vaccination Reminders -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-24-hours"></span>
                                </div>

                                <h3>
                                    <a href="#">Vaccination Reminders</a>
                                </h3>

                                <p>
                                    Get timely reminders for upcoming
                                    vaccination doses and appointments.
                                </p>

                            </div>
                        </div>


                        <!-- Child Vaccines -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-doctor"></span>
                                </div>

                                <h3>
                                    <a href="#">Child Vaccines</a>
                                </h3>

                                <p>
                                    Explore essential vaccines and
                                    recommended schedules for children.
                                </p>

                            </div>
                        </div>


                        <!-- Vaccine Information -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-stethoscope"></span>
                                </div>

                                <h3>
                                    <a href="#">Vaccine Information</a>
                                </h3>

                                <p>
                                    Access reliable information about
                                    vaccines, doses, and schedules.
                                </p>

                            </div>
                        </div>

                    </div>


                    <!-- COLUMN 3 -->
                    <div class="col-md-4">

                        <!-- Parent Support -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-doctor"></span>
                                </div>

                                <h3>
                                    <a href="#">Parent Support</a>
                                </h3>

                                <p>
                                    Get helpful vaccination guidance
                                    for parents and families.
                                </p>

                            </div>
                        </div>


                        <!-- Vaccination Centers -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-stethoscope"></span>
                                </div>

                                <h3>
                                    <a href="#">Vaccination Centers</a>
                                </h3>

                                <p>
                                    Discover nearby vaccination centers
                                    and available services.
                                </p>

                            </div>
                        </div>


                        <!-- Assistance -->
                        <div class="department-wrap p-4 ftco-animate">
                            <div class="text p-2 text-center">

                                <div class="icon">
                                    <span class="flaticon-24-hours"></span>
                                </div>

                                <h3>
                                    <a href="#">24/7 Assistance</a>
                                </h3>

                                <p>
                                    Get support whenever you need help
                                    with vaccination services.
                                </p>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

   
<!-- =========================================================
     REGISTERED HOSPITALS / VACCINATION CENTERS
========================================================= -->
<section class="ftco-section hospital-section" id="hospital-section">
<div class="container-fluid px-5 mt-5">

    <!-- Section Heading -->
    <div class="row justify-content-center mb-5 pb-2">

        <div class="col-md-8 text-center heading-section ftco-animate">

            <span class="subheading">
                VACCINATION CENTERS
            </span>

            <h2 class="mb-4 mt-3">
                Registered Hospitals
            </h2>

            <p>
                Find trusted hospitals and vaccination centers registered
                with VacciCare. View hospital information and choose a
                convenient center for your vaccination appointment.
            </p>

        </div>

    </div>


    <!-- =====================================================
         HOSPITALS
    ====================================================== -->

    <div class="row">


        <!-- =================================================
             HOSPITAL 1
        ================================================== -->

        <div class="col-md-6 col-lg-3 ftco-animate">

            <div class="staff hospital-card">

                <!-- Hospital Image -->
                <div class="img-wrap d-flex align-items-stretch">

                    <div class="img align-self-stretch"
                         style="background-image: url({{ asset('images/Aga-Khan.jpg') }});">
                    </div>

                </div>


                <!-- Hospital Information -->
                <div class="text pt-3 text-center">

                    <h3 class="mb-2">
                        Aga Khan Medical Centre
                    </h3>

                    <span class="position mb-2">
                        Karachi
                    </span>


                    <div class="faded">

                        <!-- Description -->
                        <p>
                            Trusted healthcare facility providing
                            child vaccination and immunization services.
                        </p>


                        <!-- Address -->
                        <p class="hospital-detail">
                            <strong>Address:</strong><br>
                            Karachi, Pakistan
                        </p>


                        <!-- Services -->
                        <p class="hospital-detail">
                            <strong>Services:</strong><br>
                            Child Vaccination & Immunization
                        </p>


                        <!-- Button -->
                        <p class="mt-3">

                            <a href="{{ route('appointment') }}"
                               class="btn btn-primary">

                                Book Vaccination
                                <span class="ml-2">→</span>

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>



        <!-- =================================================
             HOSPITAL 2
        ================================================== -->

        <div class="col-md-6 col-lg-3 ftco-animate">

            <div class="staff hospital-card">

                <!-- Hospital Image -->
                <div class="img-wrap d-flex align-items-stretch">

                    <div class="img align-self-stretch"
                         style="background-image: url({{ asset('images/Liaquat-National.jpg') }});">
                    </div>

                </div>


                <!-- Hospital Information -->
                <div class="text pt-3 text-center">

                    <h3 class="mb-2">
                        Liaquat National Hospital
                    </h3>

                    <span class="position mb-2">
                        Karachi
                    </span>


                    <div class="faded">

                        <!-- Description -->
                        <p>
                            Registered hospital offering reliable
                            vaccination and child healthcare services.
                        </p>


                        <!-- Address -->
                        <p class="hospital-detail">
                            <strong>Address:</strong><br>
                            Karachi, Pakistan
                        </p>


                        <!-- Services -->
                        <p class="hospital-detail">
                            <strong>Services:</strong><br>
                            Child Vaccination & Immunization
                        </p>


                        <!-- Button -->
                        <p class="mt-3">

                            <a href="{{ route('appointment') }}"
                               class="btn btn-primary">

                                Book Vaccination
                                <span class="ml-2">→</span>

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>



        <!-- =================================================
             HOSPITAL 3
        ================================================== -->

        <div class="col-md-6 col-lg-3 ftco-animate">

            <div class="staff hospital-card">

                <!-- Hospital Image -->
                <div class="img-wrap d-flex align-items-stretch">

                    <div class="img align-self-stretch"
                         style="background-image: url({{ asset('images/Indus-Hospital.jpg') }});">
                    </div>

                </div>


                <!-- Hospital Information -->
                <div class="text pt-5 text-center">

                    <h3 class="mb-2">
                        Indus Hospital
                    </h3>

                    <span class="position mb-2">
                        Karachi
                    </span>


                    <div class="faded">

                        <!-- Description -->
                        <p>
                            Providing accessible vaccination services
                            and preventive healthcare for families.
                        </p>


                        <!-- Address -->
                        <p class="hospital-detail">
                            <strong>Address:</strong><br>
                            Karachi, Pakistan
                        </p>


                        <!-- Services -->
                        <p class="hospital-detail">
                            <strong>Services:</strong><br>
                            Vaccination & Preventive Care
                        </p>


                        <!-- Button -->
                        <p class="mt-3">

                            <a href="{{ route('appointment') }}"
                               class="btn btn-primary">

                                Book Vaccination
                                <span class="ml-2">→</span>

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>



        <!-- =================================================
             HOSPITAL 4
        ================================================== -->

        <div class="col-md-6 col-lg-3 ftco-animate">

            <div class="staff hospital-card">

                <!-- Hospital Image -->
                <div class="img-wrap d-flex align-items-stretch">

                    <div class="img align-self-stretch"
                         style="background-image: url({{ asset('images/South-City.jpg') }});">
                    </div>

                </div>


                <!-- Hospital Information -->
                <div class="text pt-5 text-center">

                    <h3 class="mb-2">
                        South City Hospital
                    </h3>

                    <span class="position mb-2">
                        Karachi
                    </span>


                    <div class="faded">

                        <!-- Description -->
                        <p>
                            Professional healthcare services with
                            convenient vaccination facilities.
                        </p>


                        <!-- Address -->
                        <p class="hospital-detail">
                            <strong>Address:</strong><br>
                            Karachi, Pakistan
                        </p>


                        <!-- Services -->
                        <p class="hospital-detail">
                            <strong>Services:</strong><br>
                            Vaccination & Child Healthcare
                        </p>


                        <!-- Button -->
                        <p class="mt-3">

                            <a href="{{ route('appointment') }}"
                               class="btn btn-primary">

                                Book Vaccination
                                <span class="ml-2">→</span>

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>
</section>

<section class="ftco-facts img ftco-counter" style="background-image: url({{ asset('images/bg_4.png') }});">

    <div class="overlay"></div>

    <div class="container">
        <div class="row d-flex align-items-center">

            <!-- Left Side -->
            <div class="col-md-5 heading-section heading-section-white">

                <span class="subheading">Vaccination Statistics</span>

                <h2 class="mb-4">
                    Protecting Families Through Better Immunization
                </h2>

                <p class="mb-0">
                    <a href="#appointment-section"
                       class="btn btn-secondary px-4 py-3">
                        Book Vaccination
                    </a>
                </p>

            </div>


            <!-- Right Side Statistics -->
            <div class="col-md-7">

                <div class="row pt-4">

                    <!-- Statistic 1 -->
                    <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">

                                <strong class="number" data-number="25">
                                    0
                                </strong>

                                <span>Registered Hospitals</span>

                            </div>
                        </div>
                    </div>


                    <!-- Statistic 2 -->
                    <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">

                                <strong class="number" data-number="12500">
                                    0
                                </strong>

                                <span>Vaccinations Booked</span>

                            </div>
                        </div>
                    </div>


                    <!-- Statistic 3 -->
                    <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">

                                <strong class="number" data-number="8500">
                                    0
                                </strong>

                                <span>Families Served</span>

                            </div>
                        </div>
                    </div>


                    <!-- Statistic 4 -->
                    <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18">
                            <div class="text">

                                <strong class="number" data-number="40">
                                    0
                                </strong>

                                <span>Vaccination Centers</span>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>


<section class="ftco-section" id="how-it-works-section">

    <div class="container">

        <!-- Section Heading -->
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">

                <span class="subheading">HOW IT WORKS</span>

                <h2 class="mb-4">Simple Steps to Get Vaccinated</h2>

                <p>
                    VacciCare makes vaccination management simple, safe,
                    and convenient. Follow these easy steps to manage
                    your vaccination journey.
                </p>

            </div>
        </div>


        <!-- Steps -->
        <div class="row how-it-works-row">


            <!-- STEP 01 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-1.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 01</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Choose Your Vaccine
                        </h3>

                        <p>
                            Explore available vaccines and learn about
                            recommended vaccination schedules and
                            requirements.
                        </p>

                    </div>
                </div>
            </div>


            <!-- STEP 02 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-2.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 02</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Find a Registered Hospital
                        </h3>

                        <p>
                            Search registered hospitals and trusted
                            vaccination centers available near you.
                        </p>

                    </div>
                </div>
            </div>


            <!-- STEP 03 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-3.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 03</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Book an Appointment
                        </h3>

                        <p>
                            Select your preferred hospital, date, and
                            available time slot to book your vaccination.
                        </p>

                    </div>
                </div>
            </div>


            <!-- STEP 04 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-4.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 04</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Receive Your Vaccination
                        </h3>

                        <p>
                            Visit the selected hospital on your appointment
                            date and receive your vaccination safely.
                        </p>

                    </div>
                </div>
            </div>


            <!-- STEP 05 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-5.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 05</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Keep Your Vaccination Records
                        </h3>

                        <p>
                            Keep your vaccination history organized and
                            easily accessible for future doses and care.
                        </p>

                    </div>
                </div>
            </div>


            <!-- STEP 06 -->
            <div class="col-md-6 col-lg-4 ftco-animate d-flex">
                <div class="blog-entry how-it-works-card">

                    <div class="block-20"
                         style="background-image: url('images/step-6.png');">
                    </div>

                    <div class="text d-block">

                        <div class="meta mb-3">
                            <div>
                                <span>STEP 06</span>
                            </div>
                            <div>
                                <span>VacciCare</span>
                            </div>
                        </div>

                        <h3 class="heading">
                            Stay Updated
                        </h3>

                        <p>
                            Receive timely reminders about upcoming
                            vaccination doses and important updates.
                        </p>

                    </div>
                </div>
            </div>


        </div>

    </div>

</section>









<!-- =====================================================
     FAQ SECTION
====================================================== -->

<section class="ftco-section faq-section" id="faq-section">

    <div class="container">

        <!-- Section Heading -->
        <div class="row justify-content-center mb-5">

            <div class="col-md-9 text-center heading-section">

                <span class="subheading">
                    VACCICARE FAQ
                </span>

                <h2 class="mb-4">
                    Frequently Asked Questions
                </h2>

                <p>
                    Find answers to common questions about
                    vaccination, appointments, hospitals and
                    the VacciCare system.
                </p>

            </div>

        </div>


        <!-- FAQ -->
        <div class="row justify-content-center">

            <div class="col-lg-9">

                <div class="faq-wrapper">


                    <!-- FAQ 01 -->
                    <div class="faq-item">

                        <button
                            class="faq-question"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq1"
                            aria-expanded="true"
                            aria-controls="faq1">

                            <span>
                                What is VacciCare?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq1"
                            class="collapse show"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    VacciCare is a vaccination management
                                    system designed to help parents manage
                                    their children's vaccination information,
                                    schedules and vaccination appointments
                                    through an online platform.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 02 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq2"
                            aria-expanded="false"
                            aria-controls="faq2">

                            <span>
                                How can I book a vaccination appointment?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq2"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Parents can create an account and
                                    access the vaccination booking feature.
                                    Select the child, vaccine, vaccination
                                    hospital, preferred date and available
                                    time to submit an appointment request.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 03 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq3"
                            aria-expanded="false"
                            aria-controls="faq3">

                            <span>
                                Can I choose a vaccination hospital?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq3"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Yes. Parents can view registered
                                    vaccination hospitals and select
                                    a suitable hospital while booking
                                    a vaccination appointment.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 04 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq4"
                            aria-expanded="false"
                            aria-controls="faq4">

                            <span>
                                Can I view my child's vaccination schedule?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq4"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Yes. After registering and adding a
                                    child, parents will be able to manage
                                    vaccination dates and view upcoming
                                    vaccination information from their
                                    dashboard.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 05 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq5"
                            aria-expanded="false"
                            aria-controls="faq5">

                            <span>
                                What happens after I submit an appointment request?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq5"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    The appointment request is sent for
                                    processing. The parent can later check
                                    the request status from the dashboard.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 06 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq6"
                            aria-expanded="false"
                            aria-controls="faq6">

                            <span>
                                Can I view my previous vaccination records?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq6"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Yes. The Parent Dashboard will provide
                                    a vaccination history section where
                                    parents can view previous vaccination
                                    records of their children.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 07 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq7"
                            aria-expanded="false"
                            aria-controls="faq7">

                            <span>
                                Is registration required to book a vaccination?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq7"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Yes. Parents should create an account
                                    and sign in to manage their children
                                    and submit vaccination appointment
                                    requests.
                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- FAQ 08 -->
                    <div class="faq-item">

                        <button
                            class="faq-question collapsed"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq8"
                            aria-expanded="false"
                            aria-controls="faq8">

                            <span>
                                How can I get help with my vaccination request?
                            </span>

                            <span class="faq-icon">
                                +
                            </span>

                        </button>


                        <div
                            id="faq8"
                            class="collapse"
                            data-parent="#faq-section">

                            <div class="faq-answer">

                                <p>
                                    Parents can use the Contact section
                                    of VacciCare to get assistance or
                                    provide additional information
                                    regarding their vaccination request.
                                </p>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>













   <section class="ftco-section testimony-section img"
         style="background-image: url({{ asset('images/bg_3.png') }});">

    <div class="overlay"></div>

    <div class="container">

        <!-- Section Heading -->
        <div class="row justify-content-center pb-3">

            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">

                <span class="subheading">FAMILY REVIEWS</span>

                <h2 class="mb-4">What Families Say About VacciCare</h2>

                <p>
                    Trusted by parents and families for easier vaccination
                    booking, reminders, and organized vaccination records.
                </p>

            </div>

        </div>


        <!-- Testimonials Carousel -->
        <div class="row ftco-animate justify-content-center">

            <div class="col-md-12">

                <div class="carousel-testimony owl-carousel ftco-owl">


                    <!-- Testimonial 1 -->
                    <div class="item">

                        <div class="testimony-wrap text-center py-4 pb-5">

                            <div class="user-img"
                                 style="background-image: url({{ asset('images/per_1.png') }});">

                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>

                            </div>

                            <div class="text px-4">

                                <p class="mb-4">
                                    VacciCare made it so easy to find a registered
                                    hospital and book my child's vaccination
                                    appointment. Everything was simple and clear.
                                </p>

                                <p class="name">Ayesha Khan</p>

                                <span class="position">Parent</span>

                            </div>

                        </div>

                    </div>


                    <!-- Testimonial 2 -->
                    <div class="item">

                        <div class="testimony-wrap text-center py-4 pb-5">

                            <div class="user-img"
                                 style="background-image: url({{ asset('images/per_2.png') }});">

                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>

                            </div>

                            <div class="text px-4">

                                <p class="mb-4">
                                    I no longer have to worry about forgetting
                                    important vaccination dates. The reminder
                                    feature helps me stay on schedule.
                                </p>

                                <p class="name">Sara Ahmed</p>

                                <span class="position">Mother</span>

                            </div>

                        </div>

                    </div>


                    <!-- Testimonial 3 -->
                    <div class="item">

                        <div class="testimony-wrap text-center py-4 pb-5">

                            <div class="user-img"
                                 style="background-image: url({{ asset('images/per_3.png') }});">

                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>

                            </div>

                            <div class="text px-4">

                                <p class="mb-4">
                                    Finding a trusted vaccination center was
                                    much easier with VacciCare. The appointment
                                    booking process saved me a lot of time.
                                </p>

                                <p class="name">Hassan Ali</p>

                                <span class="position">Parent</span>

                            </div>

                        </div>

                    </div>


                    <!-- Testimonial 4 -->
                    <div class="item">

                        <div class="testimony-wrap text-center py-4 pb-5">

                            <div class="user-img"
                                 style="background-image: url({{ asset('images/per_4.png') }});">

                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>

                            </div>

                            <div class="text px-4">

                                <p class="mb-4">
                                    I love having my vaccination information
                                    organized in one place. VacciCare makes
                                    managing my family's vaccinations easier.
                                </p>

                                <p class="name">Mariam Hassan</p>

                                <span class="position">Parent</span>

                            </div>

                        </div>

                    </div>


                    <!-- Testimonial 5 -->
                    <div class="item">

                        <div class="testimony-wrap text-center py-4 pb-5">

                            <div class="user-img"
                                 style="background-image: url({{ asset('images/per_5.png') }});">

                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>

                            </div>

                            <div class="text px-4">

                                <p class="mb-4">
                                    The platform is convenient and easy to use.
                                    I can check vaccination information and
                                    manage appointments without confusion.
                                </p>

                                <p class="name">Fatima Noor</p>

                                <span class="position">Mother</span>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>

   <section class="ftco-section contact-section" id="contact-section">

    <div class="container">

        <!-- Section Heading -->
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-8 text-center heading-section ftco-animate">

                <span class="subheading">GET IN TOUCH</span>

                <h2 class="mb-4">Find Vaccination Centers</h2>

                <p>
                    Need help with vaccination appointments or schedules?
                    Contact VacciCare or find a registered vaccination center near you.
                </p>

            </div>
        </div>


        <!-- Contact Information -->
        <div class="row d-flex contact-info mb-5">

            <!-- Address -->
            <div class="col-md-3 d-flex ftco-animate">
                <div class="info bg-light p-4 w-100 text-center">

                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="icon-map-marker"></span>
                    </div>

                    <h3 class="mb-3">Address</h3>

                    <p>
                        VacciCare Vaccination Center,<br>
                        Karachi, Pakistan
                    </p>

                </div>
            </div>


            <!-- Phone -->
            <div class="col-md-3 d-flex ftco-animate">
                <div class="info bg-light p-4 w-100 text-center">

                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="icon-phone"></span>
                    </div>

                    <h3 class="mb-3">Phone</h3>

                    <p>
                        <a href="tel:+923001234567">
                            +92 300 1234567
                        </a>
                    </p>

                </div>
            </div>


            <!-- Email -->
            <div class="col-md-3 d-flex ftco-animate">
                <div class="info bg-light p-4 w-100 text-center">

                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="icon-envelope"></span>
                    </div>

                    <h3 class="mb-3">Email</h3>

                    <p>
                        <a href="mailto:info@vaccicare.com">
                            info@vaccicare.com
                        </a>
                    </p>

                </div>
            </div>


            <!-- Working Hours -->
            <div class="col-md-3 d-flex ftco-animate">
                <div class="info bg-light p-4 w-100 text-center">

                    <div class="icon d-flex align-items-center justify-content-center mb-3">
                        <span class="icon-clock-o"></span>
                    </div>

                    <h3 class="mb-3">Working Hours</h3>

                    <p>
                        Mon - Sat<br>
                        9:00 AM - 8:00 PM
                    </p>

                </div>
            </div>

        </div>


        <!-- Contact Form + Map -->
        <div class="row d-flex">

            <!-- Contact Form -->
            <div class="col-md-6 d-flex ftco-animate">

                <form action="#" class="bg-light p-5 contact-form w-100">

                    <h3 class="mb-4">Send Us a Message</h3>

                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Your Name"
                            required>
                    </div>

                    <div class="form-group">
                        <input
                            type="email"
                            class="form-control"
                            placeholder="Your Email"
                            required>
                    </div>

                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Subject"
                            required>
                    </div>

                    <div class="form-group">
                        <textarea
                            name="message"
                            id="message"
                            cols="30"
                            rows="7"
                            class="form-control"
                            placeholder="Your Message"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <input
                            type="submit"
                            value="Send Message"
                            class="btn btn-primary py-3 px-5">
                    </div>

                </form>

            </div>


            <!-- Map -->
            <div class="col-md-6 d-flex ftco-animate">

                <div class="map-container w-100">

                    <iframe
                        src="https://www.google.com/maps?q=Karachi,Pakistan&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0; min-height:450px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>
@endsection

