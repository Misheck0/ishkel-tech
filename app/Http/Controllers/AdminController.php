<?php

namespace App\Http\Controllers;

use App\Mail\UserCredentialsMail;
use App\Models\User;
use App\Models\Customer;
use App\Models\Invoices;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //

    public function AllInvoices1()
    {
        $invoices = Invoices::all();
        return view('admin.allInvoices', compact('invoices'));
    }

  

public function AllInvoices(Request $request)
{
    $invoices = Invoices::query();

    if ($request->filled('status')) {
        $invoices->where('status', $request->status);
    }

    if ($request->filled('type')) {
        $invoices->where('type', $request->type);
    }

    if ($request->filled('from_date')) {
        $invoices->whereDate('created_at', '>=', $request->from_date);
    }

    $invoices = $invoices->orderBy('created_at', 'desc')->get();

    return view('admin.allInvoices', compact('invoices'));
}


    public function AllUsers()
    {
        $users = User::all()
        ->where('role', '!=', 'IT_manager')
        ;
        return view('admin.allUsers', compact('users'));
    }

    public function AllUsersInvoices($id)
    {
        $invoices = Invoices::where('user_id', $id)->get();
        return view('admin.allUsersInvoices', compact('invoices'));
    }

    public function addUser(Request $request)
    {
        //get company id from the logged in user
        $company_id = Auth::user()->company_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:super_admin,employee'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('ishkel2025'),
            'role' => $request->role,
            'company_id' => $company_id,
        ]);
    
        // You could send email or show notification here
         Mail::to($user->email)->send(new UserCredentialsMail($user->name, $user->email, 'ishkel2025'));

        return redirect()->route('admin.addUserForm')->with('success', 'User created successfully.');
    }

   
public function showAddUserForm()
{
    return view('admin.addUser');
}

    // AdminController.php

public function editInvoice($id)
{
    $invoice = Invoices::findOrFail($id);
    return view('admin.edit', compact('invoice'));
}

public function updateInvoice(Request $request, $id)
{
    $invoice = Invoices::findOrFail($id);

    $request->validate([
        'total_amount' => 'required|numeric|min:0',
        'status' => 'required|in:paid,unpaid',
    ]);

    $invoice->update([
        'total_amount' => $request->total_amount,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.allInvoices')->with('success', 'Invoice updated successfully.');
}
public function deleteInvoice($id)
{
    $invoice = Invoices::findOrFail($id);
    $invoice->delete();

    return redirect()->route('admin.allInvoices')->with('success', 'Invoice deleted successfully.');

}

public function AllCustomers()
{
    $customers = Customer::withCount('invoices')
        ->withSum('invoices', 'total_amount')
        ->paginate(4);

        return view('admin.customers', compact('customers'));
}
public function grantAccess(Request $request)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:customer,employer,admin'
    ]);

    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make(Str::random(12)), // Generate random password
        'role' => $validated['role'],
        'customer_id' => $validated['customer_id'],
        'company_id' => Auth::user()->company_id, // Assuming the logged-in user has a company_id
    ]);

    // Send email with setup instructions
    // Mail::to($user)->send(new AccountSetupMail($user));

    return redirect()->back()->with('success', 'Dashboard access granted successfully');
}

    
public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = !$user->status;
    $user->save();

    return back()->with('success', 'User status updated.');
}

public function changeRole(Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:user,admin,super_admin,customer'
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return back()->with('success', 'User role updated.');
}



}


