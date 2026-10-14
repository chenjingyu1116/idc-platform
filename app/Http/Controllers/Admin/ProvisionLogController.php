<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProvisionLog;
class ProvisionLogController extends Controller {
    public function index() {
        $logs = ProvisionLog::with(['service','provider'])->latest()->paginate(30);
        return view('admin.provision-logs.index', compact('logs'));
    }
}
