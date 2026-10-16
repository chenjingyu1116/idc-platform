<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketReplied extends Notification
{
    use Queueable;

    public function __construct(
        public Ticket $ticket,
        public TicketReply $reply,
        public bool $fromStaff = false
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $who = $this->fromStaff ? '客服' : '您';
        return [
            'ticket_id' => $this->ticket->id,
            'title'     => $this->fromStaff ? '客服回复了您的工单' : '工单有新回复',
            'content'   => "《{$this->ticket->title}》{$who}回复：" . mb_substr($this->reply->message, 0, 50),
            'url'       => '/client/tickets/' . $this->ticket->id,
        ];
    }
}
