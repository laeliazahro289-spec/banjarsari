<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('published_at')->orderByDesc('id')->limit(8)->get();
        $totalBerita = News::count();
        $banoms = Banom::with('pengurus')->orderBy('urutan')->get();

        return view('home', compact('news', 'totalBerita', 'banoms'));
    }
}
