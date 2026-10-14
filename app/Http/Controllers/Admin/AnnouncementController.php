<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AnnouncementController extends Controller {
    public function index() {
        $announcements = Announcement::latest()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }
    public function create() { return view('admin.announcements.create'); }
    public function store(Request $request) {
        $v = $request->validate([
            'title'=>'required|string','content'=>'required|string',
            'type'=>'nullable|string','is_pinned'=>'boolean','is_active'=>'boolean',
        ]);
        Announcement::create([
            'title'=>$v['title'],'content'=>$v['content'],
            'type'=>$v['type'] ?? 'info',
            'is_pinned'=>$request->boolean('is_pinned'),
            'is_active'=>$request->boolean('is_active', true),
            'published_at'=>now(),
        ]);
        return redirect()->route('admin.announcements.index')->with('success','公告已发布');
    }
    public function destroy(Announcement $announcement) {
        $announcement->delete();
        return back()->with('success','已删除');
    }
}
