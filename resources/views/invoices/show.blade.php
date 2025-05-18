@extends('..layouts.app')

@section('title', 'Invoice Info' . $invoice->invoice_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Invoice Header -->
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

        <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Invoice #{{ $invoice->invoice_number }}</h1>
                <div class="flex items-center mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                    <span class="ml-4 text-gray-600">Issued: {{ $invoice->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.download', $invoice->id) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Download PDF
                </a>
                @if($invoice->status == 'paid')
                <!--view receipt -->
                <a href="{{ route('receipts.download', $invoice->receipt->id) }}" 
                    target="_blank"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                     View Receipt
                 </a>
                 
                 <a href="{{ route('invoices.pdf', $invoice->id) }}" target="_blank"
                    class="text-blue-500 hover:underline">
                     View Invoice PDF
                 </a>
                 
                @else
                <form action="{{ route('invoices.mark-paid', $invoice->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                        Mark as Paid
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- From (Company Info) -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">From</h3>
                <address class="not-italic text-gray-600">
                    <p class="font-semibold"> {{$company->company_name}}</p>
                    <p>  {{$company->address}}</p>
                    <p>Lusaka, Zambia</p>
                    <p>Phone: +26 {{$company->number}}</p>
                    <p>Email:  {{$company->email }}</p>
                    <p>TPIN: {{$company->tpin}}</p>
                </address>
            </div>

            <!-- To (Customer Info) -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">To</h3>
                <address class="not-italic text-gray-600">
                    <p class="font-semibold">{{ $invoice->customer->name }}</p>
                    @if($invoice->customer->address)
                        <p>{{ $invoice->customer->address }}</p>
                    @endif
                    @if($invoice->customer->phone)
                        <p>Phone: {{ $invoice->customer->phone }}</p>
                    @endif
                    @if($invoice->customer->email)
                        <p>Email: {{ $invoice->customer->email }}</p>
                    @endif
                    @if($invoice->customer->tpin)
                        <p>TPIN: {{ $invoice->customer->tpin }}</p>
                    @endif
                </address>
            </div>
        </div>

        <!-- Invoice Items Table -->
        @php
        $subtotal = $invoice->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });
    
        $tax = $subtotal * 0.00;
        $total = $subtotal + $tax;
    @endphp
    
    <div class="border-t border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($invoice->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">ZMW {{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">ZMW {{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">Subtotal</th>
                    <td class="px-6 py-3 text-sm font-medium text-gray-900">ZMW {{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">Tax (0%)</th>
                    <td class="px-6 py-3 text-sm font-medium text-gray-900">ZMW {{ number_format($tax, 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">Total</th>
                    <td class="px-6 py-3 text-sm font-bold text-gray-900">ZMW {{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
     
        </div>


    </div>
    <!-- add a button for edit or add items -->
    <div class="mt-6">
        <a href="{{ route('admin.invoice.items.show', $invoice->id) }}" 
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md">
            Edit Items
        </a>
</div>
@endsection