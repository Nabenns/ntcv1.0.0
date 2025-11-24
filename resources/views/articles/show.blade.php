@extends('layouts.app')

@section('title', $article->title . ' | Nusantara Trading Center')

@section('content')
    <article class="bg-slate-950 py-16">
        <div class="mx-auto max-w-4xl px-6">
            <div class="space-y-4 text-center">
                <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">Artikel</p>
                <h1 class="text-4xl font-semibold text-white">{{ $article->title }}</h1>
                <div class="flex flex-wrap items-center justify-center gap-3 text-sm text-slate-400">
                    <span>{{ $article->author }}</span>
                    <span class="text-white/30">&middot;</span>
                    <span>{{ optional($article->published_at)->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            @if ($article->thumbnail_url)
                <div class="mt-10 overflow-hidden rounded-[40px] border border-white/10">
                    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="w-full object-cover">
                </div>
            @endif

            <div class="prose prose-invert mt-10 max-w-none">
                {!! $article->processed_content !!}
            </div>

            <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-y border-white/10 py-6 text-sm">
                <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white">
                    ← Kembali ke daftar artikel
                </a>
                <div class="flex items-center gap-3 text-xs text-slate-400">
                    <span>Bagikan:</span>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                        target="_blank" rel="noopener" class="rounded-full border border-white/10 px-3 py-1 hover:border-white/40 hover:text-white">X</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener"
                        class="rounded-full border border-white/10 px-3 py-1 hover:border-white/40 hover:text-white">Facebook</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener"
                        class="rounded-full border border-white/10 px-3 py-1 hover:border-white/40 hover:text-white">LinkedIn</a>
                </div>
            </div>
        </div>
    </article>

    @if ($relatedArticles->isNotEmpty())
        <section class="bg-slate-950 pb-16">
            <div class="mx-auto max-w-6xl px-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-white">Artikel terkait</h2>
                    <a href="{{ route('articles.index') }}" class="text-sm text-emerald-300">Lihat semua</a>
                </div>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedArticles as $related)
                        <article class="rounded-3xl border border-white/5 bg-white/5 p-5 shadow-lg">
                            <p class="text-xs uppercase tracking-[0.4em] text-white/50">
                                {{ optional($related->published_at)->translatedFormat('d M Y') }}
                            </p>
                            <h3 class="mt-3 text-lg font-semibold text-white">{{ $related->title }}</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                {{ $related->summary ?? \Illuminate\Support\Str::limit(strip_tags($related->content), 120) }}
                            </p>
                            <a href="{{ route('articles.show', $related) }}" class="mt-4 inline-flex items-center gap-2 text-sm text-emerald-300">
                                Baca →
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

