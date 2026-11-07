<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('published_at')->orderByDesc('id')->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.form', ['news' => new News(['published_at' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = Upload::save($request->file('gambar'), 'berita');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('ok', 'Berita ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            if ($news->gambar) {
                Upload::delete($news->gambar);
            }
            $data['gambar'] = Upload::save($request->file('gambar'), 'berita');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('ok', 'Berita diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->gambar) {
            Upload::delete($news->gambar);
        }
        $news->delete();

        return redirect()->route('admin.news.index')->with('ok', 'Berita dihapus.');
    }

    private function validated(Request $request): array
    {
        $d = $request->validate([
            'judul'        => 'required|string|max:200',
            'isi'          => 'required|string',
            'ringkasan'    => 'nullable|string|max:300',
            'kategori'     => 'nullable|string|max:40',
            'published_at' => 'nullable|date',
            'gambar'       => 'nullable|image|max:2048',
        ]);

        $d['ringkasan'] = $d['ringkasan'] ?: Str::limit(strip_tags($d['isi']), 150);
        $d['published_at'] = $d['published_at'] ?? now();
        unset($d['gambar']);

        return $d;
    }
}
