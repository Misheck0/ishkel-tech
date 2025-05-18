<!DOCTYPE html>
<html>
<head>
    <title>Report Summary PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Invoice Summary Report</h2>
    <p>Period: {{ ucfirst($period) }} ({{ $startDate->toDateString() }} to {{ $endDate->toDateString() }})</p>

    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Paid</th>
                <th>Unpaid</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData as $month)
                <tr>
                    <td>{{ $month['month'] }}</td>
                    <td>{{ number_format($month['paid'], 2) }}</td>
                    <td>{{ number_format($month['unpaid'], 2) }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
