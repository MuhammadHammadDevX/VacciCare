@extends('layouts.hospital')

@section('title', 'Add Vaccine | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/add-vaccine.css') }}">
@endpush

@section('content')
<section class="add-vaccine-page">
    <div class="add-vaccine-container">

        <div class="vaccine-page-heading">
            <div class="heading-content">
                <span class="heading-eyebrow">
                    <i class="bi bi-capsule"></i>
                    VACCINE MANAGEMENT
                </span>
                <h1>{{ $editVaccine ? 'Update Vaccine' : 'Add Vaccine' }}</h1>
                <p>Add and manage vaccines available at your hospital.</p>
            </div>
            <div class="heading-icon">
                <i class="bi bi-shield-plus"></i>
            </div>
        </div>

        @if(session('message'))
            <div class="vaccine-alert {{ session('messageType', 'success') }}">
                @if(session('messageType') === 'success')
                    <i class="bi bi-check-circle-fill"></i>
                @else
                    <i class="bi bi-exclamation-circle-fill"></i>
                @endif
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="vaccine-form-card">
            <div class="form-card-header">
                <div class="form-card-title">
                    <div class="form-card-icon">
                        <i class="bi bi-capsule-pill"></i>
                    </div>
                    <div>
                        <h2>{{ $editVaccine ? 'Update Vaccine Details' : 'Add New Vaccine' }}</h2>
                        <p>Enter the vaccine information below.</p>
                    </div>
                </div>

                <span class="secure-label">
                    <i class="bi bi-shield-check"></i>
                    Secure
                </span>
            </div>

            <form method="POST" action="{{ route('hospital.manage-vaccine') }}">
                @csrf

                @if($editVaccine)
                    <input type="hidden" name="vaccine_id" value="{{ $editVaccine->id ?? $editVaccine['id'] }}">
                @endif

                <div class="vaccine-fields">
                    <!-- Vaccine Name -->
                    <div class="vaccine-field">
                        <label for="vaccine_name">
                            Vaccine Name
                            <span>*</span>
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-capsule"></i>
                            <input
                                type="text"
                                id="vaccine_name"
                                name="vaccine_name"
                                placeholder="e.g. BCG, Polio, MMR"
                                value="{{ old('vaccine_name', $editVaccine->vaccine_name ?? $editVaccine['vaccine_name'] ?? '') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="vaccine-field">
                        <label for="availability">
                            Availability
                            <span>*</span>
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-check2-circle"></i>
                            @php
                                $avail = old('availability', $editVaccine->availability ?? $editVaccine['availability'] ?? 'Available');
                            @endphp
                            <select id="availability" name="availability" required>
                                <option value="Available" {{ $avail === 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Unavailable" {{ $avail === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                    </div>

                    <!-- Stock Quantity -->
                    <div class="vaccine-field">
                        <label for="stock_quantity">
                            Stock Quantity (Vials)
                            <span>*</span>
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-boxes"></i>
                            <input
                                type="number"
                                id="stock_quantity"
                                name="stock_quantity"
                                min="0"
                                placeholder="e.g. 50"
                                value="{{ old('stock_quantity', $editVaccine->stock_quantity ?? 50) }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Batch Number -->
                    <div class="vaccine-field">
                        <label for="batch_number">
                            Batch / Lot Number
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-upc-scan"></i>
                            <input
                                type="text"
                                id="batch_number"
                                name="batch_number"
                                placeholder="e.g. BATCH-A489X"
                                value="{{ old('batch_number', $editVaccine->batch_number ?? '') }}"
                            >
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div class="vaccine-field">
                        <label for="expiry_date">
                            Expiration Date
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-calendar-event"></i>
                            <input
                                type="date"
                                id="expiry_date"
                                name="expiry_date"
                                value="{{ old('expiry_date', isset($editVaccine->expiry_date) ? ($editVaccine->expiry_date instanceof \Carbon\Carbon ? $editVaccine->expiry_date->format('Y-m-d') : substr($editVaccine->expiry_date, 0, 10)) : '') }}"
                            >
                        </div>
                    </div>

                    <!-- Low Stock Alert Threshold -->
                    <div class="vaccine-field">
                        <label for="low_stock_threshold">
                            Low Stock Alert Threshold
                        </label>
                        <div class="vaccine-input">
                            <i class="bi bi-bell"></i>
                            <input
                                type="number"
                                id="low_stock_threshold"
                                name="low_stock_threshold"
                                min="1"
                                placeholder="e.g. 10"
                                value="{{ old('low_stock_threshold', $editVaccine->low_stock_threshold ?? 10) }}"
                            >
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="vaccine-field full-width">
                        <label for="description">
                            Vaccine Description
                            <small>(Optional)</small>
                        </label>
                        <div class="vaccine-textarea">
                            <i class="bi bi-chat-left-text"></i>
                            <textarea
                                id="description"
                                name="description"
                                placeholder="Enter vaccine details or any additional information..."
                            >{{ old('description', $editVaccine->description ?? $editVaccine['description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="vaccine-form-actions">
                    @if($editVaccine)
                        <a href="{{ route('hospital.add-vaccine') }}" class="vaccine-btn vaccine-btn-secondary">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </a>

                        <button type="submit" name="update_vaccine" class="vaccine-btn vaccine-btn-primary">
                            <i class="bi bi-check2-circle"></i>
                            Update Vaccine
                        </button>
                    @else
                        <button type="reset" class="vaccine-btn vaccine-btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Clear
                        </button>

                        <button type="submit" name="add_vaccine" class="vaccine-btn vaccine-btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Add Vaccine
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="vaccine-list-card">
            <div class="list-card-header">
                <div>
                    <span class="list-eyebrow">
                        <i class="bi bi-list-check"></i>
                        YOUR VACCINES
                    </span>
                    <h2>Vaccine List</h2>
                    <p>Vaccines currently managed by your hospital.</p>
                </div>

                <div class="vaccine-count">
                    <strong>{{ count($vaccines) }}</strong>
                    <span>Vaccines</span>
                </div>
            </div>

            @if(count($vaccines) > 0)
                <div class="table-wrapper">
                    <table class="vaccine-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vaccine</th>
                                <th>Description</th>
                                <th>Availability</th>
                                <th>Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vaccines as $index => $vaccine)
                                @php
                                    $vId = $vaccine->id ?? $vaccine['id'];
                                    $vName = $vaccine->vaccine_name ?? $vaccine['vaccine_name'];
                                    $vDesc = $vaccine->description ?? $vaccine['description'] ?? '';
                                    $vAvail = $vaccine->availability ?? $vaccine['availability'];
                                    $vCreated = $vaccine->created_at ?? $vaccine['created_at'];
                                @endphp
                                <tr>
                                    <td><span class="row-number">{{ $index + 1 }}</span></td>
                                    <td>
                                        <div class="vaccine-name-cell">
                                            <span class="table-vaccine-icon">
                                                <i class="bi bi-capsule"></i>
                                            </span>
                                            <strong>{{ $vName }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="description-cell">
                                            {{ trim($vDesc) !== '' ? $vDesc : 'No description' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($vAvail === 'Available')
                                            <span class="availability-badge available">
                                                <span class="status-dot"></span>
                                                Available
                                            </span>
                                        @else
                                            <span class="availability-badge unavailable">
                                                <span class="status-dot"></span>
                                                Unavailable
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="date-cell">{{ date('d M Y', strtotime($vCreated)) }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('hospital.add-vaccine', ['edit' => $vId]) }}" class="action-btn edit-btn" title="Edit Vaccine">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form method="POST" action="{{ route('hospital.manage-vaccine') }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this vaccine?');">
                                                @csrf
                                                <input type="hidden" name="vaccine_id" value="{{ $vId }}">
                                                <button type="submit" name="delete_vaccine" class="action-btn delete-btn" title="Delete Vaccine" style="border:none; cursor:pointer;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding: 40px 20px; color:#888;">
                    <i class="bi bi-capsule" style="font-size:36px; display:block; margin-bottom:10px;"></i>
                    <p>No vaccines added yet. Use the form above to add your first vaccine.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
