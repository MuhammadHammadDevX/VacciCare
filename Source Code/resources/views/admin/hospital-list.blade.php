@extends('layouts.admin')

@section('title', 'List of Hospitals | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hospital-list.css') }}">
@endpush

@section('content')
<main class="admin-hospitals-page">

    <!-- PAGE HEADER -->
    <section class="hospitals-page-header">
        <div class="page-heading">
            <span class="page-eyebrow">
                <i class="bi bi-hospital-fill"></i>
                HOSPITAL MANAGEMENT
            </span>
            <h1>List of Hospitals</h1>
            <p>View and manage all hospitals registered in the VacciCare vaccination system.</p>
        </div>

        <div style="display:flex; gap:10px; align-items:center;">
            <a href="{{ route('admin.export.hospitals') }}" style="background:#10b981; color:#fff; border-radius:10px; padding:10px 16px; font-weight:700; font-size:13px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; box-shadow:0 4px 12px rgba(16,185,129,0.2);">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Directory (CSV)
            </a>
            <a href="{{ route('admin.add-hospital') }}" class="add-hospital-button">
                <i class="bi bi-plus-circle-fill"></i> Add Hospital
            </a>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success mt-3" role="alert">
            <i class="bi bi-check-circle-fill mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('deleted'))
        <div class="alert alert-success mt-3" role="alert">
            <i class="bi bi-check-circle-fill mr-2"></i>
            Hospital deleted successfully.
        </div>
    @endif

    <!-- SUMMARY CARDS -->
    <section class="hospital-summary">
        <div class="summary-card blue">
            <div class="summary-icon">
                <i class="bi bi-hospital-fill"></i>
            </div>
            <div>
                <span>Total Hospitals</span>
                <strong>{{ $totalHospitals }}</strong>
            </div>
        </div>

        <div class="summary-card green">
            <div class="summary-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <span>Active Hospitals</span>
                <strong>{{ $activeHospitals }}</strong>
            </div>
        </div>

        <div class="summary-card red">
            <div class="summary-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <span>Inactive Hospitals</span>
                <strong>{{ $inactiveHospitals }}</strong>
            </div>
        </div>

        <div class="summary-card purple">
            <div class="summary-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <span>System Status</span>
                <strong class="system-active">Active</strong>
            </div>
        </div>
    </section>

    <!-- HOSPITAL DIRECTORY -->
    <section class="hospital-list-card">
        <div class="hospital-list-header">
            <div>
                <span class="section-eyebrow">REGISTERED HOSPITALS</span>
                <h2>Hospital Directory</h2>
                <p>Complete list of hospitals registered with VacciCare.</p>
            </div>
            <div class="hospital-count">
                <i class="bi bi-buildings-fill"></i>
                {{ $totalHospitals }} Records
            </div>
        </div>

        <!-- FILTERS -->
        <div class="hospital-filters">
            <div class="hospital-search">
                <i class="bi bi-search"></i>
                <input type="text" id="hospitalSearch" placeholder="Search hospital, license, city...">
            </div>

            <div class="filter-select">
                <i class="bi bi-geo-alt"></i>
                <select id="cityFilter">
                    <option value="">All Cities</option>
                    <option value="Karachi">Karachi</option>
                    <option value="Lahore">Lahore</option>
                    <option value="Islamabad">Islamabad</option>
                    <option value="Rawalpindi">Rawalpindi</option>
                    <option value="Peshawar">Peshawar</option>
                    <option value="Quetta">Quetta</option>
                </select>
            </div>

            <div class="filter-select">
                <i class="bi bi-funnel"></i>
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- TABLE -->
        <div class="hospital-table-wrapper">
            <table class="hospital-table">
                <thead>
                    <tr>
                        <th>Hospital</th>
                        <th>Type</th>
                        <th>License No.</th>
                        <th>Contact</th>
                        <th>City</th>
                        <th>Working Hours</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="hospitalTableBody">
                    @forelse($hospitals as $hospital)
                        <tr class="hospital-row"
                            data-city="{{ $hospital->city }}"
                            data-status="{{ $hospital->status }}"
                            data-search="{{ strtolower($hospital->hospital_name . ' ' . $hospital->license_no . ' ' . $hospital->city . ' ' . $hospital->email . ' ' . $hospital->phone) }}">
                            <!-- HOSPITAL -->
                            <td>
                                <div class="hospital-name-cell">
                                    <div class="hospital-avatar">
                                        <i class="bi bi-hospital-fill"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $hospital->hospital_name }}</strong>
                                        <span>HSP-{{ $hospital->hospital_id }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- TYPE -->
                            <td>
                                <span class="type-badge">{{ $hospital->hospital_type }}</span>
                            </td>

                            <!-- LICENSE -->
                            <td>
                                <span class="license-number">{{ $hospital->license_no }}</span>
                            </td>

                            <!-- CONTACT -->
                            <td>
                                <div class="contact-cell">
                                    <span><i class="bi bi-telephone-fill"></i> {{ $hospital->phone }}</span>
                                    <span><i class="bi bi-envelope-fill"></i> {{ $hospital->email }}</span>
                                </div>
                            </td>

                            <!-- CITY -->
                            <td>
                                <span class="city-cell">
                                    <i class="bi bi-geo-alt-fill"></i> {{ $hospital->city }}
                                </span>
                            </td>

                            <!-- HOURS -->
                            <td>
                                <span class="hours-cell">
                                    <i class="bi bi-clock-fill"></i> {{ $hospital->working_hours ?: 'Not specified' }}
                                </span>
                            </td>

                            <!-- STATUS -->
                            <td>
                                @if($hospital->status === 'Active')
                                    <span class="status-badge active">
                                        <span></span> Active
                                    </span>
                                @else
                                    <span class="status-badge inactive">
                                        <span></span> Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- ACTIONS -->
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.view-hospital', $hospital->hospital_id) }}" class="view-button" title="View Hospital">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a href="{{ route('admin.edit-hospital', $hospital->hospital_id) }}" class="edit-button" title="Edit Hospital">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.delete-hospital') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this hospital?');">
                                        @csrf
                                        <input type="hidden" name="hospital_id" value="{{ $hospital->hospital_id }}">
                                        <button type="submit" class="delete-button" title="Delete Hospital">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:30px;">
                                No hospitals registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("hospitalSearch");
    const cityFilter = document.getElementById("cityFilter");
    const statusFilter = document.getElementById("statusFilter");
    const rows = document.querySelectorAll(".hospital-row");

    function filterHospitals() {
        const query = searchInput.value.toLowerCase().trim();
        const city = cityFilter.value;
        const status = statusFilter.value;

        rows.forEach(function (row) {
            const rowSearch = row.getAttribute("data-search") || "";
            const rowCity = row.getAttribute("data-city") || "";
            const rowStatus = row.getAttribute("data-status") || "";

            const matchesSearch = query === "" || rowSearch.includes(query);
            const matchesCity = city === "" || rowCity === city;
            const matchesStatus = status === "" || rowStatus === status;

            if (matchesSearch && matchesCity && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    if (searchInput) searchInput.addEventListener("input", filterHospitals);
    if (cityFilter) cityFilter.addEventListener("change", filterHospitals);
    if (statusFilter) statusFilter.addEventListener("change", filterHospitals);
});
</script>
@endpush