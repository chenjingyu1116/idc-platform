<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::latest();
        if ($k = $request->input('kw')) {
            $q->where('name', 'like', "%{$k}%")->orWhere('email', 'like', "%{$k}%");
        }
        $users = $q->paginate(20);
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'balance' => 'required|numeric',
            'is_admin' => 'boolean',
        ]);
        $user->update([
            'name' => $v['name'],
            'email' => $v['email'],
            'balance' => $v['balance'],
            'is_admin' => $request->boolean('is_admin'),
        ]);
        return redirect()->route('admin.users.index')->with('success', '用户已更新');
    }

    public function adjustBalance(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'nullable|string|max:255',
        ]);
        $user->increment('balance', $request->amount);
        return back()->with('success', "已调整余额 ¥{$request->amount}");
    }

    public function resetPassword(User $user)
    {
        $newPwd = 'sakura' . rand(1000, 9999);
        $user->update(['password' => Hash::make($newPwd)]);
        return back()->with('success', "新密码：{$newPwd}（请复制给用户）");
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) return back()->with('error', '不能删除管理员');
        $user->delete();
        return back()->with('success', '用户已删除');
    }
}
