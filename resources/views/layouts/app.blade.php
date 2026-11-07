<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Banom NU')</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{nu:{50:'#ecfdf3',100:'#d1fae0',600:'#0f7a3d',700:'#0b6030',800:'#094d27',900:'#06391c'},gold:'#d4a017'}}}}</script>
<style>
  @media print{.no-print{display:none!important}body{background:#fff!important}}
  .nav-soft{
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%23ffffff' stroke-opacity='.10' stroke-width='1.2'%3E%3Crect x='20' y='20' width='40' height='40'/%3E%3Crect x='20' y='20' width='40' height='40' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='9'/%3E%3C/g%3E%3C/svg%3E"),linear-gradient(135deg,#23463a 0%,#33644f 60%,#4a8168 100%);
  }
  .btn-pill-nav{ background:linear-gradient(90deg,#e7c76a,#c9a24a); color:#1b3a2d; font-weight:700; border-radius:9999px; }
</style>
</head>
<body class="bg-nu-50 text-gray-800 min-h-screen flex flex-col">

{{-- Navbar putih bulat. Beranda memakai menu sendiri (@section('tanpa_navbar')) --}}
@hasSection('tanpa_navbar')
@else
<header class="no-print nav-soft relative z-30">
  <div class="max-w-6xl mx-auto px-4 py-5">

    <div class="bg-white rounded-full shadow-xl px-5 md:px-7 py-3 flex items-center justify-between gap-4">

      <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <span class="w-9 h-9 rounded-full flex items-center justify-center font-serif font-bold text-sm text-white" style="background:#2f5f4d">NU</span>
        <span class="font-bold text-gray-900 leading-tight">Banom NU</span>
      </a>

      <nav class="hidden md:flex items-center gap-7 text-[11px] font-semibold tracking-wider uppercase text-gray-800">
        <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <a href="{{ route('news.index') }}" class="hover:text-emerald-700 transition">Berita</a>
        <a href="{{ route('home') }}#struktur" class="hover:text-emerald-700 transition">Struktur</a>
        <a href="{{ route('daftar') }}" class="hover:text-emerald-700 transition">Pendaftaran</a>
        @auth
          <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700 transition">Admin</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
            <button class="uppercase tracking-wider hover:text-red-600 transition">Keluar</button>
          </form>
        @endauth
      </nav>

      <div class="flex items-center gap-3">
        <a href="{{ route('daftar') }}" class="btn-pill-nav text-sm px-5 py-2.5 shadow hover:brightness-105 transition whitespace-nowrap">Daftar &nearr;</a>
        <button id="btn-menu-app" type="button" aria-label="Buka menu"
                class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-gray-800" style="background:#eef4f0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
      </div>
    </div>

    <div id="menu-hp-app" class="hidden md:hidden mt-3 bg-white rounded-3xl shadow-xl p-3 text-gray-800">
      <a href="{{ route('home') }}" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Beranda</a>
      <a href="{{ route('news.index') }}" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Berita</a>
      <a href="{{ route('home') }}#struktur" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Struktur</a>
      <a href="{{ route('daftar') }}" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Pendaftaran</a>
      @auth
        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-2xl text-sm font-semibold hover:bg-emerald-50">Admin</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button class="block w-full text-left px-4 py-3 rounded-2xl text-sm font-semibold text-red-600 hover:bg-red-50">Keluar</button>
        </form>
      @endauth
    </div>

  </div>
</header>
<script>
  (function () {
    var b = document.getElementById('btn-menu-app'), m = document.getElementById('menu-hp-app');
    if (b && m) b.addEventListener('click', function () { m.classList.toggle('hidden'); });
  })();
</script>
@endif

<main class="flex-1">@yield('content')</main>

<footer class="no-print bg-nu-900 text-nu-100 text-center text-sm py-4">
  © {{ date('Y') }} Badan Otonom Nahdlatul Ulama
</footer>

@stack('scripts')
</body>
</html>
