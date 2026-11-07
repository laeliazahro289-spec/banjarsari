@extends('layouts.app')
@section('title', ($news->exists ? 'Ubah' : 'Tambah') . ' Berita - Banom NU')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-nu-800 mb-6">{{ $news->exists ? 'Ubah' : 'Tambah' }} Berita</h1>
    @include('admin._nav')

    <form method="POST" enctype="multipart/form-data"
          action="{{ $news->exists ? route('admin.news.update', $news) : route('admin.news.store') }}"
          class="bg-white rounded-2xl shadow p-6 space-y-4">
        @csrf
        @if($news->exists) @method('PUT') @endif

        <div>
            <label class="text-xs font-semibold text-gray-600">Judul</label>
            <input name="judul" value="{{ old('judul', $news->judul) }}" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-600">Kategori</label>
                <input name="kategori" value="{{ old('kategori', $news->kategori) }}" placeholder="Kegiatan, Kaderisasi, ..." class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Tanggal terbit</label>
                <input type="date" name="published_at" value="{{ old('published_at', optional($news->published_at)->format('Y-m-d')) }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-600">Ringkasan (kosongkan untuk otomatis)</label>
            <textarea name="ringkasan" rows="2" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">{{ old('ringkasan', $news->ringkasan) }}</textarea>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-600">Isi berita</label>
            <textarea name="isi" rows="9" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">{{ old('isi', $news->isi) }}</textarea>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-600">Gambar (opsional, maks 2 MB)</label>
            <input type="file" name="gambar" accept="image/*" data-resize="1200" class="w-full mt-1 text-sm">
            @if($news->gambar)<img src="{{ $news->gambar_url }}" class="mt-3 h-28 rounded-xl object-cover" alt="">@endif
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-nu-700 hover:bg-nu-800 text-white font-semibold px-7 py-2.5 rounded-full">Simpan</button>
            <a href="{{ route('admin.news.index') }}" class="border border-nu-700 text-nu-700 font-semibold px-7 py-2.5 rounded-full">Batal</a>
        </div>
    </form>
</div>
@include('partials.resize-foto')
@endsection
