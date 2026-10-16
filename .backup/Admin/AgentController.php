<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
class AgentController extends Controller {
    public function index() {
        $agents = Agent::with('user')->latest()->paginate(20);
        return view('admin.agents.index', compact('agents'));
    }
    public function withdrawals() {
        $withdrawals = Withdrawal::with('agent.user')->latest()->paginate(20);
        return view('admin.agents.withdrawals', compact('withdrawals'));
    }
    public function approveWithdrawal(Withdrawal $withdrawal) {
        if ($withdrawal->status !== 'pending') return back()->with('error','已处理');
        $withdrawal->update(['status'=>'approved']);
        $withdrawal->agent->decrement('withdrawable', $withdrawal->amount);
        return back()->with('success','已批准');
    }
    public function rejectWithdrawal(Withdrawal $withdrawal) {
        $withdrawal->update(['status'=>'rejected']);
        return back()->with('success','已拒绝');
    }
}
