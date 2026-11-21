<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Waka - SMP Takhassus 2</title>
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
    <style>body { font-family: 'Karla', sans-serif; background-color: #faf6ec; } .font-heading { font-family: 'Fraunces', serif; }</style>
</head>
<body>
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div>
                    <h1 class="text-lg font-heading font-semibold">DASHBOARD WAKA</h1>
                    <p class="text-xs text-gold-400 font-heading italic">Monitoring & Supervisi SMP Takhassus 2</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-gold-400">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Selamat Datang, {{ auth()->user()->nama }}!</h2>
            <p class="text-ink-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • Panel Monitoring Sekolah</p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Total Guru -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line border-l-4 border-l-green-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-ink-500 text-sm font-bold uppercase tracking-wider">Total Guru Aktif</p>
                        <p class="text-3xl font-heading font-bold text-ink-900 mt-2">{{ $totalGuru }}</p>
                    </div>
                    <div class="bg-green-050 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Siswa -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line border-l-4 border-l-gold-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-ink-500 text-sm font-bold uppercase tracking-wider">Total Siswa</p>
                        <p class="text-3xl font-heading font-bold text-ink-900 mt-2">{{ $totalSiswa }}</p>
                    </div>
                    <div class="bg-gold-50 p-3 rounded-full">
                        <svg class="w-8 h-8 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Rombel -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line border-l-4 border-l-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-ink-500 text-sm font-bold uppercase tracking-wider">Total Rombel</p>
                        <p class="text-3xl font-heading font-bold text-ink-900 mt-2">{{ $totalRombel }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Monitoring Cepat -->
        <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
            <h3 class="text-xl font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">📊 Menu Monitoring Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="/admin/absensi-7kaih" class="block bg-paper-dim hover:bg-green-050 p-4 rounded-sm border border-line transition group">
                    <h4 class="font-bold text-ink-900 group-hover:text-green-800">📋 Rekap Absensi 7 KAIH</h4>
                    <p class="text-xs text-ink-500 mt-1">Pantau kedisiplinan siswa pagi hari</p>
                </a>
                <a href="/admin/jurnal-mengajar" class="block bg-paper-dim hover:bg-green-050 p-4 rounded-sm border border-line transition group">
                    <h4 class="font-bold text-ink-900 group-hover:text-green-800">📝 Rekap Jurnal Mengajar</h4>
                    <p class="text-xs text-ink-500 mt-1">Pantau keterisian jurnal guru mapel</p>
                </a>
                <a href="/admin/tahfidz" class="block bg-paper-dim hover:bg-green-050 p-4 rounded-sm border border-line transition group">
                    <h4 class="font-bold text-ink-900 group-hover:text-green-800">📖 Rekap Progres Tahfidz</h4>
                    <p class="text-xs text-ink-500 mt-1">Pantau perkembangan hafalan siswa</p>
                </a>
                <a href="/admin/btq" class="block bg-paper-dim hover:bg-green-050 p-4 rounded-sm border border-line transition group">
                    <h4 class="font-bold text-ink-900 group-hover:text-green-800">📖 Rekap Penilaian BTQ</h4>
                    <p class="text-xs text-ink-500 mt-1">Pantau penilaian bacaan Iqro' dan Al-Qur'an</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>