@extends('layouts.admin')

@section('title', 'Booking Details | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/booking-details.css') }}">
@endpush

@section('content')
<main class="admin-booking-page">

    <!-- PAGE HEADER -->
    <section class="booking-page-header">
        <div class="header-content">
            <span class="page-eyebrow">
                <i class="bi bi-calendar2-check-fill"></i>
                VACCINATION APPOINTMENTS
            </span>
            <h1>Booking Details</h1>
            <p>View all approved vaccination appointments scheduled across participating hospitals.</p>
        </div>

        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <a href="{{ route('admin.export.bookings') }}" class="export-csv-btn">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Bookings (CSV)
            </a>
            <div class="booking-count">
                <i class="bi bi-calendar2-week"></i>
                <span>Total Bookings <strong>{{ $totalBookings }}</strong></span>
            </div>
        </div>
    </section>

    <!-- BOOKINGS CARD -->
    <section class="booking-card">
        <div class="booking-card-header">
            <div>
                <span class="section-eyebrow">APPOINTMENT SCHEDULE</span>
                <h2>Approved Appointments</h2>
                <p style="margin:6px 0 0; color:#8a9cad; font-size:13px;">Detailed list of confirmed parent appointment requests.</p>
            </div>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <div class="booking-search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" id="bookingSearch" placeholder="Search child, hospital, vaccine..." autocomplete="off">
                </div>
                <div class="booking-count">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ $totalBookings }} Approved</span>
                </div>
            </div>
        </div>

        <div class="booking-table-wrapper">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Child Name</th>
                        <th>Hospital</th>
                        <th>Vaccine</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="bookingTableBody">
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <span class="booking-id">#{{ $booking->request_id }}</span>
                            </td>

                            <td>
                                <div class="person-cell">
                                    <div class="person-icon">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $booking->child->child_name ?? 'Child' }}</strong>
                                        <small class="parent-name">ID: {{ $booking->child_id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="hospital-name">
                                    <i class="bi bi-hospital"></i>
                                    {{ $booking->hospital->hospital_name ?? 'Hospital' }}
                                </span>
                            </td>

                            <td>
                                <span class="vaccine-name">
                                    <i class="bi bi-shield-plus"></i>
                                    {{ $booking->hospitalVaccine->vaccine_name ?? 'Vaccine' }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $booking->request_date ? date('d M Y', strtotime($booking->request_date)) : 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-time">
                                    <i class="bi bi-clock"></i>
                                    {{ $booking->preferred_time ? date('h:i A', strtotime($booking->preferred_time)) : 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="booking-status confirmed">
                                    <span></span>
                                    Approved
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x" style="font-size:40px; color:#c0d0de; display:block; margin-bottom:12px;"></i>
                                    <h3 style="color:#5a7a90; font-weight:700;">No Bookings Found</h3>
                                    <p>There are no approved vaccination appointments currently scheduled.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('bookingSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#bookingTableBody tr');
            rows.forEach(function(row) {
                if (row.querySelector('.empty-state')) return;
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush
@endsection