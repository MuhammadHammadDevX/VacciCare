@extends('layouts.admin')

@section('title', 'Vaccination Date & Time | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-vaccinations-date.css') }}">
@endpush

@section('content')
<div class="vaccination-page">

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div style="background:linear-gradient(135deg,#e8f8f1,#d5f5e8); border:1px solid #b8e9d2; border-radius:12px; padding:14px 20px; margin-bottom:18px; display:flex; align-items:center; gap:10px; color:#157a52; font-weight:600; font-size:14px;">
            <i class="fa-solid fa-circle-check" style="font-size:18px; color:#20a66b;"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- PAGE HEADER -->
    <div class="vaccination-page-header">
        <div class="page-header-content">
            <div class="page-label">
                <i class="fa-solid fa-calendar-check"></i>
                VACCINATION SCHEDULE
            </div>
            <h1>Vaccination Date &amp; Time</h1>
            <p>View vaccination dates and scheduled times for registered children.</p>
        </div>

        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <button type="button" class="schedule-btn" onclick="document.getElementById('addScheduleModal').style.display='flex'">
                <i class="fa-solid fa-plus"></i>
                Schedule Vaccination
            </button>
            <div class="header-calendar">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="vaccination-main-card">
        <div class="vaccination-card-top">
            <div>
                <span class="small-heading">VACCINATION RECORDS</span>
                <h2>Vaccination Schedule</h2>
                <p>Scheduled vaccination appointments approved by admin.</p>
            </div>

            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <div class="vacc-search-wrapper">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="vaccSearchInput" placeholder="Search child, hospital, vaccine..." autocomplete="off">
                </div>
                <div class="total-records">
                    <i class="fa-solid fa-list-check"></i>
                    <span>{{ $vaccinations->count() }} Records</span>
                </div>
            </div>
        </div>

        <div class="table-scroll">
            <table class="vaccination-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Child Name</th>
                        <th>Vaccine Name</th>
                        <th>Hospital</th>
                        <th>Vaccination Date</th>
                        <th>Vaccination Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="vaccTableBody">
                    @forelse($vaccinations as $index => $record)
                        <tr>
                            <td>
                                <span class="row-num">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="child-info">
                                    <div class="child-icon">
                                        <i class="fa-solid fa-child"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $record->child->child_name ?? 'Child' }}</strong>
                                        <small>ID: #{{ $record->child_id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="vaccine-info">
                                    <div class="vaccine-icon">
                                        <i class="fa-solid fa-syringe"></i>
                                    </div>
                                    <strong>{{ $record->hospitalVaccine->vaccine_name ?? $record->vaccine_name ?? 'Vaccine' }}</strong>
                                </div>
                            </td>

                            <td>
                                <div class="hospital-info">
                                    <i class="fa-solid fa-hospital"></i>
                                    <span>{{ $record->hospital->hospital_name ?? 'Hospital' }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="date-info">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ $record->request_date ? date('d M Y', strtotime($record->request_date)) : 'N/A' }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="time-info">
                                    <i class="fa-regular fa-clock"></i>
                                    <strong>{{ $record->preferred_time ? date('h:i A', strtotime($record->preferred_time)) : 'N/A' }}</strong>
                                </div>
                            </td>

                            <td>
                                <span class="status completed">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Approved
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-records">
                                <i class="fa-regular fa-calendar-xmark" style="font-size:40px; color:#c0d0de; display:block; margin-bottom:12px;"></i>
                                <h3>No Scheduled Vaccinations</h3>
                                <p>Approved vaccination appointment dates will appear here.</p>
                                <button type="button" class="schedule-btn-sm" onclick="document.getElementById('addScheduleModal').style.display='flex'" style="margin-top:14px;">
                                    <i class="fa-solid fa-plus"></i> Schedule First Vaccination
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- INFO BOX -->
    <div class="vaccination-information">
        <div class="information-icon">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <strong>How Vaccination Scheduling Works</strong>
            <p>Parents request appointments from their portal → Admin approves them in "Parent Requests" → Approved appointments automatically appear here. Admin can also directly schedule vaccinations using the "+ Schedule Vaccination" button above.</p>
        </div>
    </div>
</div>

<!-- =====================================================
     SCHEDULE MODAL
====================================================== -->
<div class="schedule-modal-backdrop" id="addScheduleModal" style="display:none;">
    <div class="schedule-modal">
        <div class="schedule-modal-header">
            <div>
                <span class="modal-label"><i class="fa-solid fa-calendar-plus"></i> NEW SCHEDULE</span>
                <h3>Schedule Vaccination</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="document.getElementById('addScheduleModal').style.display='none'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.vaccinations-date.store') }}" method="POST">
            @csrf
            <div class="schedule-modal-body">
                <div class="modal-field">
                    <label for="schedChild"><i class="fa-solid fa-child"></i> Select Child</label>
                    <select name="child_id" id="schedChild" required>
                        <option value="">-- Choose Child --</option>
                        @foreach($children as $child)
                            <option value="{{ $child->child_id }}">{{ $child->child_name }} (Parent: {{ $child->parent->user->name ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-field">
                    <label for="schedHospital"><i class="fa-solid fa-hospital"></i> Select Hospital</label>
                    <select name="hospital_id" id="schedHospital" required>
                        <option value="">-- Choose Hospital --</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->hospital_id }}">{{ $hospital->hospital_name }} - {{ $hospital->city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-field">
                    <label for="schedVaccine"><i class="fa-solid fa-syringe"></i> Select Vaccine</label>
                    <select name="hospital_vaccine_id" id="schedVaccine" required>
                        <option value="">-- Choose Vaccine --</option>
                        @foreach($hospitalVaccines as $hv)
                            <option value="{{ $hv->id }}">{{ $hv->vaccine_name }} ({{ $hv->hospital->hospital_name ?? 'Hospital' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-row">
                    <div class="modal-field">
                        <label for="schedDate"><i class="fa-regular fa-calendar"></i> Appointment Date</label>
                        <input type="date" name="request_date" id="schedDate" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="modal-field">
                        <label for="schedTime"><i class="fa-regular fa-clock"></i> Preferred Time</label>
                        <input type="time" name="preferred_time" id="schedTime" required>
                    </div>
                </div>
            </div>

            <div class="schedule-modal-footer">
                <button type="button" class="modal-cancel-btn" onclick="document.getElementById('addScheduleModal').style.display='none'">
                    Cancel
                </button>
                <button type="submit" class="modal-submit-btn">
                    <i class="fa-solid fa-calendar-check"></i> Schedule Appointment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    var searchInput = document.getElementById('vaccSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var query = this.value.toLowerCase().trim();
            var rows = document.querySelectorAll('#vaccTableBody tr');
            rows.forEach(function(row) {
                if (row.querySelector('.no-records')) return;
                var text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // Close modal on backdrop click
    var modal = document.getElementById('addScheduleModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Close modal on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection
