<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        return view('admin.audit.index', [
            'auditLogs' => AuditLog::with('user')->latest()->paginate(15),
        ]);
    }
}
