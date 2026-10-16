<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|max:20',
        ]);
        Announcement::create([
            'title' => $v['title'],
            'content' => $v['content'],
            'type' => $v['type'] ?? 'info',
            'is_pinned' => $request->boolean('is_pinned'),
            'is_active' => $request->boolean('is_active', true),
            'published_at' => now(),
        ]);
        return redirect()->route('admin.announcements.index')->with('success', '公告已发布');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $v = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $announcement->update([
            'title' => $v['title'],
            'content' => $v['content'],
            'is_pinned' => $request->boolean('is_pinned'),
            'is_active' => $request->boolean('is_active'),
        ]);
        return redirect()->route('admin.announcements.index')->with('success', '公告已更新');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', '公告已删除');
    }
}
