<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voters List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        h1 {
            color: #1e40af;
            text-align: center;
            margin-bottom: 5px;
            font-size: 20px;
        }
        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 20px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #1e40af;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            display: inline-block;
        }
        .status-disabled {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            display: inline-block;
        }
        .voter-badge {
            background-color: #e0e7ff;
            color: #1e40af;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 10px;
            color: #64748b;
        }
        .total-count {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
            color: #1e40af;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1>Registered Voters List</h1>
    <div class="subtitle">Election Management System</div>
    
    <div class="header-info">
        <div>Generated on: {{ date('F d, Y - h:i A') }}</div>
        <div>Total Records: {{ count($voters) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Voter ID</th>
                <th style="width: 22%;">Full Name</th>
                <th style="width: 12%;">Date of Birth</th>
                <th style="width: 8%;">Age</th>
                <th style="width: 10%;">Gender</th>
                <th style="width: 12%;">Contact</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 18%;">Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($voters as $voter)
            <tr>
                <td>{{ $voter->voter_id }}</td>
                <td style="font-weight: 600;">{{ $voter->first_name }} {{ $voter->last_name }}</td>
                <td>{{ $voter->birthdate->format('M d, Y') }}</td>
                <td>{{ $voter->birthdate->age }}</td>
                <td>
                    <span class="voter-badge">{{ $voter->gender }}</span>
                </td>
                <td>{{ $voter->contact_information }}</td>
                <td>
                    <span class="{{ $voter->status == 'Disabled' ? 'status-disabled' : 'status-active' }}">
                        {{ $voter->status ?? 'Active' }}
                    </span>
                </td>
                <td>{{ $voter->created_at->format('M d, Y - h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #64748b;">
                    No voters found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-count">
        Total Voters: {{ count($voters) }}
    </div>

    <div class="footer">
        <p>Election Management System - Voters List Report</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>