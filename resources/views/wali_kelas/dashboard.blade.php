<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - SMP Takhassus 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33', 'green-050': '#eef6ee', 'gold-500': '#c99a2c', 'gold-400': '#e3b944', 'paper': '#faf6ec', 'paper-dim': '#f2ecdc', 'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362', 'line': '#dcd3ba', }, fontFamily: { 'serif': ['Fraunces', 'serif'], 'sans': ['Karla', 'sans-serif'] } } } }
    </script>
    <style>body { font-family: 'Karla', sans-serif; background-color: #faf6ec; } .font-heading { font-family: 'Fraunces', serif; }</style>
</head>
<body>
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-lg font-heading font-semibold">DASHBOARD WALI KELAS & GURU</h1>
                <p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold">{{ $user->nama }}</p>
                    <p class="text-xs text-gold-400">Wali Kelas {{ $rombel->kode }}</p>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-6xl space-y-6">
        
        <div class="bg-paper rounded-sm shadow-md p-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Selamat Pagi, {{ $user->nama }}!</h2>
            <p class="text-ink-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • Monitoring Kelas {{ $rombel->kode }}</p>
        </div>

        {{-- BAGIAN 1: TUGAS PRIBADI GURU --}}
        @if(count($tasks) > 0)
        <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
            <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">🌅 Tugas Pribadi Saya (Absensi Pagi)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($tasks as $task)
                <a href="{{ $task['url'] }}" class="bg-gold-500 hover:bg-gold-400 text-green-900 p-4 rounded-sm shadow transition flex items-center justify-between border border-gold-600">
                    <div>
                        <div class="text-2xl mb-1">{{ $task['icon'] }}</div>
                        <div class="font-bold text-sm">{{ $task['judul'] }}</div>
                    </div>
                    <div class="text-xl">→</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- BAGIAN 2: REKAP ABSENSI KELAS --}}
        @if($rekapAbsensi->isNotEmpty())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-sm shadow-md p-6 border border-red-200">
            <h3 class="text-lg font-heading font-bold text-red-900 mb-3">⚠️ Perhatian: {{ $rekapAbsensi->count() }} Siswa Kelas {{ $rombel->kode }} Tidak Hadir</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($rekapAbsensi as $absen)
                    <div class="bg-white p-3 rounded-sm border border-red-200 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-ink-900 text-sm">{{ $absen->siswa->nama }}</p>
                            <p class="text-xs text-ink-500">{{ $absen->jenis_kegiatan }}</p>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-sm {{ $absen->status === 'Alpha' ? 'bg-red-200 text-red-800' : ($absen->status === 'Sakit' ? 'bg-yellow-200 text-yellow-800' : 'bg-blue-200 text-blue-800') }}">{{ $absen->status }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-green-050 border-l-4 border-green-700 rounded-sm shadow-md p-4 border border-green-200">
            <div class="flex items-center space-x-3">
                <div class="text-2xl">✅</div>
                <div>
                    <h3 class="font-heading font-bold text-green-900">Alhamdulillah, Semua Siswa Kelas {{ $rombel->kode }} Hadir Hari Ini!</h3>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Jadwal Mengajar Pribadi --}}
                <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
                    <div class="bg-green-900 text-paper px-6 py-4">
                        <h3 class="text-lg font-heading font-semibold">📚 Jadwal Mengajar Saya Hari Ini</h3>
                    </div>
                    <div class="p-6">
                        @if($jadwalPribadi->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($jadwalPribadi as $jadwal)
                                    @php $ceklok = $jadwal->cekloks->first(); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-sm border bg-paper-dim border-line">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-center w-12">
                                                <div class="text-xs text-ink-500">Jam ke</div>
                                                <div class="text-xl font-bold text-ink-900 font-heading">{{ $jadwal->jam_ke }}</div>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-ink-900">{{ $jadwal->mapel->nama ?? '-' }}</h4>
                                                <p class="text-sm text-ink-500">Kelas {{ $jadwal->rombel->kode ?? '-' }} • {{ substr($jadwal->waktu_mulai, 0, 5) }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            @if($ceklok)
                                                <a href="/guru/jurnal/{{ $ceklok->id }}" class="bg-green-700 hover:bg-green-800 text-paper text-xs px-4 py-2 rounded-sm font-bold transition">📝 Lanjutkan Jurnal</a>
                                            @else
                                                <form method="POST" action="/guru/ceklok/{{ $jadwal->id }}">
                                                    @csrf
                                                    <button type="submit" class="bg-gold-500 hover:bg-gold-400 text-green-900 text-xs px-4 py-2 rounded-sm font-bold transition">▶️ Mulai Kelas</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-ink-500">
                                <div class="text-4xl mb-2">☕</div>
                                <p>Tidak ada jadwal mengajar pribadi hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Monitoring Jadwal Kelas --}}
                <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
                    <div class="bg-paper-dim px-6 py-4 border-b-2 border-gold-500">
                        <h3 class="text-lg font-heading font-semibold text-ink-900">👀 Monitoring Guru di Kelas {{ $rombel->kode }}</h3>
                    </div>
                    <div class="p-6">
                        @if($jadwalKelas->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($jadwalKelas as $jadwal)
                                    @php $sudahMulai = $jadwal->cekloks->isNotEmpty(); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-sm border {{ $sudahMulai ? 'bg-green-050 border-green-700' : 'bg-white border-line' }}">
                                        <div>
                                            <h4 class="font-bold text-ink-900">{{ $jadwal->mapel->nama ?? '-' }}</h4>
                                            <p class="text-sm text-ink-500">{{ $jadwal->guru->nama ?? '-' }} • Jam ke {{ $jadwal->jam_ke }}</p>
                                        </div>
                                        <div>
                                            @if($sudahMulai)
                                                <span class="bg-green-700 text-paper text-xs px-3 py-1 rounded-sm font-bold">✅ Sudah Mengajar</span>
                                            @else
                                                <span class="bg-gold-500 text-green-900 text-xs px-3 py-1 rounded-sm font-bold">⏳ Belum Mulai</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-ink-500">Tidak ada jadwal di kelas ini hari ini.</p>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Daftar Siswa --}}
            <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line h-fit">
                <div class="bg-paper-dim px-6 py-4 border-b-2 border-gold-500">
                    <h3 class="text-lg font-heading font-semibold text-ink-900">👥 Daftar Siswa ({{ $siswaList->count() }})</h3>
                </div>
                <div class="p-4 max-h-[800px] overflow-y-auto">
                    <ul class="space-y-2">
                        @foreach($siswaList as $index => $item)
                            <li class="flex items-center space-x-3 p-2 rounded-sm hover:bg-green-050 transition border-b border-line last:border-0">
                                <span class="text-xs text-ink-500 w-6 font-bold">{{ $index + 1 }}.</span>
                                <p class="text-sm font-bold text-ink-900 flex-1">{{ $item->siswa->nama ?? '-' }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</body>
</html>