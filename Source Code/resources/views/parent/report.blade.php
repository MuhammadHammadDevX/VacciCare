@extends('layouts.parent')

@section('title', 'Vaccination Report | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vaccination-report.css') }}">
@endpush

@section('content')
<main class="dashboard-main vaccination-report-main">
    <section class="report-content">
        <div class="report-intro">
            <div class="intro-left">
                <span class="section-label">
                    <i class="bi bi-shield-check"></i>
                    VACCINATION RECORD
                </span>
                <h2>Report of Vaccination Taken</h2>
                <p>Review the vaccination doses received by your children and keep their records organized.</p>
            </div>
            <div class="report-icon-box">
                <i class="bi bi-file-earmark-medical"></i>
            </div>
        </div>

        <div class="report-summary-grid">
            <!-- TOTAL -->
            <div class="summary-card">
                <div class="summary-icon blue-icon"><i class="bi bi-shield-check"></i></div>
                <div class="summary-info">
                    <span>Total Vaccinations</span>
                    <strong>{{ $totalVaccinations }}</strong>
                    <small>Recorded doses</small>
                </div>
            </div>

            <!-- COMPLETED -->
            <div class="summary-card">
                <div class="summary-icon green-icon"><i class="bi bi-check-circle"></i></div>
                <div class="summary-info">
                    <span>Completed</span>
                    <strong>{{ $totalVaccinations }}</strong>
                    <small>Vaccinations taken</small>
                </div>
            </div>

            <!-- CHILDREN -->
            <div class="summary-card">
                <div class="summary-icon purple-icon"><i class="bi bi-people"></i></div>
                <div class="summary-info">
                    <span>Children</span>
                    <strong>{{ $totalChildren }}</strong>
                    <small>Active vaccination records</small>
                </div>
            </div>

            <!-- THIS YEAR -->
            <div class="summary-card">
                <div class="summary-icon orange-icon"><i class="bi bi-calendar-check"></i></div>
                <div class="summary-info">
                    <span>This Year</span>
                    <strong>{{ $thisYearVaccinations }}</strong>
                    <small>Vaccinations taken</small>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div class="report-card-header">
                <div>
                    <span class="card-label">
                        <i class="bi bi-list-check"></i>
                        VACCINATION HISTORY
                    </span>
                    <h3>Vaccinations Taken</h3>
                    <p>Complete record of vaccinations received.</p>
                </div>
                <button type="button" class="print-btn" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Report
                </button>
            </div>

            <div class="table-wrapper">
                <table class="vaccination-table">
                    <thead>
                        <tr>
                            <th>Child</th>
                            <th>Vaccine</th>
                            <th>Dose</th>
                            <th>Date Taken</th>
                            <th>Hospital</th>
                            <th>Status</th>
                            <th>Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vaccinations as $record)
                            <tr>
                                <td>
                                    <div class="child-name">
                                        <div class="child-avatar"><i class="bi bi-person"></i></div>
                                        <div>
                                            <strong>{{ $record->child->child_name ?? 'Child' }}</strong>
                                            <span>{{ $record->child->gender ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="vaccine-name">
                                        <i class="bi bi-shield-plus"></i>
                                        <span>{{ $record->vaccine->vaccine_name ?? 'Vaccine' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="dose-badge">Recorded</span>
                                </td>
                                <td>
                                    <span class="date-text">
                                        {{ !empty($record->vaccination_date) ? date('d M Y', strtotime($record->vaccination_date)) : '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="hospital-text">
                                        {{ $record->hospital->hospital_name ?? 'Hospital' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge completed">
                                        <i class="bi bi-check-circle-fill"></i> Taken
                                    </span>
                                </td>
                                <td>
                                    @if(!empty($record->child_id))
                                        <a href="{{ route('parent.certificate.download', $record->child_id) }}" class="btn btn-sm" style="background:#0284c7; color:#fff; border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:4px; text-decoration:none;" title="Download Official Certificate">
                                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:50px 20px;">
                                    <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                                        <i class="bi bi-clipboard-x" style="font-size:45px;"></i>
                                        <strong>No Vaccination Records Found</strong>
                                        <span>Completed vaccinations will appear here after the hospital updates the vaccination status.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="report-card-footer">
                <small>Report generated for parent account: {{ $parentName }}</small>
            </div>
        </div>
    </section>
</main>
@endsection
