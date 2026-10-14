@props(['title' => null, 'description' => null, 'keywords' => null, 'image' => null])
<title>{{ $title ?? config('app.name', '樱花云') . ' · 二次元专属云平台' }}</title>
<meta name="description" content="{{ $description ?? '樱花云 - 二次元专属云平台，提供香港、美国、国内 VPS 虚拟主机，免备案，5元起' }}">
<meta name="keywords" content="{{ $keywords ?? 'VPS,虚拟主机,云服务器,香港空间,美国空间,二次元,免备案' }}">
<meta property="og:title" content="{{ $title ?? '樱花云 · 二次元专属云平台' }}">
<meta property="og:description" content="{{ $description ?? '萌系云服务，5元起' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $image ?? asset('favicon.ico') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="csrf-token" content="{{ csrf_token() }}">
