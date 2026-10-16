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
    public function create()
    {
        $users = \App\Models\User::orderBy("id", "desc")->get();
        return view("admin.agents.create", compact("users"));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            "user_id" => "required|exists:users,id|unique:agents,user_id",
            "code" => "nullable|string|max:50|unique:agents,code",
            "level" => "required|string|max:20",
            "commission_rate" => "required|numeric|min:0|max:1",
            "is_active" => "boolean",
        ]);

        if (empty($v["code"])) {
            $v["code"] = "REF" . str_pad($v["user_id"], 6, "0", STR_PAD_LEFT);
        }

        $v["is_active"] = $request->boolean("is_active", true);
        $v["total_earned"] = 0;
        $v["withdrawable"] = 0;

        \App\Models\Agent::create($v);

        return redirect()->route("admin.agents.index")->with("success", "代理已添加");
    }
}
