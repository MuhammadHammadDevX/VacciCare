@extends('layouts.app')

@section('title', 'Book Vaccination | VacciCare')

@section('content')

<section class="hero-wrap hero-wrap-2"
         style="background-image: url('{{ asset('images/bg_1.jpg') }}');">

    <div class="overlay"></div>

    <div class="container">

        <div class="row no-gutters slider-text align-items-center justify-content-center">

            <div class="col-md-10 text-center ftco-animate">

                <span class="subheading">
                    VACCICARE • APPOINTMENT
                </span>

                <h1 class="mb-3 bread">
                    Book Your Vaccination
                </h1>

                <p class="hero-description mb-4">
                    Schedule your vaccination appointment with ease.
                    Choose your vaccine, vaccination center,
                    preferred date, and time.
                </p>

                <p class="breadcrumbs">

                    <span class="mr-2">
                        <a href="{{ route('home') }}">
                            Home
                            <i class="ion-ios-arrow-forward"></i>
                        </a>
                    </span>

                    <span>
                        Book Vaccination
                        <i class="ion-ios-arrow-forward"></i>
                    </span>

                </p>

            </div>

        </div>

    </div>

</section>


@if(session('success') || session('error'))

<div class="container mt-4">

    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">

        {{ session('success') ?? session('error') }}

    </div>

</div>

@endif



<div class="container">

    <div class="row justify-content-center mb-5 pb-3">

        <div class="col-md-9 text-center heading-section ftco-animate">

            <h2 class="mb-4 mt-5">
                Schedule Your Vaccination
            </h2>

            <p>
                Book a vaccination appointment at a registered
                vaccination center.
            </p>

        </div>

    </div>


    <div class="row align-items-stretch">



        <div class="col-lg-5 mb-5 pb-5 mb-lg-0 ftco-animate">

            <div class="appointment-sidebar h-100">

                <span class="subheading">
                    HOW IT WORKS
                </span>

                <h3 class="mb-4">
                    Vaccination Made Simple
                </h3>

                <p class="mb-5">
                    Follow these simple steps to request
                    your child's vaccination appointment.
                </p>


                <div class="appointment-step d-flex">

                    <div class="step-icon">
                        <span class="flaticon-stethoscope"></span>
                    </div>

                    <div class="step-content">

                        <span class="step-number">
                            STEP 01
                        </span>

                        <h4>
                            Choose a Vaccine
                        </h4>

                        <p>
                            Select an available vaccine
                            from the selected hospital.
                        </p>

                    </div>

                </div>


                <div class="appointment-step d-flex">

                    <div class="step-icon">
                        <span class="flaticon-hospital"></span>
                    </div>

                    <div class="step-content">

                        <span class="step-number">
                            STEP 02
                        </span>

                        <h4>
                            Select a Hospital
                        </h4>

                        <p>
                            Choose a registered vaccination center.
                        </p>

                    </div>

                </div>


                <div class="appointment-step d-flex">

                    <div class="step-icon">
                        <span class="flaticon-24-hours"></span>
                    </div>

                    <div class="step-content">

                        <span class="step-number">
                            STEP 03
                        </span>

                        <h4>
                            Select Date & Time
                        </h4>

                        <p>
                            Choose your preferred appointment
                            date and time.
                        </p>

                    </div>

                </div>


                <div class="appointment-note">

                    <div class="note-icon">
                        <span class="icon-info"></span>
                    </div>

                    <div>

                        <h4>
                            Important Information
                        </h4>

                        <p class="mb-0">
                            Please bring the child's previous
                            vaccination record to the appointment.
                        </p>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-lg-7 pb-5 ftco-animate">

            <div class="appointment-card">


                <div class="appointment-card-header">

                    <span class="subheading">
                        APPOINTMENT DETAILS
                    </span>

                    <h3>
                        Schedule a Vaccination
                    </h3>

                    <p>
                        Enter the required information below.
                    </p>

                </div>


           

                <form
                    id="appointmentForm"
                    action="{{ route('appointment.store') }}"
                    method="post">
                    @csrf


                

                    <div class="form-section">

                        <h4 class="form-section-title">

                            <span class="icon-user"></span>

                            Patient Information

                        </h4>


                        <div class="row">


                            <!-- Existing Child -->

                            @if(!$children->isEmpty())

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="child_id">
                                        Select Existing Child
                                    </label>

                                    <select
                                        id="child_id"
                                        name="child_id"
                                        class="form-control">

                                        <option value="0">
                                            New Child / Enter Below
                                        </option>

                                        @foreach($children as $child)

                                            <option
                                                value="{{ $child->child_id }}"
                                                data-name="{{ $child->child_name }}"
                                                data-dob="{{ $child->date_of_birth }}"
                                                data-gender="{{ $child->gender }}">

                                                {{ $child->child_name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            @else

                                <input
                                    type="hidden"
                                    name="child_id"
                                    value="0">

                            @endif


                            <!-- Child Name -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="child-name">
                                        Child / Patient Name
                                    </label>

                                    <input
                                        type="text"
                                        id="child-name"
                                        name="child_name"
                                        class="form-control"
                                        placeholder="Enter patient name"
                                        required>

                                </div>

                            </div>


                            <!-- DOB -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="dob">
                                        Date of Birth
                                    </label>

                                    <input
                                        type="date"
                                        id="dob"
                                        name="date_of_birth"
                                        class="form-control"
                                        required>

                                </div>

                            </div>


                            <!-- Gender -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="gender">
                                        Gender
                                    </label>

                                    <select
                                        id="gender"
                                        name="gender"
                                        class="form-control"
                                        required>

                                        <option value="">
                                            Select Gender
                                        </option>

                                        <option value="male">
                                            Male
                                        </option>

                                        <option value="female">
                                            Female
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="form-section">

                        <h4 class="form-section-title">

                            <span class="icon-medkit"></span>

                            Vaccination Details

                        </h4>


                        <div class="row">


                            <!-- HOSPITAL -->

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="hospital">
                                        Select Vaccination Center
                                    </label>

                                    <select
                                        id="hospital"
                                        name="hospital_id"
                                        class="form-control"
                                        required>

                                        <option value="">
                                            Choose a Hospital
                                        </option>

                                        @foreach($hospitals as $hospital)

                                            <option
                                                value="{{ $hospital->hospital_id ?? $hospital->id }}">
                                                {{ $hospital->hospital_name }} - {{ $hospital->city }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


                            <!-- VACCINE -->

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="vaccine">
                                        Select Vaccine
                                    </label>

                                    <select
                                        id="vaccine"
                                        name="hospital_vaccine_id"
                                        class="form-control"
                                        required>

                                        <option value="">
                                            First choose a hospital
                                        </option>

                                        @foreach($vaccines as $vaccine)

                                            <option
                                                value="{{ $vaccine->id }}"
                                                data-hospital-id="{{ $vaccine->hospital_id }}"
                                                data-availability="{{ $vaccine->availability }}">

                                                {{ $vaccine->vaccine_name }} - {{ $vaccine->availability }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


                            <!-- DATE -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="appointment-date">
                                        Preferred Date
                                    </label>

                                    <input
                                        type="date"
                                        id="appointment-date"
                                        name="appointment_date"
                                        class="form-control"
                                        min="<?php echo date('Y-m-d'); ?>"
                                        required>

                                </div>

                            </div>


                            <!-- TIME -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="appointment-time">
                                        Preferred Time
                                    </label>

                                    <select
                                        id="appointment-time"
                                        name="appointment_time"
                                        class="form-control"
                                        required>

                                        <option value="">
                                            Select Preferred Time
                                        </option>

                                        <option value="09:00:00">
                                            09:00 AM
                                        </option>

                                        <option value="10:00:00">
                                            10:00 AM
                                        </option>

                                        <option value="11:00:00">
                                            11:00 AM
                                        </option>

                                        <option value="12:00:00">
                                            12:00 PM
                                        </option>

                                        <option value="13:00:00">
                                            01:00 PM
                                        </option>

                                        <option value="14:00:00">
                                            02:00 PM
                                        </option>

                                        <option value="15:00:00">
                                            03:00 PM
                                        </option>

                                        <option value="16:00:00">
                                            04:00 PM
                                        </option>

                                        <option value="17:00:00">
                                            05:00 PM
                                        </option>

                                        <option value="18:00:00">
                                            06:00 PM
                                        </option>

                                        <option value="19:00:00">
                                            07:00 PM
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =========================================
                         PARENT CONTACT
                    ========================================== -->

                    <div class="form-section">

                        <h4 class="form-section-title">

                            <span class="icon-phone"></span>

                            Parent / Guardian Contact

                        </h4>


                        <div class="row">


                            <!-- NAME -->

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="parent-name">
                                        Parent / Guardian Name
                                    </label>

                                    <input
                                        type="text"
                                        id="parent-name"
                                        name="parent_name"
                                        class="form-control"
                                        value="{{ $parent->parent_name ?? '' }}"
                                        required>

                                </div>

                            </div>


                            <!-- PHONE -->

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
                                        value="{{ $parent->phone ?? '' }}"
                                        placeholder="+923001234567"
                                        pattern="^\+92[0-9]{10}$"
                                        maxlength="13"
                                        required>

                                    <small class="form-text text-muted">
                                        Format: +923001234567
                                    </small>

                                </div>

                            </div>


                            <!-- EMAIL -->

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
                                        value="{{ $parent->user?->email ?? ($parent->email ?? '') }}"
                                        required>

                                </div>

                            </div>


                            <!-- MESSAGE -->

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="message">
                                        Additional Information
                                    </label>

                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Any additional information about the patient or vaccination"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =========================================
                         SUBMIT
                    ========================================== -->

                    <div class="appointment-submit">

                        <button
                            type="submit"
                            id="bookAppointmentBtn"
                            class="btn btn-primary px-5 py-3">

                            Book Vaccination

                            <span class="icon-arrow-right ml-2"></span>

                        </button>

                        <p class="mt-3 mb-0">

                            Your appointment request will be
                            processed by the selected vaccination center.

                        </p>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById("appointmentForm");

    const hospital =
        document.getElementById("hospital");

    const vaccine =
        document.getElementById("vaccine");

    const child =
        document.getElementById("child_id");

    const childName =
        document.getElementById("child-name");

    const dob =
        document.getElementById("dob");

    const gender =
        document.getElementById("gender");

    const appointmentDate =
        document.getElementById("appointment-date");

    const phone =
        document.getElementById("phone");


    /* =====================================================
       CHILD AUTO FILL
    ===================================================== */

    if (child) {

        child.addEventListener("change", function () {

            const selected =
                this.options[this.selectedIndex];

            if (
                this.value !== "0" &&
                selected
            ) {

                childName.value =
                    selected.dataset.name || "";

                dob.value =
                    selected.dataset.dob || "";

                const childGender =
                    selected.dataset.gender || "";

                gender.value =
                    childGender.toLowerCase();

            } else {

                childName.value = "";
                dob.value = "";
                gender.value = "";

            }

        });

    }


    /* =====================================================
       HOSPITAL -> VACCINE FILTER
    ===================================================== */

    if (hospital && vaccine) {

        const allOptions =
            Array.from(
                vaccine.querySelectorAll(
                    "option[data-hospital-id]"
                )
            );


        function filterVaccines() {

            const hospitalId =
                hospital.value;


            vaccine.value = "";


            allOptions.forEach(function (option) {

                option.style.display = "none";

                option.disabled = true;


                if (
                    hospitalId !== "" &&
                    option.dataset.hospitalId === hospitalId &&
                    option.dataset.availability === "Available"
                ) {

                    option.style.display = "";
                    option.disabled = false;

                }

            });


            if (hospitalId === "") {

                vaccine.options[0].text =
                    "First choose a hospital";

            } else {

                vaccine.options[0].text =
                    "Choose an available vaccine";

            }

        }


        hospital.addEventListener(
            "change",
            filterVaccines
        );


        filterVaccines();

    }


    /* =====================================================
       TODAY / FUTURE DATE
    ===================================================== */

    if (appointmentDate) {

        const today =
            new Date();

        const year =
            today.getFullYear();

        const month =
            String(
                today.getMonth() + 1
            ).padStart(2, "0");

        const day =
            String(
                today.getDate()
            ).padStart(2, "0");

        appointmentDate.min =
            `${year}-${month}-${day}`;

    }


    /* =====================================================
       PHONE VALIDATION
    ===================================================== */

    if (phone) {

        phone.addEventListener(
            "input",
            function () {

                const pattern =
                    /^\+92[0-9]{10}$/;

                if (
                    pattern.test(
                        phone.value
                    )
                ) {

                    phone.setCustomValidity("");

                } else {

                    phone.setCustomValidity(
                        "Please enter a valid Pakistani phone number in the format +923001234567"
                    );

                }

            }
        );

    }


    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                if (!form.checkValidity()) {

                    event.preventDefault();

                    form.reportValidity();

                    return;

                }

                /*
                 * DO NOT prevent submission.
                 *
                 * Browser will submit the form to:
                 * appointment.php
                 *
                 * PHP above will INSERT into
                 * parent_requests table.
                 */

            }
        );

    }

});

</script>
@endsection

