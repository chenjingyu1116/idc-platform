<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $q = AuditLog::with('user')->latest();
        if ($k = $request->input('kw')) {
            $q->where('event','like',"%{$k}%")->orWhere('ip_address','like',"%{$k}%");
        }
        $logs = $q->paginate(30);
        return view('admin.audit-logs.index', compact('logs'));
    }

    public function login()
    {
        $logs = AuditLog::with('user')->where('event','login')->latest()->paginate(30);
        return view('admin.audit-logs.login', compact('logs'));
    }
}
