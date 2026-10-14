<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class ServiceExpiringNotification extends Notification {
    use Queueable;
    public function __construct(public $service, public int $days) {}
    public function via($notifiable) { return ['database','mail']; }
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('⏰ 服务即将到期 - '.$this->days.' 天后')
            ->greeting('亲爱的 '.$notifiable->name)
            ->line('您的服务 '.optional($this->service->product)->name.' 将在 '.$this->days.' 天后到期。')
            ->line('到期时间：'.optional($this->service->expires_at)->format('Y-m-d'))
            ->line('请及时续费以免影响使用~')
            ->action('立即续费', route('client.services.show', $this->service));
    }
    public function toDatabase($notifiable) {
        return [
            'type' => 'service_expiring',
            'title' => '⏰ 服务即将到期',
            'content' => optional($this->service->product)->name.' 将在 '.$this->days.' 天后到期',
            'url' => route('client.services.show', $this->service),
        ];
    }
}
