<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification | VacciCare Health Network</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --success: #10b981;
            --slate-800: #1e293b;
            --slate-600: #475569;
            --slate-100: #f1f5f9;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verify-card {
            background: #ffffff;
            width: 100%;
            max-width: 680px;
            border-radius: 18px;
            box-shadow: 0 20px 40px -15px rgba(2, 132, 199, 0.15), 0 0 1px 1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .verify-header {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            padding: 28px 24px;
            text-align: center;
            position: relative;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        .status-seal {
            width: 70px;
            height: 70px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            color: var(--success);
            font-size: 2.2rem;
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .verify-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .verify-header p {
            font-size: 0.88rem;
            opacity: 0.9;
        }
        .verify-body {
            padding: 28px 24px;
        }
        .cert-chip {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .cert-chip-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--slate-600);
            letter-spacing: 0.5px;
        }
        .cert-chip-val {
            font-family: monospace;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary-dark);
        }
        .grid-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .detail-item {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px 14px;
        }
        .detail-item .label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--slate-600);
            font-weight: 600;
            margin-bottom: 4px;
        }
        .detail-item .value {
            font-size: 0.95rem;
            color: var(--slate-800);
            font-weight: 700;
        }
        .section-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--slate-800);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .vaccines-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .vaccines-table th {
            background: #f1f5f9;
            padding: 10px 12px;
            text-align: left;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--slate-600);
        }
        .vaccines-table td {
            padding: 10px 12px;
            font-size: 0.85rem;
            border-top: 1px solid #e2e8f0;
            color: var(--slate-800);
        }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #dcfce7;
            color: #15803d;
        }
        .btn-group-action {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 10px;
        }
        .btn-verify {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: #ffffff;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-verify:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #f1f5f9;
            color: var(--slate-600);
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
        }
        .btn-home:hover {
            background: #e2e8f0;
        }
        .trust-banner {
            text-align: center;
            margin-top: 20px;
            font-size: 0.75rem;
            color: var(--slate-600);
        }
    </style>
</head>
<body>
    <div class="verify-card">
        @if(isset($certificate) && $certificate && $child)
            <div class="verify-header">
                <div class="brand-badge">
                    <i class="bi bi-shield-check"></i>
                    VACCICARE OFFICIAL REGISTRY
                </div>
                <div class="status-seal">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h1>Official Certificate Verified</h1>
                <p>This immunization record is valid and registered in the National Health Database.</p>
            </div>

            <div class="verify-body">
                <div class="cert-chip">
                    <div>
                        <div class="cert-chip-label">Certificate Number</div>
                        <div class="cert-chip-val">{{ $certificate->certificate_number }}</div>
                    </div>
                    <div>
                        <div class="cert-chip-label">Issued On</div>
                        <div style="font-size: 0.9rem; font-weight: 600; color: var(--slate-800);">
                            {{ $certificate->issued_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="section-title">
                    <i class="bi bi-person-badge-fill text-primary"></i>
                    Child Details
                </div>

                <div class="grid-details">
                    <div class="detail-item">
                        <div class="label">Full Name</div>
                        <div class="value">{{ $child->child_name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Date of Birth</div>
                        <div class="value">{{ \Carbon\Carbon::parse($child->date_of_birth)->format('d M Y') }} ({{ $child->age }})</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Gender</div>
                        <div class="value">{{ $child->gender }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Immunization Status</div>
                        <div class="value" style="color: var(--success);">
                            <i class="bi bi-check-circle-fill"></i> {{ $child->vaccination_status }}
                        </div>
                    </div>
                </div>

                <div class="section-title">
                    <i class="bi bi-shield-shaded text-primary"></i>
                    Verified Vaccinations ({{ $vaccinations->count() }})
                </div>

                <table class="vaccines-table">
                    <thead>
                        <tr>
                            <th>Vaccine</th>
                            <th>Date</th>
                            <th>Administering Center</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vaccinations as $v)
                            <tr>
                                <td><strong>{{ $v->vaccine->vaccine_name ?? 'Vaccine' }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($v->vaccination_date)->format('d M Y') }}</td>
                                <td>{{ $v->hospital->hospital_name ?? 'Medical Facility' }}</td>
                                <td>
                                    <span class="pill">
                                        <i class="bi bi-check-circle-fill"></i> Verified
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--slate-600); padding: 16px;">
                                    No completed vaccination records yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="btn-group-action">
                    <a href="{{ route('certificate.download.public', ['token' => $certificate->verification_token]) }}" class="btn-verify">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                        Download Official PDF
                    </a>
                    <a href="{{ url('/') }}" class="btn-home">
                        <i class="bi bi-house-door"></i>
                        Home
                    </a>
                </div>

                <div class="trust-banner">
                    <i class="bi bi-lock-fill"></i> Digitally signed with SHA-256 encryption • VacciCare Immunization Management System
                </div>
            </div>
        @else
            <div class="verify-header" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
                <div class="status-seal" style="color: #ef4444;">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <h1>Certificate Not Found</h1>
                <p>The verification link provided is invalid or has expired.</p>
            </div>
            <div class="verify-body" style="text-align: center;">
                <p style="color: var(--slate-600); margin-bottom: 20px;">
                    Please check the certificate QR code or contact the healthcare provider to verify authenticity.
                </p>
                <a href="{{ url('/') }}" class="btn-verify">
                    <i class="bi bi-house-door"></i>
                    Return to VacciCare Home
                </a>
            </div>
        @endif
    </div>
</body>
</html>
