@extends('layouts.parent')

@section('title', 'Book Hospital | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/book-hospital.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .backend-message {
            margin-bottom: 25px;
            padding: 16px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
        }
        .backend-message.success {
            background: #e9f9f0;
            color: #167a45;
            border: 1px solid #bde8ce;
        }
        .backend-message.error {
            background: #fff0f0;
            color: #c62828;
            border: 1px solid #f0c1c1;
        }
        .backend-message i { font-size: 20px; }
        .load-vaccine-area { margin-top: 15px; }
        .load-vaccine-btn {
            border: 0;
            padding: 10px 18px;
            border-radius: 9px;
            background: #287ff5;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        .load-vaccine-btn:hover { opacity: .9; }
        .hospital-info-box {
            margin-top: 15px;
            padding: 15px 18px;
            border-radius: 12px;
            background: #f5f9ff;
            border: 1px solid #dce9fb;
        }
        .hospital-info-box strong { display: block; margin-bottom: 4px; }
        .hospital-info-box span { display: block; font-size: 13px; color: #667085; margin-top: 3px; }
        .empty-vaccine {
            padding: 12px;
            font-size: 13px;
            color: #777;
            background: #fafafa;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
<main class="vacci-main">
    <section class="book-page">
        <!-- PAGE INTRO -->
        <div class="book-page-intro">
            <div>
                <span class="page-eyebrow">
                    <i class="bi bi-calendar2-plus-fill"></i>
                    VACCINATION BOOKING
                </span>
                <h2>Book a Hospital Appointment</h2>
                <p>Choose your child, available vaccine and preferred hospital to request an appointment.</p>
            </div>
            <div class="secure-badge">
                <i class="bi bi-shield-check"></i>
                <span>Safe &amp; Secure</span>
            </div>
        </div>

        @if(session('success'))
            <div class="backend-message success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="backend-message error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') ?? $errors->first() }}</span>
            </div>
        @endif

        <!-- INTERACTIVE HOSPITAL LOCATOR MAP -->
        <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:16px; padding:20px; margin-bottom:25px; box-shadow:0 4px 12px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:15px;">
                <div>
                    <span class="section-label" style="background:#e0f2fe; color:#0284c7; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:700;">
                        <i class="bi bi-geo-alt-fill"></i> INTERACTIVE LOCATOR
                    </span>
                    <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin-top:4px;">
                        Find Vaccination Centers Near You
                    </h3>
                    <p style="font-size:13px; color:#64748b; margin:0;">
                        Click any hospital pin on the map to view details and select it for your child's appointment.
                    </p>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" id="btnLocateMe" style="background:#f1f5f9; color:#0f172a; border:1px solid #cbd5e1; border-radius:8px; padding:8px 14px; font-size:12px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="bi bi-crosshair"></i> Locate Near Me
                    </button>
                </div>
            </div>

            <!-- City Filter Pills -->
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;" id="mapCityFilters">
                <button type="button" class="city-filter-pill active" data-city="all" style="background:#0284c7; color:#fff; border:none; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; cursor:pointer;">
                    All Centers ({{ $hospitals->count() }})
                </button>
                @foreach($hospitals->pluck('city')->unique() as $city)
                    <button type="button" class="city-filter-pill" data-city="{{ $city }}" style="background:#f1f5f9; color:#475569; border:none; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; cursor:pointer;">
                        {{ $city }}
                    </button>
                @endforeach
            </div>

            <div id="parentHospitalMap" style="height:360px; width:100%; border-radius:12px; border:1px solid #cbd5e1; z-index:1;"></div>
        </div>

        <!-- BOOKING CARD -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-card-title">
                    <div class="title-icon"><i class="bi bi-hospital"></i></div>
                    <div>
                        <h3>Hospital Booking</h3>
                        <p>Enter your appointment details below.</p>
                    </div>
                </div>
                <span class="required-note">* Required fields</span>
            </div>

            <!-- HOSPITAL SELECTION -->
            <form method="GET" action="{{ route('parent.book-hospital') }}">
                <div class="form-section">
                    <div class="form-section-heading">
                        <div class="section-number">01</div>
                        <div>
                            <h4>Hospital Selection</h4>
                            <p>Select an active hospital to view its available vaccines.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group-custom form-group-full">
                            <label for="hospital">Hospital <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="bi bi-hospital"></i>
                                <select id="hospital" name="hospital_id" required>
                                    <option value="">Select Hospital</option>
                                    @php
                                        $groupedHospitals = $hospitals->groupBy('city');
                                    @endphp
                                    @foreach($groupedHospitals as $city => $cityHospitals)
                                        <optgroup label="{{ $city ?: 'General' }}">
                                            @foreach($cityHospitals as $hosp)
                                                <option value="{{ $hosp->hospital_id }}" {{ $selectedHospitalId == $hosp->hospital_id ? 'selected' : '' }}>
                                                    {{ $hosp->hospital_name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>

                            <div class="load-vaccine-area">
                                <button type="submit" class="load-vaccine-btn">
                                    <i class="bi bi-arrow-repeat"></i> Load Available Vaccines
                                </button>
                            </div>

                            @if($selectedHospital)
                                <div class="hospital-info-box">
                                    <strong><i class="bi bi-hospital"></i> {{ $selectedHospital->hospital_name }}</strong>
                                    <span><i class="bi bi-geo-alt"></i> {{ $selectedHospital->city }}</span>
                                    @if($selectedHospital->address)
                                        <span><i class="bi bi-geo"></i> {{ $selectedHospital->address }}</span>
                                    @endif
                                    @if($selectedHospital->working_hours)
                                        <span><i class="bi bi-clock"></i> {{ $selectedHospital->working_hours }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            @if($selectedHospital)
                <form id="hospitalBookingForm" method="POST" action="{{ route('parent.store-book-hospital') }}">
                    @csrf
                    <input type="hidden" name="hospital_id" value="{{ $selectedHospitalId }}">

                    <!-- SECTION 02 -->
                    <div class="form-section">
                        <div class="form-section-heading">
                            <div class="section-number">02</div>
                            <div>
                                <h4>Child &amp; Vaccine</h4>
                                <p>Select your child and an available vaccine.</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label for="child">Child <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-person-fill"></i>
                                    <select id="child" name="child_id" required>
                                        <option value="">Select Child</option>
                                        @foreach($children as $child)
                                            <option value="{{ $child->child_id }}" {{ old('child_id') == $child->child_id ? 'selected' : '' }}>
                                                {{ $child->child_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                                @if($children->isEmpty())
                                    <small style="display:block; margin-top:8px; color:#c62828;">
                                        No children found. Please add a child first.
                                    </small>
                                @endif
                            </div>

                            <div class="form-group-custom">
                                <label for="hospital_vaccine">Vaccine <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-shield-plus"></i>
                                    <select id="hospital_vaccine" name="hospital_vaccine_id" required>
                                        <option value="">Select Available Vaccine</option>
                                        @foreach($hospitalVaccines as $vac)
                                            <option value="{{ $vac->id }}" {{ old('hospital_vaccine_id') == $vac->id ? 'selected' : '' }}>
                                                {{ $vac->vaccine_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                                @if($hospitalVaccines->isEmpty())
                                    <div class="empty-vaccine mt-2">
                                        <i class="bi bi-info-circle"></i> This hospital currently has no available vaccines.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 03 -->
                    <div class="form-section">
                        <div class="form-section-heading">
                            <div class="section-number">03</div>
                            <div>
                                <h4>Appointment Details</h4>
                                <p>Select your preferred date and time.</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label for="appointmentDate">Appointment Date <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-calendar3"></i>
                                    <input type="date" id="appointmentDate" name="appointment_date" min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" required>
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label for="appointmentTime">Preferred Time <span>*</span></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-clock-fill"></i>
                                    <select id="appointmentTime" name="preferred_time" required>
                                        <option value="">Select Time</option>
                                        @php
                                            $timeOptions = [
                                                '09:00:00' => '09:00 AM',
                                                '09:30:00' => '09:30 AM',
                                                '10:00:00' => '10:00 AM',
                                                '10:30:00' => '10:30 AM',
                                                '11:00:00' => '11:00 AM',
                                                '11:30:00' => '11:30 AM',
                                                '12:00:00' => '12:00 PM',
                                                '12:30:00' => '12:30 PM',
                                                '14:00:00' => '02:00 PM',
                                                '14:30:00' => '02:30 PM',
                                                '15:00:00' => '03:00 PM',
                                                '15:30:00' => '03:30 PM',
                                                '16:00:00' => '04:00 PM',
                                                '16:30:00' => '04:30 PM',
                                            ];
                                        @endphp
                                        @foreach($timeOptions as $timeVal => $timeLabel)
                                            <option value="{{ $timeVal }}" {{ old('preferred_time') == $timeVal ? 'selected' : '' }}>{{ $timeLabel }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>

                            <div class="form-group-custom form-group-full">
                                <label for="notes">Additional Notes <small>Optional</small></label>
                                <div class="textarea-wrapper">
                                    <i class="bi bi-chat-left-text"></i>
                                    <textarea id="notes" name="notes" rows="4" maxlength="1000" placeholder="Add any additional information about your appointment...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="booking-footer">
                        <div class="footer-security">
                            <div class="security-icon"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <strong>Your information is secure</strong>
                                <span>Your appointment request is kept private.</span>
                            </div>
                        </div>

                        <button type="submit" class="book-btn" id="bookAppointmentBtn">
                            <i class="bi bi-calendar-check"></i>
                            <span>Send Appointment Request</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </section>
</main>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var hospitals = @json($hospitals);
    var selectedHospitalId = {{ $selectedHospitalId ?? 0 }};

    var defaultLat = 24.8924;
    var defaultLng = 67.0739;

    var map = L.map('parentHospitalMap').setView([defaultLat, defaultLng], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var markers = [];
    var bounds = [];

    hospitals.forEach(function(h) {
        var lat = parseFloat(h.latitude);
        var lng = parseFloat(h.longitude);

        if (!lat || !lng) return;

        bounds.push([lat, lng]);

        var isSelected = (h.hospital_id == selectedHospitalId);

        var popupContent = `
            <div style="font-family:'Plus Jakarta Sans',sans-serif; min-width:200px;">
                <strong style="color:#0284c7; font-size:14px; display:block; margin-bottom:4px;">${h.hospital_name}</strong>
                <span style="font-size:12px; color:#475569; display:block; margin-bottom:4px;"><i class="bi bi-geo-alt"></i> ${h.city} - ${h.address}</span>
                <span style="font-size:12px; color:#475569; display:block; margin-bottom:6px;"><i class="bi bi-telephone"></i> ${h.phone || 'N/A'}</span>
                <div style="font-size:11px; color:#16a34a; font-weight:700; margin-bottom:8px;"><i class="bi bi-clock"></i> ${h.working_hours || '24 Hours'}</div>
                <a href="{{ route('parent.book-hospital') }}?hospital_id=${h.hospital_id}" style="background:#0284c7; color:#fff; display:inline-block; width:100%; text-align:center; padding:6px 10px; border-radius:6px; font-weight:700; font-size:12px; text-decoration:none;">
                    Select This Hospital
                </a>
            </div>
        `;

        var marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(popupContent);
        marker.hospitalData = h;
        markers.push(marker);

        if (isSelected) {
            marker.openPopup();
            map.setView([lat, lng], 13);
        }
    });

    if (bounds.length > 0 && selectedHospitalId === 0) {
        map.fitBounds(bounds, { padding: [30, 30] });
    }

    // City Filter Pills
    var pills = document.querySelectorAll('.city-filter-pill');
    pills.forEach(function(pill) {
        pill.addEventListener('click', function() {
            pills.forEach(p => {
                p.style.background = '#f1f5f9';
                p.style.color = '#475569';
            });
            this.style.background = '#0284c7';
            this.style.color = '#fff';

            var city = this.getAttribute('data-city');
            var filteredBounds = [];

            markers.forEach(function(m) {
                if (city === 'all' || m.hospitalData.city === city) {
                    m.addTo(map);
                    filteredBounds.push(m.getLatLng());
                } else {
                    map.removeLayer(m);
                }
            });

            if (filteredBounds.length > 0) {
                map.fitBounds(filteredBounds, { padding: [30, 30] });
            }
        });
    });

    // Locate Me
    document.getElementById('btnLocateMe').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                var userLat = pos.coords.latitude;
                var userLng = pos.coords.longitude;
                map.setView([userLat, userLng], 13);

                var userMarker = L.circleMarker([userLat, userLng], {
                    radius: 8,
                    fillColor: '#ef4444',
                    color: '#ffffff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9
                }).addTo(map).bindPopup("<strong>You are here</strong>").openPopup();
            }, function() {
                alert("Could not access your location. Please check browser permissions.");
            });
        }
    });
});
</script>
@endpush
@endsection
