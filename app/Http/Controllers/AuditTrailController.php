<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $trails = AuditTrail::with(['user', 'model'])
            ->when($request->model_type, function($query) use ($request) {
                return $query->where('model_type', $request->model_type);
            })
            ->when($request->model_id, function($query) use ($request) {
                return $query->where('model_id', $request->model_id);
            })
            ->when($request->action, function($query) use ($request) {
                return $query->where('action', $request->action);
            })
            ->when($request->user_id, function($query) use ($request) {
                return $query->where('user_id', $request->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('sysAdmin.index', compact('trails'));
    }

    public function show(AuditTrail $auditTrail)
    {
        return view('sysAdmin.audit-trails.show', compact('auditTrail'));
    }
}