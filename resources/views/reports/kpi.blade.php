@extends('layouts.app')
@section('title','KPI Report')

@section('content')
@php
    // Helper function to format currency
    function formatCurrency($amount) {
        return number_format($amount, 2);
    }
    
    // Helper function to determine trend arrow and color
    function getTrendIndicator($change) {
        if ($change > 0) {
            return [
                'icon' => '↑',
                'color' => 'text-green-500',
                'bg' => 'bg-green-50',
                'text' => 'Increase'
            ];
        } elseif ($change < 0) {
            return [
                'icon' => '↓',
                'color' => 'text-red-500',
                'bg' => 'bg-red-50',
                'text' => 'Decrease'
            ];
        } else {
            return [
                'icon' => '→',
                'color' => 'text-gray-500',
                'bg' => 'bg-gray-50',
                'text' => 'No change'
            ];
        }
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Paid Invoices Card -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Paid Invoices</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">ZMW{{ formatCurrency($currentPaid) }}</p>
            </div>
            @php $paidTrend = getTrendIndicator($paidChange); @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paidTrend['bg'] }} {{ $paidTrend['color'] }}">
                {{ abs($paidChange) }}% {{ $paidTrend['icon'] }}
            </span>
        </div>
        <p class="mt-2 text-sm text-gray-500">
            <span class="{{ $paidTrend['color'] }}">{{ $paidTrend['text'] }}</span> from previous period
        </p>
    </div>

    <!-- Unpaid Invoices Card -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Unpaid Invoices</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">ZMW{{ formatCurrency($currentUnpaid) }}</p>
            </div>
            @php $unpaidTrend = getTrendIndicator($unpaidChange); @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $unpaidTrend['bg'] }} {{ $unpaidTrend['color'] }}">
                {{ abs($unpaidChange) }}% {{ $unpaidTrend['icon'] }}
            </span>
        </div>
        <p class="mt-2 text-sm text-gray-500">
            <span class="{{ $unpaidTrend['color'] }}">{{ $unpaidTrend['text'] }}</span> from previous period
        </p>
    </div>

    <!-- Total Revenue Card -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">ZMW{{ formatCurrency($currentTotal) }}</p>
            </div>
            @php $totalTrend = getTrendIndicator($totalChange); @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $totalTrend['bg'] }} {{ $totalTrend['color'] }}">
                {{ abs($totalChange) }}% {{ $totalTrend['icon'] }}
            </span>
        </div>
        <p class="mt-2 text-sm text-gray-500">
            <span class="{{ $totalTrend['color'] }}">{{ $totalTrend['text'] }}</span> from previous period
        </p>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Trends</h3>
    <div class="h-80">
        <canvas id="revenueChart"></canvas>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const monthlyData = @json($monthlyData);
        
        const labels = monthlyData.map(item => item.month);
        const paidData = monthlyData.map(item => item.paid);
        const unpaidData = monthlyData.map(item => item.unpaid);
        const partiallyPaidData = monthlyData.map(item => item.partially_paid);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Paid',
                        data: paidData,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Unpaid',
                        data: unpaidData,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                 
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ZMW' + context.raw.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'ZMW' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
