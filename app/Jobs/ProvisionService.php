<?php
namespace App\Jobs;
use App\Models\Service;
use App\Services\Providers\ProviderFactory;
use App\Notifications\ServiceActivatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class ProvisionService implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $tries = 3;
    public int $timeout = 120;
    public function __construct(public Service $service) {}
    public function handle(): void {
        $provider = ProviderFactory::make($this->service->provider);
        $result = $provider->provision($this->service);
        if ($result['success'] ?? false) {
            $this->service->refresh();
            if ($this->service->user && $this->service->status === 'active') {
                $this->service->user->notify(new ServiceActivatedNotification($this->service));
            }
        } else {
            logger()->error('开通失败: '.($result['message'] ?? ''));
        }
    }
}
