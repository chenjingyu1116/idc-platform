<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'code'        => 'required|string|max:50|unique:coupons,code',
            'name'        => 'required|string|max:100',
            'type'        => 'required|in:fixed,percent',
            'value'       => 'required|numeric|min:0',
            'min_amount'  => 'nullable|numeric|min:0',
            'total'       => 'nullable|integer|min:1',
            'expires_at'  => 'nullable|date',
        ]);

        $v['code']       = strtoupper(trim($v['code']));
        $v['min_amount'] = $v['min_amount'] ?? 0;
        $v['total']      = $v['total'] ?? 0;
        $v['used']       = 0;
        $v['is_active']  = $request->boolean('is_active', true);

        Coupon::create($v);
        return redirect()->route('admin.coupons.index')->with('success', '优惠券已创建');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', '已删除');
    }

    /** 发放页 */
    public function distribute(Coupon $coupon)
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.coupons.distribute', compact('coupon', 'users'));
    }

    /** 执行发放 */
    public function doDistribute(Request $request, Coupon $coupon)
    {
        $request->validate([
            'mode'      => 'required|in:manual,group',
            'user_ids'  => 'required_if:mode,manual|array',
            'user_ids.*'=> 'exists:users,id',
            'group'     => 'required_if:mode,group|string',
        ]);

        $targetUsers = collect();

        if ($request->mode === 'manual') {
            $targetUsers = User::whereIn('id', $request->user_ids)->get();
        } else {
            $targetUsers = match ($request->group) {
                'all'         => User::all(),
                'no_admin'    => User::where('is_admin', false)->get(),
                'has_order'   => User::whereHas('orders')->get(),
                'no_order'    => User::whereDoesntHave('orders')->get(),
                'has_balance' => User::where('balance', '>', 0)->get(),
                'new_7d'      => User::where('created_at', '>=', now()->subDays(7))->get(),
                'new_30d'     => User::where('created_at', '>=', now()->subDays(30))->get(),
                default       => collect(),
            };
        }

        if ($targetUsers->isEmpty()) {
            return back()->with('error', '没有符合条件的用户');
        }

        $sent = 0;
        $skip = 0;
        foreach ($targetUsers as $u) {
            // 已经持有时跳过
            if (UserCoupon::where('user_id', $u->id)->where('coupon_id', $coupon->id)->exists()) {
                $skip++;
                continue;
            }
            UserCoupon::create([
                'user_id'   => $u->id,
                'coupon_id' => $coupon->id,
                'status'    => 'unused',
            ]);
            $sent++;
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', "发放完成：成功 {$sent} 人，跳过（已持有）{$skip} 人");
    }
}
