<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
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
        .log-badge {
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
        .filter-info {
            background-color: #f0f4f8;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 10px;
            color: #1e40af;
        }
        .filter-info strong {
            color: #1e40af;
        }
    </style>
</head>
<body>
    <h1>Activity Logs Report</h1>
    <div class="subtitle">Election Management System</div>
    
    <div class="header-info">
        <div>Generated on: {{ date('F d, Y - h:i A') }}</div>
        <div>Total Records: {{ count($logs) }}</div>
    </div>

    @if($filters['search'] || $filters['date_from'] || $filters['date_to'] || $filters['sort_by'])
    <div class="filter-info">
        <strong>Applied Filters & Sorting:</strong><br>
        @if($filters['search'])
            <span>Search: "{{ $filters['search'] }}"</span><br>
        @endif
        @if($filters['date_from'])
            <span>Date From: {{ date('M d, Y', strtotime($filters['date_from'])) }}</span><br>
        @endif
        @if($filters['date_to'])
            <span>Date To: {{ date('M d, Y', strtotime($filters['date_to'])) }}</span><br>
        @endif
        @if($filters['sort_by'])
            <span>Sorted by: {{ ucfirst(str_replace('_', ' ', $filters['sort_by'])) }} ({{ strtoupper($filters['sort_dir']) }})</span>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Log ID</th>
                <th style="width: 35%;">Activity</th>
                <th style="width: 20%;">User</th>
                <th style="width: 12%;">User ID</th>
                <th style="width: 25%;">Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>
                    <span class="log-badge">{{ $log->activity }}</span>
                </td>
                <td style="font-weight: 600;">
                    @if($log->user)
                        {{ $log->user->name }}
                    @else
                        <span style="color: #64748b;">Unknown User</span>
                    @endif
                </td>
                <td>{{ $log->user_id }}</td>
                <td>{{ $log->created_at->format('M d, Y - h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">
                    No activity logs found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-count">
        Total Logs: {{ count($logs) }}
    </div>

    <div class="footer">
        <p>Election Management System - Activity Logs Report</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>