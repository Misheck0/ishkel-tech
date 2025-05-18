<?php

namespace App\Policies;

use App\Models\Invoices;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
  

     public function view(User $user, Invoices $invoice)
     {
         return $user->company_id === $invoice->company_id;
     }
     
     public function update(User $user, Invoices $invoice)
     {
         return $user->company_id === $invoice->company_id;
     }
     
     public function delete(User $user, Invoices $invoice)
     {
         return $user->company_id === $invoice->company_id;
     }
     
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

  

  
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invoices $invoices): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invoices $invoices): bool
    {
        return false;
    }
}
