@extends('layouts.app')
@section('title', 'Daftar Anggota - Banom NU')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <p class="text-xs font-semibold tracking-widest uppercase text-nu-600">Pendaftaran</p>
        <h1 class="text-3xl font-bold text-nu-800 mt-1">Daftar Jadi Anggota</h1>
        <p class="text-sm text-gray-500 mt-2">Isi data berikut. Setelah mendaftar, kartu anggota Anda langsung bisa diunduh.</p>

        @if(session('ok'))
            <div class="mt-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">{{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('daftar.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-600">Nama lengkap</label>
                <input name="nama" value="{{ old('nama') }}" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
                @error('nama')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Banom</label>
                <select name="banom_id" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5 bg-white">
                    <option value="">Pilih Banom</option>
                    @foreach($banoms as $b)
                        <option value="{{ $b->id }}" @selected(old('banom_id') == $b->id)>{{ $b->nama }} &mdash; {{ $b->tingkat }}</option>
                    @endforeach
                </select>
                @error('banom_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Alamat / Ranting</label>
                <input name="alamat" value="{{ old('alamat') }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">No. HP / WhatsApp</label>
                <input name="telepon" value="{{ old('telepon') }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Foto untuk kartu (disarankan, otomatis diperkecil)</label>
                <input type="file" name="foto" accept="image/*" data-resize="900" class="w-full mt-1 text-sm">
                @error('foto')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <button class="w-full bg-nu-700 hover:bg-nu-800 text-white font-semibold rounded-xl py-3 transition">Kirim Pendaftaran</button>
        </form>
    </div>
</div>
@include('partials.resize-foto')
@endsection
