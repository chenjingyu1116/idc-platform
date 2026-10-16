<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();

        if ($kw = trim($request->input('kw', ''))) {
            $q->where(function ($qq) use ($kw) {
                $qq->where('name', 'like', "%{$kw}%")
                   ->orWhere('email', 'like', "%{$kw}%")
                   ->orWhere('phone', 'like', "%{$kw}%");
            });
        }

        if ($request->input('role') === 'admin') {
            $q->where('is_admin', true);
        } elseif ($request->input('role') === 'user') {
            $q->where('is_admin', false);
        }

        if ($min = $request->input('min_balance')) {
            $q->where('balance', '>=', $min);
        }

        $users = $q->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders', 'services']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'balance'  => 'required|numeric|min:0',
            'is_admin' => 'boolean',
        ]);

        $data['is_admin'] = $request->boolean('is_admin');
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', "用户 {$user->name} 已更新");
    }

    public function adjustBalance(Request $request, User $user)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'nullable|string|max:255',
        ]);

        $user->increment('balance', $data['amount']);

        \App\Models\ProvisionLog::create([
            'service_id'  => null,
            'provider_id' => null,
            'action'      => 'adjust_balance',
            'status'      => 'success',
            'request'     => json_encode(['user_id' => $user->id, 'amount' => $data['amount'], 'reason' => $data['reason'] ?? ''], JSON_UNESCAPED_UNICODE),
            'response'    => json_encode(['new_balance' => $user->fresh()->balance], JSON_UNESCAPED_UNICODE),
        ]);

        return back()->with('success', "已为 {$user->name} 调整余额 ¥{$data['amount']}");
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('12345678')]);
        return back()->with('success', "已重置 {$user->name} 的密码为 12345678");
    }

    public function export(): StreamedResponse
    {
        $users = User::latest()->get();
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="users-' . date('YmdHis') . '.csv"',
        ];

        return response()->stream(function () use ($users) {
            $fh = fopen('php://output', 'w');
            fwrite($fh, "\xEF\xBB\xBF");
            fputcsv($fh, ['ID', '昵称', '邮箱', '余额', '是否管理员', '注册时间']);
            foreach ($users as $u) {
                fputcsv($fh, [$u->id, $u->name, $u->email, $u->balance, $u->is_admin ? '是' : '否', $u->created_at]);
            }
            fclose($fh);
        }, 200, $headers);
    }
}
