<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
class NotificationController extends Controller {
    public function index() {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('client.notifications.index', compact('notifications'));
    }
    public function markRead($id) {
        $n = auth()->user()->notifications()->findOrFail($id);
        $n->markAsRead();
        return redirect($n->data['url'] ?? route('client.notifications.index'));
    }
    public function markAllRead() {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success','全部已读');
    }
}
