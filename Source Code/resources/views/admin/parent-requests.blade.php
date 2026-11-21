@extends('layouts.admin')

@section('title', 'Parent Requests | VacciCare Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vc-dashboard-theme.css') }}">
    <style>
        .admin-request-main {
            padding: 24px;
        }
        .request-header-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 24px;
            border: 1px solid #e8eef5;
            box-shadow: 0 7px 20px rgba(30, 60, 90, 0.05);
        }
        .request-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .request-eyebrow {
            font-size: 12px;
            font-weight: 800;
            color: #2676d9;
            letter-spacing: 1.2px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }
        .request-header-card h1 {
            font-size: 26px;
            font-weight: 800;
            color: #17324d;
            margin: 0;
        }
        .request-header-card p {
            color: #718096;
            margin: 6px 0 0;
            font-size: 14px;
        }
        .header-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: #eaf4ff;
            color: #2676d9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }
        .request-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card-inner {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff;
            padding: 18px;
            border-radius: 16px;
            border: 1px solid #e8eef5;
            box-shadow: 0 4px 15px rgba(30, 60, 90, 0.04);
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .stat-icon.total { background: #edf5ff; color: #2676d9; }
        .stat-icon.pending { background: #fff6df; color: #d89500; }
        .stat-icon.approved { background: #e9f8ef; color: #1f9d55; }
        .stat-icon.rejected { background: #ffeded; color: #d9363e; }
        .stat-number { font-size: 22px; font-weight: 800; color: #17324d; line-height: 1; }
        .stat-label { font-size: 13px; color: #7b8794; margin-top: 4px; }
        .requests-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e8eef5;
            box-shadow: 0 10px 30px rgba(30, 60, 90, 0.06);
            overflow: hidden;
        }
        .requests-card-header {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .requests-card-header h2 { font-size: 18px; font-weight: 700; color: #17324d; margin: 0; }
        .requests-card-header p { color: #718096; font-size: 13px; margin: 4px 0 0; }
        .requests-table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            font-weight: 700;
            padding: 14px 18px;
            border-top: none;
            background: #f8fafc;
        }
        .requests-table td {
            padding: 16px 18px;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
        }
        .request-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .request-status.pending { background: #fff6df; color: #b45309; }
        .request-status.approved { background: #dcfce7; color: #15803d; }
        .request-status.rejected { background: #fee2e2; color: #b91c1c; }
        .action-btn-approve, .action-btn-reject {
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .action-btn-approve { background: #198754; color: #fff; }
        .action-btn-approve:hover { background: #146c43; }
        .action-btn-reject { background: #dc3545; color: #fff; margin-left: 6px; }
        .action-btn-reject:hover { background: #b02a37; }
        @media(max-width: 900px) {
            .request-stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endpush

@section('content')
<main class="admin-request-main">

    <!-- PAGE HEADER -->
    <section class="request-header-card">
        <div class="request-header-content">
            <div>
                <span class="request-eyebrow">
                    <i class="bi bi-inbox-fill"></i> PARENT REQUESTS
                </span>
                <h1>Hospital Appointment Requests</h1>
                <p>Review appointment requests submitted by parents. Approve or reject pending requests.</p>
            </div>
            <div class="header-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>
        </div>
    </section>

    @if(session('message'))
        <div class="alert alert-{{ session('message_type', 'success') }} mb-4" role="alert">
            <i class="bi bi-info-circle-fill mr-2"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- STATS -->
    <section class="request-stats">
        <div class="stat-card-inner">
            <div class="stat-icon total"><i class="bi bi-clipboard-data"></i></div>
            <div>
                <div class="stat-number">{{ $totalRequests }}</div>
                <div class="stat-label">Total Requests</div>
            </div>
        </div>

        <div class="stat-card-inner">
            <div class="stat-icon pending"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-number">{{ $pendingRequests }}</div>
                <div class="stat-label">Pending Review</div>
            </div>
        </div>

        <div class="stat-card-inner">
            <div class="stat-icon approved"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-number">{{ $approvedRequests }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>

        <div class="stat-card-inner">
            <div class="stat-icon rejected"><i class="bi bi-x-circle"></i></div>
            <div>
                <div class="stat-number">{{ $rejectedRequests }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </section>

    <!-- REQUESTS TABLE -->
    <section class="requests-card">
        <div class="requests-card-header">
            <div>
                <h2>Parent Appointment Requests</h2>
                <p>Pending requests require Admin action.</p>
            </div>
            <span class="badge badge-warning" style="font-size: 14px; padding: 6px 12px; border-radius: 8px;">
                {{ $pendingRequests }} Pending
            </span>
        </div>

        <div class="table-responsive">
            <table class="table requests-table mb-0">
                <thead>
                    <tr>
                        <th>Request #</th>
                        <th>Parent</th>
                        <th>Child</th>
                        <th>Hospital</th>
                        <th>Vaccine</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>
                                <strong>#{{ $request->request_id }}</strong>
                            </td>
                            <td>
                                <strong>{{ $request->parent->parent_name ?? ($request->parent->user->name ?? 'Parent') }}</strong>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">{{ $request->child->child_name ?? 'Child' }}</span>
                            </td>
                            <td>
                                <span>{{ $request->hospital->hospital_name ?? 'Hospital' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-light border">{{ $request->hospitalVaccine->vaccine_name ?? 'Vaccine' }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $request->request_type }}</small>
                            </td>
                            <td>
                                {{ $request->request_date ? date('d M Y', strtotime($request->request_date)) : 'N/A' }}
                            </td>
                            <td>
                                {{ $request->preferred_time ? date('h:i A', strtotime($request->preferred_time)) : 'N/A' }}
                            </td>
                            <td>
                                <span class="request-status {{ strtolower($request->status) }}">
                                    @if($request->status === 'Approved')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($request->status === 'Rejected')
                                        <i class="bi bi-x-circle-fill"></i>
                                    @else
                                        <i class="bi bi-clock-fill"></i>
                                    @endif
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td>
                                @if($request->status === 'Pending')
                                    <form action="{{ route('admin.process-parent-request') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="request_id" value="{{ $request->request_id }}">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="action-btn-approve" title="Approve Request">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.process-parent-request') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="request_id" value="{{ $request->request_id }}">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="action-btn-reject" title="Reject Request">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">Reviewed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                                No parent appointment requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection