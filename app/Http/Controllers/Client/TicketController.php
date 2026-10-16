<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketAttachment;
use App\Services\Notifier;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->latest()->paginate(10);
        return view('client.tickets.index', compact('tickets'));
    }

    public function create() { return view('client.tickets.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => 'open',
        ]);

        return redirect()->route('client.tickets.show', $ticket)->with('success', '工单已提交');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) abort(403);
        $ticket->load(['replies.user', 'replies.attachments']);
        return view('client.tickets.show', compact('ticket'));
    }

    /**
     * 用户追加消息
     */
    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) abort(403);

        $request->validate([
            'message'   => 'required|string|max:5000',
            'file'      => 'nullable|file|max:10240',
        ]);

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'is_staff'  => false,
            'message'   => $request->message,
        ]);

        if ($request->hasFile('file')) {
            $this->attachFile($reply, $request->file('file'));
        }

        $ticket->update(['status' => 'open']);

        return back()->with('success', '已回复');
    }

    private function attachFile($reply, $file)
    {
        $path = $file->store('tickets/' . $reply->ticket_id, 'public');
        TicketAttachment::create([
            'ticket_reply_id' => $reply->id,
            'filename' => $file->getClientOriginalName(),
            'path'     => $path,
            'size'     => $file->getSize(),
            'mime'     => $file->getMimeType(),
        ]);
    }
}
