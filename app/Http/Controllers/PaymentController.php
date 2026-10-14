<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\EpayService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
class PaymentController extends Controller {
    public function checkout(Order $order) {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') return redirect()->route('client.orders.show',$order);
        return view('payment.checkout', compact('order'));
    }
    public function payWithBalance(Order $order, PaymentService $ps) {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') return back()->with('error','订单状态异常');
        $user = auth()->user();
        if ($user->balance < $order->total_amount) return back()->with('error','余额不足');
        $user->decrement('balance', $order->total_amount);
        $payment = $ps->createForOrder($order, 'balance');
        $ps->markPaid($payment);
        return redirect()->route('client.orders.show',$order)->with('success','余额支付成功，正在开通资源');
    }
    public function payWithEpay(Order $order, PaymentService $ps, EpayService $epay) {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') return back()->with('error','订单状态异常');
        if (!$epay->isConfigured()) return back()->with('error','易支付未配置，请使用余额支付或联系管理员');
        $payment = $ps->createForOrder($order, 'epay');
        $url = $epay->buildPayUrl($payment->trade_no, $payment->amount, '订单 '.$order->order_no, 'alipay');
        return redirect($url);
    }
    public function notify(Request $request, EpayService $epay) {
        $params = $request->all();
        if (!$epay->verify($params)) return response('sign error', 400);
        if (($params['trade_status'] ?? '') !== 'TRADE_SUCCESS') return response('ok');
        $payment = Payment::where('trade_no', $params['out_trade_no'])->first();
        if (!$payment) return response('payment not found', 404);
        app(PaymentService::class)->markPaid($payment, $params['trade_no'] ?? null);
        return response('success');
    }
    public function returnUrl(Request $request) {
        return redirect()->route('client.orders.index')->with('success','支付完成');
    }
}
