<?php
namespace App\Http\Controllers;
use App\Models\Announcement;
class AnnouncementController extends Controller {
    public function index() {
        $announcements = Announcement::active()->paginate(15);
        return view('announcements.index', compact('announcements'));
    }
    public function show(Announcement $announcement) {
        return view('announcements.show', compact('announcement'));
    }
}
