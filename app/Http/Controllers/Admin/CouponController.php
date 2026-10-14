<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
class CouponController extends Controller {
    public function index() {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }
    public function create() { return view('admin.coupons.create'); }
    public function store(Request $request) {
        $v = $request->validate([
            'code'=>'required|string|unique:coupons,code',
            'name'=>'required|string',
            'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric|min:0',
            'min_amount'=>'nullable|numeric|min:0',
            'total'=>'nullable|integer',
            'expires_at'=>'nullable|date',
        ]);
        Coupon::create($v + ['is_active'=>true]);
        return redirect()->route('admin.coupons.index')->with('success','已创建');
    }
    public function destroy(Coupon $coupon) { $coupon->delete(); return back()->with('success','已删除'); }
}
