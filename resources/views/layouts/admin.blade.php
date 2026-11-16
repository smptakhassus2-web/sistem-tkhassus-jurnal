<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrator') - SMP Takhassus Al-Qur'an 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33',
                        'green-050': '#eef6ee',
                        'gold-600': '#a9791a', 'gold-500': '#c99a2c', 'gold-400': '#e3b944',
                        'paper': '#faf6ec', 'paper-dim': '#f2ecdc',
                        'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362',
                        'line': '#dcd3ba',
                    },
                    fontFamily: {
                        'serif': ['Fraunces', 'Georgia', 'serif'],
                        'sans': ['Karla', 'Segoe UI', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Karla', sans-serif; background-color: #faf6ec; }
        .font-heading { font-family: 'Fraunces', serif; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-paper">

    {{-- ===================== SIDEBAR KIRI ===================== --}}
    <aside class="w-72 bg-green-900 text-paper flex flex-col shadow-xl border-r-2 border-gold-500 hidden md:flex flex-shrink-0">

        {{-- 1. HEADER PROFIL USER --}}
        <div class="p-4 border-b border-green-800">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-gold-500 flex items-center justify-center text-green-900 font-bold text-base flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama ?? 'Admin' }}</p>
                    <p class="text-xs text-gold-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <span class="inline-block bg-green-700 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                Akun Terverifikasi
            </span>
        </div>

        {{-- 2. INFO SISTEM --}}
        <div class="px-4 py-2 border-b border-green-800 bg-green-950">
            <p class="text-[11px] text-gold-400 flex items-center gap-2 whitespace-nowrap">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse flex-shrink-0"></span>
                <span>Sistem Aktif • {{ \Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}</span>
            </p>
        </div>

        {{-- 3. MENU NAVIGASI --}}
        <nav class="flex-1 py-2 overflow-y-auto">

            {{-- ===== MENU UTAMA ===== --}}
            <p class="text-[10px] text-gold-500 uppercase font-bold mb-1 mt-2 px-4 tracking-widest">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('dashboard') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">📊</span>
                <span class="flex-1">Dashboard</span>
            </a>

            {{-- ===== MANAJEMEN DATA ===== --}}
            <p class="text-[10px] text-gold-500 uppercase font-bold mb-1 mt-4 px-4 tracking-widest">Manajemen Data</p>

            <a href="{{ route('admin.guru.index') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('admin.guru.*') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">👨‍🏫</span>
                <span class="flex-1">Data Guru</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('admin.siswa.*') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">👨‍🎓</span>
                <span class="flex-1">Data Siswa</span>
            </a>

            <a href="{{ route('admin.rombel.index') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('admin.rombel.*') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">🏫</span>
                <span class="flex-1">Data Kelas</span>
            </a>

            {{-- ===== AKADEMIK ===== --}}
            <p class="text-[10px] text-gold-500 uppercase font-bold mb-1 mt-4 px-4 tracking-widest">Akademik</p>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">📚</span>
                <span class="flex-1">Mata Pelajaran</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

            <a href="{{ route('admin.jadwal.index') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('admin.jadwal.*') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">📅</span>
                <span class="flex-1">Jadwal Pelajaran</span>
            </a>

            {{-- 🔴 DIPERBAIKI: Jadwal Piket sekarang BISA DIKLIK --}}
            <a href="{{ route('admin.jadwal_piket.index') }}"
               class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap transition
                      {{ request()->routeIs('admin.jadwal_piket.*') ? 'bg-gold-500 text-green-900 font-bold' : 'text-paper-dim hover:bg-green-800 hover:text-white' }}">
                <span class="w-5 text-center flex-shrink-0">🚩</span>
                <span class="flex-1">Jadwal Piket</span>
            </a>

            {{-- ===== REKAP & LAPORAN ===== --}}
            <p class="text-[10px] text-gold-500 uppercase font-bold mb-1 mt-4 px-4 tracking-widest">Rekap & Laporan</p>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">📝</span>
                <span class="flex-1">Jurnal Mengajar</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">✅</span>
                <span class="flex-1">Absensi 7 KAIH</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">📖</span>
                <span class="flex-1">Laporan Tahfidz</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

            {{-- ===== LAINNYA ===== --}}
            <p class="text-[10px] text-gold-500 uppercase font-bold mb-1 mt-4 px-4 tracking-widest">Lainnya</p>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">👫</span>
                <span class="flex-1">Portal Orang Tua</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

            <span class="flex items-center gap-2 px-4 py-2.5 text-sm whitespace-nowrap text-paper-dim opacity-50 cursor-not-allowed">
                <span class="w-5 text-center flex-shrink-0">⚙️</span>
                <span class="flex-1">Pengaturan</span>
                <span class="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded font-bold flex-shrink-0">Segera</span>
            </span>

        </nav>

        {{-- 4. TOMBOL KELUAR --}}
        <div class="p-3 border-t border-green-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm font-bold transition flex items-center justify-center gap-2">
                    <span>⏻</span> Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ===================== KONTEN UTAMA (KANAN) ===================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar Mobile --}}
        <header class="md:hidden bg-green-900 text-paper p-4 flex justify-between items-center border-b border-gold-500">
            <h1 class="font-heading font-semibold text-sm">Panel Admin • SMP Takhassus 2</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold">Keluar</button>
            </form>
        </header>

        {{-- Area Konten Dinamis --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-paper p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>