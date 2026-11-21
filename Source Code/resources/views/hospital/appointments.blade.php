@extends('layouts.hospital')

@section('title', 'Hospital Appointments | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/hospital-appointments.css') }}">
<style>
.appointment-page {
    padding: 30px;
}
.appointment-container {
    max-width: 1200px;
    margin: auto;
}
.page-heading {
    margin-bottom: 25px;
}
.page-heading h1 {
    margin-bottom: 8px;
}
.page-heading p {
    color: #6c757d;
}
.backend-message {
    padding: 15px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.backend-message.success {
    background: #d1e7dd;
    color: #0f5132;
}
.backend-message.error {
    background: #f8d7da;
    color: #842029;
}
.appointment-card {
    background: #fff;
    border-radius: 16px;
    padding: 22px;
    margin-bottom: 20px;
    box-shadow: 0 6px 25px rgba(0,0,0,.07);
}
.appointment-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
.appointment-item span {
    display: block;
    font-size: 13px;
    color: #777;
    margin-bottom: 5px;
}
.appointment-item strong {
    display: block;
}
.appointment-actions {
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #eee;
}
.confirm-btn {
    background: #198754;
    color: #fff;
    border: 0;
    padding: 11px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}
.confirmed {
    color: #198754;
    font-weight: 700;
}
.no-appointments {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
}
@media(max-width:900px) {
    .appointment-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media(max-width:600px) {
    .appointment-page {
        padding: 15px;
    }
    .appointment-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<main class="appointment-page">
    <div class="appointment-container">
        <div class="page-heading">
            <h1>Hospital Appointments</h1>
            <p>Manage approved vaccination appointments for {{ $hospitalUser->hospital_name ?? $hospital->hospital_name ?? 'Hospital' }}.</p>
        </div>

        @if(session('message'))
            <div class="backend-message {{ session('messageType', 'success') }}">
                {{ session('message') }}
            </div>
        @endif

        @if(empty($appointments) || count($appointments) === 0)
            <div class="no-appointments">
                <i class="bi bi-calendar-x" style="font-size:45px; color:#adb5bd; margin-bottom:12px; display:inline-block;"></i>
                <h3>No Approved Appointments</h3>
                <p>Approved vaccination requests will appear here.</p>
            </div>
        @else
            @foreach($appointments as $appointment)
                @php
                    $childName = $appointment->child->child_name ?? $appointment['child_name'] ?? 'Child';
                    $parentName = $appointment->parent->parent_name ?? $appointment['parent_name'] ?? 'Parent';
                    $vaccineName = $appointment->hospitalVaccine->vaccine_name ?? $appointment['vaccine_name'] ?? 'Not specified';
                    $requestDate = $appointment->request_date ?? $appointment['request_date'] ?? date('Y-m-d');
                    $preferredTime = $appointment->preferred_time ?? $appointment['preferred_time'] ?? '';
                    $status = $appointment->status ?? $appointment['status'] ?? 'Approved';
                    $bookingId = $appointment->booking_id ?? $appointment['booking_id'] ?? null;
                    $vaccinatorName = $appointment->vaccinator_name ?? $appointment['vaccinator_name'] ?? null;
                    $requestId = $appointment->request_id ?? $appointment['request_id'] ?? 0;
                @endphp

                <div class="appointment-card">
                    <div class="appointment-grid">
                        <div class="appointment-item">
                            <span>Child</span>
                            <strong>{{ $childName }}</strong>
                        </div>

                        <div class="appointment-item">
                            <span>Parent</span>
                            <strong>{{ $parentName }}</strong>
                        </div>

                        <div class="appointment-item">
                            <span>Vaccine</span>
                            <strong>{{ $vaccineName }}</strong>
                        </div>

                        <div class="appointment-item">
                            <span>Date</span>
                            <strong>{{ date('d M Y', strtotime($requestDate)) }}</strong>
                        </div>

                        <div class="appointment-item">
                            <span>Time</span>
                            <strong>
                                @if(!empty($preferredTime))
                                    {{ date('h:i A', strtotime($preferredTime)) }}
                                @else
                                    Not specified
                                @endif
                            </strong>
                        </div>

                        <div class="appointment-item">
                            <span>Request Status</span>
                            <strong>{{ $status }}</strong>
                        </div>

                        @if(!empty($vaccinatorName))
                            <div class="appointment-item">
                                <span>Vaccinator</span>
                                <strong>{{ $vaccinatorName }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="appointment-actions">
                        @if(!empty($bookingId))
                            <span class="confirmed">
                                <i class="bi bi-check-circle-fill"></i>
                                Appointment Confirmed
                                @if(!empty($vaccinatorName))
                                    — Vaccinator: {{ $vaccinatorName }}
                                @endif
                            </span>
                        @else
                            <form method="POST" action="{{ route('hospital.appointments') }}" onsubmit="return confirm('Are you sure you want to confirm this appointment?');">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $requestId }}">
                                <button type="submit" name="confirm_appointment" class="confirm-btn">
                                    <i class="bi bi-check-circle"></i>
                                    Confirm Appointment
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</main>
@endsection
