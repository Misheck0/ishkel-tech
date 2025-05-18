@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"></h1>
        <button onclick="openAddCustomerForm()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Grant Dashboard Access
        </button>
    </div>

    <!-- Customer Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transactions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dashboard Access</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    </tr>
                @if($customers->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No customers found.
                        </td>
                    </tr>
                @endif


                    @foreach($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">
                                        {{ substr($customer->name, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->tpin ?? 'No TPIN' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->email ?? 'No email' }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->number ?? 'No phone' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $customer->invoices_count }} transactions
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            ZMW {{ number_format($customer->invoices_sum_total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($customer->user)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    No access
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($customer->user)
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">View Access</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Revoke</a>
                            @else
                                <button onclick="openAddCustomerForm({{ $customer->id }}, '{{ $customer->name }}', '{{ $customer->email }}')" 
                                        class="text-green-600 hover:text-green-900">
                                    Grant Access
                                </button>
                            @endif
                        </td>
                    </tr>
                    
                    @endforeach
                   
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add Customer Access Modal -->
<div id="customer-access-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <form id="customer-access-form" method="POST" action="{{ route('admin.customers.grant-access') }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Grant Dashboard Access</h3>
                    <div class="space-y-4">
                        <input type="hidden" name="customer_id" id="modal-customer-id">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="modal-customer-name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="modal-customer-email" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="modal-customer-role" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="customer" selected>Customer</option>
                                <option value="employer">Employer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Grant Access
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function openAddCustomerForm(customerId = null, name = '', email = '') {
        const modal = document.getElementById('customer-access-modal');
        const form = document.getElementById('customer-access-form');
        
        // Set form values
        document.getElementById('modal-customer-id').value = customerId || '';
        document.getElementById('modal-customer-name').value = name || '';
        document.getElementById('modal-customer-email').value = email || '';
        document.getElementById('modal-customer-role').value = 'customer';
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('block');
    }
    
    function closeModal() {
        const modal = document.getElementById('customer-access-modal');
        modal.classList.remove('block');
        modal.classList.add('hidden');
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('customer-access-modal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endsection
@endsection