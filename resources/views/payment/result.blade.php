@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    <div class="text-8xl mb-6">{{ $success ? '🌸' : '😿' }}</div>
    <h1 class="text-3xl font-bold mb-4" style="color:{{ $success ? '#FF9EC4' : '#9CA3AF' }}">
        {{ $success ? '支付成功' : '支付未完成' }}
    </h1>
    <p class="text-gray-500 mb-8">{{ $message }}</p>
    <div class="space-x-4">
        <a href="{{ route('client.services.index') }}" class="anime-btn inline-block">查看我的服务</a>
        <a href="{{ route('orders.index') }}" class="anime-btn-soft inline-block">返回产品</a>
    </div>
</div>
@endsection
