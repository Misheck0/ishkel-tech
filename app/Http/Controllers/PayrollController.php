<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('user')->latest()->paginate(10);
    
        foreach ($payrolls as $payroll) {
            if (!$payroll->is_paid) {
                $payroll->calculated_days_worked = Attendance::where('user_id', $payroll->user_id)
                    ->whereBetween('date', [$payroll->pay_period_start, $payroll->pay_period_end])
                    ->where('present', true)
                    ->count();
            } else {
                $payroll->calculated_days_worked = $payroll->days_worked;
            }
        }
    
        return view('payroll.index', compact('payrolls'));
    }
    
 

    public function create()
    {   //calculate total working
        $users = User::whereIn('role', ['employee', 'accountant'])->get();
        return view('payroll.create', compact('users'));
    }

 
    //
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'monthly_salary' => 'required|numeric|min:0',
        'overtime_rate' => 'nullable|numeric|min:0',
        'pay_period_start' => 'required|date',
        'pay_period_end' => 'required|date|after:pay_period_start',
    ]);

    Payroll::create([
        'user_id' => $request->user_id,
        'monthly_salary' => $request->monthly_salary,
        'overtime_rate' => $request->overtime_rate ?? 0,
        'pay_period_start' => $request->pay_period_start,
        'pay_period_end' => $request->pay_period_end,
        // 'days_worked' and 'overtime_hours' will be calculated later when marking paid
    ]);

    return redirect()->route('payroll.index')
        ->with('success', 'Payroll record created. You can mark as paid later.');
}

    //
    public function markPaid($id)
    {
        $payroll = Payroll::findOrFail($id);
    
        // Prevent duplicate payment
        if ($payroll->is_paid) {
            return back()->with('info', 'This payroll is already marked as paid.');
        }
    
        // Calculate days worked and overtime
        $daysWorked = Attendance::where('user_id', $payroll->user_id)
            ->whereBetween('date', [$payroll->pay_period_start, $payroll->pay_period_end])
            ->where('present', true)
            ->count();
    
        $overtimeHours = Attendance::where('user_id', $payroll->user_id)
            ->whereBetween('date', [$payroll->pay_period_start, $payroll->pay_period_end])
            ->sum('overtime_hours');
    
        // Assume 22 working days/month
        $dailyRate = $payroll->monthly_salary / 22;
        $baseSalary = $daysWorked * $dailyRate;
        $overtimePay = $overtimeHours * ($payroll->overtime_rate ?? 0);
        $netSalary = $baseSalary + $overtimePay;
    
        // Update this payroll
        $payroll->update([
            'days_worked' => $daysWorked,
            'overtime_hours' => $overtimeHours,
            'net_salary' => $netSalary,
            'is_paid' => true,
        ]);
    
        // Auto-generate next month's payroll
        $nextStart = Carbon::parse($payroll->pay_period_start)->addMonthNoOverflow()->startOfMonth();
        $nextEnd = Carbon::parse($payroll->pay_period_end)->addMonthNoOverflow()->endOfMonth();
    
        // Prevent duplicate generation
        $existing = Payroll::where('user_id', $payroll->user_id)
            ->where('pay_period_start', $nextStart)
            ->first();
    
        if (!$existing) {
            Payroll::create([
                'user_id' => $payroll->user_id,
                'monthly_salary' => $payroll->monthly_salary,
                'overtime_rate' => $payroll->overtime_rate,
                'pay_period_start' => $nextStart,
                'pay_period_end' => $nextEnd,
                'is_paid' => false, // default
            ]);
        }
    
        return back()->with('success', 'Payroll marked as paid. Next month\'s payroll generated.');
    }
    

    public function markPaid1(Payroll $payroll)
    {
        $payroll->update(['is_paid' => true]);
        return back()->with('success', 'Payroll marked as paid.');
    }
    

    /**
     * Payroll report
     */

     public function report1()
     {
        $payrolls = Payroll::with('user')
            ->orderBy('pay_period_start', 'desc')
            ->paginate(20);
            
        $users = User::all()->where('company_id ',Auth::user()->company_id);
        
        return view('reports.payroll', compact('payrolls','users'));
    }

    public function show1(Payroll $payroll)
    {
        $payroll->load('user');
        $attendances = Attendance::where('user_id', $payroll->user_id)
            ->whereBetween('date', [$payroll->pay_period_start, $payroll->pay_period_end])
            ->get();
    
        $daysWorked = $attendances->where('present', true)->count();
    
        return view('payroll.show', compact('payroll', 'attendances', 'daysWorked'));
    }
    
    public function show(Payroll $payroll)
{
    $payroll->load('user');

    $attendances = Attendance::where('user_id', $payroll->user_id)
        ->whereBetween('date', [$payroll->pay_period_start, $payroll->pay_period_end])
        ->get();

    $daysWorked = $attendances->where('present', true)->count();

    // Assume 30 working days in a month for simplicity (customize if needed)
    $dailyRate = $payroll->monthly_salary / 30;
    $netSalary = $dailyRate * $daysWorked;

    return view('payroll.show', compact('payroll', 'attendances', 'daysWorked', 'netSalary'));
}


    public function report() {
        $payrolls = Payroll::with('user')
        ->where('is_paid', true)
        ->whereHas('user', function($query) {
            $query->where('company_id', Auth::user()->company_id);
        })
        ->orderBy('pay_period_start', 'desc')
        ->paginate(20);
        //
        return view('reports.payroll', compact('payrolls'));
    }
}