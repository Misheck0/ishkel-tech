@extends('layouts.app')

@section('title', ' Quotation')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"> Quotation Management</h1>
        <button onclick="openInvoiceForm()" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>Create   Quotation</span>
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

   

    <!-- Invoices Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quotation #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-blue-600">{{ $invoice->quotation_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $invoice->customer->name }}</div>
                            <div class="text-sm text-gray-500">{{ $invoice->customer->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $invoice->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->type == 'invoice' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($invoice->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ZMW {{ number_format($invoice->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No invoices found matching your criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($invoices->hasPages())
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $invoices->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openInvoiceForm() {
        Swal.fire({
            title: 'Create New Quotation',
            width: '800px',
            html: `
              <div class="text-left space-y-4">
    <!-- Customer Information Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Customer Phone</label>
            <input type="tel" id="customer_phone" name="customer_phone" placeholder="Enter phone number"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
        </div>
          <div>
            <label for="customer_tpin" class="block text-sm font-medium text-gray-700 mb-1">Customer TPIN</label>
            <input type="number" id="customer_tpin" name="customer_tpin"  placeholder="Enter TPIN"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
        </div>
    </div>

    <!-- Items Section -->
    <div class="border-t pt-4">
        <h3 class="text-sm font-medium text-gray-700 mb-2">Items</h3>
        <div id="items-container">
            <div class="grid grid-cols-12 gap-4 mb-2">
                <div class="col-span-5">
                    <input type="text" name="items[0][description]" placeholder="Description" 
                           class="item-description w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[0][quantity]" placeholder="Qty" min="1" step="1"
                           class="item-qty w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[0][unit_price]" placeholder="Price" min="0" step="0.01"
                           class="item-price w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="col-span-2 flex items-center">
                    <span class="item-amount">0.00</span>
                </div>
                <div class="col-span-1 flex items-center justify-center">
                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <button type="button" id="add-item" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Item
        </button>
    </div>

    <!-- Totals Section -->
    <div class="border-t pt-4">
        <div class="flex justify-end">
            <div class="w-1/3 space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                    <span id="subtotal">0.00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-700">Tax (0%):</span>
                    <span id="tax">0.00</span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span class="text-sm font-bold text-gray-700">Total:</span>
                    <span id="total" class="font-bold">0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save Invoice',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const customerName = document.getElementById('customer_name').value;
                const customerNumber = document.getElementById('customer_phone').value;
                const customerTPIN = document.getElementById('customer_tpin').value;
                // Validate required fields
                if (!customerName) {
                    Swal.showValidationMessage('Customer name is required');
                    return false;
                }
                
                // Collect items data
                const items = [];
                document.querySelectorAll('#items-container > div').forEach(itemRow => {
                    const description = itemRow.querySelector('.item-description').value;
                    const qty = itemRow.querySelector('.item-qty').value;
                    const price = itemRow.querySelector('.item-price').value;
                    
                    if (description && qty && price) {
                        items.push({
                            description: description,
                            quantity: parseFloat(qty),
                            unit_price: parseFloat(price)
                        });
                    }
                });
                
                if (items.length === 0) {
                    Swal.showValidationMessage('Please add at least one item');
                    return false;
                }
                
                return {
                    customer_name: customerName,
                    items: items,
                    customer_tpin: customerTPIN,
                    customer_phone: customerNumber
                };
            },
            didOpen: () => {
                // Add item calculation logic
                document.querySelectorAll('#items-container .item-qty, #items-container .item-price').forEach(input => {
                    input.addEventListener('input', calculateItemAmount);
                });
                
                // Add item button
                document.getElementById('add-item').addEventListener('click', addNewItemRow);
                
                // Remove item button
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-item')) {
                        e.target.closest('#items-container > div').remove();
                        calculateTotals();
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Creating Invoice...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send to server
                fetch("{{ route('invoice.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(result.value)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Quotation Created!',
                        text: 'Quotation has been successfully created',
                        willClose: () => {
                            window.location.href = `/user/dashboard`;
                        }
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Failed to create invoice'
                    });
                });
            }
        });
    }
    
    function addNewItemRow() {
        const container = document.getElementById('items-container');
        const newItem = document.createElement('div');
        newItem.className = 'grid grid-cols-12 gap-4 mb-2';
        newItem.innerHTML = `
            <div class="col-span-5">
                <input type="text" placeholder="Description" class="item-description w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <input type="number" placeholder="Qty" class="item-qty w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <input type="number" placeholder="Price" class="item-price w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2 flex items-center">
                <span class="item-amount">0.00</span>
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        
        // Add event listeners to new inputs
        newItem.querySelector('.item-qty').addEventListener('input', calculateItemAmount);
        newItem.querySelector('.item-price').addEventListener('input', calculateItemAmount);
    }
    
    function calculateItemAmount(e) {
        const row = e.target.closest('#items-container > div');
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
      //  const amount = price; //if a user calculates the amount manually, this will be the amount 
        // if you want to calculate amount as price * qty, uncomment the next line 
        const amount = qty * price; //this automatically calculates the amount
     
       
        row.querySelector('.item-amount').textContent = amount.toFixed(2);
        calculateTotals();
    }
    
    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('#items-container > div').forEach(row => {
            const amount = parseFloat(row.querySelector('.item-amount').textContent) || 0;
            subtotal += amount;
        });
        
        const tax = subtotal * 0.00; // 5% tax rate
        const total = subtotal + tax;
        
        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('tax').textContent = tax.toFixed(2);
        document.getElementById('total').textContent = total.toFixed(2);
    }
</script>
@endsection
@endsection