<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
class AgentController extends Controller {
    public function index() {
        $agent = Agent::firstOrCreate(
            ['user_id'=>auth()->id()],
            ['code'=>'AG'.strtoupper(substr(md5(auth()->id().time()),0,8)),'commission_rate'=>10]
        );
        $commissions = $agent->commissions()->with('order')->latest()->paginate(10);
        return view('client.agent.index', compact('agent','commissions'));
    }
    public function withdraw(Request $request) {
        $v = $request->validate([
            'amount'=>'required|numeric|min:1',
            'account_type'=>'required|string',
            'account_no'=>'required|string',
        ]);
        $agent = Agent::where('user_id', auth()->id())->firstOrFail();
        if ($agent->withdrawable < $v['amount']) return back()->with('error','可提现余额不足');
        Withdrawal::create($v + ['agent_id'=>$agent->id,'status'=>'pending']);
        return back()->with('success','提现申请已提交');
    }
}
