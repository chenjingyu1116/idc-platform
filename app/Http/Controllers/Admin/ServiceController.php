<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
class ServiceController extends Controller {
    public function index() {
        $services = Service::with(['user','product','order'])->latest()->paginate(20);
        return view('admin.services.index', compact('services'));
    }
    public function edit(Service $service) { return view('admin.services.edit', compact('service')); }
    public function update(Request $request, Service $service) {
        $request->validate(['ip_address'=>'required|ip','username'=>'required|string','password'=>'required|string|min:6']);
        $service->update(['ip_address'=>$request->ip_address,'username'=>$request->username,'password_encrypted'=>$request->password,'status'=>'active','activated_at'=>now()]);
        return redirect()->route('admin.services.index')->with('success','资源分配成功');
    }
}
