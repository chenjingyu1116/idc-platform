@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">
        服务详情：{{ optional($service->product)->name ?? '-' }}
    </h1>

    {{-- 服务基本信息 --}}
    <div class="anime-card rounded-2xl p-6 space-y-4 mb-6">
        <div>
            <div class="text-sm text-gray-500">状态</div>
            <div class="mt-1 text-lg font-semibold">{{ $service->status }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">IP 地址</div>
            <div class="mt-1 text-lg font-mono" style="color:#FF9EC4">
                {{ $service->ip_address ?? '等待管理员分配' }}
            </div>
        </div>
        <div>
            <div class="text-sm text-gray-500">用户名</div>
            <div class="mt-1 text-lg font-mono">{{ $service->username ?? '等待分配' }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">密码</div>
            <div class="mt-1 text-lg font-mono text-red-500">
                {{ $service->password_encrypted ?? '等待分配' }}
            </div>
        </div>
        <div>
            <div class="text-sm text-gray-500">到期时间</div>
            <div class="mt-1 text-lg">
                {{ $service->expires_at ? $service->expires_at->format('Y-m-d') : '-' }}
            </div>
        </div>
    </div>

    {{-- 订单信息（含优惠）--}}
    @if($service->order)
    <div class="anime-card rounded-2xl p-6">
        <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">🧾 订单信息</h2>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">订单号</span>
                <span class="font-mono">{{ $service->order->order_no }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">下单时间</span>
                <span>{{ $service->order->created_at?->format('Y-m-d H:i') }}</span>
            </div>

            @if(($service->order->discount_amount ?? 0) > 0)
                @php
                    $productPrice = $service->order->quantity * (optional($service->product)->price ?? 0);
                    $originalTotal = $productPrice > 0
                        ? $productPrice
                        : $service->order->total_amount + $service->order->discount_amount;
                @endphp
                <div class="flex justify-between">
                    <span class="text-gray-500">原价</span>
                    <span class="font-mono">¥{{ number_format($originalTotal, 2) }}</span>
                </div>
                <div class="flex justify-between" style="color:#FF9EC4">
                    <span>🎫 优惠券</span>
                    <span class="font-mono">- ¥{{ number_format($service->order->discount_amount, 2) }}</span>
                </div>
            @endif

            <div class="flex justify-between pt-3 border-t-2 border-pink-100 text-base">
                <span class="font-semibold">实付金额</span>
                <span class="font-bold" style="color:#FF9EC4">
                    ¥{{ number_format($service->order->total_amount, 2) }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('client.services.index') }}" class="text-cyan-500 hover:underline">← 返回服务列表</a>
    </div>
</div>
@endsection
