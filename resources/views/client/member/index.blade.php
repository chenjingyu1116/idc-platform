@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">👑 会员等级</h1>
<div class="anime-card rounded-lg p-6 mb-6">
<div class="flex items-center gap-4">
<div class="text-5xl">💎</div>
<div>
<div class="text-sm text-gray-500">当前等级</div>
<div class="text-2xl font-bold" style="color:#FF9EC4">{{ $user->memberLevel?->name ?? '普通会员' }}</div>
</div>
</div>
</div>
<div class="grid md:grid-cols-3 gap-4">
@foreach($levels as $level)
<div class="anime-card p-6 text-center">
<div class="text-3xl mb-2">🏆</div>
<div class="font-bold mb-1">{{ $level->name }}</div>
<div class="text-xs text-gray-500 mb-2">需 {{ $level->min_points ?? 0 }} 积分</div>
<div class="text-sm" style="color:#B39DDB">折扣 {{ $level->discount ?? 100 }}%</div>
</div>
@endforeach
</div>
@endsection
