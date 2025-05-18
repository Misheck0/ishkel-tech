<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Customer;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $now = Carbon::now();
        
        // Initialize date ranges based on period
        switch ($period) {
            case 'weekly':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $previousStartDate = $startDate->copy()->subWeek();
                $previousEndDate = $endDate->copy()->subWeek();
                break;
            case 'yearly':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                $previousStartDate = $startDate->copy()->subYear();
                $previousEndDate = $endDate->copy()->subYear();
                break;
            default: // monthly
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $previousStartDate = $startDate->copy()->subMonth();
                $previousEndDate = $endDate->copy()->subMonth();
        }

        // Current period data
        $currentInvoices = Invoices::whereBetween('invoice_date', [$startDate, $endDate])->get();
        $currentPaid = $currentInvoices->where('status', 'paid')
        ->where('type','Invoice')
        ->sum('total_amount');

        $currentUnpaid = $currentInvoices->where('status', 'unpaid')
        ->where('type','Quotation')
        ->sum('total_amount');
        $currentPartiallyPaid = $currentInvoices->where('status', 'partially_paid')->sum('total_amount');
        $currentTotal = $currentPaid + $currentUnpaid + $currentPartiallyPaid;

        // Previous period data for comparison
        $previousInvoices = Invoices::whereBetween('invoice_date', [$previousStartDate, $previousEndDate])->get();
        $previousPaid = $previousInvoices->where('status', 'paid')->sum('total_amount');
        $previousUnpaid = $previousInvoices->where('status', 'unpaid')->sum('total_amount');
        $previousTotal = $previousPaid + $previousUnpaid;

        // Calculate percentage changes
        $paidChange = $previousPaid != 0 ? (($currentPaid - $previousPaid) / $previousPaid) * 100 : 100;
        $unpaidChange = $previousUnpaid != 0 ? (($currentUnpaid - $previousUnpaid) / $previousUnpaid) * 100 : 100;
        $totalChange = $previousTotal != 0 ? (($currentTotal - $previousTotal) / $previousTotal) * 100 : 100;

        // Data for the chart (last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $monthInvoices = Invoices::whereBetween('invoice_date', [$monthStart, $monthEnd])->get();
            
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'paid' => $monthInvoices->where('status', 'paid')->sum('total_amount'),
                'unpaid' => $monthInvoices->where('status', 'unpaid')->sum('total_amount'),
                'partially_paid' => $monthInvoices->where('status', 'partially_paid')->sum('total_amount'),
            ];
        }
        //get current invoices

        $currentInvoices = Invoices::where('status', 'unpaid')
            #->where('type', 'Quotation')
            ->where('invoice_date', '>=', $startDate)
            ->where('invoice_date', '<=', $endDate)
            ->get();

        // Get overDue invoices
        $overDueInvoices = Invoices::where('status', 'unpaid')
            ->where('type', 'Quotation')
            ->where('deadline', '<', now())
            ->get();
        //get top customers
        $topCustomers = Customer::withCount(['invoices as invoices_count' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('invoice_date', [$startDate, $endDate]);
        }])
        ->withSum(['invoices as total_spent' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('invoice_date', [$startDate, $endDate]);
        }], 'total_amount')
        ->orderByDesc('total_spent')
        ->limit(5)
        ->get();
      
            return view('reports.index', compact(
            'currentPaid',
            'currentUnpaid',
            'currentPartiallyPaid',
            'currentTotal',
            'paidChange',
            'unpaidChange',
            'totalChange',
            'period',
            'monthlyData',
            'startDate',
            'endDate',
            'overDueInvoices',
            'currentInvoices',
            'topCustomers'
        ));
    }
    public function exportPDF(Request $request)
{
    $data = $this->gatherReportData($request); // Reuse your existing index logic
    $pdf = Pdf::loadView('reports.export_pdf', $data);
    
    return $pdf->download('report_summary_' . now()->format('Y_m_d_His') . '.pdf');
}
/*
    public function exportExcel(Request $request)
{
    $data = $this->gatherReportData($request); // Same as PDF
    $filename = 'report_summary_' . now()->format('Y_m_d_His') . '.xlsx';
    
    return Excel::download(new ReportsExport($data), $filename);
}
*/
private function gatherReportData(Request $request)
{
    $period = $request->input('period', 'monthly');
    $now = Carbon::now();

    switch ($period) {
        case 'weekly':
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
            $previousStartDate = $startDate->copy()->subWeek();
            $previousEndDate = $endDate->copy()->subWeek();
            break;
        case 'yearly':
            $startDate = $now->copy()->startOfYear();
            $endDate = $now->copy()->endOfYear();
            $previousStartDate = $startDate->copy()->subYear();
            $previousEndDate = $endDate->copy()->subYear();
            break;
        default: // monthly
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            $previousStartDate = $startDate->copy()->subMonth();
            $previousEndDate = $endDate->copy()->subMonth();
    }

    $currentInvoices = Invoices::whereBetween('invoice_date', [$startDate, $endDate])->get();

    $currentPaid = $currentInvoices->where('status', 'paid')->where('type','Invoice')->sum('total_amount');
    $currentUnpaid = $currentInvoices->where('status', 'unpaid')->where('type','Quotation')->sum('total_amount');
    $currentPartiallyPaid = $currentInvoices->where('status', 'partially_paid')->sum('total_amount');
    $currentTotal = $currentPaid + $currentUnpaid + $currentPartiallyPaid;

    $previousInvoices = Invoices::whereBetween('invoice_date', [$previousStartDate, $previousEndDate])->get();
    $previousPaid = $previousInvoices->where('status', 'paid')->sum('total_amount');
    $previousUnpaid = $previousInvoices->where('status', 'unpaid')->sum('total_amount');
    $previousTotal = $previousPaid + $previousUnpaid;

    $paidChange = $previousPaid != 0 ? (($currentPaid - $previousPaid) / $previousPaid) * 100 : 100;
    $unpaidChange = $previousUnpaid != 0 ? (($currentUnpaid - $previousUnpaid) / $previousUnpaid) * 100 : 100;
    $totalChange = $previousTotal != 0 ? (($currentTotal - $previousTotal) / $previousTotal) * 100 : 100;

    $monthlyData = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = $now->copy()->subMonths($i);
        $monthStart = $date->copy()->startOfMonth();
        $monthEnd = $date->copy()->endOfMonth();
        
        $monthInvoices = Invoices::whereBetween('invoice_date', [$monthStart, $monthEnd])->get();
        
        $monthlyData[] = [
            'month' => $date->format('M Y'),
            'paid' => $monthInvoices->where('status', 'paid')->sum('total_amount'),
            'unpaid' => $monthInvoices->where('status', 'unpaid')->sum('total_amount'),
            'partially_paid' => $monthInvoices->where('status', 'partially_paid')->sum('total_amount'),
        ];
    }

    $currentInvoices = Invoices::where('status', 'unpaid')
        ->where('invoice_date', '>=', $startDate)
        ->where('invoice_date', '<=', $endDate)
        ->get();

    $overDueInvoices = Invoices::where('status', 'unpaid')
        ->where('type', 'Quotation')
        ->where('deadline', '<', now())
        ->get();

    $topCustomers = Customer::withCount(['invoices as invoices_count' => function($query) use ($startDate, $endDate) {
        $query->whereBetween('invoice_date', [$startDate, $endDate]);
    }])
    ->withSum(['invoices as total_spent' => function($query) use ($startDate, $endDate) {
        $query->whereBetween('invoice_date', [$startDate, $endDate]);
    }], 'total_amount')
    ->orderByDesc('total_spent')
    ->limit(5)
    ->get();

    // Return associative array (not a view)
    return [
        'currentPaid' => $currentPaid,
        'currentUnpaid' => $currentUnpaid,
        'currentPartiallyPaid' => $currentPartiallyPaid,
        'currentTotal' => $currentTotal,
        'paidChange' => $paidChange,
        'unpaidChange' => $unpaidChange,
        'totalChange' => $totalChange,
        'period' => $period,
        'monthlyData' => $monthlyData,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'overDueInvoices' => $overDueInvoices,
        'currentInvoices' => $currentInvoices,
        'topCustomers' => $topCustomers,
    ];
}



public function KPI(Request $request)
{
    $reportData = $this->gatherReportData($request);
    
    return view('reports.kpi', [
        'currentPaid' => $reportData['currentPaid'],
        'currentUnpaid' => $reportData['currentUnpaid'],
        'currentPartiallyPaid' => $reportData['currentPartiallyPaid'],
        'currentTotal' => $reportData['currentTotal'],
        'paidChange' => $reportData['paidChange'],
        'unpaidChange' => $reportData['unpaidChange'],
        'totalChange' => $reportData['totalChange'],
        'monthlyData' => $reportData['monthlyData']
    ]);
}


}