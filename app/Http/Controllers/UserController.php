<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\LoginActivity;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{
    //

 
    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
           // Configure rate limiting
    $maxAttempts = 3;
    $decayMinutes = 5; // Block for 5 minutes after max attempts
    
    // Key for rate limiting (based on IP and email)
    $throttleKey = 'login:' . $request->ip() . '|' . $request->email;

 

          // Check if too many attempts
    if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        return back()->withErrors([
            'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
        ]);

    }
      // Verify credentials manually to prevent timing attacks
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

      // Increment login attempts
      RateLimiter::hit($throttleKey, $decayMinutes * 60);
       
  
        // Check credentials
    $User = User::where('email', $request->email)->first();
    
    if (!$User || !Hash::check($request->password, $User->password)) {
       
        //log
          // If login fails, log the attempt
          LoginActivity::create([
            'user_id' => $User->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'login_at' => now(),
            'status' => 'failed',
        ]);
       
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    } 

    // If credentials are valid, clear attempts and login
    RateLimiter::clear($throttleKey);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            //store logs
            LoginActivity::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_at' => now(),
                'status' => 'success',
            ]);
            //
             // Update last login time
        $User->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $request->ip()
        ]);
        //Auth::login($User);
  // Redirect based on role
  if (Auth::user()->role == 'customer') {
    return redirect()->route('customer.invoices.index');
} 
elseif (Auth::user()->role == 'IT_manager')
{
    //do this
    return redirect()->route('sysadmin.index');
}


else {
    return redirect()->intended('/user/dashboard');
}

           // return redirect()->intended('/user/dashboard');
        }

      
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function dashboard()
{
   // $companyId = Auth::user()->company_id;

    $invoices = Invoices::with('customer')
        ->orderBy('created_at', 'desc')
        ->take(10) // Show last 10 invoices
        ->paginate(5);;
    $paidInvoices = Invoices::where('status', 'paid')->count();
    $unpaidInvoices = Invoices::where('status', 'unpaid')->count();
    $total_quotations = $paidInvoices + $unpaidInvoices;
    $stats = [
        'total_invoices' => Invoices::where('type','invoice')->count(),
        'unpaid_quotation' => Invoices::where('type', 'Quotation')->count(),
        'total_revenue' => Invoices::where('status', 'paid')->sum('total_amount'),
        'total_quotations' => $total_quotations,
        'paid_invoices' => Invoices::where('status', 'paid')->count(),
        'outstanding_amount' => Invoices::where('status', 'unpaid')->sum('total_amount')
    ];

    return view('Dashboard.homepage', [
        'invoices' => $invoices,
        'stats' => $stats
    ]);
}

public function showAddUserForm()
{
    return view('admin.addUser');
}


public function addUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'role' => 'required|in:super_admin,employe'
    ]);

    $password = 'ishkel2025'; // default password

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($password),
        'role' => $request->role
    ]);

    // Send email with credentials
    Mail::to($user->email)->send(new UserCredentialsMail($user->name, $user->email, $password));

    return redirect()->route('admin.addUserForm')->with('success', 'User created and credentials emailed successfully.');
}

//profile
public function showProfile()
{
    return view('Dashboard.profile');
}
//update profile
public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'password' => 'nullable|string|min:8|confirmed',
    ]);


    $loginuser = Auth::user();
    $user = User::findOrFail($loginuser->id);
    // Check if the email is already taken by another user
    if (User::where('email', $request->email)->where('id', '!=', $user->id)->exists()) {
        return redirect()->back()->withErrors(['email' => 'The email has already been taken.']);
    }
    // Update user details
    $user->email_verified_at = null; // Reset email verification
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

//change password
public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::findOrFail(Auth::id());

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Password changed successfully.');
}

//logout 
public function logout(Request $request)
{   //logout activity
    LoginActivity::create([
        'user_id' => Auth::id(),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'login_at' => now(),
        'status' => 'logout',
    ]);
    //logout
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/auth/login')->with('success', 'Logged out successfully.');


}

}
