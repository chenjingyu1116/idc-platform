<?php
namespace App\Services\Payment;

use App\Models\PaymentConfig;

class PaymentFactory
{
    public static function make(?PaymentConfig $config): ?PaymentInterface
    {
        if (!$config) return null;
        $cred = $config->credentials ?? [];
        if (is_string($cred)) $cred = json_decode($cred, true) ?: [];

        return match ($config->driver) {
            'epay' => new EpayGateway([
                'api_url' => $config->api_url,
                'pid'     => $cred['pid'] ?? '',
                'key'     => $cred['key'] ?? '',
            ]),
            default => null,
        };
    }
}
