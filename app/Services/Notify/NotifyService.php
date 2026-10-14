<?php
namespace App\Services\Notify;

use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyService
{
    // 发送站内信
    public static function sendInApp(User $user, string $event, string $title, string $content): void
    {
        NotificationLog::create([
            'user_id' => $user->id,
            'channel' => 'in_app',
            'event' => $event,
            'title' => $title,
            'content' => $content,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    // 发送邮件
    public static function sendMail(User $user, string $event, string $subject, string $body): void
    {
        $log = NotificationLog::create([
            'user_id' => $user->id,
            'channel' => 'mail',
            'event' => $event,
            'title' => $subject,
            'content' => $body,
            'status' => 'pending',
        ]);

        try {
            Mail::raw($body, function ($m) use ($user, $subject) {
                $m->to($user->email, $user->name)->subject($subject);
            });
            $log->update(['status' => 'sent', 'sent_at' => now()]);
        } catch (\Exception $e) {
            $log->update(['status' => 'failed', 'error' => $e->getMessage()]);
        }
    }

    // 常用事件快捷方法
    public static function orderPaid(User $user, $order): void
    {
        self::sendInApp($user, 'order_paid', '订单已支付', "订单 {$order->order_no} 已支付成功，正在开通服务。");
    }

    public static function serviceActivated(User $user, $service): void
    {
        $ip = $service->ip_address ?? '待分配';
        self::sendInApp($user, 'service_activated', '服务已开通', "服务已激活，IP：{$ip}，请前往我的服务查看详情。");
        self::sendMail($user, 'service_activated', '【樱花云】服务已开通', "您的服务已开通成功。\nIP 地址：{$ip}\n用户名：{$service->username}\n密码：{$service->password_encrypted}\n请登录控制台查看。");
    }

    public static function serviceExpiring(User $user, $service, int $days): void
    {
        self::sendInApp($user, 'service_expiring', '服务即将到期', "您的服务将在 {$days} 天后到期，请及时续费。");
        self::sendMail($user, 'service_expiring', '【樱花云】服务到期提醒', "您的服务将在 {$days} 天后到期。\n到期时间：{$service->expires_at}\n请及时续费以免影响使用。");
    }

    public static function rechargeApproved(User $user, $recharge): void
    {
        self::sendInApp($user, 'recharge_approved', '充值已到账', "充值 ¥{$recharge->amount} 已到账，当前余额 ¥{$user->balance}。");
    }
}
