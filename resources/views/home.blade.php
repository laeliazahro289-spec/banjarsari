@extends('layouts.app')

@section('tanpa_navbar', '1')

@section('title', 'Beranda - Banom NU')

@php
    $semuaBerita    = $news;
    $jumlahBanom    = $banoms->count();
    $jumlahPengurus = $banoms->sum(fn($b) => $b->pengurus->count());

    $dataBanom = [];
    foreach ($banoms as $b) {
        $pengurus = [];
        foreach ($b->pengurus as $p) {
            $pengurus[] = ['nama' => $p->nama, 'jabatan' => $p->jabatan, 'foto' => $p->foto_url];
        }
        $dataBanom[$b->id] = [
            'id' => $b->id, 'nama' => $b->nama,
            'tingkat' => trim('Struktur ' . ($b->tingkat ?? '')),
            'pengurus' => $pengurus,
        ];
    }

    // Foto opsional: simpan di public/images/hero.jpg dan public/images/banner.jpg
    $adaFotoHero   = file_exists(public_path('images/hero.jpg'));
    $adaFotoBanner = file_exists(public_path('images/banner.jpg'));
@endphp

@section('content')

<style>
    :root{ --h1:#1f4d3b; --h2:#2f7a5c; --h3:#5fae8c; --pucat:#e6f1ea; --krem:#f8f5ee; --emas:#c9a24a; }
    html{ scroll-behavior:smooth; }
    .pola-soft{ background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%23ffffff' stroke-opacity='.12' stroke-width='1.2'%3E%3Crect x='20' y='20' width='40' height='40'/%3E%3Crect x='20' y='20' width='40' height='40' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='9'/%3E%3C/g%3E%3C/svg%3E"); }
    .pola-gelap{ background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%232f7a5c' stroke-opacity='.10' stroke-width='1.2'%3E%3Crect x='20' y='20' width='40' height='40'/%3E%3Crect x='20' y='20' width='40' height='40' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='9'/%3E%3C/g%3E%3C/svg%3E"); }
    .hero-soft{ background:radial-gradient(circle at 15% 20%,rgba(95,174,140,.55) 0,transparent 45%),radial-gradient(circle at 85% 75%,rgba(201,162,74,.28) 0,transparent 40%),linear-gradient(135deg,#16392c 0%,#1f4d3b 45%,#2f7a5c 100%); }
    .orb{ position:absolute; border-radius:9999px; filter:blur(40px); pointer-events:none; animation:melayang 9s ease-in-out infinite; }
    @keyframes melayang{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-22px)} }
    @keyframes putar{ to{transform:rotate(360deg)} }
    .bintang{ animation:putar 90s linear infinite; }
    .judul-hero{ letter-spacing:.02em; text-shadow:0 6px 30px rgba(0,0,0,.25); }
    .btn-emas{ background:linear-gradient(90deg,#e7c76a,#c9a24a); color:#1b3a2d; font-weight:700; border-radius:9999px; }
    .btn-kaca{ background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.45); color:#fff; border-radius:9999px; -webkit-backdrop-filter:blur(10px); backdrop-filter:blur(10px); }
    .kaca-putih{ background:rgba(255,255,255,.82); border:1px solid rgba(255,255,255,.95); -webkit-backdrop-filter:blur(16px); backdrop-filter:blur(16px); box-shadow:0 24px 50px -24px rgba(22,57,44,.55); }
    .marquee{ overflow:hidden; white-space:nowrap; }
    .marquee-isi{ display:inline-block; animation:geser-pita 28s linear infinite; }
    @keyframes geser-pita{ from{transform:translateX(0)} to{transform:translateX(-50%)} }
    .blok-gambar{ background:linear-gradient(135deg,#3f8a6b,#1f4d3b); }
    .clamp2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .geser{ scrollbar-width:none; -ms-overflow-style:none; scroll-behavior:smooth; }
    .geser::-webkit-scrollbar{ display:none; }
    .kartu-geser img,.kartu-geser .isi-kosong{ transition:transform .8s ease; }
    .kartu-geser:hover img,.kartu-geser:hover .isi-kosong{ transform:scale(1.07); }
    .tgl-kaca{ background:rgba(255,255,255,.22); border:1px solid rgba(255,255,255,.55); -webkit-backdrop-filter:blur(10px); backdrop-filter:blur(10px); }
    .btn-panah{ width:48px; height:48px; border-radius:9999px; display:grid; place-items:center; font-size:20px; background:#fff; color:var(--h1); border:1px solid rgba(31,77,59,.15); box-shadow:0 10px 24px -14px rgba(31,77,59,.6); transition:.25s; cursor:pointer; }
    .btn-panah:hover{ background:var(--h1); color:#fff; transform:scale(1.06); }
    .banom-btn{ position:relative; z-index:5; cursor:pointer; }
    .banom-btn *{ pointer-events:none; }
    .lambang{ width:64px; height:64px; border-radius:20px; display:grid; place-items:center; color:#fff; font-weight:800; font-size:20px; background:linear-gradient(135deg,var(--h3),var(--h1)); box-shadow:0 12px 24px -12px rgba(31,77,59,.7); }
    .tumpuk>*{ margin-left:-10px; } .tumpuk>*:first-child{ margin-left:0; }
    .rv{ opacity:0; transform:translateY(26px); transition:opacity .8s ease,transform .8s ease; }
    .rv.on{ opacity:1; transform:none; }
    #modal{ display:none; } #modal.tampil{ display:flex; }
</style>
<noscript><style>.rv{opacity:1;transform:none}</style></noscript>

{{-- ===================== HERO ===================== --}}
<section class="hero-soft relative overflow-hidden text-white rounded-b-[2.5rem] md:rounded-b-[3.5rem]"
    @if($adaFotoHero) style="background-image:linear-gradient(rgba(16,45,34,.72),rgba(16,45,34,.72)),url('{{ asset('images/hero.jpg') }}');background-size:cover;background-position:center;" @endif>

    <div class="pola-soft absolute inset-0 pointer-events-none"></div>
    <div class="orb w-72 h-72 -top-16 -left-16" style="background:rgba(95,174,140,.45)"></div>
    <div class="orb w-80 h-80 bottom-0 right-10" style="background:rgba(201,162,74,.28);animation-delay:-4s"></div>

    <svg class="bintang hidden md:block absolute -right-24 top-24 opacity-25 pointer-events-none" width="520" height="520" viewBox="0 0 100 100" fill="none" stroke="#fff" stroke-width=".35">
        <rect x="22" y="22" width="56" height="56"/><rect x="22" y="22" width="56" height="56" transform="rotate(45 50 50)"/>
        <circle cx="50" cy="50" r="28"/><circle cx="50" cy="50" r="14"/><circle cx="50" cy="50" r="40" stroke-dasharray="1 2"/>
    </svg>

    {{-- Menu melayang --}}
    <div class="absolute top-5 inset-x-0 z-30 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="kaca-putih rounded-full px-5 md:px-7 py-3 flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center font-serif font-bold text-sm text-white" style="background:linear-gradient(135deg,var(--h3),var(--h1))">NU</span>
                    <span class="leading-tight"><span class="block font-bold text-gray-900">Banom NU</span><span class="block text-[10px] text-gray-500 tracking-wider">BANJARSARI</span></span>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-[11px] font-semibold tracking-[.18em] uppercase text-gray-700">
                    <a href="{{ route('home') }}" style="color:var(--h2)">Beranda</a>
                    <a href="#berita" class="hover:text-emerald-700 transition">Berita</a>
                    <a href="#struktur" class="hover:text-emerald-700 transition">Struktur</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ route('daftar') }}" class="btn-emas text-sm px-5 py-2.5 shadow-md hover:brightness-105 transition whitespace-nowrap">Daftar &nearr;</a>
                    <button id="btn-menu" type="button" aria-label="Buka menu" class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-gray-800" style="background:var(--pucat)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                </div>
            </div>
            <div id="menu-hp" class="hidden md:hidden mt-3 kaca-putih rounded-3xl p-3 text-gray-800">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50" style="color:var(--h2)">Beranda</a>
                <a href="#berita" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Berita</a>
                <a href="#struktur" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Struktur</a>
            </div>
        </div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 pt-44 md:pt-52 pb-36 md:pb-44">
        <p class="rv text-[11px] md:text-xs font-semibold tracking-[.35em] uppercase" style="color:#e7c76a">Keluarga Besar Nahdlatul Ulama</p>
        <h1 class="rv judul-hero font-serif font-bold text-5xl md:text-7xl leading-[1.05] mt-4" style="transition-delay:.1s">BANOM<br>BANJARSARI</h1>
        <div class="rv w-20 h-1 rounded-full mt-6" style="background:var(--emas);transition-delay:.2s"></div>
        <p class="rv mt-6 text-emerald-50/90 max-w-xl leading-relaxed text-base md:text-lg" style="transition-delay:.3s">
            Wadah informasi, kaderisasi, dan pendaftaran anggota IPNU, IPPNU, Muslimat, Fatayat, GP Ansor, dan Banser.
        </p>
        <div class="rv mt-9 flex flex-wrap gap-3" style="transition-delay:.4s">
            <a href="#berita" class="btn-emas px-8 py-3.5 shadow-lg hover:brightness-105 transition">Lihat Berita</a>
            <a href="#struktur" class="btn-kaca px-8 py-3.5 font-semibold hover:bg-white/25 transition">Struktur Organisasi &rarr;</a>
        </div>
    </div>
</section>

{{-- ===================== STATISTIK ===================== --}}
<div class="relative z-20 -mt-20 md:-mt-24 px-4">
    <div class="rv kaca-putih max-w-4xl mx-auto rounded-3xl px-4 py-6 md:py-7 grid grid-cols-3 text-center">
        <div class="border-r border-emerald-900/10"><p class="font-serif font-bold text-3xl md:text-4xl" style="color:var(--h1)">{{ $jumlahBanom }}</p><p class="text-[11px] md:text-xs text-gray-500 mt-1 tracking-wider uppercase">Badan Otonom</p></div>
        <div class="border-r border-emerald-900/10"><p class="font-serif font-bold text-3xl md:text-4xl" style="color:var(--h1)">{{ $jumlahPengurus }}</p><p class="text-[11px] md:text-xs text-gray-500 mt-1 tracking-wider uppercase">Pengurus</p></div>
        <div><p class="font-serif font-bold text-3xl md:text-4xl" style="color:var(--h1)">{{ $totalBerita }}</p><p class="text-[11px] md:text-xs text-gray-500 mt-1 tracking-wider uppercase">Berita</p></div>
    </div>
</div>

{{-- ===================== PITA BANOM ===================== --}}
<div class="marquee mt-14 py-4 border-y border-emerald-900/10" style="background:var(--pucat)">
    <div class="marquee-isi font-serif font-bold text-xl md:text-2xl" style="color:var(--h2)">
        @for($i = 0; $i < 2; $i++)
            @foreach(['IPNU','IPPNU','Fatayat','Muslimat','GP Ansor','Banser'] as $nm)
                <span class="mx-6">{{ $nm }}</span><span class="mx-2" style="color:var(--emas)">&#10022;</span>
            @endforeach
        @endfor
    </div>
</div>

{{-- ===================== BERITA (KARTU GESER) ===================== --}}
<section id="berita" class="pola-gelap relative overflow-hidden" style="background-color:#f1f7f3">
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/70 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 -right-24 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:rgba(95,174,140,.22)"></div>

    <div class="relative max-w-6xl mx-auto px-4 pt-20 md:pt-24 pb-20 md:pb-24">
        <div class="rv flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="text-[11px] font-semibold tracking-[.3em] uppercase" style="color:var(--h2)">Kabar Terbaru</p>
                <h2 class="font-serif font-bold text-4xl md:text-5xl text-gray-900 mt-2">Berita Terbaru</h2>
                <p class="text-gray-600 mt-3 max-w-md leading-relaxed">Geser untuk membaca kabar dan kegiatan terbaru dari keluarga besar Banom Nahdlatul Ulama.</p>
            </div>
            @if($semuaBerita->count() > 1)
            <div class="flex items-center gap-3">
                <button id="g-kiri" type="button" class="btn-panah" aria-label="Sebelumnya">&larr;</button>
                <button id="g-kanan" type="button" class="btn-panah" aria-label="Berikutnya">&rarr;</button>
            </div>
            @endif
        </div>

        @if($semuaBerita->count() > 0)
            <div id="g-jalur" class="geser rv mt-12 -mx-4 px-4 flex items-start gap-5 md:gap-6 overflow-x-auto snap-x snap-mandatory pb-14">
                @foreach($semuaBerita as $n)
                    @php $tgl = $n->published_at; @endphp
                    <a href="{{ route('news.show', $n) }}"
                       class="g-kartu kartu-geser group relative flex-shrink-0 snap-start block w-[78vw] sm:w-[320px] md:w-[350px] h-[430px] md:h-[470px] rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-shadow duration-300 {{ $loop->even ? 'md:mt-12' : '' }}">
                        @if($n->gambar)
                            <img src="{{ $n->gambar_url }}" alt="{{ $n->judul }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="isi-kosong absolute inset-0 blok-gambar pola-soft flex items-center justify-center"><span class="font-serif italic font-bold text-8xl" style="color:var(--emas)">NU</span></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                        <div class="absolute top-5 left-5 tgl-kaca rounded-2xl px-4 py-2 text-center text-white leading-none">
                            <p class="font-serif font-bold text-3xl">{{ $tgl?->format('d') }}</p>
                            <p class="text-[10px] tracking-[.2em] uppercase mt-1">{{ $tgl?->translatedFormat('M Y') }}</p>
                        </div>
                        <span class="absolute top-6 right-6 font-serif font-bold text-5xl text-white/25 leading-none">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="absolute bottom-0 inset-x-0 p-6 md:p-7 text-white">
                            <span class="inline-block text-[10px] font-bold tracking-[.18em] uppercase rounded-full px-3 py-1" style="background:var(--emas);color:#1b3a2d">{{ $n->kategori ?? 'Berita' }}</span>
                            <h3 class="clamp2 font-serif font-bold text-2xl leading-snug mt-3">{{ $n->judul }}</h3>
                            <p class="clamp2 text-sm text-white/75 mt-2">{{ Str::limit($n->ringkasan, 90) }}</p>
                            <div class="flex items-center justify-between mt-5">
                                <span class="text-sm font-semibold" style="color:#f0d27f">Baca selengkapnya</span>
                                <span class="w-11 h-11 rounded-full bg-white text-gray-900 flex items-center justify-center text-lg group-hover:translate-x-1 group-hover:bg-amber-200 transition">&rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                <a href="{{ route('news.index') }}" class="g-kartu flex-shrink-0 snap-start w-[60vw] sm:w-[240px] h-[430px] md:h-[470px] rounded-[2rem] flex flex-col items-center justify-center text-center text-white p-6 hero-soft pola-soft hover:brightness-110 transition">
                    <span class="w-16 h-16 rounded-full bg-white/20 border border-white/50 flex items-center justify-center text-3xl">&rarr;</span>
                    <p class="font-serif font-bold text-2xl mt-5">Lihat Semua<br>Berita</p>
                </a>
            </div>
            <div class="rv -mt-4 h-1.5 rounded-full overflow-hidden max-w-xs mx-auto" style="background:rgba(31,77,59,.15)"><div id="g-isi" class="h-full rounded-full transition-all duration-200" style="width:25%;background:var(--h2)"></div></div>
        @else
            <p class="text-gray-500 text-center py-16">Belum ada berita.</p>
        @endif
    </div>
</section>

{{-- ===================== STRUKTUR ===================== --}}
<section id="struktur" class="relative" style="background:var(--krem)">
    <div class="relative z-10 max-w-6xl mx-auto px-4 py-20 md:py-24">
        <div class="rv text-center max-w-xl mx-auto mb-14">
            <p class="text-[11px] font-semibold tracking-[.3em] uppercase" style="color:var(--h2)">Kepengurusan</p>
            <h2 class="font-serif font-bold text-4xl md:text-5xl mt-2" style="color:var(--h1)">Struktur Banom NU</h2>
            <p class="text-gray-500 mt-3">Klik salah satu Banom untuk melihat susunan pengurusnya.</p>
        </div>

        @if($banoms->count() > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($banoms as $b)
                <button type="button" data-banom="{{ $b->id }}"
                        class="banom-btn rv group relative text-left w-full rounded-[2rem] p-7 bg-white overflow-hidden border border-emerald-900/10 shadow-md hover:shadow-2xl hover:-translate-y-1.5 transition duration-300"
                        style="transition-delay:{{ ($loop->index % 3) * 0.08 }}s">
                    <span class="absolute -right-12 -top-12 w-44 h-44 rounded-full opacity-20 group-hover:opacity-40 group-hover:scale-125 transition duration-500" style="background:var(--h3)"></span>
                    <span class="pola-gelap absolute inset-0 opacity-70"></span>
                    <span class="lambang relative">{{ Str::upper(Str::limit($b->nama, 2, '')) }}</span>
                    <h3 class="relative font-serif font-bold text-3xl text-gray-900 mt-6 group-hover:text-emerald-700 transition">{{ $b->nama }}</h3>
                    <p class="relative text-xs tracking-widest uppercase mt-1" style="color:var(--h2)">{{ $b->tingkat ?: 'Badan Otonom NU' }}</p>
                    <div class="relative flex items-center justify-between mt-8">
                        <div class="flex items-center gap-3">
                            <div class="tumpuk flex">
                                @foreach($b->pengurus->take(3) as $p)
                                    @if($p->foto)
                                        <img src="{{ $p->foto_url }}" alt="" class="w-9 h-9 rounded-full object-cover border-2 border-white">
                                    @else
                                        <span class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold text-white" style="background:var(--h2)">{{ Str::upper(Str::substr($p->nama, 0, 1)) }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <span class="text-sm text-gray-500">{{ $b->pengurus->count() }} pengurus</span>
                        </div>
                        <span class="w-10 h-10 rounded-full flex items-center justify-center text-white text-lg group-hover:translate-x-1 transition" style="background:var(--h1)">&rarr;</span>
                    </div>
                </button>
            @endforeach
        </div>
        @else
            <p class="text-gray-500 text-center">Belum ada data Banom.</p>
        @endif
    </div>
</section>

{{-- ===================== AJAKAN DAFTAR ===================== --}}
<section class="px-4 pb-20" style="background:var(--krem)">
    <div class="rv relative max-w-6xl mx-auto overflow-hidden rounded-[2rem] md:rounded-[2.5rem] text-white hero-soft"
        @if($adaFotoBanner) style="background-image:linear-gradient(100deg,rgba(16,45,34,.92) 35%,rgba(16,45,34,.45)),url('{{ asset('images/banner.jpg') }}');background-size:cover;background-position:center;" @endif>
        <div class="pola-soft absolute inset-0 pointer-events-none"></div>
        <div class="orb w-64 h-64 -right-10 -bottom-10" style="background:rgba(201,162,74,.35)"></div>
        <div class="relative px-8 md:px-14 py-14 md:py-16 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-[11px] font-semibold tracking-[.3em] uppercase" style="color:#e7c76a">Mari Berkhidmat</p>
                <h2 class="font-serif font-bold text-4xl md:text-5xl leading-tight mt-3">Bergabunglah<br>Bersama Kami!</h2>
            </div>
            <div class="md:text-right">
                <p class="text-emerald-50/90 max-w-sm md:ml-auto leading-relaxed">Daftarkan diri Anda sebagai anggota Banom NU dan jadi bagian dari keluarga besar Nahdlatul Ulama.</p>
                <a href="{{ route('daftar') }}" class="inline-flex items-center gap-2 btn-emas px-9 py-4 mt-6 shadow-xl hover:brightness-105 transition">Daftar Sekarang &nearr;</a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== MODAL PENGURUS ===================== --}}
<div id="modal" class="fixed inset-0 items-center justify-center p-4" style="z-index:9999;background:rgba(10,30,22,.65);backdrop-filter:blur(4px)">
    <div class="bg-white max-w-2xl w-full max-h-[90vh] overflow-y-auto relative rounded-[2rem] shadow-2xl">
        <div class="hero-soft pola-soft text-white px-6 md:px-8 pt-8 pb-6 rounded-t-[2rem] relative">
            <button id="modal-close" type="button" class="absolute top-4 right-5 text-3xl leading-none text-white/70 hover:text-white" aria-label="Tutup">&times;</button>
            <h3 id="m-nama" class="font-serif font-bold text-3xl"></h3>
            <p id="m-tingkat" class="text-sm text-emerald-100/90 mt-1"></p>
        </div>
        <div class="p-6 md:p-8"><div id="m-list" class="grid grid-cols-2 sm:grid-cols-3 gap-6"></div></div>
    </div>
</div>

<script>
(function () {
    var DATA = @json($dataBanom);
    var modal = document.getElementById('modal'), mNama = document.getElementById('m-nama'),
        mTingkat = document.getElementById('m-tingkat'), mList = document.getElementById('m-list'),
        menuHp = document.getElementById('menu-hp');

    function esc(v) {
        if (v === null || v === undefined) return '';
        var map = {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'};
        return String(v).replace(/[&<>"']/g, function (c) { return map[c]; });
    }
    function kartu(p) {
        var nama = p.nama || 'Tanpa Nama', jab = p.jabatan || '-';
        var foto = p.foto
            ? '<img src="' + esc(p.foto) + '" alt="" class="w-24 h-24 rounded-3xl object-cover mx-auto shadow-md">'
            : '<div class="w-24 h-24 rounded-3xl text-white font-bold text-3xl flex items-center justify-center mx-auto shadow-md" style="background:linear-gradient(135deg,#5fae8c,#1f4d3b)">' + esc(nama.charAt(0).toUpperCase()) + '</div>';
        return '<div class="text-center">' + foto + '<p class="font-bold text-sm text-gray-900 mt-3">' + esc(nama) + '</p><p class="text-[10px] font-semibold tracking-widest uppercase mt-1" style="color:#2f7a5c">' + esc(jab) + '</p></div>';
    }
    function bukaModal(b) {
        if (!b) return;
        mNama.textContent = b.nama || 'Banom NU';
        mTingkat.textContent = b.tingkat || '';
        var ps = Array.isArray(b.pengurus) ? b.pengurus : [];
        mList.innerHTML = ps.length ? ps.map(kartu).join('') : '<p class="text-gray-500 col-span-full text-center py-6">Belum ada data pengurus.</p>';
        modal.classList.add('tampil'); document.body.style.overflow = 'hidden';
    }
    function tutupModal() { modal.classList.remove('tampil'); document.body.style.overflow = ''; }

    document.addEventListener('click', function (e) {
        var t = e.target;
        if (t.closest && t.closest('#btn-menu')) { menuHp.classList.toggle('hidden'); return; }
        if (t.closest && t.closest('#menu-hp a')) { menuHp.classList.add('hidden'); }
        var btn = t.closest ? t.closest('.banom-btn') : null;
        if (btn) { bukaModal(DATA[btn.getAttribute('data-banom')]); return; }
        if (t === modal || (t.closest && t.closest('#modal-close'))) { tutupModal(); }
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') tutupModal(); });

    var rv = document.querySelectorAll('.rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (items) {
            items.forEach(function (it) { if (it.isIntersecting) { it.target.classList.add('on'); io.unobserve(it.target); } });
        }, { threshold: 0.12 });
        rv.forEach(function (el) { io.observe(el); });
    } else { rv.forEach(function (el) { el.classList.add('on'); }); }

    var jalur = document.getElementById('g-jalur');
    if (jalur) {
        var kiri = document.getElementById('g-kiri'), kanan = document.getElementById('g-kanan'), isi = document.getElementById('g-isi');
        var langkah = function () { var k = jalur.querySelector('.g-kartu'); return k ? k.getBoundingClientRect().width + 24 : 340; };
        var perbarui = function () {
            var maks = jalur.scrollWidth - jalur.clientWidth, rasio = maks > 0 ? jalur.scrollLeft / maks : 0;
            var lebar = Math.max(18, Math.min(100, (jalur.clientWidth / jalur.scrollWidth) * 100));
            isi.style.width = lebar + '%'; isi.style.marginLeft = ((100 - lebar) * rasio) + '%';
        };
        if (kiri) kiri.addEventListener('click', function () { jalur.scrollBy({ left: -langkah(), behavior: 'smooth' }); });
        if (kanan) kanan.addEventListener('click', function () { jalur.scrollBy({ left: langkah(), behavior: 'smooth' }); });
        jalur.addEventListener('scroll', perbarui, { passive: true });
        window.addEventListener('resize', perbarui); perbarui();
    }
})();
</script>

@endsection
