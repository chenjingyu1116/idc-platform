<?php
namespace App\Services\Providers;
use App\Models\Service;
class ManualProvider implements ProvisioningInterface {
    public function provision(Service $service): array { return ['success'=>true,'message'=>'等待管理员手动分配']; }
    public function suspend(Service $service): bool { return $service->update(['status'=>'suspended']); }
    public function unsuspend(Service $service): bool { return $service->update(['status'=>'active']); }
    public function terminate(Service $service): bool { return $service->update(['status'=>'terminated']); }
    public function getStatus(Service $service): string { return $service->status; }
    public function getProducts(): array { return []; }
}
