@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daily Attendance ({{ $date }})</h1>
        <div class="mb-6 flex items-center gap-4">
            <label for="date" class="text-sm font-semibold">Select Date:</label>
            <input type="date" name="date" id="date" value="{{ $date }}" class="border rounded px-2 py-1">
        </div>
        
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 text-yellow-700 p-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif
    </div>

    @if($attendances->isEmpty())
        <p class="text-gray-600">All employees have been marked for today.</p>
    @else
    <form action="{{ route('attendance.update') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overtime Hours</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->user->name  }}
                            <input type="hidden" name="attendance[{{ $attendance->user->id }}][user_id]" value="{{ $attendance->user->id  }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($attendance->user->role) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="hidden" name="attendance[{{ $attendance->user->id  }}][present]" value="0">
                            <input type="checkbox" name="attendance[{{$attendance->user->id }}][present]" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="number" name="attendance[{{ $attendance->user->id  }}][overtime_hours]" value="0" class="w-20 px-2 py-1 border border-gray-300 rounded">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-300">
                Save Attendance
            </button>
        </div>
    </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');

        dateInput.addEventListener('change', function () {
            const selectedDate = this.value;
            if (selectedDate) {
                window.location.href = `/attendance?date=${selectedDate}`;
            }
        });
    });
</script>

@endsection
