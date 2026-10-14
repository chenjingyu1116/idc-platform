<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Recharge;
use Illuminate\Http\Request;
class RechargeController extends Controller {
    public function index() {
        $recharges = Recharge::where('user_id', auth()->id())->latest()->paginate(10);
        return view('client.recharge.index', compact('recharges'));
    }
    public function store(Request $request) {
        $request->validate(['amount'=>'required|numeric|min:1|max:100000']);
        Recharge::create(['user_id'=>auth()->id(),'amount'=>$request->amount,'status'=>'pending']);
        return back()->with('success', '充值申请已提交');
    }
}
