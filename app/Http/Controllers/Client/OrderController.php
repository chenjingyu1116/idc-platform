<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller {
    public function index() {
        $orders = Order::where('user_id', auth()->id())->with('product')->latest()->paginate(15);
        return view('client.orders.index', compact('orders'));
    }
    public function show(Order $order) {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['product','services','user']);
        return view('client.orders.show', compact('order'));
    }
    public function cancel(Order $order) {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') return back()->with('error','该订单不可取消');
        $order->update(['status'=>'cancelled']);
        return back()->with('success','订单已取消');
    }
}
