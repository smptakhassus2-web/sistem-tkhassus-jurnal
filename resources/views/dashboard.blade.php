<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrator - SMP Takhassus Al-Qur'an 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33', 'green-600': '#158a3d', 'green-050': '#eef6ee',
                        'gold-600': '#a9791a', 'gold-500': '#c99a2c', 'gold-400': '#e3b944',
                        'paper': '#faf6ec', 'paper-dim': '#f2ecdc',
                        'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362', 'line': '#dcd3ba',
                    },
                    fontFamily: { 'serif': ['Fraunces', 'Georgia', 'serif'], 'sans': ['Karla', 'Segoe UI', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>body { font-family: 'Karla', sans-serif; background-color: #faf6ec; } .font-heading { font-family: 'Fraunces', serif; }</style>
</head>
<body>
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="/images/logo.png" alt="Logo" class="w-10 h-10 object-contain bg-paper rounded-full p-1" onerror="this.style.display='none'">
                    <div>
                        <h1 class="text-lg font-heading font-semibold tracking-wide">DASHBOARD ADMINISTRATOR</h1>
                        <p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold">{{ auth()->user()->nama ?? 'Admin' }}</p>
                        <p class="text-xs text-gold-400">{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}</p>
                    </div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <!-- Header Dashboard -->
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <div class="flex justify-between items-center flex-wrap">
                <div>
                    <h2 class="text-2xl font-heading font-semibold text-ink-900">📊 Ringkasan Hari Ini</h2>
                    <p class="text-ink-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • Tahun Ajaran 2026/2027</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="bg-green-050 text-green-800 text-xs font-bold px-3 py-1 rounded-sm border border-green-700">🟢 Sistem Aktif</span>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-paper rounded-sm shadow-md p-6 border-t-4 border-green-700 hover:shadow-lg transition border border-line">
                <div class="flex items-center justify-between">
                    <div><p class="text-ink-500 text-xs font-bold uppercase">Guru Hadir</p><p class="text-3xl font-heading font-semibold text-green-700 mt-1">{{ $hadir ?? 0 }}</p></div>
                    <div class="bg-green-050 p-3 rounded-full border border-green-700"><span class="text-2xl">✅</span></div>
                </div>
            </div>
            <div class="bg-paper rounded-sm shadow-md p-6 border-t-4 border-gold-500 hover:shadow-lg transition border border-line">
                <div class="flex items-center justify-between">
                    <div><p class="text-ink-500 text-xs font-bold uppercase">Guru Terlambat</p><p class="text-3xl font-heading font-semibold text-gold-600 mt-1">{{ $terlambat ?? 0 }}</p></div>
                    <div class="bg-paper-dim p-3 rounded-full border border-gold-500"><span class="text-2xl">⏰</span></div>
                </div>
            </div>
            <div class="bg-paper rounded-sm shadow-md p-6 border-t-4 border-red-600 hover:shadow-lg transition border border-line">
                <div class="flex items-center justify-between">
                    <div><p class="text-ink-500 text-xs font-bold uppercase">Guru Alpha</p><p class="text-3xl font-heading font-semibold text-red-600 mt-1">{{ $alpha ?? 0 }}</p></div>
                    <div class="bg-red-50 p-3 rounded-full border border-red-600"><span class="text-2xl">❌</span></div>
                </div>
            </div>
            <div class="bg-paper rounded-sm shadow-md p-6 border-t-4 border-green-600 hover:shadow-lg transition border border-line">
                <div class="flex items-center justify-between">
                    <div><p class="text-ink-500 text-xs font-bold uppercase">Jurnal Terisi</p><p class="text-3xl font-heading font-semibold text-green-600 mt-1">{{ $persentaseJurnal ?? 0 }}%</p></div>
                    <div class="bg-green-050 p-3 rounded-full border border-green-600"><span class="text-2xl">📝</span></div>
                </div>
            </div>
        </div>

        <!-- Tabel Monitoring -->
        <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line mb-6">
            <div class="bg-paper-dim px-6 py-4 border-b-2 border-gold-500">
                <h3 class="text-lg font-heading font-semibold text-ink-900 flex items-center">
                    <span class="bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs mr-2">!</span>
                    PERINGATAN: Guru Belum Ceklok (Real-time)
                </h3>
                <p class="text-xs text-ink-500 mt-1">Daftar guru yang jadwalnya sudah dimulai namun belum melakukan ceklok</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-green-900 text-paper text-xs uppercase">
                            <th class="py-3 px-6 text-left font-heading font-semibold">Nama Guru</th>
                            <th class="py-3 px-6 text-left font-heading font-semibold">Mapel / Kelas</th>
                            <th class="py-3 px-6 text-left font-heading font-semibold">Jadwal</th>
                            <th class="py-3 px-6 text-left font-heading font-semibold">Status</th>
                            <th class="py-3 px-6 text-center font-heading font-semibold">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="text-ink-700 text-sm">
                        @forelse($guruPerluPerhatian ?? [] as $item)
                        <tr class="border-b border-line hover:bg-green-050 transition">
                            <td class="py-4 px-6"><div class="font-bold text-ink-900">{{ $item->guru->nama }}</div></td>
                            <td class="py-4 px-6"><div class="text-sm">{{ $item->mapel->nama ?? 'Mapel' }} / {{ $item->rombel->kode ?? 'Kelas' }}</div></td>
                            <td class="py-4 px-6"><div class="text-sm font-bold text-ink-900">{{ substr($item->waktu_mulai, 0, 5) }}</div></td>
                            <td class="py-4 px-6"><span class="bg-red-50 text-red-800 py-1 px-3 rounded-sm text-xs font-bold border border-red-600">🔴 Belum Ceklok</span></td>
                            <td class="py-4 px-6 text-center">
                                <a href="https://wa.me/{{ $item->guru->no_hp }}?text=Assalamu'alaikum%20{{ urlencode($item->guru->nama) }},%20mohon%20ceklok%20KBM%20segera." target="_blank" class="inline-block bg-green-700 hover:bg-green-800 text-white py-2 px-3 rounded-sm text-xs font-bold transition shadow-sm">💬 WA</a>
                                <button type="button" onclick="alert('Fitur Catatan Teguran akan segera ditambahkan!')" class="inline-block bg-gold-500 hover:bg-gold-400 text-green-900 py-2 px-3 rounded-sm text-xs font-bold transition shadow-sm ml-1">📝 Catatan</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 text-center text-ink-500 font-heading italic">🎉 Alhamdulillah, semua guru yang memiliki jadwal hari ini sudah melakukan ceklok!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Menu Cepat (Dikembalikan) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="/tahfidz" class="bg-paper rounded-sm shadow-md p-6 hover:shadow-lg transition border-l-4 border-green-700 border border-line block">
                <div class="flex items-center">
                    <div class="bg-green-050 p-3 rounded-full mr-4 border border-green-700"><span class="text-2xl">📖</span></div>
                    <div>
                        <h4 class="font-heading font-semibold text-ink-900">Laporan Tahfidz</h4>
                        <p class="text-xs text-ink-500">Monitoring setoran hafalan siswa</p>
                    </div>
                </div>
            </a>
            <a href="#" class="bg-paper rounded-sm shadow-md p-6 hover:shadow-lg transition border-l-4 border-gold-500 border border-line block">
                <div class="flex items-center">
                    <div class="bg-paper-dim p-3 rounded-full mr-4 border border-gold-500"><span class="text-2xl">🏃</span></div>
                    <div>
                        <h4 class="font-heading font-semibold text-ink-900">Monitoring Ekstra</h4>
                        <p class="text-xs text-ink-500">Jadwal kokurikuler sore hari ini</p>
                    </div>
                </div>
            </a>
            <a href="#" class="bg-paper rounded-sm shadow-md p-6 hover:shadow-lg transition border-l-4 border-green-600 border border-line block">
                <div class="flex items-center">
                    <div class="bg-green-050 p-3 rounded-full mr-4 border border-green-600"><span class="text-2xl">📊</span></div>
                    <div>
                        <h4 class="font-heading font-semibold text-ink-900">Laporan Periodik</h4>
                        <p class="text-xs text-ink-500">Rekap mingguan & bulanan</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Footer -->
        <div class="text-center pb-8 border-t border-line pt-6">
            <p class="text-xs text-ink-500">© 2026 SMP Takhassus Al-Qur'an 2 • Yayasan Al-Asy'ariyyah • Mojotengah, Wonosobo</p>
            <p class="text-xs text-ink-500 mt-1 font-heading italic">"Mewujudkan peserta didik yang berjiwa Qur'ani, berprestasi, terampil, dan peduli."</p>
        </div>
    </div>
</body>
</html>