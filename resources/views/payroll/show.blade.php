@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Payroll Details for {{ $payroll->user->name }}</h1>

    <div class="mb-6">
        <p><strong>Monthly Salary:</strong> {{ number_format($payroll->monthly_salary, 2) }}</p>
        <p><strong>Pay Period:</strong> {{ $payroll->pay_period_start->format('M d, Y') }} - {{ $payroll->pay_period_end->format('M d, Y') }}</p>
        <p><strong>Days Worked:</strong> {{ $daysWorked }}</p>
        <p><strong>Net Salary (Based on Attendance):</strong> {{ number_format($netSalary, 2) }}</p>
    </div>
    

    <h2 class="text-xl font-bold mb-2">Attendance Records</h2>
    <table class="min-w-full bg-white border rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Present</th>
                <th class="px-4 py-2 text-left">Overtime Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $attendance->date->format('M d, Y') }}</td>
                <td class="px-4 py-2">{{ $attendance->present ? 'Yes' : 'No' }}</td>
                <td class="px-4 py-2">{{ $attendance->overtime_hours }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
