<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller {
    public function index() {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    public function edit(User $user) { return view('admin.users.edit', compact('user')); }
    public function update(Request $request, User $user) {
        $v = $request->validate(['name'=>'required|string','email'=>'required|email','balance'=>'required|numeric','is_admin'=>'boolean']);
        $user->update($v);
        return redirect()->route('admin.users.index')->with('success','已更新');
    }
}
