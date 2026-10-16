<?php

namespace App\Services\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BtPanelProvider implements ProvisioningInterface
{
    protected string $panelUrl;
    protected string $apiSk;
    protected int $timeout = 30;

    public function __construct(array $config = [])
    {
        $this->panelUrl = rtrim($config['panel_url'] ?? '', '/');
        $this->apiSk    = $config['api_sk'] ?? '';
    }

    /**
     * 生成宝塔 API 签名（request_time + MD5(request_time + MD5(api_sk))）
     */
    protected function sign(): array
    {
        $requestTime  = time();
        $requestToken = md5($requestTime . md5($this->apiSk));
        return [
            'request_time'  => $requestTime,
            'request_token' => $requestToken,
        ];
    }

    /**
     * 通用请求
     */
    protected function request(string $module, string $action, array $data = []): array
    {
        if (empty($this->panelUrl) || empty($this->apiSk)) {
            return ['success' => false, 'message' => '宝塔配置缺失：panel_url 或 api_sk 为空'];
        }

        $payload = array_merge($this->sign(), ['action' => $action], $data);

        try {
            $resp = Http::timeout($this->timeout)
                ->asForm()
                ->withoutVerifying()   // 宝塔面板常为自签证书，生产环境建议开启验证
                ->post("{$this->panelUrl}/{$module}", $payload);

            if (!$resp->successful()) {
                Log::warning("[BtPanel] {$module}.{$action} HTTP {$resp->status()}");
                return ['success' => false, 'message' => "HTTP {$resp->status()}"];
            }

            $json = $resp->json() ?? [];
            Log::info("[BtPanel] {$module}.{$action}", ['req' => $payload, 'resp' => $json]);
            return $json;

        } catch (\Throwable $e) {
            Log::error("[BtPanel] {$module}.{$action} 请求异常: " . $e->getMessage());
            return ['success' => false, 'message' => '请求宝塔失败: ' . $e->getMessage()];
        }
    }

    /**
     * 开通资源：创建网站 + 数据库
     */
    public function provision(Service $service): array
    {
        $cfg        = $service->resource_config ?? [];
        $domain     = $cfg['domain']      ?? ('user' . $service->user_id . '-' . $service->id . '.example.com');
        $phpVersion = $cfg['php_version'] ?? '82';
        $sitePath   = "/www/wwwroot/{$domain}";
        $dbName     = 'db_' . preg_replace('/[^a-z0-9]/i', '', str_replace('.', '_', $domain));
        $dbUser     = substr($dbName, 0, 16);
        $dbPass     = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 16);

        // 1. 创建网站
        $r1 = $this->request('site', 'AddSite', [
            'webname'  => json_encode(['domain' => $domain, 'domainlist' => [], 'count' => 1]),
            'path'     => $sitePath,
            'type_id'  => 0,
            'type'     => 'PHP',
            'version'  => $phpVersion,
            'port'     => 80,
            'ps'       => 'IDC 自动开通',
        ]);

        if (!($r1['siteStatus'] ?? false)) {
            return ['success' => false, 'message' => '创建网站失败: ' . ($r1['msg'] ?? json_encode($r1))];
        }

        $siteId = $r1['siteId'] ?? null;

        // 2. 创建数据库
        $r2 = $this->request('database', 'AddDatabase', [
            'name' => $dbName,
            'codeing' => 'utf8mb4',
            'user' => $dbUser,
            'password' => $dbPass,
        ]);

        $dbOk = isset($r2['status']) && $r2['status'] === true;

        return [
            'success' => true,
            'message' => '开通成功',
            'data' => [
                'domain'     => $domain,
                'site_path'  => $sitePath,
                'site_id'    => $siteId,
                'database'   => $dbOk ? $dbName : null,
                'db_user'    => $dbOk ? $dbUser : null,
                'db_pass'    => $dbOk ? $dbPass : null,
                'php_version'=> $phpVersion,
            ],
        ];
    }

    public function suspend(Service $service): bool
    {
        $domain = $service->resource_config['domain'] ?? '';
        if (!$domain) return false;
        $r = $this->request('site', 'SiteStop', ['name' => $domain, 'id' => $service->upstream_service_id]);
        return ($r['siteStatus'] ?? false) === true;
    }

    public function unsuspend(Service $service): bool
    {
        $domain = $service->resource_config['domain'] ?? '';
        if (!$domain) return false;
        $r = $this->request('site', 'SiteStart', ['name' => $domain, 'id' => $service->upstream_service_id]);
        return ($r['siteStatus'] ?? false) === true;
    }

    public function terminate(Service $service): bool
    {
        $domain = $service->resource_config['domain'] ?? '';
        if (!$domain) return false;

        // 先删数据库，再删网站
        $dbName = $service->resource_config['database'] ?? null;
        if ($dbName) {
            $this->request('database', 'DeleteDatabase', ['name' => $dbName]);
        }

        $r = $this->request('site', 'DeleteSite', ['name' => $domain, 'id' => $service->upstream_service_id]);
        return ($r['siteStatus'] ?? false) === true;
    }

    public function getStatus(Service $service): string
    {
        $domain = $service->resource_config['domain'] ?? '';
        if (!$domain) return 'unknown';

        $r = $this->request('data', 'getData', [
            'table' => 'sites',
            'search' => $domain,
            'list' => 'true',
        ]);

        if (!empty($r['data'][0])) {
            $site = $r['data'][0];
            return ($site['status'] ?? '1') == '1' ? 'active' : 'suspended';
        }
        return 'terminated';
    }

        public function getProducts(): array
    {
        $r = $this->request("site", "GetPHPVersion");
        // 宝塔直接返回数组，不是 {"version": [...]}
        if (is_array($r) && isset($r[0]["version"])) {
            return array_map(fn($v) => [
                "id"   => $v["version"],
                "name" => $v["name"],
            ], $r);
        }
        return [];
    }
}
