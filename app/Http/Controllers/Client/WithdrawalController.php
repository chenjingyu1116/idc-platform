<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
class WithdrawalController extends Controller {
    public function index() {
        $withdrawals = Withdrawal::where('user_id', auth()->id())->latest()->paginate(10);
        return view('client.withdrawal.index', compact('withdrawals'));
    }
    public function store(Request $request) {
        $request->validate(['amount'=>'required|numeric|min:10|max:100000','account'=>'required|string|max:255']);
        Withdrawal::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'account' => $request->account,
            'status' => 'pending',
        ]);
        return back()->with('success', '提现申请已提交');
    }
}
