<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recharge;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    public function index(Request $request)
    {
        $q = Recharge::with('user');

        if ($kw = trim($request->input('kw', ''))) {
            $q->whereHas('user', function ($u) use ($kw) {
                $u->where('name', 'like', "%{$kw}%")->orWhere('email', 'like', "%{$kw}%");
            });
        }
        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        $recharges = $q->latest()->paginate(20)->withQueryString();

        $stats = [
            'pending'  => Recharge::where('status', 'pending')->sum('amount'),
            'approved' => Recharge::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.recharges.index', compact('recharges', 'stats'));
    }

    public function approve(Recharge $recharge)
    {
        if ($recharge->status !== 'pending') {
            return back()->with('error', '该记录已处理');
        }
        $recharge->update(['status' => 'approved']);
        $recharge->user->increment('balance', $recharge->amount);
        return back()->with('success', "已为用户充值 ¥{$recharge->amount}");
    }

    public function reject(Recharge $recharge)
    {
        if ($recharge->status !== 'pending') {
            return back()->with('error', '该记录已处理');
        }
        $recharge->update(['status' => 'rejected']);
        return back()->with('success', '已拒绝');
    }

    public function batchApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', '请先选择要审核的记录');
        }

        $recharges = Recharge::whereIn('id', $ids)->where('status', 'pending')->get();
        $count = 0;
        $total = 0;
        foreach ($recharges as $r) {
            $r->update(['status' => 'approved']);
            $r->user->increment('balance', $r->amount);
            $count++;
            $total += $r->amount;
        }

        return back()->with('success', "已批量批准 {$count} 笔充值，共 ¥{$total}");
    }
}
