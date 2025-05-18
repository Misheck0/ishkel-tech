<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'amount_paid',
        'payment_method',
        'paid_at',
        'receipt_number',
        'notes',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoices::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    //auto-generate receipt number
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->receipt_number = 'REC-' . date('Y') . '-' . str_pad(Receipt::count() + 1, 3, '0', STR_PAD_LEFT);
        });
    }
    public function receipt()
{
    return $this->hasOne(Receipt::class, 'invoice_id');
}

//items 
// Invoice.php
public function items()
{
    return $this->hasMany(InvoiceItem::class, 'invoice_id'); // 👈 specify correct foreign key
}

}
