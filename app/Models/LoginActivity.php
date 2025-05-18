<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $fillable = [
        'user_id', 'ip_address', 'status' ,'user_agent', 'login_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
