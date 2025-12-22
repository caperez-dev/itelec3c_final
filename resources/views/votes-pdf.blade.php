<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votes List</title>
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
        .filter-info {
            background-color: #f0f4f8;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 10px;
            color: #1e40af;
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
    <h1>Votes List</h1>
    <div class="subtitle">Election Management System</div>
    
    <div class="header-info">
        <div>Generated on: {{ date('F d, Y - h:i A') }}</div>
        <div>Total Records: {{ count($votes) }}</div>
    </div>

    @if($filters['search'] || $filters['applied_from'] || $filters['applied_to'] || $filters['sort_by'])
    <div class="filter-info">
        <strong>Applied Filters:</strong>
        @if($filters['search'])
            Search: "{{ $filters['search'] }}"
        @endif
        @if($filters['applied_from'])
            | From: {{ date('M d, Y', strtotime($filters['applied_from'])) }}
        @endif
        @if($filters['applied_to'])
            | To: {{ date('M d, Y', strtotime($filters['applied_to'])) }}
        @endif
        @if($filters['sort_by'])
            | Sorted by: {{ ucfirst(str_replace('_', ' ', $filters['sort_by'])) }} ({{ strtoupper($filters['sort_dir']) }})
        @endif
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Vote ID</th>
                <th style="width: 30%;">Voter Name</th>
                <th style="width: 40%;">Candidate Voted</th>
                <th style="width: 20%;">Voted Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($votes as $vote)
            <tr>
                <td>{{ $vote->vote_id }}</td>
                <td style="font-weight: 600;">{{ $vote->first_name }} {{ $vote->last_name }}</td>
                <td>
                    <span class="voter-badge">{{ $vote->candidate_name }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($vote->created_at)->format('M d, Y - h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px; color: #64748b;">
                    No votes found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="total-count">
        Total Votes: {{ count($votes) }}
    </div>
    
    <div class="footer">
        <p>Election Management System - Votes List Report</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>