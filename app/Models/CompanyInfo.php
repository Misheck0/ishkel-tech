<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    //
    protected $table = 'company_info';

    protected $fillable = [
        'company_name',
        'address',
        'email',
        'number',
        'tpin',
        'last_login_at',
        'last_login_ip'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

}
