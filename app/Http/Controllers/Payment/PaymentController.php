<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentConfig;
use App\Models\Recharge;
use App\Models\Transaction;
use App\Services\Payment\PaymentFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') {
            return redirect()->route('client.services.index')->with('error', '订单状态异常');
        }
        $gateways = PaymentConfig::where('is_active', true)->get();
        return view('payment.checkout', compact('order', 'gateways'));
    }

    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') return back()->with('error', '订单状态异常');

        $request->validate(['gateway' => 'required|string']);

        // 余额支付
        if ($request->gateway === 'balance') {
            $user = auth()->user();
            if ($user->balance < $order->total_amount) {
                return back()->with('error', '余额不足');
            }
            DB::transaction(function () use ($user, $order) {
                $user->decrement('balance', $order->total_amount);
                $order->update(['status' => 'paid', 'paid_at' => now()]);
                $this->dispatchProvision($order);
            });
            return redirect()->route('client.services.index')->with('success', '订单支付成功，正在开通！');
        }

        // 网关支付
        $config = PaymentConfig::where('driver', $request->gateway)->where('is_active', true)->first();
        if (!$config) return back()->with('error', '支付方式不可用');
        $gateway = PaymentFactory::make($config);
        if (!$gateway) return back()->with('error', '支付网关配置错误');

        $tradeNo = 'PAY' . date('YmdHis') . strtoupper(Str::random(4));

        Transaction::create([
            'transaction_no'   => $tradeNo,
            'user_id'          => auth()->id(),
            'order_id'         => $order->id,
            'amount'           => $order->total_amount,
            'gateway'          => $request->gateway,
            'status'           => 'pending',
        ]);

        $url = $gateway->pay([
            'trade_no'   => $tradeNo,
            'name'       => '订单支付-' . $order->order_no,
            'amount'     => $order->total_amount,
            'pay_type'   => $request->pay_type ?? 'alipay',
            'notify_url' => url('/payment/notify'),
            'return_url' => url('/payment/return'),
        ]);

        return redirect($url);
    }

    public function notify(Request $request)
    {
        Log::info('Payment notify', $request->all());

        $tradeNo = $request->input('out_trade_no', '');
        $tx = Transaction::where('transaction_no', $tradeNo)->first();
        if (!$tx || $tx->status === 'success') return response('success');

        $config = PaymentConfig::where('driver', $tx->gateway)->first();
        $gateway = PaymentFactory::make($config);
        if (!$gateway) return response('fail');

        $result = $gateway->handleNotify($request->all());
        if (!$result['success']) {
            Log::warning('Payment notify failed', $result);
            return response('fail');
        }

        // 金额校验
        if (abs($result['amount'] - $tx->amount) > 0.01) {
            Log::warning('Payment amount mismatch', ['expect' => $tx->amount, 'got' => $result['amount']]);
            return response('fail');
        }

        DB::transaction(function () use ($tx, $result) {
            $tx->update([
                'status' => 'success',
                'gateway_transaction_id' => $result['gateway_no'],
                'gateway_response' => json_encode($result['raw']),
            ]);

            $order = $tx->order;
            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'paid', 'paid_at' => now()]);
                $this->dispatchProvision($order);
            }
        });

        return response('success');
    }

    public function return(Request $request)
    {
        return view('payment.result', [
            'success' => $request->input('trade_status') === 'TRADE_SUCCESS',
            'order'   => null,
            'message' => $request->input('trade_status') === 'TRADE_SUCCESS' ? '支付成功，正在为您开通' : '支付未完成',
        ]);
    }

    protected function dispatchProvision(Order $order): void
    {
        foreach ($order->services as $service) {
            if ($service->status === 'pending') {
                \App\Jobs\ProvisionService::dispatch($service);
            }
        }
    }
}
