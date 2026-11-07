@extends('layouts.app')
@section('title', 'Kelola Anggota - Banom NU')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-nu-800 mb-6">Anggota &amp; Kartu</h1>
    @include('admin._nav')

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <a href="{{ route('admin.members.create') }}" class="bg-nu-700 hover:bg-nu-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full">+ Tambah Anggota</a>

        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama..." class="border border-gray-300 rounded-full px-4 py-2 text-sm">
            <select name="banom_id" class="border border-gray-300 rounded-full px-4 py-2 text-sm bg-white">
                <option value="">Semua Banom</option>
                @foreach($banoms as $b)<option value="{{ $b->id }}" @selected(request('banom_id') == $b->id)>{{ $b->nama }}</option>@endforeach
            </select>
            <select name="status" class="border border-gray-300 rounded-full px-4 py-2 text-sm bg-white">
                <option value="">Semua status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
            </select>
            <button class="bg-gray-800 text-white text-sm font-semibold px-5 py-2 rounded-full">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left text-xs uppercase text-gray-500">
                <tr><th class="p-3">Foto</th><th class="p-3">NIA</th><th class="p-3">Nama</th><th class="p-3">Banom</th><th class="p-3">Jabatan</th><th class="p-3">Status</th><th class="p-3"></th></tr>
            </thead>
            <tbody>
            @forelse($members as $m)
                <tr class="border-t">
                    <td class="p-3">
                        @if($m->foto)<img src="{{ $m->foto_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
                        @else<span class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">{{ strtoupper(mb_substr($m->nama, 0, 1)) }}</span>@endif
                    </td>
                    <td class="p-3 whitespace-nowrap">{{ $m->nia }}</td>
                    <td class="p-3 font-semibold">{{ $m->nama }}</td>
                    <td class="p-3">{{ $m->banom->nama }}</td>
                    <td class="p-3">{{ $m->jabatan }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $m->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }}">{{ $m->status === 'aktif' ? 'Aktif' : 'Menunggu' }}</span>
                    </td>
                    <td class="p-3 whitespace-nowrap text-right">
                        @if($m->status === 'pending')
                            <form method="POST" action="{{ route('admin.members.approve', $m) }}" class="inline">@csrf
                                <button class="text-emerald-700 font-semibold mr-3">Setujui</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.members.card', $m) }}" class="bg-nu-700 text-white text-xs font-semibold px-3 py-1.5 rounded-full mr-2">Cetak Kartu</a>
                        <a href="{{ route('admin.members.edit', $m) }}" class="text-emerald-700 font-semibold mr-3">Ubah</a>
                        <form method="POST" action="{{ route('admin.members.destroy', $m) }}" class="inline" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="p-6 text-center text-gray-500">Belum ada anggota.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $members->links() }}</div>
</div>
@endsection
