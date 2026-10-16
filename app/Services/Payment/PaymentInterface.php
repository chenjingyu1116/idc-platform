<?php
namespace App\Services\Payment;

interface PaymentInterface
{
    // 发起支付，返回跳转 URL
    public function pay(array $order): string;

    // 验证回调签名
    public function verify(array $params): bool;

    // 处理异步通知
    public function handleNotify(array $params): array;
}
