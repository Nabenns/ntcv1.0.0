<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nusantara Trading Center - pusat informasi resmi komunitas trading berbahasa Indonesia.">
    <title>@yield('title', 'Nusantara Trading Center')</title>
    <link rel="icon" href="https://www.svgrepo.com/show/530559/candlestick-chart.svg" />
    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-slate-100 antialiased font-space">
    <div class="min-h-screen flex flex-col">
        <header id="site-nav" class="fixed inset-x-0 top-0 z-30 transition-all">
            <div class="w-full">
                <div class="mx-auto max-w-6xl px-6 py-4 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-semibold tracking-wide">
                        <img src="{{ asset('NCT.png') }}" alt="NTC Logo" class="h-10 w-10 rounded-lg border border-white/10 object-contain">
                        <div class="flex flex-col leading-tight">
                            <span class="text-sm uppercase text-slate-400">Nusantara</span>
                            <span class="-mt-1 text-base text-white">Trading Center</span>
                        </div>
                    </a>
                    <nav class="hidden lg:flex items-center gap-8 text-sm font-medium">
                        <a href="#articles" class="nav-link text-slate-200">Artikel</a>
                        <a href="#faq" class="nav-link text-slate-200">FAQ</a>
                    </nav>
                    <div class="hidden lg:flex items-center gap-3 text-sm font-semibold">
                        <button type="button" class="inline-flex items-center gap-1 rounded-full border border-white/10 px-3 py-1.5 text-slate-300 transition hover:border-white/30">
                            ID
                            <span class="text-white/40">/</span>
                            EN
                        </button>
                        <a href="http://t.me/signaladminxbt" target="_blank" rel="noopener" class="rounded-full bg-emerald-400 px-4 py-2 text-slate-900 shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-300">
                            Join Now
                        </a>
                    </div>
                    <button id="mobile-toggle" type="button" class="lg:hidden inline-flex items-center justify-center rounded-full border border-white/10 p-2 text-white">
                        <span class="sr-only">Toggle navigation</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div id="mobile-menu" class="lg:hidden hidden border-t border-white/10 bg-slate-950/95 px-6 pb-6">
                    <div class="flex flex-col gap-4 pt-4 text-sm">
                        <a href="#articles" class="nav-link">Artikel</a>
                        <a href="#faq" class="nav-link">FAQ</a>
                        <a href="http://t.me/signaladminxbt" target="_blank" rel="noopener" class="rounded-full bg-emerald-400 px-4 py-2 text-center font-semibold text-slate-900">Join Now</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 pt-24 lg:pt-32">
            @yield('content')
        </main>

        <footer class="border-t border-white/5 bg-black/30">
            <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-10 lg:flex-row lg:justify-between lg:items-center">
                <div>
                    <p class="text-sm text-slate-400">© {{ now()->year }} Nusantara Trading Center</p>
                    <p class="text-xs text-slate-500 mt-2">Landing page resmi & pusat informasi komunitas trader Nusantara.</p>
                </div>
                <div class="flex flex-wrap gap-3 text-sm text-slate-300">
                    <a href="https://t.me/nusantaratradingcentral" class="hover:text-white transition" target="_blank" rel="noopener">Telegram</a>
                    <a href="https://www.instagram.com/nusantaratradingcentral" class="hover:text-white transition" target="_blank" rel="noopener">Instagram</a>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>

