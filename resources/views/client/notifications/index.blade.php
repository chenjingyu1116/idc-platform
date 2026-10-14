@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-8" style="font-family:'ZCOOL KuaiLe';color:#FF9EC4">🔔 通知中心</h1>

@if($notifications->isEmpty())
<div class="anime-card p-12 text-center">
<div class="text-6xl mb-4">🌙</div>
<div style="color:#9CA3AF">暂无通知～</div>
</div>
@else
<div class="space-y-4">
@foreach($notifications as $n)
<div class="anime-card p-6 {{ $n->sent_at ? '' : 'ring-2' }}" style="{{ $n->sent_at ? '' : 'ring-color:#FF9EC4' }}">
<div class="flex justify-between items-start mb-2">
<div class="flex items-center gap-3">
@if(!$n->sent_at)
<span class="w-2 h-2 rounded-full" style="background:#FF6B9E"></span>
@endif
<h3 class="font-bold text-lg">{{ $n->title }}</h3>
</div>
<div class="text-xs" style="color:#9CA3AF">{{ $n->created_at->format('Y-m-d H:i') }}</div>
</div>
<div class="text-sm leading-relaxed" style="color:#7A7A9A">{{ $n->content }}</div>
@if(!$n->sent_at)
<form method="POST" action="{{ route('client.notifications.read', $n) }}" class="mt-3">@csrf
<button type="submit" class="text-xs font-semibold" style="color:#B39DDB">标记为已读 →</button>
</form>
@endif
</div>
@endforeach
</div>
<div class="mt-6">{{ $notifications->links() }}</div>
@endif
@endsection
