<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Package Sales Report</title>
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
            line-height: 1.4;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #667eea;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .stats-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 5px;
        }
        .stat-label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .filters {
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-left: 4px solid #667eea;
            border-radius: 5px;
        }
        .filter-label {
            font-weight: bold;
            color: #667eea;
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success {
            background-color: #198754;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
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

    <h1>Package Sales Report</h1>
    <p class="subtitle">{{ $reportTitle }}</p>

    @if($filters)
    <div class="filters">
        <span class="filter-label">Applied Filters:</span>
        @foreach($filters as $key => $value)
            <div class="filter-item"><strong>{{ $key }}:</strong> {{ $value }}</div>
        @endforeach
    </div>
    @endif

    <div class="stats-container">
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-label">Total Packages Sold</div>
                <div class="stat-value">{{ $totalPackagesSold }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Sales Amount</div>
                <div class="stat-value">৳{{ number_format($totalSalesAmount, 0) }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Paid</div>
                <div class="stat-value">৳{{ number_format($totalPaidAmount, 0) }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Due</div>
                <div class="stat-value">৳{{ number_format($totalDueAmount, 0) }}</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">SL</th>
                <th style="width: 15%">PHO</th>
                <th style="width: 15%">Customer</th>
                <th style="width: 15%">Package</th>
                <th style="width: 10%">Date</th>
                <th style="width: 12%">Total</th>
                <th style="width: 12%">Paid</th>
                <th style="width: 12%">Due</th>
                <th style="width: 9%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packagePurchases as $index => $purchase)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $purchase->pho->name }}</td>
                <td>{{ $purchase->customer->name }}</td>
                <td>{{ $purchase->package->name }}</td>
                <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                <td class="text-right">৳{{ number_format($purchase->total_price, 2) }}</td>
                <td class="text-right">৳{{ number_format($purchase->paid_amount, 2) }}</td>
                <td class="text-right">৳{{ number_format($purchase->due_amount, 2) }}</td>
                <td class="text-center">
                    @if($purchase->payment_status == 'paid')
                        <span class="badge badge-success">Paid</span>
                    @elseif($purchase->payment_status == 'partial')
                        <span class="badge badge-warning">Partial</span>
                    @else
                        <span class="badge badge-danger">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y h:i A') }} | Prottoy Healthcare Management System</p>
        <p>© {{ date('Y') }} Prottoy Healthcare System. All rights reserved.</p>
    </div>
</body>
</html>
