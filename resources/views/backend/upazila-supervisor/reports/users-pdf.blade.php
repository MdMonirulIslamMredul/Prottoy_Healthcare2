<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Report</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #667eea;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filters {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #667eea;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .filter-item strong {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #667eea;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }
        .badge-primary { background-color: #0d6efd; }
        .badge-success { background-color: #198754; }
        .badge-info { background-color: #0dcaf0; color: #000; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-secondary { background-color: #6c757d; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary {
            margin-bottom: 15px;
            font-size: 13px;
        }
        .summary strong {
            color: #667eea;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .print-btn:hover {
            background-color: #5568d3;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn no-print">
        🖨️ Print / Save as PDF
    </button>
    <div class="header">
        <h1>Prottoy Healthcare System - Users Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
    </div>

    <div class="filters">
        <h3>Applied Filters:</h3>
        <div class="filter-item">
            <strong>PHO:</strong> {{ $filters['pho'] }}
        </div>
        <div class="filter-item">
            <strong>Role:</strong> {{ $filters['role'] }}
        </div>
    </div>

    <div class="summary">
        <strong>Total Users:</strong> {{ $users->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Name</th>
                <th style="width: 18%;">Email</th>
                <th style="width: 10%;">Phone</th>
                <th style="width: 12%;">Role</th>
                <th style="width: 13%;">Division</th>
                <th style="width: 12%;">District</th>
                <th style="width: 15%;">Upazila</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        @php
                            $roleColors = [
                                'divisional_chief' => 'primary',
                                'district_manager' => 'success',
                                'upazila_supervisor' => 'info',
                                'pho' => 'warning',
                                'customer' => 'secondary'
                            ];
                            $color = $roleColors[$user->role] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $color }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td>{{ $user->division->name ?? '-' }}</td>
                    <td>{{ $user->district->name ?? '-' }}</td>
                    <td>{{ $user->upzila->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated report from the Prottoy Healthcare Management System</p>
        <p>© {{ date('Y') }} Prottoy Healthcare System. All rights reserved.</p>
    </div>
</body>
</html>
