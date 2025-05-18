<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditTrail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SysAdminController extends Controller
{
    //

    public function dashboard()
{
    return view('sysAdmin.dashboard', [
        'recentActivities' => AuditTrail::with('user')
            ->latest()
            ->take(5)
            ->get(),
            
        'auditTrails' => AuditTrail::with('user')
            ->whereIn('action', ['deleted', 'updated']) // Critical actions
            ->latest()
            ->take(5)
            ->get(),
            
        // Add any system health data you want to display
    ]);
}

public function index()
{
    $users = User::orderBy('name')->paginate(15);
    return view('sysAdmin.users', compact('users'));
}

public function changeEmail(Request $request, User $user)
{
    $request->validate(['email' => 'required|email|unique:users,email']);
    
    $user->update(['email' => $request->email]);
    
    return response()->json(['success' => true]);
}

public function resetPassword(User $user)
{
    // Generate random password
    $password = 'ishkel2025';
    $user->update(['password' => Hash::make($password)]);
    
    // Send email with new password (implement this)
    // Mail::to($user)->send(new PasswordResetMail($password));
    
    return response()->json(['success' => true]);
}

public function revoke(User $user)
{
    $user->update(['status' => 'inactive']);
    return response()->json(['success' => true]);
}

public function activate(User $user)
{
    $user->update(['status' => 'active']);
    return response()->json(['success' => true]);
}

public function destroy(User $user)
{
    $user->delete();
    return response()->json(['success' => true]);
}
//add userto company
public function AddUser1(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:super_admin,employee',
            'company_id' => 'required|exists:company_info,id'
        ]);

        // Create the user with a default password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'company_id' => $validated['company_id'],
            'password' => Hash::make('password') // Default password, user should change it
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function AddUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:super_admin,employee',
                'company_id' => 'required|exists:company_info,id' // Ensure table name matches your DB
            ]);
    
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'company_id' => $validated['company_id'],
                'password' => Hash::make('password')
            ]);
    
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            // Optional: log the error for the server
            Log::error('AddUser failed: ' . $e->getMessage());
    
            // Return the error for debugging (in development)
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

//logs history
public function loginActivity(){
    $activities = LoginActivity::with('user')->latest()->paginate(20);
    return view('sysAdmin.login_history.index', compact('activities'));

}

}

