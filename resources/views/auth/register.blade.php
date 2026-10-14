<x-guest-layout>
<form method="POST" action="{{ route('register') }}">
@csrf
<div>
<x-input-label for="name" :value="__('昵称')" />
<x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="给可爱的自己起个名字" />
<x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<div class="mt-4">
<x-input-label for="email" :value="__('邮箱')" />
<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your@email.com" />
<x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>
<div class="mt-4">
<x-input-label for="password" :value="__('密码')" />
<x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="至少 8 位" />
<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>
<div class="mt-4">
<x-input-label for="password_confirmation" :value="__('确认密码')" />
<x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="再输一次" />
<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>
<div class="mt-4">
<x-input-label for="ref" :value="__('推荐码（选填）')" />
<x-text-input id="ref" class="block mt-1 w-full" type="text" name="ref" :value="old('ref', $refCode ?? '')" placeholder="填好友的推荐码可享福利 🎁" />
<x-input-error :messages="$errors->get('ref')" class="mt-2" />
</div>

<div class="mt-6">
<button type="submit" class="anime-btn w-full">🌸 创建账号</button>
</div>

<div class="text-center mt-4 text-xs" style="color:#9CA3AF">
已经有账号了？<a href="{{ route('login') }}" class="font-semibold" style="color:#FF9EC4">去登录 →</a>
</div>
</form>
</x-guest-layout>
