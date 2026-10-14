<?php
namespace App\Services\Providers;
use App\Models\Service;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class HttpProvider implements ProvisioningInterface {
    protected ?Provider $provider;
    protected array $config;

    public function __construct(?Provider $provider) {
        $this->provider = $provider;
        $this->config = $provider?->config ?? [];
    }

    protected function endpoint(string $key, string $default): string {
        $base = rtrim($this->provider?->api_url ?? '', '/');
        $path = $this->config['endpoints'][$key] ?? $default;
        return $base . $path;
    }

    protected function headers(): array {
        $creds = $this->provider?->credentials_encrypted ?? [];
        return [
            'Authorization' => 'Bearer ' . ($creds['api_key'] ?? ''),
            'X-API-Secret' => $creds['api_secret'] ?? '',
            'Accept' => 'application/json',
        ];
    }

    protected function payload(array $extra = []): array {
        return array_merge([
            'timestamp' => time(),
            'nonce' => bin2hex(random_bytes(8)),
        ], $extra);
    }

    public function provision(Service $service): array {
        try {
            $resp = Http::withHeaders($this->headers())
                ->timeout(30)
                ->post($this->endpoint('provision', '/api/v1/provision'), $this->payload([
                    'upstream_product_id' => $service->upstream_product_id,
                    'order_no' => optional($service->order)->order_no,
                    'quantity' => 1,
                ]));
            if (!$resp->successful()) {
                return ['success'=>false, 'message'=>'上游返回错误：'.$resp->status()];
            }
            $data = $resp->json();
            if (($data['code'] ?? -1) !== 0) {
                return ['success'=>false, 'message'=>$data['msg'] ?? '上游开通失败'];
            }
            $info = $data['data'] ?? [];
            $service->update([
                'upstream_service_id' => $info['service_id'] ?? null,
                'ip_address' => $info['ip'] ?? null,
                'username' => $info['username'] ?? null,
                'password_encrypted' => $info['password'] ?? null,
                'status' => 'active',
                'activated_at' => now(),
                'expires_at' => now()->addMonth(),
            ]);
            return ['success'=>true, 'message'=>'自动开通成功'];
        } catch (\Throwable $e) {
            Log::error('HttpProvider provision 失败: '.$e->getMessage());
            return ['success'=>false, 'message'=>'异常：'.$e->getMessage()];
        }
    }

    protected function callAction(Service $service, string $action, string $defaultPath): bool {
        try {
            $resp = Http::withHeaders($this->headers())
                ->timeout(30)
                ->post($this->endpoint($action, $defaultPath), $this->payload([
                    'service_id' => $service->upstream_service_id,
                ]));
            return $resp->successful() && (($resp->json('code') ?? -1) === 0);
        } catch (\Throwable $e) {
            Log::error("HttpProvider {$action} 失败: ".$e->getMessage());
            return false;
        }
    }

    public function suspend(Service $service): bool {
        if (!$this->callAction($service, 'suspend', '/api/v1/suspend')) return false;
        return $service->update(['status'=>'suspended']);
    }
    public function unsuspend(Service $service): bool {
        if (!$this->callAction($service, 'unsuspend', '/api/v1/unsuspend')) return false;
        return $service->update(['status'=>'active']);
    }
    public function terminate(Service $service): bool {
        if (!$this->callAction($service, 'terminate', '/api/v1/terminate')) return false;
        return $service->update(['status'=>'terminated']);
    }
    public function getStatus(Service $service): string {
        return $service->status;
    }
    public function getProducts(): array {
        try {
            $resp = Http::withHeaders($this->headers())
                ->timeout(15)
                ->get($this->endpoint('products', '/api/v1/products'));
            return $resp->json('data') ?? [];
        } catch (\Throwable $e) { return []; }
    }
    public function ping(): array {
        try {
            $resp = Http::withHeaders($this->headers())->timeout(8)->get($this->endpoint('ping','/api/v1/ping'));
            return ['ok'=>$resp->successful(),'status'=>$resp->status(),'body'=>substr($resp->body(),0,200)];
        } catch (\Throwable $e) {
            return ['ok'=>false,'status'=>0,'body'=>$e->getMessage()];
        }
    }
}
