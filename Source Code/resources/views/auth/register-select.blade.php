@extends('layouts.app')

@section('title', 'Choose Account Type | VacciCare')

@section('content')
<style>
    .register-select-page {
        min-height: 760px;
        padding: 52px 0 72px;
        background:
            linear-gradient(110deg, rgba(6, 50, 69, 0.9), rgba(15, 118, 110, 0.78)),
            url("{{ asset('images/vaccination-hero.png') }}") center right / cover no-repeat;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .register-select-page::after {
        content: "";
        position: absolute;
        inset: auto 0 0;
        height: 165px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0), #ffffff);
        pointer-events: none;
    }

    .register-select-wrap {
        position: relative;
        z-index: 1;
    }

    .register-select-kicker {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        padding: 8px 15px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.26);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .register-select-heading {
        max-width: 760px;
        margin-bottom: 16px;
        color: #ffffff;
        font-size: 48px;
        line-height: 1.15;
        font-weight: 800;
    }

    .register-select-text {
        max-width: 680px;
        margin-bottom: 38px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 18px;
        line-height: 1.8;
    }

    .register-choice-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        max-width: 1080px;
    }

    .register-choice-card {
        display: flex;
        min-height: 255px;
        padding: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 22px 55px rgba(4, 30, 42, 0.22);
        color: #15333d;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .register-choice-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 70px rgba(4, 30, 42, 0.3);
        color: #15333d;
        text-decoration: none;
    }

    .register-choice-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .register-choice-icon {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
        border-radius: 8px;
        color: #ffffff;
        font-size: 25px;
        background: #11998e;
    }

    .register-choice-card:nth-child(2) .register-choice-icon {
        background: #2f80ed;
    }

    .register-choice-card:nth-child(3) .register-choice-icon {
        background: #6c63ff;
    }

    .register-choice-card h2 {
        margin: 0 0 10px;
        color: #12313b;
        font-size: 23px;
        font-weight: 800;
        line-height: 1.25;
    }

    .register-choice-card p {
        margin: 0 0 24px;
        color: #60727a;
        font-size: 15px;
        line-height: 1.7;
    }

    .register-choice-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
        color: #0b8278;
        font-weight: 800;
        font-size: 14px;
    }

    @media (max-width: 991.98px) {
        .register-select-page {
            padding: 48px 0 64px;
        }

        .register-select-heading {
            font-size: 38px;
        }

        .register-choice-grid {
            grid-template-columns: 1fr;
        }

        .register-choice-card {
            min-height: auto;
        }
    }

    @media (max-width: 575.98px) {
        .register-select-page {
            padding: 42px 0 54px;
        }

        .register-select-heading {
            font-size: 31px;
        }

        .register-select-text {
            font-size: 16px;
        }

        .register-choice-card {
            padding: 24px;
        }
    }
</style>

<section class="register-select-page">
    <div class="container register-select-wrap">
        <span class="register-select-kicker">
            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
            Choose Account Type
        </span>

        <h1 class="register-select-heading">
            Which type of account would you like to register?
        </h1>

        <p class="register-select-text">
            Select your category below. The related signup page will open
            based on your choice.
        </p>

        <div class="register-choice-grid">
            <a class="register-choice-card" href="{{ route('hospital.register') }}">
                <span class="register-choice-content">
                    <span class="register-choice-icon">
                        <i class="fa-solid fa-hospital" aria-hidden="true"></i>
                    </span>
                    <h2>Hospital Register</h2>
                    <p>
                        Create a hospital profile and manage vaccination
                        services through VacciCare.
                    </p>
                    <span class="register-choice-action">
                        Open Hospital Signup
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </span>
                </span>
            </a>

            <a class="register-choice-card" href="{{ route('register.parent') }}">
                <span class="register-choice-content">
                    <span class="register-choice-icon">
                        <i class="fa-solid fa-people-roof" aria-hidden="true"></i>
                    </span>
                    <h2>Parent Register</h2>
                    <p>
                        Create a parent account to manage child records,
                        schedules, and appointments.
                    </p>
                    <span class="register-choice-action">
                        Open Parent Signup
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </span>
                </span>
            </a>
        </div>
    </div>
</section>
@endsection
