<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['agent.user'])->latest()->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }
    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') return back()->with('error','已处理过');
        $withdrawal->update(['status'=>'approved']);
        return back()->with('success','已批准');
    }
    public function reject(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') return back()->with('error','已处理过');
        $withdrawal->update(['status'=>'rejected']);
        // 退还金额
        if ($withdrawal->agent && $withdrawal->agent->user) {
            $withdrawal->agent->user->increment('balance', $withdrawal->amount);
        }
        return back()->with('success','已拒绝，金额已退回');
    }
}
