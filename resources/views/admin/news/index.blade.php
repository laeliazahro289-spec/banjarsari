@extends('layouts.app')
@section('title', 'Kelola Berita - Banom NU')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-nu-800 mb-6">Kelola Berita</h1>
    @include('admin._nav')

    <a href="{{ route('admin.news.create') }}" class="inline-block bg-nu-700 hover:bg-nu-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full mb-5">+ Tambah Berita</a>

    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left text-xs uppercase text-gray-500">
                <tr><th class="p-3">Gambar</th><th class="p-3">Judul</th><th class="p-3">Tanggal</th><th class="p-3"></th></tr>
            </thead>
            <tbody>
            @forelse($news as $n)
                <tr class="border-t">
                    <td class="p-3">
                        @if($n->gambar)<img src="{{ $n->gambar_url }}" class="w-14 h-14 object-cover rounded-lg" alt="">
                        @else<span class="w-14 h-14 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">NU</span>@endif
                    </td>
                    <td class="p-3 font-semibold">{{ $n->judul }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $n->published_at?->translatedFormat('d M Y') }}</td>
                    <td class="p-3 whitespace-nowrap text-right">
                        <a href="{{ route('admin.news.edit', $n) }}" class="text-emerald-700 font-semibold mr-3">Ubah</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $n) }}" class="inline" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-6 text-center text-gray-500">Belum ada berita.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $news->links() }}</div>
</div>
@endsection
