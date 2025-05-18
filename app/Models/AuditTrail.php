<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    protected $fillable = [
        'action', 'model_type', 'model_id', 
        'old_values', 'new_values', 'user_id',
        'ip_address', 'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}