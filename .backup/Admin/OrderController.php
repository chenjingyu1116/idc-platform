<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with(['user', 'product'])->latest();
        if ($s = $request->input('status')) $q->where('status', $s);
        if ($k = $request->input('kw')) {
            $q->where('order_no', 'like', "%{$k}%")
              ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$k}%")->orWhere('email', 'like', "%{$k}%"));
        }
        $orders = $q->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'product', 'services']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update(['status' => $request->status]);
        if ($request->status === 'paid' && !$order->paid_at) {
            $order->update(['paid_at' => now()]);
        }
        return back()->with('success', '订单状态已更新');
    }
}
