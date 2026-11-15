<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrator') - SMP Takhassus 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33', 'green-050': '#eef6ee', 
                        'gold-500': '#c99a2c', 'gold-400': '#e3b944', 
                        'paper': '#faf6ec', 'paper-dim': '#f2ecdc', 
                        'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362', 'line': '#dcd3ba', 
                    }, 
                    fontFamily: { 'serif': ['Fraunces', 'serif'], 'sans': ['Karla', 'sans-serif'] } 
                } 
            } 
        }
    </script>
    <style>
        body { font-family: 'Karla', sans-serif; background-color: #faf6ec; } 
        .font-heading { font-family: 'Fraunces', serif; }
        .sidebar-link { @apply flex items-center px-4 py-3 text-sm font-medium text-paper-dim hover:bg-green-800 hover:text-white transition rounded-sm mb-1; }
        .sidebar-link.active { @apply bg-gold-500 text-green-900 font-bold; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    {{-- SIDEBAR KIRI --}}
    <aside class="w-64 bg-green-900 text-paper flex flex-col shadow-xl border-r-2 border-gold-500 hidden md:flex">
        {{-- Logo Area --}}
        <div class="p-6 border-b border-green-800">
            <h1 class="text-lg font-heading font-semibold text-white">PANEL ADMIN</h1>
            <p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex-1 p-4 overflow-y-auto">
            <p class="text-xs text-gold-500 uppercase font-bold mb-2 px-2">Menu Utama</p>
            
            <a href="/dashboard" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="mr-3">📊</span> Dashboard
            </a>

            <p class="text-xs text-gold-500 uppercase font-bold mt-6 mb-2 px-2">Manajemen Data</p>
            
            <a href="/admin/guru" class="sidebar-link {{ request()->is('admin/guru*') ? 'active' : '' }}">
                <span class="mr-3">👨‍🏫</span> Data Guru
            </a>
            
   <a href="/admin/siswa" class="sidebar-link {{ request()->is('admin/siswa*') ? 'active' : '' }}">
       <span class="mr-3">👨‍🎓</span> Data Siswa
   </a>
            
            <a href="#" class="sidebar-link">
                <span class="mr-3">🏫</span> Data Kelas <span class="ml-auto text-[10px] bg-green-800 px-1 rounded">Segera</span>
            </a>

            <p class="text-xs text-gold-500 uppercase font-bold mt-6 mb-2 px-2">Akademik</p>
            
            <a href="#" class="sidebar-link">
                <span class="mr-3">📅</span> Jadwal Pelajaran <span class="ml-auto text-[10px] bg-green-800 px-1 rounded">Segera</span>
            </a>
            
            <a href="#" class="sidebar-link">
                <span class="mr-3">🚩</span> Jadwal Piket <span class="ml-auto text-[10px] bg-green-800 px-1 rounded">Segera</span>
            </a>
        </nav>

        {{-- User Info & Logout --}}
        <div class="p-4 border-t border-green-800 bg-green-950">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-gold-500 flex items-center justify-center text-green-900 font-bold text-sm">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-gold-400">Administrator</p>
                </div>
            </div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-sm text-xs font-bold transition">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA (KANAN) --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar Mobile (Hanya muncul di HP) --}}
        <header class="md:hidden bg-green-900 text-paper p-4 flex justify-between items-center border-b border-gold-500">
            <h1 class="font-heading font-semibold">Panel Admin</h1>
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Keluar</button>
            </form>
        </header>

        {{-- Area Konten Dinamis --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-paper p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>