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
                <img src="/images/logo.png" alt="Logo" class="w-10 h-10 object-contain bg-paper rounded-full p-1" onerror="this.style.display='none'">
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
        @php
            $user = auth()->user();
            $hariIni = \Carbon\Carbon::now()->locale('id')->dayName;
            $isPiket = \App\Models\JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
            $isBtq = \App\Models\KelompokBtq::where('pembina_id', $user->id)->exists();
            $isTahfidz = str_contains($user->nama, 'Miftahul');
            $adaTugas = $isPiket || $isBtq || $isTahfidz;
        @endphp

        @if($adaTugas)
        <div class="bg-green-050 border-l-4 border-green-700 p-5 mb-6 rounded-sm shadow border border-line flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="font-heading font-bold text-green-900 text-lg">📋 Anda Memiliki Tugas Pagi Hari Ini!</h3>
                <p class="text-sm text-green-800 mt-1">
                    @if($isPiket) <span class="font-bold">🚩 Guru Piket</span> • @endif
                    @if($isBtq) <span class="font-bold">📖 Pembina BTQ</span> • @endif
                    @if($isTahfidz) <span class="font-bold">🕌 Pembina Tahfidz</span> • @endif
                    <span class="italic">Silakan lakukan absensi kegiatan pagi (Jam 0).</span>
                </p>
            </div>
            <a href="/absensi-pagi" class="bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-2 px-6 rounded-sm transition shadow-sm border border-gold-600 whitespace-nowrap">
                🕌 Buka Absensi Pagi
            </a>
        </div>
        @endif

        {{-- TAMPILAN BERDASARKAN ROLE --}}
        @if(auth()->user()->role === 'guru_tahfidz')
            @php $adaTahfidz = in_array($hariIni, ['Rabu', 'Kamis', 'Jumat']); @endphp

            @if($adaTahfidz)
                <div class="bg-paper rounded-sm shadow-md p-8 border border-line text-center">
                    <div class="text-6xl mb-4">🕌</div>
                    <h3 class="text-2xl font-heading font-semibold text-ink-900 mb-2">Hari Ini Ada Program Tahfidz!</h3>
                    <p class="text-ink-500 mb-6">Sebagai Pembina Program Tahfidz, silakan absen 20 peserta Tahfidz untuk kegiatan hari {{ $hariIni }}.</p>
                    
                    <div class="bg-green-050 p-4 rounded-sm border border-green-700 mb-6 text-left max-w-md mx-auto">
                        <p class="text-sm text-green-900 font-bold mb-2">📋 Jadwal Program Tahfidz:</p>
                        <ul class="text-sm text-ink-700 space-y-1">
                            <li>✅ <strong>Rabu:</strong> Program Tahfidz (Jam 0-1)</li>
                            <li>✅ <strong>Kamis:</strong> Program Tahfidz (Jam 0-1)</li>
                            <li>✅ <strong>Jumat:</strong> Program Tahfidz (Jam 0-1)</li>
                        </ul>
                    </div>
                    
                    <a href="/absensi-pagi" class="inline-block bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 px-8 rounded-sm shadow-lg transition transform hover:-translate-y-1 border border-gold-600">
                        🕌 Mulai Absensi Tahfidz
                    </a>
                </div>
            @else
                <div class="bg-paper rounded-sm shadow-md p-8 border border-line text-center">
                    <div class="text-6xl mb-4">☕</div>
                    <h3 class="text-2xl font-heading font-semibold text-ink-900 mb-2">Tidak Ada Kegiatan Tahfidz Hari Ini</h3>
                    <p class="text-ink-500">Program Tahfidz dilaksanakan pada hari <strong>Rabu, Kamis, dan Jumat</strong>.<br>Silakan istirahat atau mempersiapkan materi untuk besok.</p>
                </div>
            @endif

        @else
            {{-- TAMPILAN UNTUK GURU MAPEL --}}
            @if(isset($jadwals) && $jadwals->isNotEmpty())
                <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
                    <div class="bg-paper-dim px-6 py-4 border-b-2 border-gold-500">
                        <h3 class="text-lg font-heading font-semibold text-ink-900">📅 Jadwal Mengajar Hari Ini</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-green-900 text-paper text-xs uppercase">
                                    <th class="py-3 px-6 text-left font-heading">Jam</th>
                                    <th class="py-3 px-6 text-left font-heading">Kelas</th>
                                    <th class="py-3 px-6 text-left font-heading">Mata Pelajaran</th>
                                    <th class="py-3 px-6 text-center font-heading">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-ink-700 text-sm">
                                @foreach($jadwals as $jadwal)
                                <tr class="border-b border-line hover:bg-green-050 transition">
                                    <td class="py-4 px-6 font-bold text-ink-900">{{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }}</td>
                                    <td class="py-4 px-6">{{ $jadwal->rombel->kode ?? '-' }}</td>
                                    <td class="py-4 px-6">{{ $jadwal->mapel->nama ?? 'Kokurikuler' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="/guru/jurnal/{{ $jadwal->id }}" class="inline-block bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded-sm text-xs font-bold transition shadow-sm">
                                            🎥 Mulai Kelas
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-paper rounded-sm shadow-md p-8 border border-line text-center">
                    <div class="text-6xl mb-4">☕</div>
                    <h3 class="text-2xl font-heading font-semibold text-ink-900 mb-2">Tidak ada jadwal mengajar hari ini.</h3>
                    <p class="text-ink-500">Silakan istirahat atau mempersiapkan materi untuk esok hari.</p>
                </div>
            @endif
        @endif
    </div>
</body>
</html>