<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationService
{
    public function generateQuotationId(): string
    {
        return DB::transaction(function () {
            $todayPrefix = now()->format('Ymd');
            $prefix = 'QUO-' . $todayPrefix . '-';
    
            $counter = DB::table('quotation_counters')->lockForUpdate()->first();
    
            if (!$counter) {
                DB::table('quotation_counters')->insert([
                    'last_number' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $number = 1;
            } else {
                $number = $counter->last_number + 1;
                DB::table('quotation_counters')->update([
                    'last_number' => $number,
                    'updated_at' => now(),
                ]);
            }
    
            $nextNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
    
            return $prefix . $nextNumber;
        });
    }
    
}
