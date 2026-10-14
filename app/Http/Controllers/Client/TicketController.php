<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
class TicketController extends Controller {
    public function index() {
        $tickets = Ticket::where('user_id',auth()->id())->latest()->paginate(10);
        return view('client.tickets.index', compact('tickets'));
    }
    public function create() { return view('client.tickets.create'); }
    public function store(Request $request) {
        $v = $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required|string',
            'category'=>'nullable|string',
            'priority'=>'nullable|string',
        ]);
        Ticket::create([
            'user_id'=>auth()->id(),'title'=>$v['title'],'content'=>$v['content'],
            'category'=>$v['category'] ?? 'technical','priority'=>$v['priority'] ?? 'normal',
        ]);
        return redirect()->route('client.tickets.index')->with('success','工单提交成功');
    }
    public function show(Ticket $ticket) {
        if ($ticket->user_id !== auth()->id()) abort(403);
        $replies = TicketReply::where('ticket_id',$ticket->id)->with('user')->oldest()->get();
        return view('client.tickets.show', compact('ticket','replies'));
    }
    public function reply(Request $request, Ticket $ticket) {
        if ($ticket->user_id !== auth()->id()) abort(403);
        $v = $request->validate(['content'=>'required|string']);
        TicketReply::create([
            'ticket_id'=>$ticket->id,'user_id'=>auth()->id(),
            'is_admin'=>false,'content'=>$v['content'],
        ]);
        $ticket->update(['status'=>'open']);
        return back()->with('success','已回复');
    }
}
