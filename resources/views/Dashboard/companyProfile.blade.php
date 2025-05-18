@extends('layouts.app')
@section('title', 'Company Profile')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Toggle Header -->
    <div class="flex border-b border-gray-200 mb-6">
        <button id="companyTab" class="py-4 px-6 font-medium text-sm focus:outline-none border-b-2 border-indigo-500 text-indigo-600">
            Company Profile
        </button>
        <button id="usersTab" class="py-4 px-6 font-medium text-sm focus:outline-none text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
            Users
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@elseif(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

    <!-- Company Profile Section (Default Visible) -->
    <div id="companySection" class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Company Information</h3>
            <p class="mt-1 text-sm text-gray-500">Basic details about your company.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company Name</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $company->company_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company TPIN</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $company->tpin }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $company->address }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company Email</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $company->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $company->number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('companies.edit', $company->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit Company Details
                </a>
            </div>
        </div>
    </div>

    <!-- Users Section (Hidden by Default) -->
    <div id="usersSection" class="bg-white shadow overflow-hidden sm:rounded-lg hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Company Users</h3>
            <p class="mt-1 text-sm text-gray-500">All users associated with your company.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center gap-2">
                                <!-- Status badge -->
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            
                                <!-- Toggle Status Button -->
                                <form action="{{ route('admin.toggleStatus', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="ml-2 px-3 py-1 text-xs font-medium rounded bg-blue-100 text-blue-800 hover:bg-blue-200">
                                        {{ $user->status ? 'Revoke Access' : 'Grant Access' }}
                                    </button>
                                </form>
                            
                                <!-- Optional: Role Dropdown -->
                                <form action="{{ route('admin.changeRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="ml-2 px-2 py-1 text-xs rounded border border-gray-300">
                                        <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">User</option>
                                        <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                        <option {{ $user->role == 'super_admin' ? 'selected' : '' }} value="super_admin">Super Admin</option>
                                        <option {{ $user->role == 'customer' ? 'selected' : '' }} value="customer">customer</option>  
                                    </select>
                                </form>
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                No users found for this company.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const companyTab = document.getElementById('companyTab');
    const usersTab = document.getElementById('usersTab');
    const companySection = document.getElementById('companySection');
    const usersSection = document.getElementById('usersSection');

    // Switch to Company Profile tab
    companyTab.addEventListener('click', function() {
        companyTab.classList.add('border-indigo-500', 'text-indigo-600');
        companyTab.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        usersTab.classList.remove('border-indigo-500', 'text-indigo-600');
        usersTab.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        companySection.classList.remove('hidden');
        usersSection.classList.add('hidden');
    });

    // Switch to Users tab
    usersTab.addEventListener('click', function() {
        usersTab.classList.add('border-indigo-500', 'text-indigo-600');
        usersTab.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        companyTab.classList.remove('border-indigo-500', 'text-indigo-600');
        companyTab.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        usersSection.classList.remove('hidden');
        companySection.classList.add('hidden');
    });
});
</script>
@endsection
@endsection