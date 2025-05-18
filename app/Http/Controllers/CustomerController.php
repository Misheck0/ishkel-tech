<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Customer;
use App\Models\Invoices;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    //

    public function index(Request $request)
{
    $invoices = Invoices::where('customer_id', Auth::user()->customer_id)
        ->when($request->status, function($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->when($request->type, function($query) use ($request) {
            return $query->where('type', $request->type);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('Customer.index', compact('invoices'));
}

public function suggest(Request $request)
{
    $term = $request->query('term');

    $customers = Customer::where('name', 'LIKE', "%{$term}%")
        ->where('company_id', Auth::user()->company_id)
        ->limit(5)
        ->get(['id', 'name', 'number', 'customer_tpin']);

    return response()->json($customers);
}


}
