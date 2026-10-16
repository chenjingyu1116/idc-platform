<?php

namespace App\Jobs;

use App\Models\ProvisionLog;
use App\Models\Service;
use App\Services\Providers\ProviderFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProvisionService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(public Service $service) {}

    public function handle(): void
    {
        $provider = ProviderFactory::make($this->service->provider);
        $result = $provider->provision($this->service);

        // 写开通日志
        ProvisionLog::create([
            'service_id'  => $this->service->id,
            'provider_id' => $this->service->provider_id,
            'action'      => 'provision',
            'status'      => ($result['success'] ?? false) ? 'success' : 'failed',
            'request'     => json_encode([
                'service_id' => $this->service->id,
                'domain'     => $this->service->resource_config['domain'] ?? null,
            ], JSON_UNESCAPED_UNICODE),
            'response'    => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        // 根据结果处理
        if ($result['success'] ?? false) {
            if ($this->service->provider_type === 'manual') {
                // 手动模式：等待管理员
                $this->service->update(['status' => 'pending']);
            } else {
                // 自动开通成功：写回 IP / 用户名 / 密码
                $data = $result['data'] ?? [];
                $this->service->update([
                    'status'              => 'active',
                    'ip_address'          => $data['domain'] ?? ($this->service->resource_config['domain'] ?? null),
                    'username'            => $data['db_user'] ?? null,
                    'password_encrypted'  => $data['db_pass'] ?? null,
                    'upstream_service_id' => $data['site_id'] ?? null,
                    'activated_at'        => now(),
                    'expires_at'          => now()->addMonth(),
                ]);
            }
        }
    }
}
