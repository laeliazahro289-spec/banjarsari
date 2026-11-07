@extends('layouts.app')
@section('title', 'Berita - Banom NU')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <p class="text-xs font-semibold tracking-widest uppercase text-nu-600">Kabar Terbaru</p>
    <h1 class="text-3xl md:text-4xl font-bold text-nu-800 mt-1">Berita</h1>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-8">
        @forelse($news as $n)
            <a href="{{ route('news.show', $n) }}" class="group bg-white rounded-3xl overflow-hidden shadow hover:shadow-xl transition block">
                @if($n->gambar)
                    <img src="{{ $n->gambar_url }}" alt="{{ $n->judul }}" class="h-48 w-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="h-48 flex items-center justify-center bg-gradient-to-br from-emerald-600 to-emerald-900">
                        <span class="font-serif italic font-bold text-5xl text-amber-300">NU</span>
                    </div>
                @endif
                <div class="p-5">
                    <p class="text-xs text-gray-500">{{ $n->published_at?->translatedFormat('d F Y') }}</p>
                    <h2 class="font-bold text-lg text-nu-800 mt-1 group-hover:text-emerald-700">{{ $n->judul }}</h2>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($n->ringkasan, 110) }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-full">Belum ada berita.</p>
        @endforelse
    </div>

    <div class="mt-10">{{ $news->links() }}</div>
</div>
@endsection
