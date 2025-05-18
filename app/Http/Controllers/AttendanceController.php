<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
    
        // Get users who already have attendance on the selected date
        $alreadyMarkedUserIds = Attendance::where('date', $date)->pluck('user_id');
    
        // Get employees and accountants who haven't been marked
        $users = User::whereIn('role', ['employee', 'accountant'])
            ->whereNotIn('id', $alreadyMarkedUserIds)
            ->get();
    
        // Create dummy attendance objects for the view
        $attendances = $users->map(function ($user) use ($date) {
            return new Attendance([
                'user_id' => $user->id,
                'date' => $date,
                'user' => $user,
            ]);
        });
    
        return view('attendance.schedule', compact('attendances', 'date'));
    }
    

 /**
  * Store attendance function
  * This function is responsible for saving attendance records for users.
    * It validates the input data, checks if attendance for the date already exists,
  */
    
  
    public function update(Request $request)
    {
        $request->validate([
            'attendance.*.user_id' => 'required|exists:users,id',
            'attendance.*.present' => 'required|boolean',
            'attendance.*.overtime_hours' => 'nullable|numeric|min:0',
            'date' => 'required|date',
        ]);
    
        $date = $request->input('date');
        $alreadyMarked = [];
    
        foreach ($request->attendance as $data) {
            $exists = Attendance::where('user_id', $data['user_id'])
                ->where('date', $date)
                ->exists();
    
            if ($exists) {
                $user = User::find($data['user_id']);
                $alreadyMarked[] = $user->name;
                continue;
            }
    
            Attendance::create([
                'user_id' => $data['user_id'],
                'date' => $date,
                'present' => $data['present'],
                'overtime_hours' => $data['overtime_hours'] ?? 0,
            ]);
        }
    
        if (count($alreadyMarked)) {
            return back()->with('warning', 'Already submitted for: ' . implode(', ', $alreadyMarked));
        }
    
        return back()->with('success', 'Attendance saved successfully.');
    }
    
/**
 * Report function
 */
    public function report()
    {
        $attendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->paginate(20);
         $users = User::all()->where('company_id ',Auth::user()->company_id);
          
        return view('reports.attendance', compact('attendances','users'));
    }
}