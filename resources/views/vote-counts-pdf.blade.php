<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Counts Report</title>
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
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 10px;
            color: #64748b;
        }
        .position-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .position-header {
            background-color: #1e40af;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
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
        .rank-badge {
            background-color: #1e40af;
            color: white;
            padding: 4px 8px;
            border-radius: 50%;
            font-weight: bold;
            display: inline-block;
            min-width: 30px;
            text-align: center;
            font-size: 9px;
        }
        .vote-badge {
            background-color: #e0e7ff;
            color: #1e40af;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            display: inline-block;
            font-weight: 600;
        }
        .candidate-name {
            font-weight: 600;
            color: #1e3a8a;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .summary-box {
            background-color: #f0f9ff;
            border: 1px solid #1e40af;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 10px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 20px;
            color: #1e40af;
            font-weight: 600;
        }
        .no-candidates {
            text-align: center;
            padding: 15px;
            color: #64748b;
            font-style: italic;
        }
        .filter-info {
            background-color: #fef3c7;
            border-left: 3px solid #f59e0b;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 10px;
            color: #92400e;
        }
    </style>
</head>
<body>
    <h1>Vote Counts Report</h1>
    <div class="subtitle">Election Management System</div>
    
    <div class="header-info">
        <div>Generated on: {{ date('F d, Y - h:i A') }}</div>
        <div>Total Positions: {{ count($positions) }}</div>
    </div>

    @if(isset($filters['search']) && $filters['search'])
    <div class="filter-info">
        <strong>Filtered by:</strong> Search term "{{ $filters['search'] }}"
    </div>
    @endif

    <div class="summary-box">
        <span class="summary-item">Total Positions: {{ count($positions) }}</span>
        <span class="summary-item">Total Candidates: {{ $positions->sum(function($p) { return $p->rankedCandidates->count(); }) }}</span>
        <span class="summary-item">Total Votes Cast: {{ $positions->sum(function($p) { return $p->rankedCandidates->sum('vote_count'); }) }}</span>
    </div>

    @forelse($positions as $position)
        <div class="position-section">
            <div class="position-header">
                {{ $position->position_name }}
                <span style="float: right; font-weight: normal; font-size: 10px;">
                    {{ $position->rankedCandidates->count() }} candidate(s) | 
                    {{ $position->rankedCandidates->sum('vote_count') }} total votes
                </span>
            </div>
            
            @if($position->rankedCandidates->count())
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%; text-align: center;">Rank</th>
                            <th style="width: 15%;">Candidate ID</th>
                            <th style="width: 55%;">Candidate Name</th>
                            <th style="width: 20%; text-align: center;">Vote Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($position->rankedCandidates as $idx => $candidate)
                        <tr>
                            <td style="text-align: center;">
                                <span class="rank-badge">{{ $idx + 1 }}</span>
                            </td>
                            <td>{{ $candidate->candidate_id }}</td>
                            <td class="candidate-name">{{ $candidate->candidate_name }}</td>
                            <td style="text-align: center;">
                                <span class="vote-badge">{{ $candidate->vote_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-candidates">No candidates for this position</div>
            @endif
        </div>
    @empty
        <div class="no-candidates" style="margin-top: 40px;">
            No vote count data available
        </div>
    @endforelse

    <div class="footer">
        <p>Election Management System - Vote Counts Report</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>