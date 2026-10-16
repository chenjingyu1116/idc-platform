<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $q = Service::with(['user', 'product', 'order']);

        if ($kw = trim($request->input('kw', ''))) {
            $q->where(function ($qq) use ($kw) {
                $qq->where('ip_address', 'like', "%{$kw}%")
                   ->orWhere('upstream_service_id', 'like', "%{$kw}%")
                   ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$kw}%")->orWhere('email', 'like', "%{$kw}%"))
                   ->orWhereHas('order', fn($o) => $o->where('order_no', 'like', "%{$kw}%"));
            });
        }

        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        $services = $q->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'     => Service::count(),
            'active'    => Service::where('status', 'active')->count(),
            'pending'   => Service::where('status', 'pending')->count(),
            'suspended' => Service::where('status', 'suspended')->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'ip_address' => 'required|string|max:255',
            'username'   => 'required|string|max:255',
            'password'   => 'required|string|min:6',
        ]);

        $service->update([
            'ip_address'         => $request->ip_address,
            'username'           => $request->username,
            'password_encrypted' => $request->password,
            'status'             => 'active',
            'activated_at'       => now(),
        ]);

        return redirect()->route('admin.services.index')->with('success', '资源分配成功');
    }

    public function suspend(Service $service)
    {
        $service->update(['status' => 'suspended']);
        return back()->with('success', "已暂停服务 #{$service->id}");
    }

    public function unsuspend(Service $service)
    {
        $service->update(['status' => 'active']);
        return back()->with('success', "已恢复服务 #{$service->id}");
    }

    public function terminate(Service $service)
    {
        $service->update(['status' => 'terminated']);
        $service->delete();
        return back()->with('success', "已终止服务 #{$service->id}");
    }

    public function logs()
    {
        $logs = \App\Models\ProvisionLog::with(['service', 'provider'])
            ->latest()->paginate(30);
        return view('admin.provision-logs.index', compact('logs'));
    }
}
