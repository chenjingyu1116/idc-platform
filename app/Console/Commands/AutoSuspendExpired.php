<?php
namespace App\Console\Commands;

use App\Models\Service;
use App\Services\Providers\ProviderFactory;
use Illuminate\Console\Command;

class AutoSuspendExpired extends Command
{
    protected $signature = 'services:auto-suspend';
    protected $description = '自动暂停已过期服务';

    public function handle(): int
    {
        $services = Service::where('status', 'active')
            ->where('expires_at', '<', now())
            ->with('provider')
            ->get();

        foreach ($services as $service) {
            try {
                $provider = ProviderFactory::make($service->provider);
                $provider->suspend($service);
                $this->info("已暂停服务 #{$service->id}");
            } catch (\Exception $e) {
                $this->error("暂停失败 #{$service->id}: {$e->getMessage()}");
            }
        }
        return self::SUCCESS;
    }
}
