@extends('layouts.admin')

@section('title', 'Edit Hospital | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/add-hospital.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<main class="add-hospital-page">

    <!-- PAGE HEADER -->
    <section class="add-hospital-header">
        <div class="header-content">
            <span class="page-eyebrow">
                <i class="bi bi-hospital-fill"></i>
                HOSPITAL MANAGEMENT
            </span>
            <h1>Edit Hospital</h1>
            <p>Update and manage hospital information in the VacciCare vaccination management system.</p>
        </div>

        <div class="header-badge">
            <i class="bi bi-shield-check"></i>
            <div>
                <strong>Admin Portal</strong>
                <span>Hospital Management</span>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success mt-3" role="alert">
            <i class="bi bi-check-circle-fill mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3" role="alert">
            <i class="bi bi-exclamation-circle-fill mr-2"></i>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- EDIT HOSPITAL FORM -->
    <section class="hospital-form-card">
        <div class="form-card-header">
            <div class="form-title-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <span class="section-eyebrow">UPDATE HOSPITAL</span>
                <h2>{{ $hospital->hospital_name }}</h2>
                <p>Modify hospital details below.</p>
            </div>
        </div>

        <form class="hospital-form" action="{{ route('admin.update-hospital', $hospital->hospital_id) }}" method="POST">
            @csrf

            <!-- BASIC INFORMATION -->
            <div class="form-section-title">
                <i class="bi bi-info-circle-fill"></i>
                <span>Basic Information</span>
            </div>

            <div class="form-grid">
                <!-- Hospital Name -->
                <div class="form-group full">
                    <label for="hospitalName">Hospital Name <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-hospital"></i>
                        <input type="text" id="hospitalName" name="hospital_name" value="{{ old('hospital_name', $hospital->hospital_name) }}" required>
                    </div>
                </div>

                <!-- Hospital Type -->
                <div class="form-group">
                    <label for="hospitalType">Hospital Type <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-building"></i>
                        <select id="hospitalType" name="hospital_type" required>
                            <option value="Private" {{ old('hospital_type', $hospital->hospital_type) === 'Private' ? 'selected' : '' }}>Private Hospital</option>
                            <option value="Government" {{ old('hospital_type', $hospital->hospital_type) === 'Government' ? 'selected' : '' }}>Government Hospital</option>
                            <option value="Public" {{ old('hospital_type', $hospital->hospital_type) === 'Public' ? 'selected' : '' }}>Public Hospital</option>
                            <option value="Clinic" {{ old('hospital_type', $hospital->hospital_type) === 'Clinic' ? 'selected' : '' }}>Medical Center / Clinic</option>
                        </select>
                    </div>
                </div>

                <!-- License -->
                <div class="form-group">
                    <label for="licenseNumber">Registration / License No. <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-card-text"></i>
                        <input type="text" id="licenseNumber" name="license_no" value="{{ old('license_no', $hospital->license_no) }}" required>
                    </div>
                </div>
            </div>

            <!-- CONTACT INFORMATION -->
            <div class="form-section-title">
                <i class="bi bi-person-lines-fill"></i>
                <span>Contact Information</span>
            </div>

            <div class="form-grid">
                <!-- Email -->
                <div class="form-group">
                    <label for="hospitalEmail">Email Address <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="hospitalEmail" name="email" value="{{ old('email', $hospital->email) }}" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="hospitalPhone">Phone Number <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-telephone"></i>
                        <input type="text" id="hospitalPhone" name="phone" value="{{ old('phone', $hospital->phone) }}" required>
                    </div>
                </div>

                <!-- Contact Person -->
                <div class="form-group">
                    <label for="contactPerson">Contact Person</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="text" id="contactPerson" name="contact_person" value="{{ old('contact_person', $hospital->contact_person) }}">
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="form-group">
                    <label for="workingHours">Working Hours</label>
                    <div class="input-wrapper">
                        <i class="bi bi-clock"></i>
                        <select id="workingHours" name="working_hours">
                            <option value="24 Hours" {{ old('working_hours', $hospital->working_hours) === '24 Hours' ? 'selected' : '' }}>24 Hours</option>
                            <option value="8 AM - 5 PM" {{ old('working_hours', $hospital->working_hours) === '8 AM - 5 PM' ? 'selected' : '' }}>8:00 AM - 5:00 PM</option>
                            <option value="9 AM - 6 PM" {{ old('working_hours', $hospital->working_hours) === '9 AM - 6 PM' ? 'selected' : '' }}>9:00 AM - 6:00 PM</option>
                            <option value="10 AM - 8 PM" {{ old('working_hours', $hospital->working_hours) === '10 AM - 8 PM' ? 'selected' : '' }}>10:00 AM - 8:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- LOCATION -->
            <div class="form-section-title">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Hospital Location</span>
            </div>

            <div class="form-grid">
                <!-- Location / City -->
                <div class="form-group">
                    <label for="hospitalCity">Location / City <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-buildings"></i>
                        <select id="hospitalCity" name="city" required>
                            <option value="Karachi" {{ old('city', $hospital->city) === 'Karachi' ? 'selected' : '' }}>Karachi</option>
                            <option value="Lahore" {{ old('city', $hospital->city) === 'Lahore' ? 'selected' : '' }}>Lahore</option>
                            <option value="Islamabad" {{ old('city', $hospital->city) === 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                            <option value="Rawalpindi" {{ old('city', $hospital->city) === 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                            <option value="Peshawar" {{ old('city', $hospital->city) === 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                            <option value="Quetta" {{ old('city', $hospital->city) === 'Quetta' ? 'selected' : '' }}>Quetta</option>
                        </select>
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="hospitalStatus">Account Status</label>
                    <div class="input-wrapper">
                        <i class="bi bi-toggle-on"></i>
                        <select id="hospitalStatus" name="status">
                            <option value="Active" {{ old('status', $hospital->status) === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $hospital->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div class="form-group full">
                    <label for="hospitalAddress">Complete Address <span>*</span></label>
                    <div class="input-wrapper textarea-wrapper">
                        <i class="bi bi-geo"></i>
                        <textarea id="hospitalAddress" name="address" rows="3" required>{{ old('address', $hospital->address) }}</textarea>
                    </div>
                </div>

                <!-- Interactive Map Pin Picker -->
                <div class="form-group full" style="margin-top: 10px;">
                    <label><i class="bi bi-map-fill"></i> Pin Hospital Location on Map (Click or Drag Marker)</label>
                    <div id="adminEditMapPicker" style="height: 280px; width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; margin-top: 6px;"></div>
                    <small style="color: #64748b; margin-top: 4px; display: block;">
                        Click anywhere on the map or drag the pin to update coordinates.
                    </small>
                </div>

                <div class="form-group">
                    <label for="hospitalLat">Latitude</label>
                    <div class="input-wrapper">
                        <i class="bi bi-compass"></i>
                        <input type="text" id="hospitalLat" name="latitude" value="{{ old('latitude', $hospital->latitude ?? 24.8924) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="hospitalLng">Longitude</label>
                    <div class="input-wrapper">
                        <i class="bi bi-compass"></i>
                        <input type="text" id="hospitalLng" name="longitude" value="{{ old('longitude', $hospital->longitude ?? 67.0739) }}">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">
                    <i class="bi bi-check-circle-fill"></i> Update Hospital
                </button>
                <a href="{{ route('admin.hospital-list') }}" class="cancel-button">
                    <i class="bi bi-arrow-left"></i> Cancel & View List
                </a>
                <span class="form-action-note">
                    <i class="bi bi-shield-check"></i> VacciCare Verified
                </span>
            </div>
        </form>
    </section>
</main>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var latInput = document.getElementById('hospitalLat');
    var lngInput = document.getElementById('hospitalLng');
    var citySelect = document.getElementById('hospitalCity');

    var currentLat = parseFloat(latInput.value) || 24.8924;
    var currentLng = parseFloat(lngInput.value) || 67.0739;

    var map = L.map('adminEditMapPicker').setView([currentLat, currentLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    function updateInputs(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
    }

    marker.on('dragend', function() {
        var pos = marker.getLatLng();
        updateInputs(pos.lat, pos.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
    });

    var cityCoords = {
        'Karachi': [24.8607, 67.0011],
        'Lahore': [31.5204, 74.3587],
        'Islamabad': [33.6844, 73.0479],
        'Rawalpindi': [33.5651, 73.0169],
        'Peshawar': [34.0151, 71.5249],
        'Quetta': [30.1798, 66.9750]
    };

    citySelect.addEventListener('change', function() {
        var city = this.value;
        if (cityCoords[city]) {
            var coords = cityCoords[city];
            map.setView(coords, 12);
            marker.setLatLng(coords);
            updateInputs(coords[0], coords[1]);
        }
    });
});
</script>
@endpush
@endsection