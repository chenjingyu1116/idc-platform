<x-guest-layout>
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
@csrf
<div>
<x-input-label for="email" :value="__('邮箱')" />
<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your@email.com" />
<x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>
<div class="mt-4">
<x-input-label for="password" :value="__('密码')" />
<x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>
<div class="block mt-4">
<label for="remember_me" class="inline-flex items-center">
<input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
<span class="ms-2 text-sm" style="color:#7A7A9A">记住我</span>
</label>
</div>
<div class="mt-6">
<button type="submit" class="anime-btn w-full">💗 登录</button>
</div>
<div class="flex items-center justify-between mt-4 text-xs">
@if (Route::has('password.request'))
<a class="font-semibold" style="color:#B39DDB" href="{{ route('password.request') }}">忘记密码？</a>
@endif
<a class="font-semibold" style="color:#FF9EC4" href="{{ route('register') }}">还没有账号？去注册 →</a>
</div>
</form>
</x-guest-layout>
