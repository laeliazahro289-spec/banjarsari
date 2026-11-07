@extends('layouts.app')

@section('title', $news->judul . ' - Banom NU')

@section('content')

<style>
    /* Mencegah halaman melebar ke samping */
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Pembungkus artikel */
    .artikel-berita {
        width: 100%;
        max-width: 768px;
        min-width: 0;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    /* Judul berita */
    .artikel-judul {
        max-width: 100%;
        overflow-wrap: anywhere;
        word-break: normal;
        white-space: normal;
    }

    /* Isi berita */
    .isi-berita {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        white-space: normal !important;
        overflow-wrap: anywhere !important;
        word-wrap: break-word;
        word-break: normal;
        line-height: 1.8;
        color: #374151;
    }

    /* Gambar dalam isi berita */
    .isi-berita img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 12px;
    }

    /* Video dalam isi berita */
    .isi-berita iframe,
    .isi-berita video {
        max-width: 100%;
    }

    /* Tabel dalam isi berita */
    .isi-berita table {
        max-width: 100%;
        display: block;
        overflow-x: auto;
    }

    /* Paragraf */
    .isi-berita p {
        margin-bottom: 16px;
        overflow-wrap: anywhere;
    }

    /* Daftar */
    .isi-berita ul,
    .isi-berita ol {
        padding-left: 24px;
        margin-bottom: 16px;
    }

    /* Mencegah elemen artikel melebar */
    .artikel-berita * {
        max-width: 100%;
    }
</style>

<article class="artikel-berita mx-auto px-4 py-12">

    {{-- Tombol kembali --}}
    <a href="{{ route('news.index') }}"
       class="text-sm text-nu-600 hover:underline">
        &larr; Semua berita
    </a>

    {{-- Kategori dan tanggal --}}
    <p class="text-xs font-semibold tracking-widest uppercase text-nu-600 mt-6">
        {{ $news->kategori ?? 'Berita' }}
        &middot;
        {{ $news->published_at?->translatedFormat('d F Y') }}
    </p>

    {{-- Judul berita --}}
    <h1 class="artikel-judul text-3xl md:text-4xl font-bold text-nu-900 leading-tight mt-2">
        {{ $news->judul }}
    </h1>

    {{-- Gambar berita --}}
    @if($news->gambar)
        <img
            src="{{ $news->gambar_url }}"
            alt="{{ $news->judul }}"
            class="w-full max-h-[420px] object-cover rounded-3xl mt-6 shadow"
        >
    @endif

    {{-- Isi berita --}}
    <div class="isi-berita mt-8 text-lg">
        {!! nl2br(e($news->isi)) !!}
    </div>

    {{-- Berita lainnya --}}
    @if($lainnya->count())

        <hr class="my-12">

        <h2 class="text-xl font-bold text-nu-800 mb-4">
            Berita lainnya
        </h2>

        <div class="grid gap-4 sm:grid-cols-3">

            @foreach($lainnya as $n)

                <a href="{{ route('news.show', $n) }}"
                   class="bg-white rounded-2xl p-4 shadow hover:shadow-lg transition block min-w-0">

                    <p class="text-xs text-gray-500">
                        {{ $n->published_at?->translatedFormat('d M Y') }}
                    </p>

                    <p class="font-semibold text-nu-800 mt-1"
                       style="overflow-wrap:anywhere">
                        {{ Str::limit($n->judul, 60) }}
                    </p>

                </a>

            @endforeach

        </div>

    @endif

</article>

@endsection