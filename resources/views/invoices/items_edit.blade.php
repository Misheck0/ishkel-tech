@extends('layouts.app')
@section('title', 'Invoice item')
@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Invoice Items</h2>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.invoice.items.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="text-left space-y-4">

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ $invoice->customer->name }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Items</h3>
                    <div id="items-container">

                        @foreach($invoice->items as $item)
                        <div class="grid grid-cols-12 gap-4 mb-2 item-row">
                            <div class="col-span-5">
                                <input type="text" name="items[{{ $loop->index }}][description]" placeholder="Description"
                                    value="{{ $item->description }}" 
                                    class="item-description w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="col-span-2">
                                <input type="number" name="items[{{ $loop->index }}][quantity]" placeholder="Qty"
                                    value="{{ $item->quantity }}" 
                                    class="item-qty w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="col-span-2">
                                <input type="number" name="items[{{ $loop->index }}][unit_price]" placeholder="Price"
                                    value="{{ $item->unit_price }}" 
                                    class="item-price w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="col-span-2 flex items-center">
                                <span class="item-amount">{{ number_format($item->total_price, 2) }}</span>
                            </div>
                            <div class="col-span-1 flex items-center justify-center">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                              a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <button type="button" id="add-item" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Item
                    </button>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-end">
                        <div class="w-1/3 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                <span id="subtotal">0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Tax (5%):</span>
                                <span id="tax">0.00</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="text-sm font-bold text-gray-700">Total:</span>
                                <span id="total" class="font-bold">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md">
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
// Similar logic to your "Add Item" and "Calculate" functionality
let index = {{ $invoice->items->count() }};

document.getElementById('add-item').addEventListener('click', function () {
    const container = document.getElementById('items-container');
    const div = document.createElement('div');
    div.classList.add('grid', 'grid-cols-12', 'gap-4', 'mb-2', 'item-row');
    div.innerHTML = `
        <div class="col-span-5">
            <input type="text" name="items[${index}][description]" placeholder="Description" 
                class="item-description w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="col-span-2">
            <input type="number" name="items[${index}][quantity]" placeholder="Qty" 
                class="item-qty w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="col-span-2">
            <input type="number" name="items[${index}][unit_price]" placeholder="Price" 
                class="item-price w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="col-span-2 flex items-center">
            <span class="item-amount">0.00</span>
        </div>
        <div class="col-span-1 flex items-center justify-center">
            <button type="button" class="remove-item text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                          m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    `;
    container.appendChild(div);
    index++;
});

// Remove item
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        e.target.closest('.item-row').remove();
        calculateTotal();
    }
});

// Calculate subtotal, tax, total
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
        calculateTotal();
    }
});

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
        const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
        const amount = qty * price;
        row.querySelector('.item-amount').innerText = amount.toFixed(2);
        subtotal += amount;
    });
    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    const tax = subtotal * 0.05;
    document.getElementById('tax').innerText = tax.toFixed(2);
    document.getElementById('total').innerText = (subtotal + tax).toFixed(2);
}

// Initial calculation
calculateTotal();
</script>
@endsection
