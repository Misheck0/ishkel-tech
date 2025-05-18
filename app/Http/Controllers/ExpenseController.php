<?php

// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        //we pass in the based on current date
        $currentDate = Carbon::now()->format('Y-m-d');
        $category = $request->get('category');
      //  $expenses = Expense::when($category, fn($q) => $q->where('category', $category))
        //                   ->latest()->get();
        $expenses = Expense::with('invoice') // Eager load invoice
    ->when($category, fn($q) => $q->where('category', $category))
    ->latest()
    ->get();

        $categories = Expense::select('category')->distinct()->pluck('category');

        return view('expenses.index', compact('expenses', 'categories','currentDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Expense recorded successfully.');
    }

    public function chartData()
    {
        $data = Expense::selectRaw('category, SUM(amount) as total')
                        ->groupBy('category')
                        ->get();
    
        return response()->json([
            'labels' => $data->pluck('category'),
            'amounts' => $data->pluck('total')
        ]);
    }
    

    public function report(Request $request)
    {
        // Get filter values
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $category = $request->input('category');

        // Base query
        $query = Expense::query();

        // Apply filters
        if ($year) {
            $query->whereYear('date', $year);
        }
        if ($month) {
            $query->whereMonth('date', $month);
        }
        if ($category) {
            $query->where('category', $category);
        }

        // Get expenses for table
        $expenses = $query->with('user')
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Get all categories for filter dropdown
        $categories = Expense::distinct('category')
            ->whereNotNull('category')
            ->pluck('category');

        // Current month total
        $currentMonthTotal = Expense::whereYear('date', date('Y'))
            ->whereMonth('date', date('m'))
            ->sum('amount');

        // Previous month total
        $previousMonthTotal = Expense::whereYear('date', Carbon::now()->subMonth()->year)
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->sum('amount');

        // Year to date total
        $yearToDateTotal = Expense::whereYear('date', date('Y'))
            ->sum('amount');

        // Previous year total
        $previousYearTotal = Expense::whereYear('date', date('Y') - 1)
            ->sum('amount');

        // Top category for current month
        $topCategory = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->whereYear('date', date('Y'))
            ->whereMonth('date', date('m'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->first();

        // Monthly trend data (current vs previous year)
        $monthlyTrendData = [
            'current_year' => $this->getMonthlyTrendData(date('Y')),
            'previous_year' => $this->getMonthlyTrendData(date('Y') - 1)
        ];

        // Category breakdown data
        $categoryData = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->whereYear('date', $year)
            ->when($month, function($query, $month) {
                return $query->whereMonth('date', $month);
            })
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        return view('reports.expenses', compact(
            'expenses',
            'categories',
            'currentMonthTotal',
            'previousMonthTotal',
            'yearToDateTotal',
            'previousYearTotal',
            'topCategory',
            'monthlyTrendData',
            'categoryData',
            'year',
            'month',
            'category'
        ));
    }

    protected function getMonthlyTrendData($year)
    {
        $data = Expense::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('date', $year)
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('MONTH(date)'))
            ->get()
            ->keyBy('month');

        // Fill all months with 0 if no data exists
        $trendData = [];
        for ($i = 1; $i <= 12; $i++) {
            $trendData[$i] = $data->has($i) ? $data[$i]->total : 0;
        }

        return $trendData;
    }

}
