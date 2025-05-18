@extends('layouts.app')
@section('title', 'Invoice edit')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Invoice</h2>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.invoice.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="invoice_number">
                    Invoice Number
                </label>
                <input type="text" id="invoice_number" name="invoice_number" 
                    value="{{ $invoice->invoice_number }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="customer_name">
                    Customer Name
                </label>
                <input type="text" id="customer_name" name="customer_name" 
                    value="{{ $invoice->customer->name ?? '' }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="total_amount">
                    Total Amount
                </label>
                <input type="number" id="total_amount" name="total_amount" 
                    value="{{ $invoice->total_amount }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="status">
                    Status
                </label>
                <select id="status" name="status" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md">
                    Update Invoice
                </button>
            </div>
        </form>
        
<!-- add a button for edit or add items -->
        <div class="mt-6">
            <a href="{{ route('admin.invoice.items.show', $invoice->id) }}" 
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md">
                Edit Items
            </a>
        </div>


    </div>
</div>
@endsection
