@extends('layouts.app')
@section('title', 'Kartu Anggota Anda - Banom NU')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10 text-center">
    <div class="no-print">
        <span class="inline-block bg-emerald-100 text-emerald-800 rounded-full px-4 py-1 text-xs font-semibold tracking-wider uppercase">Pendaftaran berhasil</span>
        <h1 class="text-3xl font-bold text-nu-800 mt-3">Kartu Anggota Anda</h1>
        <p class="text-gray-600 mt-2 max-w-xl mx-auto">
            Halo <b>{{ $member->nama }}</b>, kartu Anda sudah jadi. Unduh dan simpan sekarang.
            @if($member->status === 'pending')
                Kartu akan berstatus resmi setelah pengurus memverifikasi data Anda.
            @endif
        </p>
    </div>

    <div class="mt-6">@include('partials.kartu')</div>

    <div class="no-print mt-6 flex flex-wrap justify-center gap-3">
        <button id="unduh" class="bg-nu-700 hover:bg-nu-800 text-white font-semibold px-7 py-3 rounded-full shadow">Unduh Kartu (PNG)</button>
        <button onclick="window.print()" class="border border-nu-700 text-nu-700 font-semibold px-7 py-3 rounded-full">Cetak</button>
        <a href="{{ route('home') }}" class="border border-gray-400 text-gray-700 font-semibold px-7 py-3 rounded-full">Ke Beranda</a>
    </div>

    <p class="no-print text-xs text-gray-500 mt-5">Simpan (bookmark) alamat halaman ini bila ingin mengunduh kartu lagi nanti.</p>
</div>
@endsection
