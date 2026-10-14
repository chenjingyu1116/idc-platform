<?php
namespace App\Console\Commands;
use App\Models\Service;
use App\Notifications\ServiceExpiringNotification;
use Illuminate\Console\Command;
class CheckExpiringServices extends Command {
    protected $signature = 'services:check-expiring';
    protected $description = '检查即将到期的服务并通知客户';
    public function handle() {
        foreach ([7, 3, 1] as $days) {
            $target = now()->addDays($days)->startOfDay();
            $services = Service::where('status','active')
                ->whereDate('expires_at', $target->toDateString())
                ->with('user','product')->get();
            foreach ($services as $s) {
                if ($s->user) {
                    $s->user->notify(new ServiceExpiringNotification($s, $days));
                    $this->info("已通知 {$s->user->email}：{$days} 天后到期");
                }
            }
        }
    }
}
