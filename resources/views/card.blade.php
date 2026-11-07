@extends('layouts.app')
@section('title', 'Kartu Anggota - ' . $member->nama)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10 text-center">
    <h1 class="no-print text-2xl font-bold text-nu-800 mb-1">Kartu Tanda Anggota</h1>
    <p class="no-print text-sm text-gray-500 mb-6">{{ $member->nama }} &middot; {{ $member->nia }}</p>

    @include('partials.kartu')

    <div class="no-print mt-6 flex flex-wrap justify-center gap-3">
        <button id="unduh" class="bg-nu-700 hover:bg-nu-800 text-white font-semibold px-7 py-3 rounded-full">Unduh Kartu (PNG)</button>
        <button onclick="window.print()" class="border border-nu-700 text-nu-700 font-semibold px-7 py-3 rounded-full">Cetak</button>
        <a href="{{ route('admin.members.index') }}" class="border border-gray-400 text-gray-700 font-semibold px-7 py-3 rounded-full">&larr; Kembali</a>
    </div>
</div>
@endsection
