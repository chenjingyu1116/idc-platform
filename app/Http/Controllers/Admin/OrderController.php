<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with(['user', 'product']);

        if ($kw = trim($request->input('kw', ''))) {
            $q->where(function ($qq) use ($kw) {
                $qq->where('order_no', 'like', "%{$kw}%")
                   ->orWhereHas('user', function ($u) use ($kw) {
                       $u->where('name', 'like', "%{$kw}%")
                         ->orWhere('email', 'like', "%{$kw}%");
                   });
            });
        }

        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        if ($from = $request->input('from')) {
            $q->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $q->whereDate('created_at', '<=', $to);
        }

        $orders = $q->latest()->paginate(20)->withQueryString();

        $summary = [
            'total'  => Order::count(),
            'paid'   => Order::where('status', 'paid')->count(),
            'amount' => Order::where('status', 'paid')->sum('total_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'summary'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'product', 'services']);
        return view('admin.orders.show', compact('order'));
    }

    public function export(Request $request): StreamedResponse
    {
        $q = Order::with(['user', 'product']);

        if ($kw = trim($request->input('kw', ''))) {
            $q->where(function ($qq) use ($kw) {
                $qq->where('order_no', 'like', "%{$kw}%")
                   ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$kw}%")->orWhere('email', 'like', "%{$kw}%"));
            });
        }
        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        $orders = $q->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders-' . date('YmdHis') . '.csv"',
        ];

        return response()->stream(function () use ($orders) {
            $fh = fopen('php://output', 'w');
            // BOM 让 Excel 正确识别 UTF-8
            fwrite($fh, "\xEF\xBB\xBF");
            fputcsv($fh, ['订单号', '用户', '邮箱', '产品', '数量', '金额', '状态', '下单时间', '支付时间']);
            foreach ($orders as $o) {
                fputcsv($fh, [
                    $o->order_no,
                    optional($o->user)->name ?? '-',
                    optional($o->user)->email ?? '-',
                    optional($o->product)->name ?? '-',
                    $o->quantity,
                    $o->total_amount,
                    $o->status,
                    optional($o->created_at)->format('Y-m-d H:i:s'),
                    optional($o->paid_at)->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($fh);
        }, 200, $headers);
    }
}
