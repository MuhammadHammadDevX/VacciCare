@extends('layouts.admin')

@section('title', 'Admin Dashboard | VacciCare')

@section('content')
<div class="admin-dashboard">


    <div
        class="dash-atmosphere"
        aria-hidden="true"
    >

        <span class="dash-orb dash-orb-1"></span>

        <span class="dash-orb dash-orb-2"></span>

        <span class="dash-orb dash-orb-3"></span>

    </div>


    <section class="admin-page-header">

        <div class="page-heading">

            <span class="page-eyebrow">

                <span class="eyebrow-icon">

                    <i class="bi bi-stars"></i>

                </span>

                ADMIN PORTAL

            </span>

            <h1>
                Admin Dashboard
            </h1>

            <p>
                Manage vaccination records, hospitals,
                vaccines and parent requests.
            </p>

        </div>


        <div class="header-date">

            <div class="date-icon">

                <i class="bi bi-calendar3"></i>

            </div>

            <div>

                <span>
                    Today
                </span>

                <strong>
                    {{ date('d F Y') }}
                </strong>

            </div>

        </div>

    </section>



    @if(session('requestMessage'))

        <div class="alert alert-{{ session('requestMessageType', 'success') }}">

            {{ session('requestMessage') }}

        </div>

    @endif


    <section class="stats-grid">

        @foreach($stats as $stat)

            <div class="stat-card">

                <div class="stat-top">

                    <div
                        class="stat-icon {{ $stat['class'] }}"
                    >

                        <i
                            class="bi {{ $stat['icon'] }}"
                        ></i>

                    </div>

                    <span class="stat-arrow">

                        <i class="bi bi-arrow-up-right"></i>

                    </span>

                </div>


                <div class="stat-content">

                    <span class="stat-title">

                        {{ $stat['title'] }}

                    </span>


                    <strong class="stat-value">

                        {{ $stat['value'] }}

                    </strong>


                    <span class="stat-label">

                        {{ $stat['label'] }}

                    </span>

                </div>

            </div>

        @endforeach

    </section>


    <section class="dashboard-grid">


        <div class="dashboard-card activity-card">

            <div class="card-header">

                <div>

                    <span class="card-eyebrow">
                        VACCINATION MANAGEMENT
                    </span>

                    <h2>
                        Vaccination Activity
                    </h2>

                    <p>
                        Monthly completed vaccination records
                    </p>

                </div>


                <select
                    id="activityFilter"
                    class="small-select"
                >

                    <option value="{{ $currentYear }}">
                        {{ $currentYear }}
                    </option>

                    <option value="{{ $previousYear }}">
                        {{ $previousYear }}
                    </option>

                </select>

            </div>


            <div class="chart-wrapper">

                <canvas
                    id="vaccinationChart"
                ></canvas>

            </div>

        </div>


        <div class="dashboard-card quick-card">

            <div class="card-header">

                <div>

                    <span class="card-eyebrow">
                        ADMIN TOOLS
                    </span>

                    <h2>
                        Quick Actions
                    </h2>

                    <p>
                        Frequently used management tools
                    </p>

                </div>

            </div>


            <div class="quick-actions">


                <a
                    href="{{ route('admin.add-hospital') }}"
                    class="quick-action"
                >

                    <span class="quick-icon blue-bg">

                        <i class="bi bi-hospital-fill"></i>

                    </span>

                    <span>

                        <strong>
                            Add Hospital
                        </strong>

                        <small>
                            Register a new hospital
                        </small>

                    </span>

                    <b>
                        <i class="bi bi-arrow-right"></i>
                    </b>

                </a>


                <a
                    href="{{ route('admin.vaccine-list') }}"
                    class="quick-action"
                >

                    <span class="quick-icon green-bg">

                        <i class="bi bi-capsule-pill"></i>

                    </span>

                    <span>

                        <strong>
                            Manage Vaccines
                        </strong>

                        <small>
                            View vaccine availability
                        </small>

                    </span>

                    <b>
                        <i class="bi bi-arrow-right"></i>
                    </b>

                </a>


                <a
                    href="{{ route('admin.parent-requests') }}"
                    class="quick-action"
                >

                    <span class="quick-icon orange-bg">

                        <i class="bi bi-person-lines-fill"></i>

                    </span>

                    <span>

                        <strong>
                            Parent Requests
                        </strong>

                        <small>
                            Review pending requests
                        </small>

                    </span>

                    <b>
                        <i class="bi bi-arrow-right"></i>
                    </b>

                </a>


                <a
                    href="{{ route('admin.vaccination-report') }}#vaccineReport"
                    class="quick-action"
                >

                    <span class="quick-icon purple-bg">

                        <i class="bi bi-bar-chart-line-fill"></i>

                    </span>

                    <span>

                        <strong>
                            Vaccination Reports
                        </strong>

                        <small>
                            View date-wise reports
                        </small>

                    </span>

                    <b>
                        <i class="bi bi-arrow-right"></i>
                    </b>

                </a>

            </div>

        </div>

    </section>


    <section class="dashboard-card table-card">

        <div class="card-header">

            <div>

                <span class="card-eyebrow">
                    VACCINATION RECORDS
                </span>

                <h2>
                    Recent Vaccination Records
                </h2>

                <p>
                    Latest vaccination activity across hospitals
                </p>

            </div>


            <a
                href="{{ route('admin.vaccination-report') }}"
                class="view-all"
            >

                View All

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        <div class="table-container">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            Child
                        </th>

                        <th>
                            Vaccine
                        </th>

                        <th>
                            Hospital
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @if($recentVaccinations->isEmpty())

                        <tr>

                            <td
                                colspan="5"
                                style="text-align:center;padding:30px;"
                            >

                                No vaccination records found.

                            </td>

                        </tr>

                    @else


                        @foreach($recentVaccinations as $record)

                            <tr>

                                <td>

                                    <div class="person-cell">

                                        <span class="person-avatar">

                                            {{ strtoupper(substr($record->child->child_name ?? '', 0, 1)) }}

                                        </span>


                                        <strong>

                                            {{ $record->child->child_name ?? 'N/A' }}

                                        </strong>

                                    </div>

                                </td>


                                <td>

                                    <span class="vaccine-name">

                                        <i class="bi bi-shield-fill-check"></i>

                                        {{ $record->vaccine->vaccine_name ?? 'N/A' }}

                                    </span>

                                </td>


                                <td>

                                    <span class="hospital-table-name">

                                        <i class="bi bi-hospital"></i>

                                        {{ $record->hospital->hospital_name ?? 'N/A' }}

                                    </span>

                                </td>


                                <td>

                                    <span class="date-cell">

                                        <i class="bi bi-calendar3"></i>

                                        {{ \Carbon\Carbon::parse($record->vaccination_date)->format('d M Y') }}

                                    </span>

                                </td>


                                <td>

                                    <span class="status completed">

                                        <i class="bi bi-check-circle-fill"></i>

                                        {{ $record->status }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach


                    @endif

                </tbody>

            </table>

        </div>

    </section>


    <section class="bottom-grid">


        <div class="dashboard-card">

            <div class="card-header">

                <div>

                    <span class="card-eyebrow">
                        PARENT MANAGEMENT
                    </span>

                    <h2>
                        Recent Parent Requests
                    </h2>

                    <p>
                        Requests waiting for admin review
                    </p>

                </div>


                <span class="pending-count">

                    <i class="bi bi-hourglass-split"></i>

                    {{ number_format($pendingRequests) }}
                    Pending

                </span>

            </div>


            <div class="request-list">

                @if($parentRequests->isEmpty())

                    <div class="request-item">

                        <div class="request-info">

                            <strong>
                                No pending requests
                            </strong>

                            <span>
                                All parent requests have been reviewed.
                            </span>

                        </div>

                    </div>

                @else


                    @foreach($parentRequests as $request)

                        <div class="request-item">

                            <div class="request-avatar">

                                {{ strtoupper(substr($request->parent->parent_name ?? '', 0, 1)) }}

                            </div>


                            <div class="request-info">

                                <strong>

                                    {{ $request->parent->parent_name ?? 'N/A' }}

                                </strong>


                                <span>

                                    Child:

                                    {{ $request->child->child_name ?? 'N/A' }}

                                </span>


                                <small>

                                    <i class="bi bi-file-earmark-text"></i>

                                    {{ $request->request_type }}

                                    &middot;

                                    {{ \Carbon\Carbon::parse($request->request_date)->format('d M Y') }}

                                </small>

                            </div>


                            <!-- BACKEND FORM -->

                            <div class="request-actions">


                                <form
                                    method="POST"
                                    action="{{ route('admin.dashboard') }}"
                                    style="display:inline;"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="request_id"
                                        value="{{ (int)$request->request_id }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="approved"
                                    >

                                    <button
                                        type="submit"
                                        class="approve-btn"
                                        title="Approve"
                                    >

                                        <i class="bi bi-check-lg"></i>

                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="{{ route('admin.dashboard') }}"
                                    style="display:inline;"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="request_id"
                                        value="{{ (int)$request->request_id }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="rejected"
                                    >

                                    <button
                                        type="submit"
                                        class="reject-btn"
                                        title="Reject"
                                    >

                                        <i class="bi bi-x-lg"></i>

                                    </button>

                                </form>

                            </div>

                        </div>

                    @endforeach


                @endif

            </div>


            <a
                href="{{ route('admin.parent-requests') }}"
                class="full-link"
            >

                Manage All Requests

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        <div class="dashboard-card">

            <div class="card-header">

                <div>

                    <span class="card-eyebrow">
                        HOSPITAL MANAGEMENT
                    </span>

                    <h2>
                        Hospital Overview
                    </h2>

                    <p>
                        Registered hospitals and activity
                    </p>

                </div>


                <a
                    href="{{ route('admin.hospital-list') }}"
                    class="view-all"
                >

                    View All

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="hospital-list">

                @if($hospitalOverview->isEmpty())

                    <div class="hospital-item">

                        <div class="hospital-info">

                            <strong>
                                No hospitals found
                            </strong>

                        </div>

                    </div>

                @else


                    @foreach($hospitalOverview as $hospital)

                        <div class="hospital-item">

                            <div class="hospital-icon">

                                <i class="bi bi-hospital-fill"></i>

                            </div>


                            <div class="hospital-info">

                                <strong>

                                    {{ $hospital->hospital_name }}

                                </strong>


                                <span>

                                    <i class="bi bi-geo-alt"></i>

                                    {{ $hospital->city }}

                                    &middot;

                                    {{ number_format((int)$hospital->vaccination_count) }}

                                    vaccinations

                                </span>

                            </div>


                            <span class="hospital-status">

                                @if($hospital->status === 'Active')

                                    <i class="bi bi-check-circle-fill"></i>

                                @else

                                    <i class="bi bi-x-circle-fill"></i>

                                @endif


                                {{ $hospital->status }}

                            </span>

                        </div>

                    @endforeach


                @endif

            </div>


            <a
                href="{{ route('admin.add-hospital') }}"
                class="add-hospital-btn"
            >

                <i class="bi bi-plus-lg"></i>

                Add New Hospital

            </a>

        </div>

    </section>


    <section class="management-strip">

        <div class="management-title">

            <span class="card-eyebrow">
                SYSTEM MANAGEMENT
            </span>

            <h2>
                Vaccination System Overview
            </h2>

        </div>


        <div class="management-links">


            <a href="{{ route('admin.children') }}">

                <span>
                    <i class="bi bi-people-fill"></i>
                </span>

                All Children

            </a>


            <a
                href="{{ route('admin.vaccination-report') }}#vaccineReport"
            >

                <span>
                    <i class="bi bi-clipboard2-pulse-fill"></i>
                </span>

                Vaccination Reports

            </a>


            <a href="{{ route('admin.vaccine-list') }}">

                <span>
                    <i class="bi bi-capsule-pill"></i>
                </span>

                Vaccine List

            </a>


            <a href="{{ route('admin.parent-requests') }}">

                <span>
                    <i class="bi bi-person-lines-fill"></i>
                </span>

                Parent Requests

            </a>


            <a href="{{ route('admin.hospital-list') }}">

                <span>
                    <i class="bi bi-hospital-fill"></i>
                </span>

                Hospitals

            </a>


            <a href="{{ route('admin.booking-details') }}">

                <span>
                    <i class="bi bi-calendar2-check-fill"></i>
                </span>

                Booking Details

            </a>


        </div>

    </section>

</div>
@endsection

@push('scripts')
<script
    src="https://cdn.jsdelivr.net/npm/chart.js"
></script>

<script>

const vaccinationChartData = {

    "{{ $currentYear }}":
        {!! json_encode($currentYearData) !!},

    "{{ $previousYear }}":
        {!! json_encode($previousYearData) !!}

};

</script>

<script
    src="{{ asset('js/admin-dashboard.js') }}"
></script>
@endpush
