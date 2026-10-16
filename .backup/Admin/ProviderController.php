<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Services\Providers\HttpProvider;
use Illuminate\Http\Request;
class ProviderController extends Controller {
    public function index() {
        $providers = Provider::latest()->paginate(20);
        return view('admin.providers.index', compact('providers'));
    }
    public function create() { return view('admin.providers.create'); }
    public function store(Request $request) {
        $v = $request->validate(['name'=>'required|string','driver'=>'required|string','api_url'=>'nullable','api_key'=>'nullable','api_secret'=>'nullable']);
        Provider::create([
            'name'=>$v['name'],'driver'=>$v['driver'],'api_url'=>$v['api_url']??null,
            'credentials_encrypted'=>['api_key'=>$v['api_key']??null,'api_secret'=>$v['api_secret']??null],
            'config'=>['endpoints'=>[
                'provision'=>'/api/v1/provision','suspend'=>'/api/v1/suspend',
                'unsuspend'=>'/api/v1/unsuspend','terminate'=>'/api/v1/terminate',
                'products'=>'/api/v1/products','ping'=>'/api/v1/ping',
            ]],
            'is_active'=>true,
        ]);
        return redirect()->route('admin.providers.index')->with('success','已添加');
    }
    public function edit(Provider $provider) { return view('admin.providers.edit', compact('provider')); }
    public function update(Request $request, Provider $provider) {
        $v = $request->validate(['name'=>'required|string','driver'=>'required|string','api_url'=>'nullable','is_active'=>'boolean']);
        $provider->update($v);
        return redirect()->route('admin.providers.index')->with('success','已更新');
    }
    public function destroy(Provider $provider) { $provider->delete(); return back()->with('success','已删除'); }
    public function test(Provider $provider) {
        $http = new HttpProvider($provider);
        $result = $http->ping();
        return response()->json($result);
    }
}
