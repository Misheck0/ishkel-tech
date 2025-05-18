@extends('layouts.app')
@section('title','Report')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Invoice Report ({{ ucfirst($period) }})</h1>
        <div class="space-x-2">
            <a href="?period=weekly" class="btn btn-sm {{ $period == 'weekly' ? 'bg-blue-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">Weekly</a>
            <a href="?period=monthly" class="btn btn-sm {{ $period == 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">Monthly</a>
            <a href="?period=yearly" class="btn btn-sm {{ $period == 'yearly' ? 'bg-blue-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">Yearly</a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Paid</h2>
            <p class="text-2xl font-bold text-green-600">ZMW{{ number_format($currentPaid, 2) }}</p>
            <p class="text-sm text-gray-500">Change: {{ round($paidChange, 2) }}%</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Unpaid</h2>
            <p class="text-2xl font-bold text-red-600">ZMW{{ number_format($currentUnpaid, 2) }}</p>
            <p class="text-sm text-gray-500">Change: {{ round($unpaidChange, 2) }}%</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Total</h2>
            <p class="text-2xl font-bold text-blue-600">ZMW{{ number_format($currentTotal, 2) }}</p>
            <p class="text-sm text-gray-500">Change: {{ round($totalChange, 2) }}%</p>
        </div>
    </div>

    <!-- Monthly Summary Chart -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <h3 class="text-xl font-semibold mb-4">Monthly Invoice Summary</h3>
        <div id="monthly-chart"></div>
    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <h3 class="text-xl font-semibold mb-4">Top 5 Customers</h3>
        <ul>
            @foreach($topCustomers as $customer)
                <li class="mb-2">{{ $customer->name }} - ZMW{{ number_format($customer->total_spent, 2) }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Overdue Invoices Table -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <h3 class="text-xl font-semibold mb-4">Overdue Quotation</h3>
        <table class="w-full table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border">Quotation #</th>
                    <th class="px-2 py-1 border">Customer</th>
                    <th class="px-2 py-1 border">Amount</th>
                    <th class="px-2 py-1 border">Deadline</th>
                </tr>
            </thead>
            <tbody>
                @forelse($overDueInvoices as $invoice)
                    <tr class="text-sm text-gray-700">
                        <td class="border px-2 py-1">{{ $invoice->quotation_id ?? 'N/A' }}</td>
                        <td class="border px-2 py-1">{{ $invoice->customer->name }}</td>
                        <td class="border px-2 py-1">ZMW{{ number_format($invoice->total_amount, 2) }}</td>
                        <td class="border px-2 py-1 text-red-600">{{ $invoice->deadline->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-2">No overdue invoices.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Export Options -->
     <!-- Export Options -->
     <div class="flex justify-end space-x-2">
        <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded">Print</button>
        <a href="{{ route('reports.export.pdf', ['period' => $period]) }}" class="bg-red-600 text-white px-4 py-2 rounded">Export PDF</a>
        <a href="{{ route('reports.export.excel', ['period' => $period]) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Export Excel</a>
    </div>
</div>
</div>

<!-- ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'bar',
            stacked: true,
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: @json(array_column($monthlyData, 'month')),
        },
        yaxis: {
            title: {
                text: 'Amount'
            }
        },
        series: [
            {
                name: 'Paid',
                data: @json(array_column($monthlyData, 'paid')),
            },
            {
                name: 'Unpaid',
                data: @json(array_column($monthlyData, 'unpaid')),
            },
            {
                name: 'Partially Paid',
                data: @json(array_column($monthlyData, 'partially_paid')),
            }
        ],
        colors: ['#34D399', '#F87171', '#FBBF24'],
        legend: {
            position: 'top'
        }
    };
    var chart = new ApexCharts(document.querySelector("#monthly-chart"), options);
    chart.render();
</script>
@endsection
