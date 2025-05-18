@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Expense Reports</h1>

    <!-- Filters -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form action="{{ route('reports.expenses') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @foreach(range(date('Y'), date('Y')-5) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md w-full">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Current Month</h3>
            <p class="text-2xl font-bold text-gray-800">
                {{ number_format($currentMonthTotal, 2) }}
            </p>
            @if($previousMonthTotal != 0)
                <p class="text-sm mt-1 {{ $currentMonthTotal > $previousMonthTotal ? 'text-red-500' : 'text-green-500' }}">
                    @if($previousMonthTotal > 0)
                        {{ $currentMonthTotal > $previousMonthTotal ? '↑' : '↓' }}
                        {{ number_format(abs(($currentMonthTotal - $previousMonthTotal) / $previousMonthTotal * 100), 2) }}%
                        vs last month
                    @else
                        No previous data
                    @endif
                </p>
            @endif
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Year to Date</h3>
            <p class="text-2xl font-bold text-gray-800">
                {{ number_format($yearToDateTotal, 2) }}
            </p>
            @if($previousYearTotal != 0)
                <p class="text-sm mt-1 {{ $yearToDateTotal > $previousYearTotal ? 'text-red-500' : 'text-green-500' }}">
                    @if($previousYearTotal > 0)
                        {{ $yearToDateTotal > $previousYearTotal ? '↑' : '↓' }}
                        {{ number_format(abs(($yearToDateTotal - $previousYearTotal) / $previousYearTotal * 100), 2) }}%
                        vs last year
                    @else
                        No previous data
                    @endif
                </p>
            @endif
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Top Category</h3>
            <p class="text-2xl font-bold text-gray-800">
                {{ $topCategory->category ?? 'N/A' }}
            </p>
            <p class="text-sm text-gray-600 mt-1">
                {{ $topCategory ? number_format($topCategory->total, 2) : 0 }} ({{ $topCategory ? round(($topCategory->total / $currentMonthTotal) * 100, 2) : 0 }}%)
            </p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Trend Chart -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Monthly Expense Trend</h3>
            <div id="monthlyTrendChart"></div>
        </div>

        <!-- Category Breakdown Chart -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Category Breakdown</h3>
            <div id="categoryChart"></div>
        </div>
    </div>

    <!-- Expense Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-700">Detailed Expenses</h3>
            <div class="text-sm text-gray-500">
                Showing {{ $expenses->total() }} records
            </div>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded By</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($expenses as $expense)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ number_format($expense->amount, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $expense->category ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($expense->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->user->name ?? 'System' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No expenses found for the selected filters.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($expenses->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $expenses->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Monthly Trend Chart
    const monthlyTrendChart = new ApexCharts(document.querySelector("#monthlyTrendChart"), {
        series: [{
            name: 'Current Year',
            data: @json(array_values($monthlyTrendData['current_year']))
        }, {
            name: 'Previous Year',
            data: @json(array_values($monthlyTrendData['previous_year']))
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: {
            title: {
                text: 'Amount'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "k" + val.toFixed(2)
                }
            }
        },
        colors: ['#3B82F6', '#94A3B8'],
    });
    monthlyTrendChart.render();

    // Category Breakdown Chart
    const categoryChart = new ApexCharts(document.querySelector("#categoryChart"), {
        series: [{
            name: 'Amount',
            data: @json(array_column($categoryData, 'total'))
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: @json(array_column($categoryData, 'category')),
        },
        yaxis: {
            title: {
                text: 'Categories'
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "k" + val.toFixed(2)
                }
            }
        },
        colors: ['#10B981'],
    });
    categoryChart.render();
</script>

@endsection