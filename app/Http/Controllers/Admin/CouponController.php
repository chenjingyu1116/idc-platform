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
        public function store(Request $request)
    {
        $v = $request->validate([
            "code" => "required|string|max:50|unique:coupons,code",
            "name" => "required|string|max:100",
            "type" => "required|in:fixed,percent",
            "value" => "required|numeric|min:0",
            "min_amount" => "nullable|numeric|min:0",
            "total" => "nullable|integer|min:1",
            "expires_at" => "nullable|date",
        ]);

        // 处理可选字段的默认值（因为数据库字段是 NOT NULL）
        $v["min_amount"] = $v["min_amount"] ?? 0;
        $v["total"]      = $v["total"] ?? 0;      // 0 表示不限量
        $v["used"]       = 0;
        $v["is_active"]  = $request->boolean("is_active", true);

        \App\Models\Coupon::create($v);

        return redirect()->route("admin.coupons.index")->with("success", "优惠券已创建");
    }
    public function destroy(Coupon $coupon) { $coupon->delete(); return back()->with('success','已删除'); }
}
