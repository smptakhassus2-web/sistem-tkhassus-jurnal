<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMP Takhassus 2</title>
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
                    <h1 class="text-lg font-heading font-semibold">DASHBOARD GURU</h1>
                    <p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p>
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
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Selamat Pagi, {{ auth()->user()->nama }}!</h2>
            <p class="text-ink-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • Tahun Ajaran 2026/2027</p>
        </div>

        {{-- NOTIFIKASI TUGAS PAGI --}}
        @if(isset($tasks) && count($tasks) > 0)
        <div class="bg-green-050 border-l-4 border-green-700 p-5 mb-6 rounded-sm shadow border border-line">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-heading font-bold text-green-900 text-lg">📋 Anda Memiliki Tugas Pagi Hari Ini!</h3>
                    <p class="text-sm text-green-800 mt-1">
                        @foreach($tasks as $task)
                            <span class="font-bold">{{ $task['icon'] }} {{ $task['judul'] }}</span>
                            @if(!$loop->last) • @endif
                        @endforeach
                    </p>
                </div>
                <a href="/absensi-pagi" class="bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-2 px-6 rounded-sm transition shadow-sm border border-gold-600 whitespace-nowrap">
                     Buka Absensi Pagi
                </a>
            </div>
        </div>
        @endif

        {{-- TAMPILAN JADWAL --}}
        @if(isset($jadwalHariIni) && $jadwalHariIni->isNotEmpty())
            <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
                <div class="bg-paper-dim px-6 py-4 border-b-2 border-gold-500">
                    <h3 class="text-lg font-heading font-semibold text-ink-900">📅 Jadwal Mengajar Hari Ini ({{ $hariIni }})</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="bg-paper-dim rounded-sm p-4 border border-line hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-green-900 text-paper text-xs px-2 py-1 rounded-sm font-bold">Jam ke-{{ $jadwal->jam_ke }}</span>
                            <span class="text-xs text-ink-500">{{ substr($jadwal->waktu_mulai, 0, 5) }}</span>
                        </div>
                        <h4 class="font-heading font-bold text-ink-900 mb-1">{{ $jadwal->mapel->nama ?? 'Kokurikuler' }}</h4>
                        <p class="text-sm text-ink-500 mb-4">Kelas: {{ $jadwal->rombel->kode ?? '-' }}</p>
                        
                        @if($jadwal->sudah_ceklok)
                            <a href="/guru/jurnal/{{ $jadwal->ceklok_id }}" class="block w-full bg-green-700 hover:bg-green-800 text-white text-center py-2 rounded-sm text-sm font-bold transition">
                                📝 Lanjutkan Jurnal
                            </a>
                        @else
                            <form method="POST" action="/guru/ceklok/{{ $jadwal->id }}">
                                @csrf
                                <button type="submit" class="block w-full bg-gold-500 hover:bg-gold-400 text-green-900 py-2 rounded-sm text-sm font-bold transition">
                                    🎥 Mulai Kelas
                                </button>
                            </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-paper rounded-sm shadow-md p-8 border border-line text-center">
                <div class="text-6xl mb-4">☕</div>
                <h3 class="text-2xl font-heading font-semibold text-ink-900 mb-2">Tidak ada jadwal mengajar hari ini.</h3>
                <p class="text-ink-500">Silakan istirahat atau mempersiapkan materi untuk esok hari.</p>
            </div>
        @endif

        {{-- 🔴 TOMBOL INPUT SETORAN HAFALAN (Hanya muncul jika guru punya akses tahfidz) --}}
        @if(auth()->user()->role === 'guru_tahfidz' || auth()->user()->role === 'guru_mapel')
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h3 class="text-lg font-heading font-semibold text-ink-900">📖 Input Setoran Hafalan Siswa</h3>
                <p class="text-sm text-ink-500 mt-1">Catat progres hafalan, nilai, dan juz yang disetor siswa hari ini.</p>
            </div>
            <a href="/tahfidz" class="bg-green-700 hover:bg-green-800 text-paper px-5 py-2.5 rounded-sm text-sm font-bold transition shadow-sm">
                Buka Menu Setoran &rarr;
            </a>
        </div>
        @endif

        {{-- 🔴 TOMBOL INPUT PENILAIAN BTQ (Hanya muncul jika guru terdaftar sebagai pembina BTQ) --}}
        @php
            $isPembinaBtq = \App\Models\KelompokBtq::where('pembina_id', auth()->id())->exists();
        @endphp
        @if($isPembinaBtq)
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-green-700 border border-line flex justify-between items-center">
            <div>
                <h3 class="text-lg font-heading font-semibold text-ink-900">📖 Input Penilaian BTQ</h3>
                <p class="text-sm text-ink-500 mt-1">Catat progres bacaan Iqro' dan Al-Qur'an siswa binaan Anda.</p>
            </div>
            <a href="/btq" class="bg-green-700 hover:bg-green-800 text-paper px-5 py-2.5 rounded-sm text-sm font-bold transition shadow-sm">
                Buka Menu BTQ &rarr;
            </a>
        </div>
        @endif

    </div> <!-- Penutup container utama -->
</body>
</html>