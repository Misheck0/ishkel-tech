@extends('layouts.app')
@section('title','Report')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <!-- Header -->
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">ISHKEL TECH ENTERPRISES</h1>
                <p class="text-gray-600">Invoice Performance Dashboard</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form method="GET" action="{{ route('reports.index') }}" class="flex items-center space-x-2">
                    <label for="period" class="text-sm font-medium text-gray-700">Report Period:</label>
                    <select name="period" id="period" onchange="this.form.submit()"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </form>
                <p class="text-xs text-gray-500 mt-1">
                    Showing data from {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
                </p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Total Revenue</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ number_format($currentPaid * 0.05 , 2) }} ZMW
                        </p>
                        <div class="mt-2 flex items-center text-sm {{ $totalChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            @if($totalChange >= 0)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            <span class="ml-1">{{ number_format(abs($totalChange), 2) }}% vs previous period</span>
                        </div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Paid Invoices -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Paid Invoices</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ number_format($currentPaid, 2) }} ZMW
                        </p>
                        <div class="mt-2 flex items-center text-sm {{ $paidChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            @if($paidChange >= 0)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            <span class="ml-1">{{ number_format(abs($paidChange), 2) }}% vs previous period</span>
                        </div>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Unpaid Invoices -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Unpaid Quotation</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ number_format($currentUnpaid, 2) }} ZMW
                        </p>
                        <div class="mt-2 flex items-center text-sm {{ $unpaidChange <= 0 ? 'text-green-600' : 'text-red-600' }}">
                            @if($unpaidChange <= 0)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            <span class="ml-1">{{ number_format(abs($unpaidChange), 2) }}% vs previous period</span>
                        </div>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Partially Paid -->
           
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Monthly Performance Chart -->
            <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">12-Month Performance Trend</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100">
                            Export
                        </button>
                    </div>
                </div>
                <div id="monthlyPerformanceChart"></div>
            </div>

            <!-- Payment Status Distribution -->
           <!-- Payment Status Distribution -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Status Distribution</h2>
    <div class="h-80 flex items-center justify-center">
        <div id="paymentStatusChart" class="w-full"></div>
    </div>
    <div class="mt-4 flex flex-wrap justify-center gap-x-6 gap-y-2">
        <div class="flex items-center">
            <div class="h-3 w-3 rounded-full bg-green-500 mr-2"></div>
            <span class="text-xs text-gray-600">Paid ({{ number_format($currentPaid, 2) }} ZMW)</span>
        </div>
        <div class="flex items-center">
            <div class="h-3 w-3 rounded-full bg-red-500 mr-2"></div>
            <span class="text-xs text-gray-600">Unpaid ({{ number_format($currentUnpaid, 2) }} ZMW)</span>
        </div>
      
    </div>
</div>
        </div>

        <!-- Additional Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Performance Highlights -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Performance Highlights</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mt-1">
                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Average Invoice Value</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ number_format($currentTotal/max(1, $currentInvoices->count()), 2) }} ZMW
                            </p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mt-1">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Collection Rate</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $currentTotal > 0 ? number_format(($currentPaid/$currentTotal)*100, 2) : 0 }}%
                            </p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mt-1">
                            <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Total Invoices Processed</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $currentInvoices->count() }}
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Top Customers -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Top Customers</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse($topCustomers as $customer)
                    <li class="py-4 flex items-center justify-between hover:bg-gray-50 px-2 rounded">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $customer->invoices_count }} invoices</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-indigo-600">
                            {{ number_format($customer->total_spent, 2) }} ZMW
                        </span>
                    </li>
                    @empty
                    <li class="py-4 text-center text-gray-500">No customer data available</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Overdue Invoices -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Overdue Quotation </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($overDueInvoices->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No overdue invoices found</td>
                        </tr>
                        @else
                        @foreach($overDueInvoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    {{ $invoice->deadline->format('Y-m-d') }}
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        @php
                                        $daysDiff = (int) now()->diffInDays(\Carbon\Carbon::parse($invoice->deadline), false);
                                    @endphp
                                    
                                    @if ($daysDiff < 0)
                                        <span class="text-red-600">{{ abs($daysDiff) }} days overdue</span>
                                    @elseif ($daysDiff === 0)
                                        <span class="text-yellow-600">Due today</span>
                                    @else
                                        <span class="text-green-600">{{ $daysDiff }} days left</span>
                                    @endif
                                    
                                    


                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($invoice->status == 'partially_paid' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                {{ number_format($invoice->total_amount, 2) }} zmw
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
      <!-- Export Options -->
      <div class="flex justify-end space-x-2">
        <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded">Print</button>
        <a href="{{ route('reports.export.pdf', ['period' => $period]) }}" class="bg-red-600 text-white px-4 py-2 rounded">Export PDF</a>
        <a href="{{ route('reports.export.excel', ['period' => $period]) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Export Excel</a>
    </div>
</div>

@section('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Monthly Performance Chart
    var monthlyOptions = {
        series: [{
            name: 'Paid',
            data: @json(array_column($monthlyData, 'paid'))
        }, {
            name: 'Unpaid',
            data: @json(array_column($monthlyData, 'unpaid'))
        },],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 4,
                columnWidth: '70%',
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        xaxis: {
            type: 'category',
            categories: @json(array_column($monthlyData, 'month')),
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return val.toLocaleString() + ' ZMW';
                }
            }
        },
        colors: ['#10B981', '#EF4444', '#F59E0B'],
        legend: {
            position: 'top',
            fontSize: '14px'
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val.toLocaleString() + ' ZMW';
                }
            }
        },
        dataLabels: {
            enabled: false
        }
    };

    var monthlyChart = new ApexCharts(document.querySelector("#monthlyPerformanceChart"), monthlyOptions);
    monthlyChart.render();

    // Payment Status Distribution Chart
// Payment Status Distribution Chart
var paymentStatusOptions = {
    series: [
        parseFloat({{ $currentPaid }}), 
        parseFloat({{ $currentUnpaid }}), 
       
    ],
    chart: {
        type: 'donut',
        height: '100%',
        width: '100%'
    },
    labels: ['Paid', 'Unpaid'],
    colors: ['#10B981', '#EF4444', '#F59E0B'],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: '100%'
            },
            legend: {
                position: 'bottom'
            }
        }
    }],
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        color: '#6B7280',
                        formatter: function (w) {
                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('en-US') + ' ZMW';
                        }
                    },
                    value: {
                        color: '#111827',
                        formatter: function(val) {
                            return parseFloat(val).toLocaleString('en-US') + ' ZMW';
                        }
                    }
                }
            }
        }
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center'
    },
    dataLabels: {
        enabled: false
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return parseFloat(val).toLocaleString('en-US') + ' ZMW';
            }
        }
    }
};

var paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"), paymentStatusOptions);
paymentStatusChart.render();
</script>
@endsection
@endsection