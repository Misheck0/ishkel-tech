<?php

namespace App\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
   protected $table = 'customer';

    protected $fillable = [
        'company_id',
        'name',
        'number',
        'customer_tpin',
        'address',
        'created_at',
        'updated_at'
    ];

    public function invoices() {
      return $this->hasMany(Invoices::class);
  }
  public function company()
{
    return $this->belongsTo(CompanyInfo::class, 'company_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
{
    static::addGlobalScope(new CompanyScope);
}

}
