<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * The companyController will allow IT manager and super admin
 * to access the company information
 */


class CompanyController extends Controller
{
    //

    

public function index()
{
    $companies = CompanyInfo::all();
    return view('sysAdmin.company', compact('companies'));
}

public function show($id)
{
    $company = CompanyInfo::with('users')->findOrFail($id);
    return view('sysAdmin.viewcompany', compact('company'));
}

public function destroy($id)
{
    $company = CompanyInfo::findOrFail($id);
    $company->delete();
    return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
}

// CompanyController.php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'number' => 'nullable|string|max:20',
        'tpin' => 'required|string|max:255|unique:company_infos,tpin',
    ]);

    $company = CompanyInfo::create($validated);

    return response()->json($company);
}

// CompanyProfileController.php
/**
 * This method is used to show the company profile.
 * It retrieves the company information and all users associated with the company.
 */
public function Profile()
{
    //check if the user is super admin
    if (Auth::user()->role != 'super_admin') {
        return redirect()->route('invoices.index')->with('error', 'You are not authorized to view this page.');
    }

    $company = CompanyInfo::findOrFail(Auth::user()->company_id);
    // Get all users associated with the company
    $users = User::where('company_id', $company->id)->get();

    return view('Dashboard.companyProfile', [
        'company' => $company,
        'users' => $users
    ]);
}

/**
 * This method allow super admin to edit 
 * there company info 
 */

public function edit($id)
{
    // Ensure the company belongs to the current user's company
    $company = CompanyInfo::where('id', $id)->firstOrFail();
    
    return view('Dashboard.companyedit', compact('company'));
}

/**
 * This method handle the Post request to store 
 * It the company details
 */

public function update(Request $request, $id)
{
    $company = CompanyInfo::where('id', $id)->firstOrFail();
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'number' => 'nullable|string|max:20',
        'tpin' => 'required|string|max:255|unique:company_info,tpin,'.$company->id,
    ]);
    
    $company->update($validated);
    
    return redirect()->route('company.profile')
        ->with('success', 'Company information updated successfully');
}

}
