<?php

namespace App\Services\Providers;

use App\Models\Provider;

class ProviderFactory
{
    public static function make(?Provider $provider): ProvisioningInterface
    {
        $driver = $provider?->driver ?? 'manual';
        $cred   = $provider?->credentials_encrypted ?? [];

        return match ($driver) {
            'manual' => new ManualProvider(),

            'bt_panel' => new BtPanelProvider([
                'panel_url' => $provider->api_url,
                'api_sk'    => $cred['api_sk'] ?? $cred['api_key'] ?? '',
            ]),

            'novaix' => new NovaixProvider([
                'api_url'   => $provider->api_url,
                'api_token' => $cred['api_token'] ?? $cred['api_key'] ?? '',
            ]),

            default => new ManualProvider(),
        };
    }
}
