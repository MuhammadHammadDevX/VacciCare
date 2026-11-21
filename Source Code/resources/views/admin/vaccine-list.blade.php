@extends('layouts.admin')

@section('title', 'List of Vaccines | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vaccine-list.css') }}">
@endpush

@section('content')
<main class="admin-vaccine-page">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-check-circle-fill" style="font-size:18px;"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px; margin-bottom:20px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size:18px;"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <!-- PAGE HEADER -->
    <section class="vaccine-page-header">
        <div class="heading-area">
            <div class="eyebrow">
                <i class="bi bi-shield-plus"></i> VACCINE MANAGEMENT
            </div>
            <h1>Vaccine List</h1>
            <p>View vaccines added by hospitals and check their current availability.</p>
        </div>

        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <button type="button" class="btn-add-primary" data-toggle="modal" data-target="#addVaccineModal">
                <i class="bi bi-plus-circle-fill"></i> Add Vaccine
            </button>
            <div class="header-badge">
                <div class="header-badge-icon">
                    <i class="bi bi-capsule"></i>
                </div>
                <div>
                    <span>Hospital Vaccines</span>
                    <strong>{{ $totalVaccines }} Vaccines</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- SUMMARY CARDS -->
    <section class="vaccine-summary">
        <!-- TOTAL -->
        <div class="summary-card">
            <div class="summary-icon blue">
                <i class="bi bi-capsule"></i>
            </div>
            <div>
                <span>Total Vaccines</span>
                <strong>{{ $totalVaccines }}</strong>
            </div>
        </div>

        <!-- AVAILABLE -->
        <div class="summary-card">
            <div class="summary-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <span>Available</span>
                <strong>{{ $availableVaccines }}</strong>
            </div>
        </div>

        <!-- UNAVAILABLE -->
        <div class="summary-card">
            <div class="summary-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <span>Unavailable</span>
                <strong>{{ $unavailableVaccines }}</strong>
            </div>
        </div>
    </section>

    <!-- VACCINE TABLE CARD -->
    <section class="vaccine-card">
        <div class="card-top">
            <div>
                <span class="section-label">VACCINATION INVENTORY</span>
                <h2>Hospital Vaccine List</h2>
                <p>Track vaccines supplied and managed across participating hospitals.</p>
            </div>

            <div class="table-tools">
                <div class="search-input">
                    <i class="bi bi-search"></i>
                    <input type="text" id="vaccineSearch" placeholder="Search vaccine or hospital...">
                </div>

                <!-- Custom Modern Glassmorphic Dropdown -->
                <div class="custom-dropdown" id="customAvailabilityDropdown">
                    <button type="button" class="custom-dropdown-trigger" id="availabilityTrigger" aria-haspopup="listbox" aria-expanded="false">
                        <i class="bi bi-funnel filter-icon"></i>
                        <span class="status-indicator-dot dot-all"></span>
                        <span class="selected-text" id="selectedAvailabilityText">All Availability</span>
                        <i class="bi bi-chevron-down chevron-icon"></i>
                    </button>

                    <select id="statusFilter" class="sr-only" aria-hidden="true" tabindex="-1">
                        <option value="all" selected>All Availability</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>

                    <div class="custom-dropdown-menu" id="availabilityMenu" role="listbox">
                        <div class="dropdown-header">Filter by Status</div>

                        <div class="dropdown-item active" data-value="all" role="option" aria-selected="true">
                            <span class="status-indicator-dot dot-all"></span>
                            <div class="item-text">
                                <strong>All Availability</strong>
                                <small>Show all hospital vaccines</small>
                            </div>
                            <i class="bi bi-check2 check-icon"></i>
                        </div>

                        <div class="dropdown-item" data-value="available" role="option" aria-selected="false">
                            <span class="status-indicator-dot dot-available"></span>
                            <div class="item-text">
                                <strong>Available</strong>
                                <small>In stock at hospitals</small>
                            </div>
                            <i class="bi bi-check2 check-icon"></i>
                        </div>

                        <div class="dropdown-item" data-value="unavailable" role="option" aria-selected="false">
                            <span class="status-indicator-dot dot-unavailable"></span>
                            <div class="item-text">
                                <strong>Unavailable</strong>
                                <small>Currently out of stock</small>
                            </div>
                            <i class="bi bi-check2 check-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="vaccine-table" id="vaccineTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vaccine</th>
                        <th>Hospital</th>
                        <th>Description</th>
                        <th>Availability</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vaccines as $index => $vaccine)
                        <tr data-status="{{ strtolower($vaccine->availability) }}"
                            data-search="{{ strtolower(($vaccine->vaccine_name ?? '') . ' ' . ($vaccine->hospital->hospital_name ?? '') . ' ' . ($vaccine->description ?? '')) }}">
                            <td>
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>

                            <td>
                                <div class="vaccine-name-cell">
                                    <div class="vaccine-icon">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $vaccine->vaccine_name }}</strong>
                                        <small>Hospital Vaccine</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="info-cell">
                                    <i class="bi bi-hospital"></i>
                                    <span>{{ $vaccine->hospital->hospital_name ?? 'Unknown Hospital' }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="info-cell">
                                    <i class="bi bi-info-circle"></i>
                                    <span>{{ $vaccine->description ?: 'No description provided' }}</span>
                                </div>
                            </td>

                            <td>
                                @if($vaccine->availability === 'Available')
                                    <span class="status-badge available">
                                        <span class="status-dot"></span> Available
                                    </span>
                                @else
                                    <span class="status-badge unavailable">
                                        <span class="status-dot"></span> Unavailable
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:right; white-space:nowrap;">
                                <div class="table-action-btns">
                                    <button type="button" class="action-btn-circle edit-btn" data-toggle="modal" data-target="#editVaccineModal{{ $vaccine->id }}" title="Edit Vaccine">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('admin.vaccines.destroy', $vaccine->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this vaccine from hospital inventory?');">
                                        @csrf
                                        <button type="submit" class="action-btn-circle delete-btn" title="Delete Vaccine">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px;">
                                <div style="opacity: 0.7;">
                                    <div class="no-results-icon">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <h3>No Vaccines Found</h3>
                                    <p>No hospital has added any vaccines yet.</p>
                                </div>
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
    const searchInput = document.getElementById("vaccineSearch");
    const statusFilter = document.getElementById("statusFilter");
    const rows = document.querySelectorAll("#vaccineTable tbody tr");

    const customDropdown = document.getElementById("customAvailabilityDropdown");
    const dropdownTrigger = document.getElementById("availabilityTrigger");
    const selectedText = document.getElementById("selectedAvailabilityText");
    const dropdownItems = document.querySelectorAll(".custom-dropdown-menu .dropdown-item");
    const triggerDot = dropdownTrigger ? dropdownTrigger.querySelector(".status-indicator-dot") : null;

    function filterVaccines() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
        const status = statusFilter ? statusFilter.value : "all";

        rows.forEach(function (row) {
            const rowSearch = row.getAttribute("data-search") || "";
            const rowStatus = row.getAttribute("data-status") || "";

            const matchesSearch = query === "" || rowSearch.includes(query);
            const matchesStatus = status === "all" || rowStatus === status;

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    if (dropdownTrigger && customDropdown) {
        dropdownTrigger.addEventListener("click", function (e) {
            e.stopPropagation();
            const isOpen = customDropdown.classList.contains("open");
            customDropdown.classList.toggle("open", !isOpen);
            dropdownTrigger.setAttribute("aria-expanded", !isOpen);
        });

        document.addEventListener("click", function (e) {
            if (!customDropdown.contains(e.target)) {
                customDropdown.classList.remove("open");
                dropdownTrigger.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && customDropdown.classList.contains("open")) {
                customDropdown.classList.remove("open");
                dropdownTrigger.setAttribute("aria-expanded", "false");
            }
        });
    }

    dropdownItems.forEach(function (item) {
        item.addEventListener("click", function () {
            const val = this.getAttribute("data-value");
            const label = this.querySelector("strong") ? this.querySelector("strong").innerText : val;

            dropdownItems.forEach(i => i.classList.remove("active"));
            this.classList.add("active");

            if (selectedText) {
                selectedText.innerText = label;
            }

            if (triggerDot) {
                triggerDot.className = "status-indicator-dot " + (val === "available" ? "dot-available" : (val === "unavailable" ? "dot-unavailable" : "dot-all"));
            }

            if (statusFilter) {
                statusFilter.value = val;
            }

            if (customDropdown) {
                customDropdown.classList.remove("open");
                if (dropdownTrigger) dropdownTrigger.setAttribute("aria-expanded", "false");
            }

            filterVaccines();
        });
    });

    if (searchInput) searchInput.addEventListener("input", filterVaccines);
    if (statusFilter) statusFilter.addEventListener("change", filterVaccines);
});
</script>
@endpush