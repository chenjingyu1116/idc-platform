<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentConfig;
use Illuminate\Http\Request;

class PaymentConfigController extends Controller
{
    public function index() {
        $configs = PaymentConfig::orderBy('sort')->get();
        return view('admin.payments.index', compact('configs'));
    }
    public function create() {
        return view('admin.payments.create');
    }
    public function store(Request $request) {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'driver' => 'required|string|max:50',
            'api_url' => 'nullable|string',
            'pid' => 'nullable|string',
            'key_secret' => 'nullable|string',
            'sort' => 'nullable|integer',
        ]);
        PaymentConfig::create([
            'name' => $v['name'],
            'driver' => $v['driver'],
            'api_url' => $v['api_url'] ?? null,
            'pid' => $v['pid'] ?? null,
            'key_secret' => $v['key_secret'] ?? null,
            'notify_url' => url('/payment/notify'),
            'return_url' => url('/payment/return'),
            'sort' => $v['sort'] ?? 0,
            'is_active' => true,
        ]);
        return redirect()->route('admin.payments.index')->with('success', '支付渠道已添加');
    }
    public function edit(PaymentConfig $payment) {
        return view('admin.payments.edit', compact('payment'));
    }
    public function update(Request $request, PaymentConfig $payment) {
        $v = $request->validate([
            'name' => 'required|string',
            'driver' => 'required|string',
            'api_url' => 'nullable|string',
            'pid' => 'nullable|string',
            'key_secret' => 'nullable|string',
            'is_active' => 'boolean',
            'sort' => 'nullable|integer',
        ]);
        $payment->update($v);
        return redirect()->route('admin.payments.index')->with('success', '已更新');
    }
    public function destroy(PaymentConfig $payment) {
        $payment->delete();
        return back()->with('success', '已删除');
    }
}
