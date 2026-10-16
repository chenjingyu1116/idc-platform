<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\OrderCreated;
use App\Models\Order;
use Illuminate\Console\Command;

class TestMail extends Command
{
    protected $signature   = 'test:mail {email=test@idc.local}';
    protected $description = '测试邮件通知';

    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();
        if (!$user) {
            $this->error("用户不存在: " . $this->argument('email'));
            return 1;
        }

        $order = Order::first();
        if (!$order) {
            $order = Order::create([
                'order_no' => 'MAIL' . time(),
                'user_id' => $user->id,
                'product_id' => 1,
                'quantity' => 1,
                'total_amount' => 15,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        $user->notify(new OrderCreated($order));
        $this->info("✅ 测试邮件已发送（MAIL_MAILER=log 时会写入日志）");
        $this->line("📂 查看日志: tail -f storage/logs/laravel.log");
        return 0;
    }
}
