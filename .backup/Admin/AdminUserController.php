<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)->latest()->paginate(20);
        return view('admin.admins.index', compact('admins'));
    }
    public function create()
    {
        return view('admin.admins.create');
    }
    public function store(Request $request)
    {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        User::create([
            'name' => $v['name'],
            'email' => $v['email'],
            'password' => Hash::make($v['password']),
            'is_admin' => true,
            'balance' => 0,
        ]);
        return redirect()->route('admin.admins.index')->with('success','管理员已添加');
    }
    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) return back()->with('error','不能删除自己');
        $admin->update(['is_admin' => false]);
        return back()->with('success','已取消管理员权限');
    }
}
