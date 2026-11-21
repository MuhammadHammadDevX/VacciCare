@extends('layouts.parent')

@section('title', 'Vaccination Schedule | VacciCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/parent_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vaccination-schedule.css') }}">
@endpush

@section('content')
<main class="dashboard-main">
    <section class="schedule-content">
        <div class="schedule-intro">
            <div class="schedule-intro-text">
                <span class="section-label">
                    <i class="bi bi-calendar2-week-fill"></i>
                    VACCINATION TRACKER
                </span>
                <h2>Upcoming Vaccinations</h2>
                <p>Stay informed about your children's upcoming vaccinations and never miss an important dose.</p>
            </div>

            <div class="child-selector">
                <label for="childSelect">
                    <i class="bi bi-person-fill"></i> Select Child
                </label>

                @if(!empty($children) && count($children) > 0)
                    <form method="GET" action="{{ route('parent.schedule') }}">
                        <select id="childSelect" name="child_id" onchange="this.form.submit()">
                            @foreach($children as $child)
                                <option value="{{ $child['child_id'] }}" {{ $child['child_id'] == $selectedChildId ? 'selected' : '' }}>
                                    {{ $child['child_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <select id="childSelect" disabled>
                        <option>No children added</option>
                    </select>
                @endif
            </div>
        </div>

        @if($selectedChild)
            <div class="selected-child-info" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div>
                    <i class="bi bi-person-circle"></i>
                    <span>Showing vaccination schedule for <strong>{{ $selectedChild['child_name'] }}</strong> (DOB: {{ \Carbon\Carbon::parse($selectedChild->date_of_birth)->format('d M Y') }})</span>
                </div>
                <div style="display:flex; gap:8px;">
                    <a href="{{ route('parent.certificate.download', $selectedChild->child_id) }}" class="schedule-action-btn" style="background:#0284c7; color:#fff; border-radius:8px; padding:6px 14px; text-decoration:none; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Download Certificate
                    </a>
                </div>
            </div>
        @endif

        <div class="schedule-summary">
            <!-- Upcoming -->
            <div class="summary-card">
                <div class="summary-icon upcoming-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
                <div class="summary-info">
                    <span>Upcoming</span>
                    <strong>{{ $upcomingCount }}</strong>
                    <small>Vaccinations</small>
                </div>
            </div>

            <!-- Completed -->
            <div class="summary-card">
                <div class="summary-icon completed-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="summary-info">
                    <span>Completed</span>
                    <strong>{{ $completedCount }}</strong>
                    <small>Vaccinations</small>
                </div>
            </div>

            <!-- Total -->
            <div class="summary-card">
                <div class="summary-icon total-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="summary-info">
                    <span>Total</span>
                    <strong>{{ $totalVaccinations }}</strong>
                    <small>Vaccinations</small>
                </div>
            </div>

            <!-- Progress -->
            <div class="summary-card">
                <div class="summary-icon progress-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="summary-info">
                    <span>Progress</span>
                    <strong>{{ $progressPercentage }}%</strong>
                    <small>Completed</small>
                </div>
            </div>
        </div>

        @if($smartSchedule && !empty($smartSchedule['milestones']))
            <div class="schedule-section" style="margin-bottom: 30px;">
                <div class="schedule-section-header">
                    <div>
                        <span class="section-label" style="background:#e0f2fe; color:#0284c7; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:700;">
                            <i class="bi bi-cpu-fill"></i> WHO / EPI SMART ENGINE
                        </span>
                        <h3 style="margin-top:6px;">
                            <i class="bi bi-shield-check"></i> Standard Immunization Schedule & Milestones
                        </h3>
                        <p>Calculated automatically according to {{ $selectedChild['child_name'] }}'s date of birth ({{ $smartSchedule['dob'] }}).</p>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:13px; font-weight:700; color:#0284c7;">
                            Overall EPI Coverage: {{ $smartSchedule['progress_percentage'] }}%
                        </span>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px; margin-top: 15px;">
                    @foreach($smartSchedule['milestones'] as $milestone)
                        @php
                            $mStatus = $milestone['status'];
                            $headerBg = '#f1f5f9';
                            $badgeBg = '#e2e8f0';
                            $badgeColor = '#475569';
                            $borderCol = '#cbd5e1';

                            if ($mStatus === 'Completed') {
                                $headerBg = '#f0fdf4';
                                $badgeBg = '#dcfce7';
                                $badgeColor = '#15803d';
                                $borderCol = '#86efac';
                            } elseif ($mStatus === 'Overdue') {
                                $headerBg = '#fef2f2';
                                $badgeBg = '#fee2e2';
                                $badgeColor = '#b91c1c';
                                $borderCol = '#fca5a5';
                            } elseif ($mStatus === 'Due Soon') {
                                $headerBg = '#fffbeb';
                                $badgeBg = '#fef3c7';
                                $badgeColor = '#b45309';
                                $borderCol = '#fcd34d';
                            }
                        @endphp
                        <div style="background:#ffffff; border:1px solid {{ $borderCol }}; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
                            <div style="background:{{ $headerBg }}; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid {{ $borderCol }};">
                                <div>
                                    <h4 style="margin:0; font-size:14px; font-weight:700; color:#0f172a;">
                                        {{ $milestone['title'] }}
                                    </h4>
                                    <small style="color:#64748b; font-size:11px;">
                                        <i class="bi bi-calendar-event"></i> Due: {{ $milestone['due_date_formatted'] }} ({{ $milestone['days_relative'] }})
                                    </small>
                                </div>
                                <span style="background:{{ $badgeBg }}; color:{{ $badgeColor }}; font-size:11px; font-weight:700; padding:3px 8px; border-radius:12px;">
                                    {{ $mStatus }}
                                </span>
                            </div>

                            <div style="padding:14px 16px;">
                                <p style="font-size:12px; color:#64748b; margin-bottom:12px;">{{ $milestone['description'] }}</p>

                                <div style="display:flex; flex-direction:column; gap:8px;">
                                    @foreach($milestone['vaccines'] as $vac)
                                        <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:8px 10px; border-radius:8px; border:1px solid #e2e8f0;">
                                            <div>
                                                <div style="font-size:13px; font-weight:700; color:#1e293b;">
                                                    {{ $vac['name'] }}
                                                </div>
                                                <div style="font-size:11px; color:#64748b;">
                                                    {{ $vac['target'] }} &bull; {{ $vac['dose'] }}
                                                </div>
                                            </div>

                                            <div>
                                                @if($vac['is_completed'])
                                                    <span style="background:#dcfce7; color:#15803d; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px; display:inline-flex; align-items:center; gap:3px;">
                                                        <i class="bi bi-check-circle-fill"></i> Given
                                                    </span>
                                                @else
                                                    <a href="{{ route('parent.book-hospital', ['hospital_id' => 1]) }}" style="background:#0284c7; color:#ffffff; font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                                        <i class="bi bi-calendar-plus"></i> Book
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="schedule-section">
            <div class="schedule-section-header">
                <div>
                    <h3>
                        <i class="bi bi-calendar3"></i>
                        Vaccination History & Booked Appointments
                    </h3>
                    <p>Complete record of doses received and upcoming scheduled appointments</p>
                </div>
                <span class="schedule-count">
                    {{ $totalVaccinations }} {{ $totalVaccinations === 1 ? 'Vaccine' : 'Vaccines' }}
                </span>
            </div>

            <div class="vaccination-timeline">
                @if(!empty($timeline) && count($timeline) > 0)
                    @foreach($timeline as $item)
                        @php
                            $timestamp = strtotime($item['date'] . ' ' . ($item['time'] ?: '00:00:00'));
                            $day = date('d', $timestamp);
                            $monthYear = strtoupper(date('M Y', $timestamp));
                            $formattedDate = date('d M Y', $timestamp);
                        @endphp

                        <div class="timeline-item {{ $item['type'] }}">
                            <div class="timeline-date">
                                <strong>{{ $day }}</strong>
                                <span>{{ $monthYear }}</span>
                            </div>

                            <div class="timeline-line">
                                <div class="timeline-dot">
                                    @if($item['type'] === 'completed')
                                        <i class="bi bi-check-lg"></i>
                                    @else
                                        <i class="bi bi-calendar-event-fill"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="timeline-content {{ $item['type'] === 'upcoming' ? 'upcoming-content' : '' }}">
                                <div class="timeline-content-top">
                                    <div>
                                        <span class="vaccine-category {{ $item['type'] === 'upcoming' ? 'upcoming-category' : '' }}">
                                            {{ $item['type'] === 'completed' ? 'COMPLETED' : 'UPCOMING' }}
                                        </span>
                                        <h4>{{ $item['vaccine_name'] ?? $item['title'] ?? 'Vaccine' }}</h4>
                                        @if(!empty($item['description']) || !empty($item['notes']))
                                            <p>{{ $item['description'] ?? $item['notes'] }}</p>
                                        @endif
                                    </div>

                                    @if($item['type'] === 'completed')
                                        <span class="vaccine-status completed-status">
                                            <i class="bi bi-check-circle-fill"></i> Completed
                                        </span>
                                    @else
                                        <span class="vaccine-status upcoming-status">
                                            <i class="bi bi-clock-fill"></i> Upcoming
                                        </span>
                                    @endif
                                </div>

                                <div class="vaccine-meta">
                                    <span>
                                        <i class="bi bi-calendar-check"></i>
                                        {{ $item['type'] === 'completed' ? 'Given:' : 'Due:' }} {{ $formattedDate }}
                                    </span>
                                    @if(!empty($item['time']))
                                        <span>
                                            <i class="bi bi-clock"></i> {{ date('h:i A', strtotime($item['time'])) }}
                                        </span>
                                    @endif
                                    @if(!empty($item['hospital_name']))
                                        <span>
                                            <i class="bi bi-hospital-fill"></i> {{ $item['hospital_name'] }} {{ !empty($item['city']) ? ' - ' . $item['city'] : '' }}
                                        </span>
                                    @endif
                                </div>

                                @if($item['type'] === 'completed' && !empty($item['notes']))
                                    <div class="timeline-notes">
                                        <i class="bi bi-info-circle"></i> {{ $item['notes'] }}
                                    </div>
                                @endif

                                @if($item['type'] === 'upcoming')
                                    <a href="{{ route('appointment') }}" class="schedule-action-btn">
                                        <i class="bi bi-calendar-plus"></i> Book Appointment
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-schedule">
                        <div class="empty-icon"><i class="bi bi-calendar2-x"></i></div>
                        <h3>No Vaccination Records</h3>
                        @if($selectedChild)
                            <p>There are currently no completed or approved upcoming vaccinations for <strong>{{ $selectedChild['child_name'] }}</strong>.</p>
                            <a href="{{ route('appointment') }}" class="schedule-action-btn">
                                <i class="bi bi-calendar-plus"></i> Book Appointment
                            </a>
                        @else
                            <p>Please add a child first to view the vaccination schedule.</p>
                            <a href="{{ route('parent.children') }}" class="schedule-action-btn">
                                <i class="bi bi-person-plus"></i> Add Child
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
