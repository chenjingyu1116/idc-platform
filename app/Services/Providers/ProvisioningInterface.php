<?php
namespace App\Services\Providers;
use App\Models\Service;
interface ProvisioningInterface {
    public function provision(Service $service): array;
    public function suspend(Service $service): bool;
    public function unsuspend(Service $service): bool;
    public function terminate(Service $service): bool;
    public function getStatus(Service $service): string;
    public function getProducts(): array;
}
