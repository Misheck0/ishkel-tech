@extends('..layouts.SysAdmin.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">IT Manager Dashboard</h1>
        <div class="text-sm text-gray-500">
            Last updated: {{ now()->format('M j, Y H:i') }}
        </div>
    </div>

    <!-- Quick Access Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- User Management -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition duration-300">
            <div class="px-4 py-5 sm:p-6 flex items-center">
                <div class="rounded-full bg-indigo-100 p-3 mr-4">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                    <p class="mt-1 text-sm text-gray-500">Manage system users and permissions</p>
                </div>
            </div>
        </a>

        <!-- Audit Logs -->
      

        <!-- System Settings -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition duration-300">
            <div class="px-4 py-5 sm:p-6 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">System Settings</h3>
                    <p class="mt-1 text-sm text-gray-500">Configure application parameters</p>
                </div>
            </div>
        </a>

        <!-- Backup Management -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition duration-300">
            <div class="px-4 py-5 sm:p-6 flex items-center">
                <div class="rounded-full bg-red-100 p-3 mr-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Backup Management</h3>
                    <p class="mt-1 text-sm text-gray-500">Manage database backups</p>
                </div>
            </div>
        </a>
    </div>

    <!-- System Health Check -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">System Health Check</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Server Status -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-medium text-gray-900">Server Status</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Operational
                        </span>
                    </div>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">CPU Usage</span>
                            <span class="font-medium">24%</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Memory</span>
                            <span class="font-medium">1.2GB / 4GB</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Disk Space</span>
                            <span class="font-medium">45% used</span>
                        </div>
                    </div>
                </div>

                <!-- Sync Status -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-medium text-gray-900">Sync Status</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Last ERP Sync</span>
                            <span class="font-medium">2 min ago</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Failed Jobs (24h)</span>
                            <span class="font-medium text-red-600">3</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Queue Size</span>
                            <span class="font-medium">12</span>
                        </div>
                    </div>
                </div>

                <!-- Error Reports -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-medium text-gray-900">Error Reports</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Needs Review
                        </span>
                    </div>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Errors (24h)</span>
                            <span class="font-medium">8</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Critical</span>
                            <span class="font-medium text-red-600">2</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Last Occurrence</span>
                            <span class="font-medium">30 min ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Audit Trails -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
                <p class="mt-1 text-sm text-gray-500">System-wide changes in the last 24 hours</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            @if($activity->event === 'created')
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            @elseif($activity->event === 'updated')
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            @else
                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity->user->name ?? 'System' }} 
                                <span class="text-gray-500">{{ $activity->event }}d</span> 
                                {{ class_basename($activity->auditable_type) }} #{{ $activity->auditable_id }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                            @if($activity->event === 'updated')
                            <div class="mt-1 text-xs text-gray-500">
                                @foreach(array_keys($activity->new_values) as $field)
                                <span class="font-medium">{{ $field }}</span> changed
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        View all activity →
                    </a>
                </div>
            </div>
        </div>

        <!-- Audit Trails -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Audit Trails</h3>
                <p class="mt-1 text-sm text-gray-500">Critical changes requiring attention</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($auditTrails as $audit)
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $audit->user->name ?? 'System' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium 
                                        {{ $audit->event === 'created' ? 'bg-green-100 text-green-800' : 
                                           ($audit->event === 'updated' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($audit->event) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $audit->created_at->format('H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        View complete audit trail →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection