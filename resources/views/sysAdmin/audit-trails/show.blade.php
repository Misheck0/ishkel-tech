@extends('..layouts.SysAdmin.app')

@section('title', 'Audit Trail Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-xl font-semibold text-gray-800">Audit Trail Details</h1>
        </div>
        
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Action</h3>
                <p class="mt-1 text-sm text-gray-900">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $auditTrail->action == 'created' ? 'bg-green-100 text-green-800' : 
                           ($auditTrail->action == 'updated' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($auditTrail->action) }}
                    </span>
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">Model</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ class_basename($auditTrail->model_type) }} #{{ $auditTrail->model_id }}
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">User</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $auditTrail->user->name ?? 'System' }}
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">Date & Time</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $auditTrail->created_at->format('Y-m-d H:i:s') }}
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">IP Address</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $auditTrail->ip_address }}
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">User Agent</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $auditTrail->user_agent }}
                </p>
            </div>
        </div>
        
        @if($auditTrail->old_values || $auditTrail->new_values)
        <div class="px-6 py-4 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Changes</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Before</h4>
                    @if($auditTrail->old_values)
                        <div class="bg-gray-50 p-4 rounded-md">
                            @foreach($auditTrail->old_values as $key => $value)
                                <div class="mb-2">
                                    <span class="font-medium">{{ $key }}:</span>
                                    <span class="ml-2">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No data</p>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">After</h4>
                    @if($auditTrail->new_values)
                        <div class="bg-gray-50 p-4 rounded-md">
                            @foreach($auditTrail->new_values as $key => $value)
                                <div class="mb-2">
                                    <span class="font-medium">{{ $key }}:</span>
                                    <span class="ml-2">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No data</p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection