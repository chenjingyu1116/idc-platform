<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
class CouponController extends Controller {
    public function index() {
        $coupons = auth()->user()->coupons()->latest()->paginate(10);
        return view('client.coupons.index', compact('coupons'));
    }
}
