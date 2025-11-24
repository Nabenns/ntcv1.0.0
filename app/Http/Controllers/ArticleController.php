<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::published()->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        abort_unless($article->is_published, 404);

        $relatedArticles = Article::published()
            ->whereKeyNot($article->getKey())
            ->take(3)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
