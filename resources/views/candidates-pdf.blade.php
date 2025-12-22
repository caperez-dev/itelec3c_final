<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates List</title>
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
        .position-badge {
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
    <h1>Registered Candidates List</h1>
    <div class="subtitle">Election Management System</div>
    
    <div class="header-info">
        <div>Generated on: {{ date('F d, Y - h:i A') }}</div>
        <div>Total Records: {{ count($candidates) }}</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 25%;">Candidate Name</th>
                <th style="width: 20%;">Party Affiliation</th>
                <th style="width: 18%;">Position</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 19%;">Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($candidates as $candidate)
            <tr>
                <td>{{ $candidate->candidate_id }}</td>
                <td style="font-weight: 600;">{{ $candidate->candidate_name }}</td>
                <td>{{ $candidate->party_affiliation }}</td>
                <td>
                    <span class="position-badge">{{ $candidate->position_name }}</span>
                </td>
                <td>
                    <span class="{{ $candidate->status == 'Disabled' ? 'status-disabled' : 'status-active' }}">
                        {{ $candidate->status ?? 'Active' }}
                    </span>
                </td>
                <td>{{ $candidate->created_at->format('M d, Y - h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                    No candidates found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="total-count">
        Total Candidates: {{ count($candidates) }}
    </div>
    
    <div class="footer">
        <p>Election Management System - Candidates List Report</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>