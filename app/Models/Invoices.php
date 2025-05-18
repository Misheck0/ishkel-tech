<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    //
     //  protected $table = 'customer';

     protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
        'type',
        'company_id',
        'quotation_id',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];
       
    public function company()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_id');
    }

    
    
// Invoice.php
public function items()
{
    return $this->hasMany(InvoiceItem::class, 'invoice_id'); // 👈 specify correct foreign key
}

public function customer() {
    return $this->belongsTo(Customer::class);
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

//auto-generate update receipt when invoice is paid
protected static function booted1()
{
    static::updated(function ($invoice) {
        if ($invoice->isDirty('status') && $invoice->status === 'paid') {
            Receipt::create([
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'amount_paid' => $invoice->total_amount,
                'payment_date' => now(),
               
            ]);
        }
    });

    static::creating(function ($invoice) {
        if (empty($invoice->deadline)) {
            $invoice->deadline = now()->addDays(7);
        }
    });

// Apply the global scope    
    static::addGlobalScope(new CompanyScope);
}

protected static function booted()
{
    static::updated(function ($invoice) {
        if ($invoice->isDirty('status') && $invoice->status === 'paid') {
            Receipt::create([
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'amount_paid' => $invoice->total_amount,
                'payment_date' => now(),
            ]);
        }
    });

    static::creating(function ($invoice) {
        // Set default deadline
        if (empty($invoice->deadline)) {
            $invoice->deadline = now()->addDays(7);
        }
        // Generate quotation_id if it's a quotation and not already set
    
    });

    static::addGlobalScope(new CompanyScope);
}


public function receipt()
{
    return $this->hasOne(Receipt::class, 'invoice_id');
}
public function auditTrails()
{
    return $this->morphMany(AuditTrail::class, 'model');
}

public function orders()
{
    return $this->hasMany(InvoiceOrder::class, 'quotation_id');
}


}
