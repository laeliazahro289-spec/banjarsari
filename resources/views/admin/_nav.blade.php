<div class="no-print">
    <div class="flex flex-wrap gap-2 mb-6">
        @php
            $menu = [
                ['admin.dashboard', 'Dashboard', 'admin.dashboard'],
                ['admin.news.index', 'Berita', 'admin.news.*'],
                ['admin.members.index', 'Anggota & Kartu', 'admin.members.*'],
            ];
        @endphp
        @foreach($menu as [$rute, $nama, $pola])
            <a href="{{ route($rute) }}"
               class="px-5 py-2 rounded-full text-sm font-semibold border transition {{ request()->routeIs($pola) ? 'bg-nu-700 text-white border-nu-700' : 'bg-white text-nu-700 border-emerald-200 hover:bg-emerald-50' }}">
                {{ $nama }}
            </a>
        @endforeach
    </div>

    @if(session('ok'))
        <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">{{ session('ok') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
            <ul class="list-disc ml-5">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif
</div>
