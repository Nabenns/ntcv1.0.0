@extends('layouts.app')

@section('title', 'Artikel | Nusantara Trading Center')

@section('content')
    <section class="bg-slate-950 py-16">
        <div class="mx-auto max-w-6xl px-6">
            <div class="space-y-4 text-center">
                <p class="text-sm uppercase tracking-[0.4em] text-emerald-300">NTC Articles</p>
                <h1 class="text-4xl font-semibold text-white">Wawasan terbaru & studi kasus</h1>
                <p class="text-slate-400">Semua artikel memiliki URL SEO-friendly dan siap dibagikan.</p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($articles as $article)
                    <article class="flex flex-col rounded-3xl border border-white/5 bg-white/5 p-5 shadow-xl">
                        @if ($article->thumbnail_url)
                            <div class="mb-4 overflow-hidden rounded-2xl border border-white/5">
                                <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}"
                                    class="h-44 w-full object-cover transition duration-500 hover:scale-105">
                            </div>
                        @endif
                        <p class="text-xs uppercase tracking-[0.4em] text-white/50">
                            {{ optional($article->published_at)->translatedFormat('d M Y') }}
                        </p>
                        <h2 class="mt-3 text-xl font-semibold text-white">{{ $article->title }}</h2>
                        <p class="mt-2 flex-1 text-sm text-slate-300">
                            {{ $article->summary ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 140) }}
                        </p>
                        <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $article->author }}</span>
                            <a href="{{ route('articles.show', $article) }}" class="text-emerald-300 hover:text-emerald-200">Baca →</a>
                        </div>
                    </article>
                @empty
                    <p class="text-slate-400">Belum ada artikel.</p>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $articles->links('pagination::tailwind') }}
            </div>
        </div>
    </section>
@endsection

