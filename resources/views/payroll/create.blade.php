@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Payroll Record</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('payroll.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <select name="user_id" id="user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Employee</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="monthly_salary" class="block text-sm font-medium text-gray-700 mb-1">Monthly Salary</label>
                    <input type="number" step="0.01" name="monthly_salary" id="monthly_salary" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="overtime_rate" class="block text-sm font-medium text-gray-700 mb-1">Overtime Rate (per hour)</label>
                    <input type="number" step="0.01" name="overtime_rate" id="overtime_rate" min="0" value="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="pay_period_start" class="block text-sm font-medium text-gray-700 mb-1">Pay Period Start</label>
                    <input type="date" name="pay_period_start" id="pay_period_start" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="pay_period_end" class="block text-sm font-medium text-gray-700 mb-1">Pay Period End</label>
                    <input type="date" name="pay_period_end" id="pay_period_end" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('payroll.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md mr-3 transition duration-300">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300">
                    Create Payroll
                </button>
            </div>
        </form>
    </div>
</div>
@endsection