<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Wali Murid - SMP Takhassus Al-Qur'an 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33',
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
    <!-- Navbar -->
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="/images/logo.png" alt="Logo" class="w-10 h-10 object-contain bg-paper rounded-full p-1" onerror="this.style.display='none'">
                <div>
                    <h1 class="text-lg font-heading font-semibold">PORTAL WALI MURID</h1>
                    <p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <p class="text-sm font-bold hidden md:block">Wali dari: {{ $anak->nama }}</p>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mx-auto p-6 max-w-5xl">
        
        <!-- Profil Anak -->
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex items-center space-x-6">
            <div class="bg-green-050 w-20 h-20 rounded-full flex items-center justify-center text-3xl border border-green-700 flex-shrink-0">👤</div>
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">{{ $anak->nama }}</h2>
                <p class="text-ink-500 text-sm">NISN: {{ $anak->nisn }} • NIPD: {{ $anak->nipd }} • Kelas: {{ $anak->rombels->first()->kode ?? 'Belum ada kelas' }}</p>
                <p class="text-ink-500 text-xs mt-1">📍 {{ $anak->dusun }}, {{ $anak->kelurahan }}, {{ $anak->kecamatan }}, {{ $anak->kabupaten }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Rekap Absensi -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">📊 Rekap Absensi Bulan Ini</h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-green-050 p-4 rounded-sm border border-green-700">
                        <p class="text-3xl font-heading font-bold text-green-800">{{ $absensiBulanIni['H'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-green-900">HADIR</p>
                    </div>
                    <div class="bg-paper-dim p-4 rounded-sm border border-gold-500">
                        <p class="text-3xl font-heading font-bold text-gold-600">{{ $absensiBulanIni['S'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-ink-700">SAKIT</p>
                    </div>
                    <div class="bg-green-050 p-4 rounded-sm border border-green-600">
                        <p class="text-3xl font-heading font-bold text-green-700">{{ $absensiBulanIni['I'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-green-900">IZIN</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-sm border border-red-600">
                        <p class="text-3xl font-heading font-bold text-red-600">{{ $absensiBulanIni['A'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-red-800">ALPHA</p>
                    </div>
                </div>
            </div>

            <!-- Progres Tahfidz -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">📖 Progres Tahfidz Terbaru</h3>
                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                    @forelse($tahfidzTerbaru as $item)
                    <div class="bg-paper-dim p-3 rounded-sm border border-line flex justify-between items-center">
                        <div>
                            <p class="font-bold text-ink-900 text-sm">Juz {{ $item->juz }} • {{ $item->surat }}</p>
                            <p class="text-xs text-ink-500">Ayat {{ $item->ayat_awal }} - {{ $item->ayat_akhir }} • Oleh: {{ $item->guru->nama ?? 'Guru' }}</p>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-sm {{ $item->nilai == 'Lancar' ? 'bg-green-050 text-green-800 border border-green-700' : 'bg-gold-500 text-green-900 border border-gold-600' }}">
                            {{ $item->nilai }}
                        </span>
                    </div>
                    @empty
                    <p class="text-ink-500 italic text-center py-4">Belum ada data setoran hafalan.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-8 text-center pb-8 border-t border-line pt-6">
            <p class="text-xs text-ink-500">© 2026 SMP Takhassus Al-Qur'an 2 • Yayasan Al-Asy'ariyyah • Mojotengah, Wonosobo</p>
        </div>
    </div>
</body>
</html>