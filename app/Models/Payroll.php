<?php

// app/Models/Payroll.php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'monthly_salary',
        'days_worked',
        'overtime_hours',
        'overtime_rate',
        'total_earnings',
        'pay_period_start',
        'pay_period_end',
        'is_paid'
    ];
// Payroll.php
protected $casts = [
    'pay_period_start' => 'date',
    'pay_period_end' => 'date',
];

    protected static function booted()
    {
        static::saving(function ($payroll) {
            $dailyRate = $payroll->monthly_salary / 22; // Assuming 22 working days/month
            $payroll->total_earnings = ($payroll->days_worked * $dailyRate) 
                                     + ($payroll->overtime_hours * $payroll->overtime_rate);
        });
    }
    // getActivitylogOptions based on our model
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'monthly_salary', 'days_worked', 'overtime_hours', 'overtime_rate', 'total_earnings', 'pay_period_start', 'pay_period_end'])
            ->logOnlyDirty()
            ->useLogName('payroll');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}