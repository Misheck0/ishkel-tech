@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendance Reports</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <form action="{{ route('reports.attendance') }}" method="GET" class="flex items-end gap-4">
                <div class="flex-1">
                    <label for="employee" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <select name="employee" id="employee" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">All Employees</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('employee') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <div class="flex gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-3 py-2 border border-gray-300 rounded-md">
                        <span class="flex items-center">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Filter
                </button>
            </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overtime</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($attendances as $attendance)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($attendance->present)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->overtime_hours }} hours</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $attendances->links() }}
    </div>
</div>
@endsection