<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Notifier
{
    /**
     * 推送站内信（写入 Laravel notifications 表）
     */
    public static function send($userId, string $title, string $content, string $type = 'info', ?string $link = null): void
    {
        $user = User::find($userId);
        if (!$user) return;

        DB::table('notifications')->insert([
            'id'              => (string) \Illuminate\Support\Str::uuid(),
            'type'            => 'App\\Notifications\\SiteNotification',
            'notifiable_type' => User::class,
            'notifiable_id'   => $user->id,
            'data'            => json_encode([
                'title'   => $title,
                'content' => $content,
                'type'    => $type,
                'link'    => $link,
            ], JSON_UNESCAPED_UNICODE),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // 常用快捷方法
    public static function orderPaid($userId, $orderNo, $amount): void {
        self::send($userId, '订单支付成功',
            "订单 {$orderNo} 已支付 ¥{$amount}，正在为您开通资源。",
            'success', '/client/services');
    }

    public static function serviceActivated($userId, $serviceId, $domain): void {
        self::send($userId, '服务开通成功',
            "您的服务已开通，域名/地址：{$domain}。",
            'success', "/client/services/{$serviceId}");
    }

    public static function rechargeApproved($userId, $amount): void {
        self::send($userId, '充值成功',
            "已为您充值 ¥{$amount}，可前往余额查看。",
            'success', '/client/recharge');
    }

    public static function ticketReplied($userId, $ticketId, $title): void {
        self::send($userId, '工单已回复',
            "您的工单「{$title}」已收到客服回复。",
            'info', "/client/tickets/{$ticketId}");
    }

    public static function serviceExpiring($userId, $serviceId, $days): void {
        self::send($userId, '服务即将到期',
            "您有服务将在 {$days} 天后到期，请及时续费。",
            'warning', "/client/services/{$serviceId}");
    }
}
