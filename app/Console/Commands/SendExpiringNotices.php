<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Notifications\ExpiringSoon;
use Illuminate\Console\Command;

class SendExpiringNotices extends Command
{
    protected $signature   = 'services:expiring-notice {days=7}';
    protected $description = '发送服务到期提醒（默认提前 7 天）';

    public function handle()
    {
        $days = (int) $this->argument('days');
        $target = now()->addDays($days);

        $services = Service::where('status', 'active')
            ->whereBetween('expires_at', [now(), $target])
            ->get();

        $this->info("找到 {$services->count()} 个即将到期的服务");

        foreach ($services as $service) {
            if ($service->user) {
                $daysLeft = now()->diffInDays($service->expires_at, false);
                $service->user->notify(new ExpiringSoon($service, $daysLeft));
                $this->line("  📧 已通知: {$service->user->email} (还有 {$daysLeft} 天)");
            }
        }

        $this->info("✅ 完成");
        return 0;
    }
}
