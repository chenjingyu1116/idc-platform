<?php
namespace App\Services\Payment;

interface PaymentInterface
{
    public function pay(string $tradeNo, float $amount, string $subject): array;
    public function verifyNotify(array $data): bool;
    public function getNotifyTradeNo(array $data): ?string;
}
