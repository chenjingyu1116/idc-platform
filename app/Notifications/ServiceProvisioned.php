<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceProvisioned extends Notification
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
            ->subject('🌸 开通成功 - ' . ($this->service->product->name ?? '服务'))
            ->greeting('Hi ' . $notifiable->name . '！')
            ->line('您购买的「' . ($this->service->product->name ?? '服务') . '」已经开通成功！')
            ->line('IP 地址：' . ($this->service->ip_address ?? '待分配'))
            ->line('用户名：' . ($this->service->username ?? '-'))
            ->line('到期时间：' . ($this->service->expires_at ? $this->service->expires_at->format('Y-m-d') : '-'))
            ->action('查看详情', url('/client/services/' . $this->service->id))
            ->line('感谢您的信任，樱花云会一直陪伴您 🌸');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_id' => $this->service->id,
            'title'      => '服务开通成功',
            'content'    => '您购买的「' . ($this->service->product->name ?? '服务') . '」已开通',
            'url'        => '/client/services/' . $this->service->id,
        ];
    }
}
