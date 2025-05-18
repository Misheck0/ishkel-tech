<?php
namespace App\Observers;

use App\Models\AuditTrail;

use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;

class InvoiceObserver
{
    public function created(Invoices $invoice)
    {
        $this->logAction($invoice, 'created');
    }

    public function updated(Invoices $invoice)
    {
        $this->logAction($invoice, 'updated', $invoice->getOriginal());
    }

    public function deleted(Invoices $invoice)
    {
        $this->logAction($invoice, 'deleted');
    }

    protected function logAction(Invoices $invoice, string $action, array $original = null)
    {
        $changes = [];
        
        if ($action === 'updated') {
            $changes = [
                'old_values' => $this->getChangedValues($original, $invoice->getAttributes()),
                'new_values' => $this->getChangedValues($invoice->getAttributes(), $original),
            ];
        }

        AuditTrail::create([
            'action' => $action,
            'model_type' => get_class($invoice),
            'model_id' => $invoice->id,
            'old_values' => $changes['old_values'] ?? null,
            'new_values' => $changes['new_values'] ?? null,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected function getChangedValues(array $original, array $current)
    {
        $changed = [];
        
        foreach ($original as $key => $value) {
            if (array_key_exists($key, $current) ){
                if ($value != $current[$key]) {
                    $changed[$key] = $value;
                }
            }
        }
        
        return $changed;
    }
}
