<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Service;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 最近 30 天营收趋势
        $days = collect(range(29, 0))->map(function ($d) {
            return Carbon::today()->subDays($d);
        });

        $revenue = $days->map(function ($date) {
            return (float) Order::where('status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('total_amount');
        });

        $orderCount = $days->map(function ($date) {
            return Order::whereDate('created_at', $date)->count();
        });

        $userCount = $days->map(function ($date) {
            return User::whereDate('created_at', $date)->count();
        });

        // 产品销量排行
        $topProducts = Order::select('product_id', DB::raw('count(*) as cnt'), DB::raw('sum(total_amount) as total'))
            ->with('product')
            ->where('status', 'paid')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 汇总
        $summary = [
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
            'month_revenue' => Order::where('status', 'paid')->whereMonth('paid_at', now()->month)->sum('total_amount'),
            'today_revenue' => Order::where('status', 'paid')->whereDate('paid_at', today())->sum('total_amount'),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_services' => Service::count(),
            'total_commission' => Commission::sum('amount'),
        ];

        return view('admin.reports.index', compact(
            'days','revenue','orderCount','userCount','topProducts','summary'
        ));
    }
}
