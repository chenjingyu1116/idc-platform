<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 关键词搜索（昵称 / 邮箱 / 手机）
        if ($kw = $request->input('kw')) {
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('email', 'like', "%{$kw}%")
                  ->orWhere('phone', 'like', "%{$kw}%");
            });
        }

        // 角色筛选
        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'user') {
                $query->where('is_admin', false);
            }
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders', 'services', 'recharges']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $v = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'balance'  => 'nullable|numeric|min:0',
            'is_admin' => 'boolean',
            'phone'    => 'nullable|string|max:20',
        ]);

        $v['is_admin'] = $request->boolean('is_admin');

        $user->update($v);

        return redirect()->route('admin.users.index')->with('success', "用户 {$user->name} 已更新");
    }

    public function adjustBalance(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'remark' => 'nullable|string|max:255',
        ]);

        $amount = (float) $request->amount;
        $user->increment('balance', $amount);

        \App\Models\Transaction::create([
            'transaction_no' => 'ADJ' . date('YmdHis') . rand(1000, 9999),
            'user_id'        => $user->id,
            'amount'         => $amount,
            'gateway'        => 'admin_adjust',
            'status'         => 'success',
            'gateway_response' => ['remark' => $request->remark, 'operator' => auth()->id()],
        ]);

        $action = $amount > 0 ? '增加' : '扣除';
        return back()->with('success', "已为 {$user->name} {$action} ¥" . abs($amount));
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'idc' . rand(100000, 999999);
        $user->update(['password' => bcrypt($newPassword)]);
        return back()->with('success', "密码已重置为：{$newPassword}（请立即通知用户）");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '不能删除自己');
        }
        $user->delete();
        return back()->with('success', '用户已删除');
    }
}
