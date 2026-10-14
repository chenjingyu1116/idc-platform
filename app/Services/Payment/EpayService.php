<?php
namespace App\Services\Payment;
class EpayService {
    protected array $config;
    public function __construct() {
        $this->config = config('payment.epay');
    }
    public function isConfigured(): bool {
        return !empty($this->config['api_url']) && !empty($this->config['pid']) && !empty($this->config['key']);
    }
    public function buildPayUrl(string $tradeNo, float $amount, string $name, string $type = 'alipay'): string {
        $params = [
            'pid' => $this->config['pid'],
            'type' => $type,
            'out_trade_no' => $tradeNo,
            'notify_url' => $this->config['notify_url'],
            'return_url' => $this->config['return_url'],
            'name' => $name,
            'money' => number_format($amount, 2, '.', ''),
        ];
        $params['sign'] = $this->sign($params);
        $params['sign_type'] = 'MD5';
        return rtrim($this->config['api_url'], '/') . '/submit.php?' . http_build_query($params);
    }
    public function verify(array $params): bool {
        if (empty($params['sign'])) return false;
        $sign = $params['sign'];
        unset($params['sign'], $params['sign_type']);
        ksort($params);
        $str = '';
        foreach ($params as $k => $v) {
            if ($v !== '' && $v !== null) $str .= $k . '=' . $v . '&';
        }
        $str = rtrim($str, '&');
        return md5($str . $this->config['key']) === $sign;
    }
    protected function sign(array $params): string {
        ksort($params);
        $str = '';
        foreach ($params as $k => $v) {
            if ($v !== '' && $v !== null) $str .= $k . '=' . $v . '&';
        }
        $str = rtrim($str, '&');
        return md5($str . $this->config['key']);
    }
}
