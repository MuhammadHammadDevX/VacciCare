@extends('layouts.hospital')

@section('title', 'Update Vaccine Status | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vaccine-status.css') }}">
@endpush

@section('content')
<section class="vaccine-page">
    <div class="vaccine-container">

        <div class="page-title">
            <div class="title-content">
                <div class="eyebrow">
                    <i class="bi bi-shield-check"></i>
                    Vaccination Management
                </div>
                <h1>Update Vaccine Status</h1>
                <p>Select a confirmed appointment and update its vaccination result.</p>
            </div>
            <div class="title-icon">
                <i class="bi bi-clipboard2-check"></i>
            </div>
        </div>

        @if(session('message'))
            <div class="backend-message {{ session('messageType', 'success') }}">
                @if(session('messageType') === 'success')
                    <i class="bi bi-check-circle-fill"></i>
                @else
                    <i class="bi bi-exclamation-circle-fill"></i>
                @endif
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <form
            id="vaccineForm"
            class="vaccine-card"
            method="POST"
            action="{{ route('hospital.vaccine-status') }}"
            onsubmit="return confirm('Are you sure you want to update this vaccination status?');"
        >
            @csrf

            <section class="form-section">
                <div class="section-number">01</div>
                <div class="section-body">
                    <div class="section-title">
                        <div>
                            <h3>Confirmed Appointment</h3>
                            <p>Select the appointment you want to update.</p>
                        </div>
                    </div>

                    <div class="fields-grid">
                        <div class="field" style="grid-column:1/-1;">
                            <label for="appointment">
                                Select Appointment
                                <span>*</span>
                            </label>

                            <div class="input-box">
                                <i class="bi bi-calendar-check"></i>
                                <select id="appointment" name="request_id" required>
                                    <option value="">Select Appointment</option>
                                    @foreach($confirmedAppointments as $appointment)
                                        @php
                                            $bId = data_get($appointment, 'booking_id');
                                            $cName = data_get($appointment, 'child.child_name', data_get($appointment, 'child_name', 'Child'));
                                            $vName = data_get($appointment, 'vaccine.vaccine_name', data_get($appointment, 'vaccine_name', 'Vaccine'));
                                            $bDate = data_get($appointment, 'booking_date');
                                            $bTime = data_get($appointment, 'booking_time', '09:00:00');
                                            $vacName = data_get($appointment, 'vaccinator.name', data_get($appointment, 'vaccinator_name', ''));
                                        @endphp
                                        <option value="{{ (int) $bId }}">
                                            {{ $cName }} - {{ $vName }} - {{ date('d M Y', strtotime($bDate)) }} - {{ date('h:i A', strtotime($bTime)) }}
                                            @if(!empty($vacName))
                                                - {{ $vacName }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <div class="section-number">02</div>
                <div class="section-body">
                    <div class="section-title">
                        <div>
                            <h3>Vaccination Result</h3>
                            <p>Record whether the vaccine was administered.</p>
                        </div>
                    </div>

                    <div class="fields-grid">
                        <!-- RESULT -->
                        <div class="field">
                            <label>
                                Vaccination Result
                                <span>*</span>
                            </label>
                            <div class="input-box">
                                <i class="bi bi-check2-circle"></i>
                                <select name="vaccination_result" required>
                                    <option value="">Select Result</option>
                                    <option value="Vaccinated">Vaccinated</option>
                                    <option value="Not Vaccinated">Not Vaccinated</option>
                                </select>
                            </div>
                        </div>

                        <!-- NOTES -->
                        <div class="field">
                            <label>Notes</label>
                            <div class="textarea-box">
                                <i class="bi bi-chat-left-text"></i>
                                <textarea name="notes" placeholder="Enter vaccination notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="form-actions">
                <button type="reset" class="btn btn-secondary">
                    Clear Form
                </button>

                <button type="submit" class="btn btn-primary">
                    Update Vaccine Status
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/vaccine-status.js') }}"></script>
@endpush
