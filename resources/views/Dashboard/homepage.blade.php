@extends('layouts.app')
@section('title',Auth::user()->company->company_name )


@section('content')
<div class="space-y-6">
  <!-- Check if Invoice are empty or not -->
    @if($invoices->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">No Invoices Found</p>
            <p>You have no Quotation yet. Create one to get started!</p>
       
        </div>
        <button id="create" onclick="openInvoiceForm()" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>Create Quotation</span>
        </button>
    @else

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Invoices -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total  Quotation </p>
                    <p class="mt-1 text-3xl font-bold text-blue-600">{{ $stats['total_quotations'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
         <!-- Unpaid Quotation -->
      
        

        <!-- Unpaid Invoices -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Unpaid Quotation</p>
                    <p class="mt-1 text-3xl font-bold text-red-600">{{ $stats['unpaid_quotation'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-red-50 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">ZMW {{ number_format($stats['outstanding_amount'], 2) }} outstanding</p>
        </div>
        @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="mt-1 text-3xl font-bold text-green-600">ZMW {{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
@endif
        <!-- Paid Invoices -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Paid Invoices</p>
                    <p class="mt-1 text-3xl font-bold text-purple-600">{{ $stats['paid_invoices']}}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            @if($stats['paid_invoices'] > 0)
                <p class="mt-2 text-xs text-gray-500">{{ round(($stats['total_invoices'] - $stats['unpaid_quotation']) / $stats['paid_invoices'] * 100) }}% payment rate</p>
            @endif
        </div>
    </div>

    <!-- Recent Invoices Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Recent Quotation</h2>
            <button id="create" onclick="openInvoiceForm()" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Create Quotation</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quotation #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-blue-600">{{ $invoice->quotation_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-600 font-medium">{{ substr($invoice->customer->name, 0, 2) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">{{ $invoice->customer->name }}</div>
                                    <div class="text-gray-500">{{ $invoice->customer->email ?? 'No email' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium">ZMW {{ number_format($invoice->total_amount, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($invoice->status == 'paid')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unpaid</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $invoice->created_at->format('d-M-Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                            @if($invoice->status == 'unpaid')
                            <form action="{{ route('invoices.mark-paid', $invoice->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                                    Mark as Paid
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                {{ $invoices->links() }}   
            </div>
        </div>

        <!-- Table Footer/Pagination -->
       
    </div>
@endif
</div>
@endsection

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
            <input type="text" id="customer_name" name="customer_name" list="customer-suggestions"
       placeholder="Enter customer name"
       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
<datalist id="customer-suggestions"></datalist>
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

<script>
   document.getElementById('create').addEventListener('click',function () {
        const nameInput = document.getElementById('customer_name');
        const phoneInput = document.getElementById('customer_phone');
        const tpinInput = document.getElementById('customer_tpin');
    
        if (!nameInput || !phoneInput || !tpinInput) {
            console.warn("Customer input fields not found in DOM.");
            return;
        }
    
        let timeout = null;
    
        nameInput.addEventListener('input', function () {
            const query = this.value;
    
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (query.length >= 2) {
                    fetch(`{{ route('customer.suggest') }}?term=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const datalist = document.getElementById('customer-suggestions');
                        datalist.innerHTML = '';
                        data.forEach(customer => {
                            const option = document.createElement('option');
                            option.value = customer.name;
                            option.dataset.phone = customer.number;
                            option.dataset.tpin = customer.customer_tpin;
                            datalist.appendChild(option);
                        });
                    });
                }
            }, 300);
        });
    
        nameInput.addEventListener('change', function () {
  const inputValue = this.value;
  const options = document.getElementById('customer-suggestions').children;
  let matched = false;

  for (let option of options) {
    if (option.value === inputValue) {
      phoneInput.value = option.dataset.phone || '';
      tpinInput.value = option.dataset.tpin || '';
      matched = true;
      break;
    }
  }

  if (!matched) {
    phoneInput.value = '';
    tpinInput.value = '';
  }
});

    });
    </script>
    


    @endsection