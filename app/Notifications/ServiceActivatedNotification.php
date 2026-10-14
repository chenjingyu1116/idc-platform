<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class ServiceActivatedNotification extends Notification {
    use Queueable;
    public function __construct(public $service) {}
    public function via($notifiable) { return ['database','mail']; }
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('✨ 服务已开通 - '.optional($this->service->product)->name)
            ->greeting('亲爱的 '.$notifiable->name)
            ->line('您的服务已成功开通！')
            ->line('IP：'.($this->service->ip_address ?? '-'))
            ->line('账号：'.($this->service->username ?? '-'))
            ->line('密码：'.($this->service->password_encrypted ?? '-'))
            ->action('查看详情', route('client.services.show', $this->service));
    }
    public function toDatabase($notifiable) {
        return [
            'type' => 'service_activated',
            'title' => '✨ 服务已开通',
            'content' => optional($this->service->product)->name.' 已激活，IP：'.($this->service->ip_address ?? '-'),
            'url' => route('client.services.show', $this->service),
        ];
    }
}
