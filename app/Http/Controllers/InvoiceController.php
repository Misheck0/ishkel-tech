<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Customer;
use App\Models\Invoices;

use Barryvdh\DomPDF\PDF;
use App\Models\CompanyInfo;
use App\Models\InvoiceItem;
use App\Models\InvoiceOrder;
use Illuminate\Http\Request;
use App\Services\QuotationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    //
    public function index(Request $request)
    {
        $invoices = Invoices::with('customer')
           ->where('type','invoice')
           ->where('status','paid')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('invoices.index', compact('invoices'));
    }


    public function show($id)
    {   $company = Auth::user()->company;
        $invoice = Invoices::with('items')->findOrFail($id);
        return view('invoices.show', compact('invoice','company'));
    }
     
    public function markPaid($id)
{
    $invoice = Invoices::findOrFail($id);
    $user = Auth::user();

    if ($user->role !== 'super_admin' && $invoice->user_id !== $user->id) {
        return redirect()->route('invoices.index')->with('error', 'Unauthorized action.');
    }

    DB::transaction(function () use ($invoice) {
        // Only generate invoice number if not already set
        if (empty($invoice->invoice_number)) {
            $datePrefix = now()->format('Ymd'); // e.g., 20250504
            $prefix = 'INV-' . $datePrefix . '-';

            $nextNumber = DB::table('invoice_counters')->lockForUpdate()->first();

            if (!$nextNumber) {
                DB::table('invoice_counters')->insert([
                    'last_number' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $number = 1;
            } else {
                $number = $nextNumber->last_number + 1;
                DB::table('invoice_counters')->update([
                    'last_number' => $number,
                    'updated_at' => now(),
                ]);
            }

            $invoiceNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

            $invoice->update([
                'invoice_number' => $invoiceNumber,
            ]);
        }

        $invoice->update([
            'status' => 'paid',
            'type' => 'Invoice', // Capitalize to match system naming
        ]);
    });

    return redirect()->route('invoices.index')->with('success', 'Invoice marked as paid.');
}

    
    //


public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'string|max:11',
        'customer_tpin' => 'string|max:20',
        'items' => 'required|array|min:1',
        'items.*.description' => 'required|string',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0'
    ]);

    $maxAttempts = 5;
    $attempt = 0;

    do {
        try {
            DB::beginTransaction();

            // 1. Customer handling
            $customer = Customer::firstOrCreate(
                ['name' => $validated['customer_name']],
                ['number' => $validated['customer_phone'],
                'customer_tpin' => $validated['customer_tpin'],
                'email' => null, 
                'company_id' => Auth::user()->company_id]
            );

            // 2. Calculate totals
            $subtotal = collect($validated['items'])->sum(fn($item) => $item['unit_price'] * $item['quantity']);
            $tax = $subtotal * 0.00;
            $total = $subtotal + $tax;

        
            //generate quotation number
            $quotationId = (new QuotationService)->generateQuotationId();
            //end code 

            // 4. Create invoice
            $invoice = Invoices::create([
                'user_id' => Auth::id(),
                'customer_id' => $customer->id,
                'invoice_date' => now(),
                'total_amount' => $total,
                'status' => 'unpaid',
                'deadline' => now()->addDays(7),
                'company_id' => Auth::user()->company_id,
                'type' => 'Quotation',
                'quotation_id' => $quotationId
            ]);

            // 5. Create invoice items
            foreach ($validated['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price']
                ]);
            }

            DB::commit();

            return response()->json([
                'id' => $invoice->id,
                'message' => 'Invoice created successfully'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            $attempt++;

            if ($attempt >= $maxAttempts) {
                return response()->json([
                    'message' => 'Error creating invoice: ' . $e->getMessage()
                ], 500);
            }

            usleep(100000); // 100ms
        }
    } while ($attempt < $maxAttempts);
}

public function edit($id)
{
    $invoice = Invoices::with('items')->findOrFail($id);

    if (Auth::user()->role !== 'super_admin' && $invoice->user_id !== Auth::id()) {
        return redirect()->route('invoices.index')->with('error', 'Unauthorized to edit this invoice.');
    }
       // Prevent deletion if invoice is already paid
       if ($invoice->status === 'paid') {
        return redirect()->route('invoices.index')->with('error', 'Paid invoices cannot be Edit.');
    }

    return view('invoices.edit', compact('invoice'));
}

//deleted
public function destroy($id)
{
    $invoice = Invoices::findOrFail($id);
    $user = Auth::user();

    // Only allow if user is super_admin or the owner
    if ($user->role !== 'super_admin' && $invoice->user_id !== $user->id) {
        return redirect()->route('invoices.index')->with('error', 'Unauthorized action.');
    }

    // Prevent deletion if invoice is already paid
    if ($invoice->status === 'paid') {
        return redirect()->route('invoices.index')->with('error', 'Paid invoices cannot be deleted.');
    }

    $invoice->delete();
    return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
}

//download quotation

public function download($id)
{
    $company = Auth::user()->company; 
    //CompanyInfo::first(); // company details
    $user = Auth::user(); // currently logged-in user

    // Allow any user to download any invoice
    $invoice = Invoices::with(['items', 'user'])->findOrFail($id); // also eager load the user who created it

    // Get customer info related to the invoice
    $customer = Customer::find($invoice->customer_id);

    // $invoice->user will contain the user who created the invoice

    $pdf = app('dompdf.wrapper');
    $pdf->loadView('Dashboard.quotation', compact('invoice', 'company', 'customer', 'user'));

    return $pdf->download('quotation_' . $invoice->quotation_id . '.pdf');
}

//editInoice

public function editInvoiceItems($id)
{
    $invoice = Invoices::with('items', 'customer')->findOrFail($id);

    // Only allow super_admin or the invoice creator to edit
    if (Auth::user()->role !== 'super_admin' && $invoice->user_id !== Auth::id()) {
        return redirect()->route('invoices.index')->with('error', 'Unauthorized to edit this invoice.');
    }

       // Prevent deletion if invoice is already paid
       if ($invoice->status === 'paid') {
        return redirect()->route('invoices.index')->with('error', 'Paid invoices cannot be deleted.');
    }
    return view('invoices.items_edit', compact('invoice'));
}


//post function to update
    public function updateInvoiceItems(Request $request, $id)
    {
        $invoice = Invoices::findOrFail($id);
        
    if (Auth::user()->role !== 'super_admin' && $invoice->user_id !== Auth::id()) {
        return redirect()->route('invoices.index')->with('error', 'Unauthorized to edit this invoice.');
    }
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
    
        // Delete existing items and recreate
        $invoice->items()->delete();
    
        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price']
            ]);
        }
    
        // Update invoice total
        $subtotal = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $tax = $subtotal * 0.16;
        $invoice->total_amount = $subtotal + $tax;
        $invoice->save();
    
        return redirect()->route('admin.allInvoices')->with('success', 'Invoice items updated successfully!');
    }
    
 


        //search controller
public function search(Request $request)
{
    $query = $request->input('query');
    
    // If query is just numbers after INV-, prepend INV- automatically
    if (preg_match('/^\d{8}-\d{3}$/', $query)) {
        $query = 'INV-' . $query;
    }
    
    $invoices = Invoices::with('customer')
        ->where('invoice_number', 'like', "%{$query}%")
        ->where('type', 'invoice')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('invoices.search', compact('invoices'));
}

public function quotations()
{
    $invoices = Invoices::with('customer')
        ->where('type', 'quotation')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('invoices.quotation', compact('invoices'));

}//end of controller

/**
 * invoice orders
 */

 public function storeInvoiceOrders(Request $request)
 {
     $request->validate([
         'quotation_id' => 'required|exists:invoices,id',
         'invoice_number' => 'required|string',
         'total_sale_price' => 'required|numeric|min:0',
         'orders' => 'required|array',
         'orders.*.actual_price' => 'required|numeric|min:0',
     ]);
 
     $totalActual = 0;
     $quotationId = $request->quotation_id;
     $invoiceNumber = $request->invoice_number;
     $totalSalePrice = $request->total_sale_price;
 
     foreach ($request->orders as $order) {
         $actualPrice = $order['actual_price'];
         $saleProfit = $totalSalePrice - $actualPrice;
 
         InvoiceOrder::create([
             'quotation_id' => $quotationId,
             'actual_price' => $actualPrice,
             'sale_price' => $totalSalePrice,
             'sale_profit' => $saleProfit,
         ]);
 
         $totalActual += $actualPrice;
     }
 
     // Store in expenses
     Expense::create([
         'date' => now(),
         'amount' => $totalActual,
         'category' => 'invoice order',
         'description' => 'Order parts for Invoice ID ' . $invoiceNumber,
         'user_id' => Auth::id(),
         'invoice_id' => $request->invoice_id,
     ]);
 
     return redirect()->route('invoice.orders.create')
         ->with('success', 'Invoice orders and expense recorded successfully.');
 }
 
 public function showInvoiceOrders()
 {
     $quotations = Invoices::where('type', 'Invoice')->get();
     return view('invoice_orders.create', compact('quotations'));
 }
 

}