@extends('layouts.app')

@section('title', 'Nusantara Trading Center | Komunitas Trading Nusantara')

@section('content')
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-slate-950 via-slate-950 to-slate-900">
        <div class="mx-auto max-w-6xl px-6 pb-16 pt-10 lg:pb-24 lg:pt-12">
            <div class="ticker-bar mb-6 rounded-2xl border border-white/5 bg-white/5 p-4 shadow-lg" data-ticker>
                <div class="ticker-track flex gap-8 whitespace-nowrap" id="ticker-track">
                    @foreach ($tickerData as $item)
                        <div class="ticker-item flex items-center gap-3 text-sm font-semibold text-slate-200" data-symbol="{{ $item['symbol'] }}">
                            <span class="text-white/70">{{ $item['symbol'] }}</span>
                            <span class="ticker-price text-white">{{ $item['price'] }}</span>
                            <span class="ticker-change {{ str_contains($item['change'], '-') ? 'text-rose-400' : 'text-emerald-400' }}">
                                {{ $item['change'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-12 lg:grid-cols-[3fr,2fr] lg:items-center">
                <div class="space-y-8">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/10 px-3 py-1 text-xs uppercase tracking-[0.3em] text-emerald-300">
                        #TradingCommunity
                        <span class="h-1 w-1 rounded-full bg-emerald-300"></span>
                        Live Mentoring
                    </p>
                    <div class="space-y-6">
                        <h1 class="text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                            Nusantara Trading Center
                            <span class="text-emerald-300">membantu trader tumbuh</span> dengan komunitas, sistem,
                            dan pengetahuan yang teruji.
                        </h1>
                        <p class="text-lg text-slate-300">
                        Trading bukan bakat bawaan, tapi keterampilan yang ditempa dari disiplin dan keberanian belajar setiap hari.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-4 text-sm font-semibold">
                        <a href="https://wa.me/6281288880000?text=Halo%20NTC%2C%20saya%20ingin%20bergabung" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-400 px-6 py-3 text-slate-900 shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-300">
                            Sign Up Now
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 6.75L6.75 17.25M17.25 6.75H8.25M17.25 6.75V15.75" />
                            </svg>
                        </a>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3 text-sm">
                        @foreach ($stats as $stat)
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-4 backdrop-blur" data-animate>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/60">{{ $stat['label'] }}</p>
                                <p class="mt-2 text-3xl font-semibold text-white">{{ $stat['value'] }}</p>
                                <p class="text-xs text-emerald-300">{{ $stat['delta'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="community" class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">Why NTC</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Empat pilar utama</h2>
                </div>
                <p class="text-slate-400 lg:w-2/3">
                    Kami mengintegrasikan empat pilar utama berikut untuk membantu Anda mencapai tujuan di pasar modal dan berkembang secara berkelanjutan:
                </p>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2">
                @foreach ($pillars as $index => $pillar)
                    <div class="rounded-3xl border border-white/5 bg-white/5 p-6 transition hover:translate-y-1 hover:border-emerald-400/40" data-animate>
                        <div class="flex items-center gap-3 text-sm text-emerald-300">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-emerald-400/40 bg-emerald-400/10 text-base font-semibold text-emerald-200">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            {{ $pillar['title'] }}
                        </div>
                        <p class="mt-4 text-base text-slate-300">{{ $pillar['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="ecourse" class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">Produk & Layanan</p>
                <h2 class="mt-2 text-3xl font-semibold text-white">Dirancang untuk trader modern</h2>
            </div>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ($services as $service)
                    <div class="rounded-3xl border border-white/5 bg-gradient-to-b from-white/10 via-slate-950 to-slate-950 p-6 shadow-lg" data-animate>
                        <div class="flex items-center justify-between text-xs uppercase tracking-[0.4em] text-white/60">
                            {{ $service['label'] }}
                            <span class="rounded-full bg-white/10 px-3 py-1 text-[10px] tracking-[0.3em] text-emerald-200">
                                {{ $service['status'] }}
                            </span>
                        </div>
                        <p class="mt-6 text-base text-slate-300">{{ $service['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="rounded-3xl border border-white/5 bg-gradient-to-r from-emerald-400/15 to-indigo-500/10 p-8 shadow-2xl" data-animate>
                <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] text-emerald-200">Cara Kerja</p>
                        <h2 class="mt-3 text-3xl font-semibold text-white">Tiga langkah untuk bergabung</h2>
                        <p class="mt-4 text-slate-200">Registrasi, pilih paket, dan langsung terhubung dengan komunitas.</p>
                    </div>
                    <div class="grid gap-4">
                        @foreach ($howItWorks as $step)
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <p class="text-xs uppercase tracking-[0.4em] text-white/50">{{ $step['step'] }}</p>
                                <p class="text-lg text-white">{{ $step['title'] }}</p>
                                <p class="text-sm text-slate-300">{{ $step['copy'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">Testimoni</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Cerita anggota komunitas</h2>
                </div>
            </div>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ($testimonials as $t)
                    <div class="rounded-3xl border border-white/5 bg-white/5 p-6" data-animate>
                        <p class="text-sm text-slate-200">"{{ $t['content'] }}"</p>
                        <div class="mt-6 text-sm">
                            <p class="font-semibold text-white">{{ $t['name'] }}</p>
                            <p class="text-slate-400">{{ $t['role'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="articles" class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">Artikel Terbaru</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Wawasan terbaru dari NTC</h2>
                </div>
                <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-emerald-300">
                    Lihat semua artikel →
                </a>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @forelse ($articles as $article)
                    <article class="rounded-3xl border border-white/5 bg-white/5 p-5 shadow-xl" data-animate>
                        <p class="text-xs uppercase tracking-[0.4em] text-white/50">
                            {{ optional($article->published_at)->translatedFormat('d M Y') }}
                        </p>
                        <h3 class="mt-3 text-xl font-semibold text-white">{{ $article->title }}</h3>
                        <p class="mt-2 text-sm text-slate-300">{{ $article->summary ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $article->author }}</span>
                            <a href="{{ route('articles.show', $article) }}" class="text-emerald-300 hover:text-emerald-200">Baca →</a>
                        </div>
                    </article>
                @empty
                    <p class="text-slate-400">Belum ada artikel. Silakan tambahkan melalui Admin Panel.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="faq" class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-10 lg:grid-cols-3">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">FAQ</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Pertanyaan populer</h2>
                    <p class="mt-4 text-slate-400">Butuh bantuan? Silakan hubungi admin melalui Telegram yang tersedia di grup official NTC.</p>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    @foreach ($faq as $item)
                        <div class="rounded-3xl border border-white/5 bg-white/5 p-6" data-animate>
                            <p class="text-base font-semibold text-white">{{ $item['q'] }}</p>
                            <p class="mt-2 text-sm text-slate-300">{{ $item['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-5xl px-6">
            <div class="rounded-[40px] border border-emerald-500/30 bg-gradient-to-r from-emerald-400/10 via-slate-900 to-indigo-500/10 p-10 text-center shadow-2xl" data-animate>
                <p class="text-sm uppercase tracking-[0.4em] text-emerald-200">Bergabung Sekarang</p>
                <h2 class="mt-4 text-3xl font-semibold text-white">Bangun rutinitas trading yang disiplin bersama NTC.</h2>
                <p class="mt-3 text-slate-200">Semua CTA diarahkan ke formulir atau kanal resmi kami.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm font-semibold">
                    <a href="https://wa.me/6281288880000?text=Halo%20NTC%2C%20saya%20ingin%20gabung%20komunitas" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-400 px-8 py-3 text-slate-900 shadow-lg shadow-emerald-500/30">
                        WhatsApp Kami
                    </a>
                    <a href="mailto:hello@nusantaratradingcenter.com?subject=Join%20NTC" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 px-8 py-3 text-white">
                        Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

