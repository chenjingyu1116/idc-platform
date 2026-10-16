<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
class MemberLevelController extends Controller {
    public function index() {
        $levels = MemberLevel::orderBy('min_spent')->get();
        return view('admin.levels.index', compact('levels'));
    }
    public function store(Request $request) {
        $v = $request->validate([
            'name'=>'required|string','min_spent'=>'required|integer|min:0',
            'discount'=>'required|numeric|min:0|max:100',
            'points_multiplier'=>'required|integer|min:1',
            'color'=>'nullable|string',
        ]);
        MemberLevel::create($v);
        return back()->with('success','已创建');
    }
    public function destroy(MemberLevel $level) { $level->delete(); return back()->with('success','已删除'); }
}
