<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
class DashboardController extends Controller {
    public function index() {
        $stats = [
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status','paid')->sum('total_amount'),
            'active_services' => Service::where('status','active')->count(),
            'pending_services' => Service::where('status','pending')->count(),
        ];
        $recentOrders = Order::with(['user','product'])->latest()->limit(10)->get();
        return view('admin.dashboard', compact('stats','recentOrders'));
    }
}
