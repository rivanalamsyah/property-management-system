<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lease Agreement - {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #1c1917;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e7e5e4;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18pt;
            margin: 0;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10pt;
            color: #78716c;
        }
        .doc-number {
            font-family: monospace;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #44403c;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            background-color: #f5f5f4;
            padding: 6px 12px;
            margin-top: 25px;
            margin-bottom: 12px;
            color: #1c1917;
            border-left: 4px solid #4f46e5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table td {
            padding: 6px 0;
            vertical-align: top;
        }
        table td.label {
            width: 30%;
            color: #78716c;
            font-weight: bold;
        }
        table td.value {
            width: 70%;
        }
        .terms-list {
            margin: 0;
            padding-left: 20px;
        }
        .terms-list li {
            margin-bottom: 8px;
            text-align: justify;
        }
        .signatures {
            margin-top: 50px;
            width: 100%;
        }
        .signatures td {
            width: 50%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #78716c;
            width: 200px;
            display: inline-block;
        }
        .verification {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #e7e5e4;
            padding-top: 20px;
            font-size: 8pt;
            color: #78716c;
        }
        .verification img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Lease Agreement</h1>
        <p>{{ $contract->boardingHouse->name }} - Managed by {{ tenant()->name }}</p>
        <p>{{ $contract->boardingHouse->address }}</p>
    </div>

    <div class="doc-number">
        Agreement No: {{ $contract->contract_number }}
    </div>

    <p>This Lease Agreement is made and entered into on this day <strong>{{ $contract->created_at->format('d F Y') }}</strong>, by and between:</p>

    <div class="section-title">I. The Parties</div>
    <table>
        <tr>
            <td class="label">The Landlord</td>
            <td class="value"><strong>{{ tenant()->name }}</strong><br>Address: {{ $contract->boardingHouse->address }}</td>
        </tr>
        <tr>
            <td class="label">The Tenant</td>
            <td class="value"><strong>{{ $contract->resident->name }}</strong><br>NIK: {{ $contract->resident->nik }}<br>Phone: {{ $contract->resident->phone }}</td>
        </tr>
    </table>

    <div class="section-title">II. Rental Specifications & Terms</div>
    <table>
        <tr>
            <td class="label">Room Allocated</td>
            <td class="value"><strong>Room {{ $contract->room ? $contract->room->room_number : '-' }}</strong> (Floor {{ $contract->room ? $contract->room->floor : '-' }})</td>
        </tr>
        <tr>
            <td class="label">Lease Period</td>
            <td class="value">{{ $contract->start_date->format('d M Y') }} to {{ $contract->end_date->format('d M Y') }} ({{ $contract->duration_months }} Months)</td>
        </tr>
        <tr>
            <td class="label">Move-In Date</td>
            <td class="value">{{ $contract->move_in_date->format('d M Y') }}</td>
        </tr>
        <tr>
            <td class="label">Billing Option</td>
            <td class="value">{{ $contract->contract_type->label() }}</td>
        </tr>
    </table>

    <div class="section-title">III. Financial Details (Monthly Fees)</div>
    <table>
        <tr>
            <td class="label">Monthly Rent Price</td>
            <td class="value">Rp{{ number_format($contract->monthly_rent, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Water Utility Fee</td>
            <td class="value">Rp{{ number_format($contract->water_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Internet Connection Fee</td>
            <td class="value">Rp{{ number_format($contract->internet_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Parking Lot Fee</td>
            <td class="value">Rp{{ number_format($contract->parking_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Electricity (Token)</td>
            <td class="value">Rp{{ number_format($contract->electricity_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Paid Security Deposit</td>
            <td class="value"><strong>Rp{{ number_format($contract->security_deposit, 0, ',', '.') }}</strong> (Refundable)</td>
        </tr>
    </table>

    <div class="section-title">IV. Standard House Rules & Terms</div>
    <ul class="terms-list">
        <li>The Tenant agrees to pay the monthly rental fees on or before the due date of each month. Late payments may trigger additional penalty charges.</li>
        <li>The paid Security Deposit is refundable at the termination of lease agreement, subject to assessments of rooms cleanliness and damages.</li>
        <li>The Tenant is fully responsible to maintain hygiene, clean state of rooms, and prevent any damage to landlord properties.</li>
        <li>Any illegal activities, loud noises past 10 PM, or unapproved overnight guests are strictly prohibited.</li>
    </ul>

    <div class="signatures">
        <table>
            <tr>
                <td>
                    <p>The Landlord</p>
                    <div class="signature-line"></div>
                    <p><strong>{{ tenant()->name }} representative</strong></p>
                </td>
                <td>
                    <p>The Tenant</p>
                    <div class="signature-line"></div>
                    <p><strong>{{ $contract->resident->name }}</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="verification">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('dashboard')) }}" alt="Verification QR">
        <p>This is a system-generated document. Scan the QR code to verify the validity of this contract within the KosManager workspace platform.</p>
    </div>

</body>
</html>
