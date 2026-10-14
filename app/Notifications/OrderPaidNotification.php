<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class OrderPaidNotification extends Notification {
    use Queueable;
    public function __construct(public $order) {}
    public function via($notifiable) { return ['database','mail']; }
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('🌸 订单支付成功 - '.$this->order->order_no)
            ->greeting('亲爱的 '.$notifiable->name)
            ->line('您的订单 '.$this->order->order_no.' 已支付成功！')
            ->line('金额：¥'.$this->order->total_amount)
            ->line('樱花喵正在为您开通资源，请稍候~')
            ->action('查看订单', route('client.orders.show', $this->order));
    }
    public function toDatabase($notifiable) {
        return [
            'type' => 'order_paid',
            'title' => '🌸 订单支付成功',
            'content' => '订单 '.$this->order->order_no.' 已支付 ¥'.$this->order->total_amount,
            'url' => route('client.orders.show', $this->order),
        ];
    }
}
