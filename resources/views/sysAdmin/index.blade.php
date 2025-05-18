@extends('layouts.SysAdmin.app')

@section('title', 'Audit Trails')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Audit Trails</h1>
        <div class="flex space-x-2">
            <form method="GET" class="flex items-center space-x-2">
                <select name="model_type" class="border-gray-300 rounded-md">
                    <option value="">All Models</option>
                    <option value="App\Models\Invoice" {{ request('model_type') == 'App\Models\Invoice' ? 'selected' : '' }}>Invoices</option>
                </select>
                <select name="action" class="border-gray-300 rounded-md">
                    <option value="">All Actions</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($trails as $trail)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $trail->action == 'created' ? 'bg-green-100 text-green-800' : 
                               ($trail->action == 'updated' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($trail->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ class_basename($trail->model_type) }} #{{ $trail->model_id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $trail->user->name ?? 'System' }}</div>
                        <div class="text-sm text-gray-500">{{ $trail->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($trail->old_values && $trail->new_values)
                            <div class="text-sm text-gray-500">
                                @foreach($trail->old_values as $key => $value)
                                    <div>{{ $key }}: {{ $value }} → {{ $trail->new_values[$key] ?? '' }}</div>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $trail->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('audit-trails.show', $trail) }}" class="text-blue-600 hover:text-blue-900">Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $trails->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection