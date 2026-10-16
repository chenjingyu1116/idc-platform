<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Notifications\TicketReplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'replies.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'file'    => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tickets', 'public');
        }

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'is_staff'  => true,
            'message'   => $request->message,
            'file_path' => $filePath,
        ]);

        // 推送站内信给工单所属用户
        if ($ticket->user) {
            $ticket->user->notify(new TicketReplied($ticket, $reply, true));
        }

        // 自动更新工单状态为处理中
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'processing']);
        }

        return back()->with('success', '回复成功，已通知用户');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('success', '工单已关闭');
    }
}
