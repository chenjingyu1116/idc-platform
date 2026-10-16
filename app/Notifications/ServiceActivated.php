<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceActivated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Service $service) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 服务已开通 - ' . ($this->service->product->name ?? 'VPS'))
            ->greeting('Hi ' . $notifiable->name . '！')
            ->line('您的服务已开通 🎉')
            ->line('**产品**：' . ($this->service->product->name ?? 'VPS'))
            ->line('**IP / 域名**：' . ($this->service->ip_address ?? '-'))
            ->line('**用户名**：' . ($this->service->username ?? '-'))
            ->action('查看详情', url('/client/services/' . $this->service->id))
            ->line('祝您使用愉快 🌸');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_id' => $this->service->id,
            'title'      => '服务已开通',
            'content'    => ($this->service->product->name ?? 'VPS') . ' 已开通',
            'url'        => '/client/services/' . $this->service->id,
        ];
    }
}
