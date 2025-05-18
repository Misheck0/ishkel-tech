@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Payroll Records</h1>
        <a href="{{ route('payroll.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300">
            Create New Payroll
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Worked</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payrolls as $payroll)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $payroll->pay_period_start->format('M d') }} - {{ $payroll->pay_period_end->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->calculated_days_worked }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payroll->is_paid)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if(!$payroll->is_paid)
                            <form action="{{ route('payroll.mark-paid', $payroll->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Mark Paid</button>
                            </form>
                        @endif
                        <a href="{{ route('payroll.show', $payroll->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No payroll records found.</td>
                </tr>
                @endforelse
            </tbody>
            
        </table>
    </div>

    <div class="mt-4">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection