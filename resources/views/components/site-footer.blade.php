@php
    use App\Models\Setting;
    $__icp      = Setting::where('key', 'icp')->value('value') ?? '';
    $__icpLink  = Setting::where('key', 'icp_link')->value('value') ?? 'https://beian.miit.gov.cn/';
    $__siteName = Setting::where('key', 'site_name')->value('value') ?? '樱花云';
    $__slogan   = Setting::where('key', 'site_slogan')->value('value') ?? '让 IDC 管理也能如此可爱';
    $__footer   = Setting::where('key', 'footer_text')->value('value') ?? '';
    $__qq       = Setting::where('key', 'contact_qq')->value('value') ?? '';
    $__wechat   = Setting::where('key', 'contact_wechat')->value('value') ?? '';
    $__email    = Setting::where('key', 'contact_email')->value('value') ?? '';
@endphp

<footer class="border-t-2 border-pink-100 mt-12 py-6 px-4 text-center text-sm" style="color:#9CA3AF;position:relative;z-index:10">
    {{-- 平铺一行 --}}
    <div class="max-w-7xl mx-auto flex flex-wrap justify-center items-center gap-x-4 gap-y-2">

        {{-- 联系方式 --}}
        @if($__qq)
        <span class="whitespace-nowrap">💬 QQ: {{ $__qq }}</span>
        <span class="text-pink-200">·</span>
        @endif
        @if($__wechat)
        <span class="whitespace-nowrap">💚 微信: {{ $__wechat }}</span>
        <span class="text-pink-200">·</span>
        @endif
        @if($__email)
        <span class="whitespace-nowrap">📧 {{ $__email }}</span>
        <span class="text-pink-200">·</span>
        @endif

        {{-- 版权 --}}
        <span class="whitespace-nowrap">
            🌸 {{ $__siteName }} © {{ date('Y') }}
        </span>
        <span class="text-pink-200">·</span>

        {{-- 返回官网 --}}
        <a href="{{ route('home') }}" class="hover:text-pink-500 whitespace-nowrap">返回官网</a>

        {{-- 标语 --}}
        @if($__slogan)
        <span class="text-pink-200">·</span>
        <span class="whitespace-nowrap">{{ $__slogan }}</span>
        @endif

        {{-- 页脚文字 --}}
        @if($__footer)
        <span class="text-pink-200">·</span>
        <span class="whitespace-nowrap">{{ $__footer }}</span>
        @endif

        {{-- ICP 备案 --}}
        @if($__icp)
        <span class="text-pink-200">·</span>
        <a href="{{ $__icpLink }}" target="_blank" rel="noopener"
           class="hover:text-pink-500 transition whitespace-nowrap">
            🛡️ {{ $__icp }}
        </a>
        @endif

    </div>
</footer>
