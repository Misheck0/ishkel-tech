@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Add Customer Orders</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
    @endif
    <form id="invoiceOrderForm" method="POST" action="{{ route('invoice.orders.store') }}">
        @csrf
    
        <div class="mb-4">
            <label for="quotation_id" class="block text-sm font-medium">Select Quotation</label>
            <select name="quotation_id" id="quotation_id" class="w-full border rounded p-2" required>
                <option value="">-- Select Quotation --</option>
                @foreach($quotations as $quotation)
                    <option value="{{ $quotation->id }}" data-amount="{{ $quotation->total_amount }}" data-invoice="{{ $quotation->invoice_number }}">
                        #{{ $quotation->invoice_number }} - {{ $quotation->customer->name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <input type="hidden" name="invoice_number" id="invoice_number">
        <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $quotation->id }}">
        <div class="mb-4">
            <label class="block text-sm font-medium">Total Sale Price</label>
            <input type="number" step="0.01" id="total_sale_price" name="total_sale_price" readonly class="border p-2 rounded w-full bg-gray-100 text-gray-700">
        </div>
    
        <div id="order-items" class="space-y-4">
            <div class="order-item border p-4 rounded bg-gray-50">
                <div class="grid grid-cols-2 gap-4 items-center">
                    <input type="number" step="0.01" name="orders[0][actual_price]" class="actual_price border p-2 rounded" placeholder="Actual Price" required>
                    <input type="number" step="0.01" name="orders[0][sale_profit]" class="profit border p-2 rounded bg-gray-100" placeholder="Profit" readonly>
                </div>
            </div>
        </div>
    
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Submit Invoice Orders</button>
        </div>
    </form>
    
    @section('scripts')
    <script>
        let totalAmount = 0;
    
        document.getElementById('quotation_id').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            totalAmount = parseFloat(selected.getAttribute('data-amount')) || 0;
            const invoice = selected.getAttribute('data-invoice');
    
            document.getElementById('total_sale_price').value = totalAmount || '';
            document.getElementById('invoice_number').value = invoice || '';
    
            updateProfitFields();
        });
    
        function updateProfitFields() {
            document.querySelectorAll('.order-item').forEach(item => {
                const actualInput = item.querySelector('.actual_price');
                const profitInput = item.querySelector('.profit');
    
                actualInput.addEventListener('input', function () {
                    const actual = parseFloat(actualInput.value) || 0;
                    const profit = totalAmount > 0 ? (totalAmount - actual).toFixed(2) : '';
                    profitInput.value = profit;
                });
            });
        }
    
        // Initialize listeners
        updateProfitFields();
    </script>
    @endsection
    
@endsection    