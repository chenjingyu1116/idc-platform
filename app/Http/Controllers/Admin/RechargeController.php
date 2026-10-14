<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Recharge;
class RechargeController extends Controller {
    public function index() {
        $recharges = Recharge::with('user')->latest()->paginate(20);
        return view('admin.recharges.index', compact('recharges'));
    }
    public function approve(Recharge $recharge) {
        if ($recharge->status !== 'pending') return back()->with('error','已处理过');
        $recharge->update(['status'=>'approved']);
        $recharge->user->increment('balance', $recharge->amount);
        return back()->with('success',"已充值 ¥{$recharge->amount}");
    }
}
