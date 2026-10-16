<?php

namespace App\Services\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NovaixProvider implements ProvisioningInterface
{
    protected string $baseUrl;
    protected string $apiToken;
    protected int $timeout = 30;

    public function __construct(array $config = [])
    {
        $this->baseUrl  = rtrim($config['api_url'] ?? '', '/');
        $this->apiToken = $config['api_token'] ?? '';
    }

    /**
     * 统一请求封装
     */
    protected function request(string $method, string $path, array $data = []): array
    {
        if (empty($this->baseUrl) || empty($this->apiToken)) {
            return ['success' => false, 'message' => 'Novaix 配置缺失：api_url 或 api_token 为空'];
        }

        $url = $this->baseUrl . $path;

        try {
            $http = Http::timeout($this->timeout)
                ->withToken($this->apiToken)
                ->acceptJson()
                ->asJson();

            $resp = match (strtoupper($method)) {
                'GET'    => $http->get($url, $data),
                'POST'   => $http->post($url, $data),
                'PUT'    => $http->put($url, $data),
                'DELETE' => $http->delete($url, $data),
                default  => throw new \InvalidArgumentException("不支持的方法: {$method}"),
            };

            $json = $resp->json() ?? [];

            if (!$resp->successful()) {
                Log::warning("[Novaix] {$method} {$path} HTTP {$resp->status()}", [
                    'req' => $data, 'resp' => $json,
                ]);
                return [
                    'success' => false,
                    'message' => $json['message'] ?? "HTTP {$resp->status()}",
                    'raw'     => $json,
                ];
            }

            Log::info("[Novaix] {$method} {$path}", ['resp' => $json]);
            return ['success' => true, 'data' => $json['data'] ?? $json, 'raw' => $json];

        } catch (\Throwable $e) {
            Log::error("[Novaix] {$method} {$path} 异常: " . $e->getMessage());
            return ['success' => false, 'message' => '请求 Novaix 失败: ' . $e->getMessage()];
        }
    }

    /**
     * 开通资源
     * ⚠️ 需根据 Novaix 实际 API 文档调整 path / 字段名
     */
    public function provision(Service $service): array
    {
        $cfg = $service->resource_config ?? [];

        $payload = [
            'plan_id'  => $service->upstream_product_id ?: ($cfg['plan_id'] ?? null),
            'hostname' => $cfg['hostname'] ?? ('user' . $service->user_id . '-' . $service->id),
            'os'       => $cfg['os'] ?? 'ubuntu-22.04',
            'region'   => $cfg['region'] ?? null,
            'label'    => "Service-{$service->id}",
        ];

        $result = $this->request('POST', '/api/provisioning/instances', $payload);

        if (!($result['success'] ?? false)) {
            return ['success' => false, 'message' => $result['message'] ?? '开通失败'];
        }

        $data = $result['data'] ?? [];

        return [
            'success' => true,
            'message' => '开通成功',
            'data'    => [
                'instance_id'   => $data['id'] ?? null,
                'ip_address'    => $data['ip'] ?? ($data['ip_address'] ?? null),
                'hostname'      => $data['hostname'] ?? null,
                'username'      => $data['username'] ?? 'root',
                'password'      => $data['password'] ?? null,
                'status'        => $data['status'] ?? 'active',
            ],
        ];
    }

    public function suspend(Service $service): bool
    {
        $id = $this->getInstanceId($service);
        if (!$id) return false;

        $r = $this->request('POST', "/api/provisioning/instances/{$id}/suspend");
        return $r['success'] ?? false;
    }

    public function unsuspend(Service $service): bool
    {
        $id = $this->getInstanceId($service);
        if (!$id) return false;

        $r = $this->request('POST', "/api/provisioning/instances/{$id}/unsuspend");
        return $r['success'] ?? false;
    }

    public function terminate(Service $service): bool
    {
        $id = $this->getInstanceId($service);
        if (!$id) return false;

        $r = $this->request('DELETE', "/api/provisioning/instances/{$id}");
        return $r['success'] ?? false;
    }

    public function getStatus(Service $service): string
    {
        $id = $this->getInstanceId($service);
        if (!$id) return 'unknown';

        $r = $this->request('GET', "/api/provisioning/instances/{$id}");
        if (!($r['success'] ?? false)) return 'unknown';

        $status = strtolower($r['data']['status'] ?? 'unknown');
        return match ($status) {
            'running', 'active'  => 'active',
            'stopped', 'paused'  => 'suspended',
            'terminated'         => 'terminated',
            default              => 'pending',
        };
    }

    public function getProducts(): array
    {
        $r = $this->request('GET', '/api/provisioning/plans');
        if (!($r['success'] ?? false)) return [];

        $plans = $r['data'] ?? [];
        return array_map(fn($p) => [
            'id'    => $p['id'] ?? null,
            'name'  => $p['name'] ?? 'Unnamed',
            'price' => $p['price'] ?? null,
        ], is_array($plans) ? $plans : []);
    }

    /**
     * 从 Service 取上游实例 ID
     */
    protected function getInstanceId(Service $service): ?string
    {
        return $service->upstream_service_id
            ?: ($service->resource_config['instance_id'] ?? null);
    }
}
