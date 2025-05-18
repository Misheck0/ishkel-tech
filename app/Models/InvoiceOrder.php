<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceOrder extends Model
{
    //
    protected $fillable = [
        'quotation_id',
        'actual_price',
        'sale_price',
        'sale_profit',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'quotation_id');
    }
}
