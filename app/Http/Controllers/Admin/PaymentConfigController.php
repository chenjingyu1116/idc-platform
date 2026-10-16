<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentConfig;
use Illuminate\Http\Request;

class PaymentConfigController extends Controller
{
    public function index()
    {
        $configs = PaymentConfig::latest()->paginate(20);
        return view('admin.payment-configs.index', compact('configs'));
    }

    public function create()
    {
        return view('admin.payment-configs.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'name'    => 'required|string|max:255',
            'driver'  => 'required|string|in:epay',
            'api_url' => 'required|url',
            'pid'     => 'required|string',
            'key'     => 'required|string',
        ]);

        PaymentConfig::create([
            'name'    => $v['name'],
            'driver'  => $v['driver'],
            'api_url' => $v['api_url'],
            'credentials' => json_encode(['pid' => $v['pid'], 'key' => $v['key']]),
            'is_active' => true,
        ]);

        return redirect()->route('admin.payment-configs.index')->with('success', '支付配置已添加');
    }

    public function edit($id)
    {
        $config = PaymentConfig::findOrFail($id);
        return view('admin.payment-configs.edit', compact('config'));
    }

    public function update(Request $request, $id)
    {
        $config = PaymentConfig::findOrFail($id);
        $v = $request->validate([
            'name'    => 'required|string|max:255',
            'api_url' => 'required|url',
            'pid'     => 'nullable|string',
            'key'     => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $cred = json_decode($config->credentials, true) ?: [];
        if (!empty($v['pid'])) $cred['pid'] = $v['pid'];
        if (!empty($v['key'])) $cred['key'] = $v['key'];

        $config->update([
            'name' => $v['name'],
            'api_url' => $v['api_url'],
            'credentials' => json_encode($cred),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.payment-configs.index')->with('success', '支付配置已更新');
    }

    public function destroy($id)
    {
        PaymentConfig::findOrFail($id)->delete();
        return back()->with('success', '支付配置已删除');
    }
}
