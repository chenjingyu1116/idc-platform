<?php
namespace App\Services\Payment;

use App\Models\PaymentConfig;

class PaymentFactory
{
    public static function make(PaymentConfig $config): PaymentInterface {
        return match ($config->driver) {
            'epay', 'alipay', 'wechat' => new EpayService($config),
            default => new EpayService($config),
        };
    }

    public static function getActiveConfigs() {
        return PaymentConfig::where('is_active', true)->orderBy('sort')->get();
    }
}
