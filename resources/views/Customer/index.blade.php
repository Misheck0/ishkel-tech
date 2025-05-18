@extends('layouts.customer.app')

@section('title', 'My Invoices')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-white">My Transaction History</h1>
            <div class="text-blue-100">
                {{ now()->format('F j, Y') }}
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">All Types</option>
                        <option value="invoice" {{ request('type') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                        <option value="quotation" {{ request('type') == 'quotation' ? 'selected' : '' }}>Quotation</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Filter
                    </button>
                    <a href="{{ route('customer.invoices.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-blue-600">{{ $invoice->invoice_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $invoice->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            ZMW {{ number_format($invoice->total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('customer.invoices.show', $invoice->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                View Details
                            </a>
                            <a href="{{ route('customer.invoices.download', $invoice->id) }}" 
                               class="text-gray-600 hover:text-gray-900">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
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
@endsection