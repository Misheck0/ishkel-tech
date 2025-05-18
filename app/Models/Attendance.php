<?php

// app/Models/Attendance.php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory,LogsActivity;
    
    

    protected $fillable = ['user_id', 'date', 'present', 'overtime_hours'];
    protected $casts = [
        'date' => 'date',
        
    ];

   // getActivitylogOptions based on our model
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
           ->logOnly(['date', 'present', 'overtime_hours'])
           ->logOnlyDirty()
           ->useLogName('attendance');
   }




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}