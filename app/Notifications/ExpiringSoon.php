<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiringSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Service $service, public int $daysLeft) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ 服务即将到期 - ' . ($this->service->product->name ?? 'VPS'))
            ->greeting('Hi ' . $notifiable->name . '！')
            ->line('您的服务将在 ' . $this->daysLeft . ' 天后到期')
            ->line('**产品**：' . ($this->service->product->name ?? 'VPS'))
            ->line('**到期时间**：' . optional($this->service->expires_at)->format('Y-m-d'))
            ->action('立即续费', url('/client/services/' . $this->service->id))
            ->line('请及时续费，避免服务中断 🌸');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_id' => $this->service->id,
            'title'      => '服务即将到期',
            'content'    => '还有 ' . $this->daysLeft . ' 天到期，请及时续费',
            'url'        => '/client/services/' . $this->service->id,
        ];
    }
}
