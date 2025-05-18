<?php

// app/Models/Expense.php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Expense extends Model
{
    use logsActivity;
    protected $fillable = ['date', 'amount', 'category', 'description', 'user_id', 'invoice_id'];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // getActivitylogOptions based on our model
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['date', 'amount', 'category', 'description'])
            ->logOnlyDirty()
            ->useLogName('expense');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function invoice()
{
    return $this->belongsTo(Invoices::class);
}

}
