<?php
namespace App\Services\Payment;

class EpayGateway implements PaymentInterface
{
    protected string $apiUrl;
    protected string $pid;
    protected string $key;

    public function __construct(array $config = [])
    {
        $this->apiUrl = rtrim($config['api_url'] ?? '', '/');
        $this->pid    = (string)($config['pid'] ?? '');
        $this->key    = (string)($config['key'] ?? '');
    }

    public function sign(array $params): string
    {
        unset($params['sign'], $params['sign_type']);
        $params = array_filter($params, fn($v) => $v !== '' && $v !== null);
        ksort($params);
        $parts = [];
        foreach ($params as $k => $v) $parts[] = "{$k}={$v}";
        return md5(implode('&', $parts) . $this->key);
    }

    public function pay(array $order): string
    {
        $params = [
            'pid'          => $this->pid,
            'type'         => $order['pay_type'] ?? 'alipay',
            'out_trade_no' => $order['trade_no'],
            'notify_url'   => $order['notify_url'] ?? url('/payment/notify'),
            'return_url'   => $order['return_url'] ?? url('/payment/return'),
            'name'         => $order['name'],
            'money'        => number_format($order['amount'], 2, '.', ''),
            'sitename'     => config('app.name', 'IDC'),
        ];
        $params['sign'] = $this->sign($params);
        $params['sign_type'] = 'MD5';

        return $this->apiUrl . '/submit.php?' . http_build_query($params);
    }

    public function verify(array $params): bool
    {
        if (empty($params['sign'])) return false;
        $sign = $params['sign'];
        return $this->sign($params) === $sign;
    }

    public function handleNotify(array $params): array
    {
        if (!$this->verify($params)) {
            return ['success' => false, 'message' => '签名验证失败'];
        }
        if (($params['trade_status'] ?? '') !== 'TRADE_SUCCESS') {
            return ['success' => false, 'message' => '交易未成功'];
        }
        return [
            'success'    => true,
            'trade_no'   => $params['out_trade_no'] ?? '',
            'gateway_no' => $params['trade_no'] ?? '',
            'amount'     => (float)($params['money'] ?? 0),
            'raw'        => $params,
        ];
    }
}
