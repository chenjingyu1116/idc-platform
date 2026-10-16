<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🌸 订单提交成功 - ' . $this->order->order_no)
            ->greeting('Hi ' . $notifiable->name . '！')
            ->line('您的订单已成功提交：')
            ->line('**订单号**：' . $this->order->order_no)
            ->line('**金额**：¥' . $this->order->total_amount)
            ->line('**状态**：待开通')
            ->action('查看订单', url('/client/services'))
            ->line('我们会尽快为您开通服务 🌸');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'title'    => '订单提交成功',
            'content'  => '订单 ' . $this->order->order_no . ' 已提交，等待开通',
            'url'      => '/client/services',
        ];
    }
}
