<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🌸 欢迎加入樱花云 - ' . $notifiable->name)
            ->greeting('Hi ' . $notifiable->name . '，欢迎来到樱花云！')
            ->line('感谢你注册樱花云，这里是你专属的二次元云平台 🌸')
            ->line('')
            ->line('📖 快速上手：')
            ->line('  1. 前往「产品列表」选购云服务器')
            ->line('  2. 使用支付宝/微信支付或充值余额')
            ->line('  3. 支付成功后系统自动开通，秒级交付')
            ->line('  4. 在「我的服务」查看 IP / 账号 / 密码')
            ->line('')
            ->line('🎁 新用户福利：首次下单可使用优惠券')
            ->line('💌 遇到问题？提交工单，7×24 萌妹客服在线')
            ->action('立即选购产品', url('/products'))
            ->line('樱花云 · 让 IDC 管理也能如此可爱 🎀');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => '欢迎加入樱花云',
            'content' => '感谢注册！前往产品列表选购你的第一台云服务器吧 🌸',
            'url'     => '/products',
        ];
    }
}
