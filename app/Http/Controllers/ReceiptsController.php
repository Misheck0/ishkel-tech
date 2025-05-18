<?php

namespace App\Http\Controllers;


use App\Models\Receipt;
use App\Models\Invoices;
use Barryvdh\DomPDF\PDF;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptsController extends Controller
{
    //

    public function download($id)
    {
        $receipt = Receipt::findOrFail($id);

        // Generate the PDF on the fly
        $pdf = app(PDF::class)->loadView('receipts.pdf', compact('receipt'));

        // Stream the PDF directly to the browser (open in a new tab)
        return $pdf->stream('receipt-' . $receipt->reference_number . '.pdf');
    }

    public function viewPaidInvoicePdf($id)
{
    $invoice = Invoices::with(['customer', 'items'])->findOrFail($id);

    // get the company info based on the company_id in the invoice
    // Assuming you have a relationship set up in the Invoices model
    $company = Auth::user()->company;

    $pdf = app(PDF::class)->loadView('receipts.pdf_invoice', compact('invoice', 'company'));

    return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
}

}
