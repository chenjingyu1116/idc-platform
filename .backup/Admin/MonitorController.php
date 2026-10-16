<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class MonitorController extends Controller
{
    public function index()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'os' => php_uname('s') . ' ' . php_uname('r'),
            'server_ip' => $_SERVER['SERVER_ADDR'] ?? '未知',
            'disk_total' => $this->formatBytes(disk_total_space(base_path())),
            'disk_free' => $this->formatBytes(disk_free_space(base_path())),
            'disk_used_pct' => $this->diskUsedPct(),
            'memory_usage' => $this->formatBytes(memory_get_usage(true)),
            'memory_peak' => $this->formatBytes(memory_get_peak_usage(true)),
            'database_size' => $this->dbSize(),
            'timezone' => config('app.timezone'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? '开启' : '关闭',
        ];

        $counts = [
            'users' => User::count(),
            'orders' => Order::count(),
            'services' => Service::count(),
            'active_services' => Service::where('status', 'active')->count(),
        ];

        return view('admin.monitor.index', compact('info','counts'));
    }

    protected function formatBytes($bytes): string
    {
        $units = ['B','KB','MB','GB','TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) { $bytes /= 1024; $i++; }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    protected function diskUsedPct(): float
    {
        $total = disk_total_space(base_path());
        $free = disk_free_space(base_path());
        if ($total <= 0) return 0;
        return round((($total - $free) / $total) * 100, 2);
    }

    protected function dbSize(): string
    {
        try {
            if (config('database.default') === 'sqlite') {
                $path = config('database.connections.sqlite.database');
                return file_exists($path) ? $this->formatBytes(filesize($path)) : 'N/A';
            }
            $result = DB::select('SELECT SUM(data_length + index_length) AS size FROM information_schema.TABLES WHERE table_schema = ?', [config('database.connections.mysql.database')]);
            return $this->formatBytes($result[0]->size ?? 0);
        } catch (\Exception $e) { return 'N/A'; }
    }
}
