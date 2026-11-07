@extends('layouts.app')
@section('title', ($member->exists ? 'Ubah' : 'Tambah') . ' Anggota - Banom NU')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-nu-800 mb-6">{{ $member->exists ? 'Ubah' : 'Tambah' }} Anggota</h1>
    @include('admin._nav')

    <form method="POST" enctype="multipart/form-data"
          action="{{ $member->exists ? route('admin.members.update', $member) : route('admin.members.store') }}"
          class="bg-white rounded-2xl shadow p-6 space-y-4">
        @csrf
        @if($member->exists) @method('PUT') @endif

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-600">Nama lengkap</label>
                <input name="nama" value="{{ old('nama', $member->nama) }}" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Banom</label>
                <select name="banom_id" required class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5 bg-white">
                    @foreach($banoms as $b)<option value="{{ $b->id }}" @selected(old('banom_id', $member->banom_id) == $b->id)>{{ $b->nama }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Jabatan (isi "Anggota" bila bukan pengurus)</label>
                <input name="jabatan" list="jabatan-list" value="{{ old('jabatan', $member->jabatan) }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
                <datalist id="jabatan-list">@foreach(\App\Models\Member::JABATAN as $j)<option value="{{ $j }}">@endforeach</datalist>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Status</label>
                <select name="status" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5 bg-white">
                    <option value="aktif" @selected(old('status', $member->status) === 'aktif')>Aktif</option>
                    <option value="pending" @selected(old('status', $member->status) === 'pending')>Menunggu persetujuan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Alamat / Ranting</label>
                <input name="alamat" value="{{ old('alamat', $member->alamat) }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">No. HP</label>
                <input name="telepon" value="{{ old('telepon', $member->telepon) }}" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Tahun bergabung</label>
                <input name="tahun" value="{{ old('tahun', $member->tahun) }}" maxlength="4" class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Foto (opsional, maks 2 MB)</label>
                <input type="file" name="foto" accept="image/*" data-resize="1200" class="w-full mt-1 text-sm">
            </div>
        </div>
        @if($member->foto)<img src="{{ $member->foto_url }}" class="h-28 rounded-xl object-cover" alt="">@endif

        <div class="flex gap-3 pt-2">
            <button class="bg-nu-700 hover:bg-nu-800 text-white font-semibold px-7 py-2.5 rounded-full">Simpan</button>
            <a href="{{ route('admin.members.index') }}" class="border border-nu-700 text-nu-700 font-semibold px-7 py-2.5 rounded-full">Batal</a>
        </div>
    </form>
</div>
@include('partials.resize-foto')
@endsection
