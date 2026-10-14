<?php
namespace App\Services\Payment;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Recharge;
use App\Notifications\OrderPaidNotification;
use Illuminate\Support\Str;
class PaymentService {
    public function createForOrder(Order $order, string $gateway = 'epay'): Payment {
        return Payment::create([
            'trade_no' => 'PAY'.date('YmdHis').strtoupper(Str::random(6)),
            'user_id' => $order->user_id, 'payable_type' => Order::class, 'payable_id' => $order->id,
            'amount' => $order->total_amount, 'gateway' => $gateway, 'status' => 'pending',
        ]);
    }
    public function createForRecharge(Recharge $recharge, string $gateway = 'epay'): Payment {
        return Payment::create([
            'trade_no' => 'PAY'.date('YmdHis').strtoupper(Str::random(6)),
            'user_id' => $recharge->user_id, 'payable_type' => Recharge::class, 'payable_id' => $recharge->id,
            'amount' => $recharge->amount, 'gateway' => $gateway, 'status' => 'pending',
        ]);
    }
    public function markPaid(Payment $payment, ?string $gatewayTradeNo = null): void {
        if ($payment->status === 'paid') return;
        $payment->update(['status'=>'paid','gateway_trade_no'=>$gatewayTradeNo,'paid_at'=>now()]);
        if ($payment->payable_type === Order::class) {
            $order = Order::find($payment->payable_id);
            if ($order && $order->status === 'pending') {
                $order->update(['status'=>'paid','paid_at'=>now()]);
                if ($order->user) $order->user->notify(new OrderPaidNotification($order));
                foreach (range(1, $order->quantity) as $i) {
                    $service = $order->services()->create([
                        'user_id'=>$order->user_id,'product_id'=>$order->product_id,
                        'service_type'=>'vps','provider_type'=>'manual','status'=>'pending',
                    ]);
                    \App\Jobs\ProvisionService::dispatch($service);
                }
            }
        } elseif ($payment->payable_type === Recharge::class) {
            $recharge = Recharge::find($payment->payable_id);
            if ($recharge && $recharge->status === 'pending') {
                $recharge->update(['status'=>'approved']);
                $recharge->user->increment('balance', $recharge->amount);
            }
        }
    }
}
