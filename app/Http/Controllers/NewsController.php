<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('published_at')->orderByDesc('id')->paginate(9);

        return view('news-index', compact('news'));
    }

    public function show(News $news)
    {
        $lainnya = News::where('id', '!=', $news->id)->orderByDesc('published_at')->limit(3)->get();

        return view('news-show', compact('news', 'lainnya'));
    }
}
