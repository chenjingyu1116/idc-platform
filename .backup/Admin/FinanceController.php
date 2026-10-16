<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Recharge;
use Illuminate\Http\Request;
class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->toDateString());

        $orders = Order::where('status','paid')
            ->whereBetween('paid_at', [$start.' 00:00:00', $end.' 23:59:59'])
            ->with(['user','product'])
            ->latest()->paginate(30);

        $income = Order::where('status','paid')
            ->whereBetween('paid_at', [$start.' 00:00:00', $end.' 23:59:59'])
            ->sum('total_amount');

        $recharges = Recharge::where('status','approved')
            ->whereBetween('updated_at', [$start.' 00:00:00', $end.' 23:59:59'])
            ->sum('amount');

        $stats = [
            'income' => $income,
            'recharges' => $recharges,
            'order_count' => $orders->total(),
            'start' => $start,
            'end' => $end,
        ];

        return view('admin.finance.index', compact('orders','stats'));
    }

    public function export(Request $request)
    {
        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->toDateString());

        $orders = Order::where('status','paid')
            ->whereBetween('paid_at', [$start.' 00:00:00', $end.' 23:59:59'])
            ->with(['user','product'])
            ->get();

        $filename = "finance-{$start}-{$end}.csv";
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($orders) {
            $fp = fopen('php://output', 'w');
            fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($fp, ['订单号','用户','邮箱','产品','金额','支付时间']);
            foreach ($orders as $o) {
                fputcsv($fp, [
                    $o->order_no,
                    optional($o->user)->name ?? '-',
                    optional($o->user)->email ?? '-',
                    optional($o->product)->name ?? '-',
                    $o->total_amount,
                    $o->paid_at ? $o->paid_at->format('Y-m-d H:i:s') : '-',
                ]);
            }
            fclose($fp);
        };

        return response()->stream($callback, 200, $headers);
    }
}
