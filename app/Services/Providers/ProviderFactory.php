<?php
namespace App\Services\Providers;
use App\Models\Provider;
class ProviderFactory {
    public static function make(?Provider $provider): ProvisioningInterface {
        $driver = $provider?->driver ?? 'manual';
        return match ($driver) {
            'http' => new HttpProvider($provider),
            'manual' => new ManualProvider(),
            default => new ManualProvider(),
        };
    }
}
