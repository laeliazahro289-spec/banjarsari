@extends('layouts.app')
@section('title', 'Dashboard - Banom NU')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-nu-800 mb-6">Panel Admin</h1>
    @include('admin._nav')

    <div class="grid gap-4 sm:grid-cols-3">
        <a href="{{ route('admin.news.index') }}" class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition border-t-4 border-amber-400">
            <p class="text-4xl font-bold text-nu-800">{{ $jumlahBerita }}</p><p class="text-sm text-gray-500 mt-1">Berita</p>
        </a>
        <a href="{{ route('admin.members.index', ['status' => 'aktif']) }}" class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition border-t-4 border-emerald-500">
            <p class="text-4xl font-bold text-nu-800">{{ $jumlahAnggota }}</p><p class="text-sm text-gray-500 mt-1">Anggota aktif</p>
        </a>
        <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition border-t-4 border-orange-400">
            <p class="text-4xl font-bold text-nu-800">{{ $jumlahPending }}</p><p class="text-sm text-gray-500 mt-1">Menunggu persetujuan</p>
        </a>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('admin.news.create') }}" class="bg-nu-700 hover:bg-nu-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full">+ Tambah Berita</a>
        <a href="{{ route('admin.members.create') }}" class="bg-nu-700 hover:bg-nu-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full">+ Tambah Anggota</a>
    </div>

    @if($pending->count())
    <div class="bg-white rounded-2xl shadow mt-8 p-6">
        <h2 class="font-bold text-nu-800 mb-3">Pendaftar terbaru</h2>
        @foreach($pending as $m)
            <div class="flex items-center justify-between gap-3 py-2 border-b last:border-0">
                <div><p class="font-semibold">{{ $m->nama }}</p><p class="text-xs text-gray-500">{{ $m->banom->nama }} &middot; {{ $m->created_at->diffForHumans() }}</p></div>
                <form method="POST" action="{{ route('admin.members.approve', $m) }}">@csrf
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-full">Setujui</button>
                </form>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
