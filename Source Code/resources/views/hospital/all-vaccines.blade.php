@extends('layouts.hospital')

@section('title', 'All Vaccines | VacciCare')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/all-vaccines.css') }}">
@endpush

@section('content')
<section class="all-vaccines-page">
    <div class="all-vaccines-container">

        <div class="vaccines-page-heading">
            <div class="heading-content">
                <span class="heading-eyebrow">
                    <i class="bi bi-capsule-pill"></i>
                    VACCINE MANAGEMENT
                </span>
                <h1>All Vaccines</h1>
                <p>View all vaccines currently added by {{ $hospitalUser->hospital_name ?? $hospital->hospital_name ?? 'Hospital' }}.</p>
            </div>
            <div class="heading-icon">
                <i class="bi bi-capsule"></i>
            </div>
        </div>

        <div class="vaccine-stat-grid">
            <!-- Total -->
            <div class="vaccine-stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-capsule-pill"></i>
                </div>
                <div class="stat-content">
                    <span>Total Vaccines</span>
                    <strong>{{ $totalVaccines ?? count($vaccines) }}</strong>
                </div>
            </div>

            <!-- Available -->
            <div class="vaccine-stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <span>Available</span>
                    <strong>{{ $availableVaccines ?? 0 }}</strong>
                </div>
            </div>

            <!-- Unavailable -->
            <div class="vaccine-stat-card">
                <div class="stat-icon red">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-content">
                    <span>Unavailable</span>
                    <strong>{{ $unavailableVaccines ?? 0 }}</strong>
                </div>
            </div>
        </div>

        <div class="all-vaccines-card">
            <div class="all-vaccines-card-header">
                <div>
                    <span class="list-eyebrow">
                        <i class="bi bi-list-check"></i>
                        VACCINE LIST
                    </span>
                    <h2>All Vaccines</h2>
                    <p>All vaccines available in your hospital database.</p>
                </div>

                <a href="{{ route('hospital.add-vaccine') }}" class="add-vaccine-small-btn">
                    <i class="bi bi-plus-circle"></i>
                    Add Vaccine
                </a>
            </div>

            @if(count($vaccines) > 0)
                <div class="table-wrapper">
                    <table class="all-vaccine-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vaccine</th>
                                <th>Stock (Vials)</th>
                                <th>Batch &amp; Expiry</th>
                                <th>Availability</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vaccines as $index => $vaccine)
                                @php
                                    $vId = $vaccine->id ?? $vaccine['id'];
                                    $vName = $vaccine->vaccine_name ?? $vaccine['vaccine_name'];
                                    $vDesc = $vaccine->description ?? $vaccine['description'] ?? '';
                                    $vAvail = $vaccine->availability ?? $vaccine['availability'];
                                    $vStock = $vaccine->stock_quantity ?? 0;
                                    $vBatch = $vaccine->batch_number ?? 'N/A';
                                    $vExpiry = $vaccine->expiry_date;
                                    $threshold = $vaccine->low_stock_threshold ?? 10;

                                    $isLow = $vStock > 0 && $vStock <= $threshold;
                                    $isOut = $vStock <= 0;
                                    $isExpired = $vExpiry && \Carbon\Carbon::parse($vExpiry)->isPast();
                                    $isExpiringSoon = $vExpiry && !$isExpired && \Carbon\Carbon::parse($vExpiry)->diffInDays(now()) <= 30;
                                @endphp
                                <tr>
                                    <td><span class="row-number">{{ $index + 1 }}</span></td>
                                    <td>
                                        <div class="vaccine-name-cell">
                                            <div class="table-vaccine-icon">
                                                <i class="bi bi-capsule"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $vName }}</strong>
                                                <small style="display:block; color:#64748b;">{{ Str::limit($vDesc, 35) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <strong style="font-size:14px; color:#0f172a;">{{ $vStock }}</strong>
                                            @if($isOut)
                                                <span style="background:#fee2e2; color:#b91c1c; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px;">Out of Stock</span>
                                            @elseif($isLow)
                                                <span style="background:#fef3c7; color:#b45309; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px;">Low Stock</span>
                                            @else
                                                <span style="background:#dcfce7; color:#15803d; font-size:11px; font-weight:700; padding:2px 6px; border-radius:4px;">Good</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size:12px;">
                                            <div><strong style="font-family:monospace; color:#0284c7;">{{ $vBatch }}</strong></div>
                                            @if($vExpiry)
                                                <div style="font-size:11px; color:#64748b; margin-top:2px;">
                                                    Exp: {{ \Carbon\Carbon::parse($vExpiry)->format('d M Y') }}
                                                    @if($isExpired)
                                                        <span style="color:#ef4444; font-weight:bold;">(EXPIRED)</span>
                                                    @elseif($isExpiringSoon)
                                                        <span style="color:#f59e0b; font-weight:bold;">(Expiring Soon)</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span style="color:#94a3b8; font-size:11px;">No expiry set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($vAvail === 'Available' && !$isOut)
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
                                        <a href="{{ route('hospital.add-vaccine', ['edit' => $vId]) }}" class="btn btn-sm" style="background:#0284c7; color:#fff; border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding: 50px 20px; color:#888;">
                    <i class="bi bi-capsule" style="font-size:40px; display:block; margin-bottom:12px; color:#adb5bd;"></i>
                    <p>No vaccines found in your hospital records.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
