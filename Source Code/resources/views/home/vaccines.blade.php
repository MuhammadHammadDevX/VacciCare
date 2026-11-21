@extends('layouts.app')

@section('title', 'Vaccines | VacciCare')

@push('styles')
<style>
    html, body {
        overflow-x: hidden !important;
        max-width: 100% !important;
    }
    .vaccine-detail-card {
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
</style>
@endpush

@section('content')
<!-- Vaccines Page Header -->
<section class="hero-wrap hero-wrap-2"
         style="background-image: url('{{ asset('images/vaccine-header.png') }}');">

    <div class="overlay"></div>

    <div class="container">

        <div class="row no-gutters slider-text align-items-center justify-content-center">

            <div class="col-md-9 text-center">

                <span class="subheading">VACCICARE</span>

                <h1 class="mb-3">
                    Vaccines
                </h1>

                <p class="mb-4">
                    Explore essential vaccines, recommended doses, and
                    vaccination information to protect you and your family.
                </p>

                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">
                            Home <i class="ion-ios-arrow-forward"></i>
                        </a>
                    </span>

                    <span>
                        Vaccines <i class="ion-ios-arrow-forward"></i>
                    </span>
                </p>

            </div>

        </div>

    </div>

</section>






<div class="container">

    <!-- =====================================================
         01. BCG VACCINE
    ====================================================== -->
    <div class="vaccine-detail-card" id="bcg">

        <div class="row align-items-center">

            <!-- Image -->
            <div class="col-md-5">
                <div class="vaccine-image-box">

                    <span class="vaccine-number">01</span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-bcg.jpg') }}');">
                    </div>

                </div>
            </div>

            <!-- Content -->
            <div class="col-md-7 pl-md-5">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>BCG Vaccine</h2>

                    <p class="vaccine-description">
                        The BCG vaccine helps protect children against
                        tuberculosis (TB), particularly serious forms
                        of tuberculosis in young children.
                    </p>


                    <!-- Information -->
                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    At birth / early infancy
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    According to immunization schedule
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Tuberculosis
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">
                            →
                        </span>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         02. POLIO VACCINE
    ====================================================== -->
    <div class="vaccine-detail-card" id="polio">

        <div class="row align-items-center">

            <!-- Content -->
            <div class="col-md-7 pr-md-5 order-md-1 order-2">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>Polio Vaccine</h2>

                    <p class="vaccine-description">
                        Polio vaccination protects children against
                        poliovirus, which can cause paralysis and
                        other serious complications.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Infancy and early childhood
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Multiple doses as scheduled
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Poliovirus / Polio
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>


            <!-- Image -->
            <div class="col-md-5 order-md-2 order-1">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        02
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-polio.jpg') }}');">
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         03. HEPATITIS B
    ====================================================== -->
    <div class="vaccine-detail-card" id="hepatitis-b">

        <div class="row align-items-center">

            <div class="col-md-5">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        03
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-hepatitis-b.jpg') }}');">
                    </div>

                </div>

            </div>


            <div class="col-md-7 pl-md-5">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        Hepatitis B Vaccine
                    </h2>

                    <p class="vaccine-description">
                        The Hepatitis B vaccine protects against
                        hepatitis B virus infection, which can affect
                        the liver and cause long-term complications.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Birth and infancy
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Multiple doses as scheduled
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Hepatitis B infection
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         04. DTP
    ====================================================== -->
    <div class="vaccine-detail-card" id="dtp">

        <div class="row align-items-center">

            <div class="col-md-7 pr-md-5 order-md-1 order-2">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        DTP Vaccine
                    </h2>

                    <p class="vaccine-description">
                        The DTP vaccine helps protect children against
                        diphtheria, tetanus and pertussis (whooping cough).
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Infancy and early childhood
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Multiple doses as scheduled
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Diphtheria, Tetanus & Pertussis
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>


            <div class="col-md-5 order-md-2 order-1">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        04
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-dtp.jpg') }}');">
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         05. HIB
    ====================================================== -->
    <div class="vaccine-detail-card" id="hib">

        <div class="row align-items-center">

            <div class="col-md-5">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        05
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-hib.jpg') }}');">
                    </div>

                </div>

            </div>


            <div class="col-md-7 pl-md-5">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        Hib Vaccine
                    </h2>

                    <p class="vaccine-description">
                        The Hib vaccine protects young children from
                        serious infections caused by Haemophilus
                        influenzae type b bacteria.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Infants and young children
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Multiple doses as scheduled
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Serious Hib infections
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         06. MEASLES
    ====================================================== -->
    <div class="vaccine-detail-card" id="measles">

        <div class="row align-items-center">

            <div class="col-md-7 pr-md-5 order-md-1 order-2">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        Measles Vaccine
                    </h2>

                    <p class="vaccine-description">
                        Measles vaccination provides protection against
                        measles, a highly contagious viral infection
                        that can cause serious complications.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Children according to schedule
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Dose as recommended by schedule
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Measles
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>


            <div class="col-md-5 order-md-2 order-1">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        06
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-measles.jpg') }}');">
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         07. MMR
    ====================================================== -->
    <div class="vaccine-detail-card" id="mmr">

        <div class="row align-items-center">

            <div class="col-md-5">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        07
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-mmr.jpg') }}');">
                    </div>

                </div>

            </div>


            <div class="col-md-7 pl-md-5">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        MMR Vaccine
                    </h2>

                    <p class="vaccine-description">
                        The MMR vaccine helps protect against measles,
                        mumps and rubella and is an important part
                        of childhood immunization.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Children according to schedule
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Doses according to schedule
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Measles, Mumps & Rubella
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         08. ROTAVIRUS
    ====================================================== -->
    <div class="vaccine-detail-card" id="rotavirus">

        <div class="row align-items-center">

            <div class="col-md-7 pr-md-5 order-md-1 order-2">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        Rotavirus Vaccine
                    </h2>

                    <p class="vaccine-description">
                        Rotavirus vaccination helps protect infants
                        and young children from rotavirus infection,
                        which can cause severe diarrhea and dehydration.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Young infants
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Doses according to vaccine schedule
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Rotavirus disease
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>


            <div class="col-md-5 order-md-2 order-1">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        08
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-rotavirus.jpg') }}');">
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         09. PNEUMOCOCCAL
    ====================================================== -->
    <div class="vaccine-detail-card" id="pneumococcal">

        <div class="row align-items-center">

            <div class="col-md-5">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        09
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-pneumococcal.jpg') }}');">
                    </div>

                </div>

            </div>


            <div class="col-md-7 pl-md-5">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        Pneumococcal Vaccine
                    </h2>

                    <p class="vaccine-description">
                        Pneumococcal vaccination helps protect children
                        against infections caused by pneumococcal bacteria,
                        including serious respiratory and invasive diseases.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👶
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Infants and young children
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    Multiple doses as scheduled
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Pneumococcal disease
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         10. COVID-19
    ====================================================== -->
    <div class="vaccine-detail-card" id="covid-19">

        <div class="row align-items-center">

            <div class="col-md-7 pr-md-5 order-md-1 order-2">

                <div class="vaccine-content">

                    <span class="subheading">
                        VACCINE INFORMATION
                    </span>

                    <h2>
                        COVID-19 Vaccine
                    </h2>

                    <p class="vaccine-description">
                        COVID-19 vaccination helps reduce the risk
                        of severe illness caused by SARS-CoV-2.
                        Recommendations may vary according to
                        age, health status and current guidance.
                    </p>


                    <div class="vaccine-info-row">

                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                👨‍👩‍👧
                            </span>

                            <div>
                                <small>RECOMMENDED AGE</small>

                                <strong>
                                    Eligible individuals
                                </strong>
                            </div>

                        </div>


                        <div class="vaccine-info-box">

                            <span class="info-icon">
                                💉
                            </span>

                            <div>
                                <small>DOSE</small>

                                <strong>
                                    According to current guidance
                                </strong>
                            </div>

                        </div>

                    </div>


                    <div class="protect-box">

                        <span>🛡</span>

                        <div>
                            <small>PROTECTS AGAINST</small>

                            <strong>
                                Severe COVID-19 illness
                            </strong>
                        </div>

                    </div>


                    <a href="{{ route('appointment') }}"
                       class="btn btn-primary vaccine-btn">

                        Select Vaccine & Book

                        <span class="ml-2">→</span>

                    </a>

                </div>

            </div>


            <div class="col-md-5 order-md-2 order-1">

                <div class="vaccine-image-box">

                    <span class="vaccine-number">
                        10
                    </span>

                    <div class="img"
                         style="background-image: url('{{ asset('images/vaccine-covid.jpg') }}');">
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection

