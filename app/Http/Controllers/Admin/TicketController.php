<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
class TicketController extends Controller {
    public function index() {
        $tickets = Ticket::with('user')->latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket) {
        $replies = TicketReply::where('ticket_id',$ticket->id)->with('user')->oldest()->get();
        return view('admin.tickets.show', compact('ticket','replies'));
    }
    public function reply(Request $request, Ticket $ticket) {
        $v = $request->validate(['content'=>'required|string']);
        TicketReply::create([
            'ticket_id'=>$ticket->id,'user_id'=>auth()->id(),
            'is_admin'=>true,'content'=>$v['content'],
        ]);
        $ticket->update(['status'=>'replied']);
        return back()->with('success','已回复');
    }
    public function close(Ticket $ticket) {
        $ticket->update(['status'=>'closed']);
        return back()->with('success','已关闭');
    }
}
