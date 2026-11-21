<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vaccination Certificate - {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            background: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.4;
        }
        .cert-container {
            border: 3px double #0284c7;
            padding: 24px;
            background: #ffffff;
            position: relative;
            min-height: 980px;
        }
        .cert-inner-border {
            border: 1px solid #94a3b8;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header-logo {
            width: 70px;
            text-align: left;
            vertical-align: middle;
        }
        .header-title-cell {
            text-align: center;
            vertical-align: middle;
        }
        .header-title {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-size: 11px;
            color: #0284c7;
            margin: 4px 0 0 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .header-cert-info {
            width: 130px;
            text-align: right;
            vertical-align: middle;
            font-size: 9px;
            color: #475569;
        }
        .cert-badge {
            display: inline-block;
            background: #0284c7;
            color: #ffffff;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            margin-bottom: 4px;
        }
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #0369a1;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-top: 15px;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
        }
        .info-label {
            width: 20%;
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
        }
        .info-value {
            width: 30%;
            font-size: 11px;
            color: #0f172a;
            font-weight: 600;
        }
        .records-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 20px;
        }
        .records-table th {
            background: #f1f5f9;
            color: #334155;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 7px 8px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .records-table td {
            font-size: 10px;
            padding: 7px 8px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .records-table tr:nth-child(even) td {
            background: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            font-weight: bold;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 3px;
            border: 1px solid #86efac;
        }
        .footer-table {
            width: 100%;
            margin-top: 25px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 15px;
        }
        .qr-cell {
            width: 110px;
            text-align: center;
            vertical-align: middle;
        }
        .qr-img {
            width: 95px;
            height: 95px;
        }
        .verify-text-cell {
            vertical-align: middle;
            padding-left: 15px;
        }
        .signature-cell {
            width: 160px;
            text-align: center;
            vertical-align: bottom;
        }
        .signature-line {
            border-top: 1px solid #475569;
            margin-top: 35px;
            padding-top: 4px;
            font-size: 9px;
            color: #475569;
            font-weight: bold;
        }
        .watermark {
            position: absolute;
            top: 40%;
            left: 20%;
            font-size: 50px;
            color: rgba(2, 132, 199, 0.05);
            font-weight: bold;
            text-transform: uppercase;
            transform: rotate(-30deg);
            z-index: -1;
        }
        .summary-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 15px;
        }
        .summary-box table {
            width: 100%;
        }
        .summary-box td {
            font-size: 10px;
            color: #166534;
        }
    </style>
</head>
<body>
    <div class="cert-container">
        <div class="cert-inner-border">
            <div class="watermark">VACCICARE VERIFIED</div>

            <!-- Header -->
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <div style="width: 55px; height: 55px; background: #0284c7; border-radius: 50%; text-align: center; line-height: 55px; color: #ffffff; font-size: 26px; font-weight: bold;">
                            VC
                        </div>
                    </td>
                    <td class="header-title-cell">
                        <div class="header-title">VacciCare Health Network</div>
                        <div class="header-subtitle">Official Digital Immunization Pass & Certificate</div>
                    </td>
                    <td class="header-cert-info">
                        <div class="cert-badge">VERIFIED PASS</div>
                        <div><strong>Cert #:</strong> {{ $certificate->certificate_number }}</div>
                        <div><strong>Issue Date:</strong> {{ $certificate->issued_at->format('d M Y') }}</div>
                    </td>
                </tr>
            </table>

            <!-- Child & Parent Information -->
            <div class="section-heading">1. Beneficiary Information</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Child Name:</td>
                    <td class="info-value">{{ $child->child_name }}</td>
                    <td class="info-label">Parent / Guardian:</td>
                    <td class="info-value">{{ $parent->user->name ?? $parent->father_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Date of Birth:</td>
                    <td class="info-value">{{ \Carbon\Carbon::parse($child->date_of_birth)->format('d F Y') }}</td>
                    <td class="info-label">Gender:</td>
                    <td class="info-value">{{ $child->gender }}</td>
                </tr>
                <tr>
                    <td class="info-label">Blood Group:</td>
                    <td class="info-value">{{ $child->blood_group ?: 'Not Specified' }}</td>
                    <td class="info-label">Contact / Phone:</td>
                    <td class="info-value">{{ $child->contact ?: ($parent->user->phone ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <td class="info-label">System ID:</td>
                    <td class="info-value">CH-{{ str_pad($child->child_id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="info-label">Status:</td>
                    <td class="info-value">
                        <span class="status-badge">{{ $child->vaccination_status }}</span>
                    </td>
                </tr>
            </table>

            <!-- Protection Summary -->
            <div class="summary-box">
                <table>
                    <tr>
                        <td style="font-weight: bold;">
                            Total Doses Administered: {{ $vaccinations->count() }} doses
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            Official EPI / WHO Harmonized Record
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Vaccination Ledger -->
            <div class="section-heading">2. Immunization History & Verification Ledger</div>
            <table class="records-table">
                <thead>
                    <tr>
                        <th style="width: 25px;">#</th>
                        <th>Vaccine Name</th>
                        <th>Date Administered</th>
                        <th>Healthcare Facility</th>
                        <th>Vaccinator</th>
                        <th style="width: 65px; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vaccinations as $index => $vaccination)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $vaccination->vaccine->vaccine_name ?? 'Vaccine' }}</strong>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($vaccination->vaccination_date)->format('d M Y') }}</td>
                            <td>{{ $vaccination->hospital->hospital_name ?? 'Registered Medical Center' }}</td>
                            <td>{{ $vaccination->vaccinator->vaccinator_name ?? 'Authorized Vaccinator' }}</td>
                            <td style="text-align: center;">
                                <span class="status-badge">Completed</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 18px;">
                                No completed vaccination doses recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Security & Verification Footer -->
            <table class="footer-table">
                <tr>
                    <td class="qr-cell">
                        <img src="{{ $qrCode }}" class="qr-img" alt="Verification QR Code">
                    </td>
                    <td class="verify-text-cell">
                        <div style="font-size: 11px; font-weight: bold; color: #0284c7; margin-bottom: 4px;">
                            SCAN TO INSTANTLY VERIFY
                        </div>
                        <div style="font-size: 9px; color: #475569; line-height: 1.3;">
                            This digital certificate is cryptographically linked to the official VacciCare database. Scan the QR code with any smartphone camera or visit:<br>
                            <span style="font-family: monospace; color: #0f172a;">{{ $verifyUrl }}</span>
                        </div>
                        <div style="margin-top: 6px; font-size: 8px; color: #94a3b8;">
                            Security Hash: {{ substr(hash('sha256', $certificate->verification_token . $child->child_id), 0, 32) }}
                        </div>
                    </td>
                    <td class="signature-cell">
                        <div style="height: 35px; line-height: 35px; color: #0284c7; font-weight: bold; font-family: cursive; font-size: 16px;">
                            Dr. A. Rahman
                        </div>
                        <div class="signature-line">
                            Director General of Immunization<br>
                            VacciCare Authority
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
