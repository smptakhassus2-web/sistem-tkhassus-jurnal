<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurnal & Absensi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33',
                        'gold-500': '#c99a2c', 'gold-400': '#e3b944',
                        'paper': '#faf6ec', 'paper-dim': '#f2ecdc',
                        'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362',
                        'line': '#dcd3ba',
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
            <h1 class="text-lg font-heading font-semibold">🔍 DETAIL MONITORING GURU</h1>
            <a href="/dashboard" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        @if (session('success'))
            <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-line font-bold">✅ {{ session('success') }}</div>
        @endif

        <!-- Info Guru -->
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-2xl font-heading font-semibold text-ink-900">{{ $ceklok->guru->nama }}</h2>
            <p class="text-ink-500 text-sm mt-1">Mapel: {{ $ceklok->jadwal->mapel->nama }} • Kelas: {{ $ceklok->jadwal->rombel->kode }} • Jam: {{ substr($ceklok->jadwal->waktu_mulai, 0, 5) }}</p>
            <p class="text-ink-500 text-sm">Tanggal: {{ \Carbon\Carbon::parse($ceklok->tanggal)->isoFormat('dddd, D MMMM YYYY') }} • Status: <span class="font-bold {{ $ceklok->status == 'hadir' ? 'text-green-700' : 'text-gold-600' }}">{{ ucfirst($ceklok->status) }}</span></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Foto KBM -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4">📸 Foto KBM</h3>
                @if($ceklok->jurnal && $ceklok->jurnal->lampiran_url)
                    <img src="{{ asset('storage/' . $ceklok->jurnal->lampiran_url) }}" class="w-full h-64 object-cover rounded-sm border border-line">
                @else
                    <p class="text-ink-500 italic text-center py-10">Belum ada foto diupload.</p>
                @endif
            </div>

            <!-- Peta GPS -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4">📍 Lokasi GPS</h3>
                @if($ceklok->jurnal && $ceklok->jurnal->lokasi_gps)
                    @php $coords = explode(',', $ceklok->jurnal->lokasi_gps); $lat = $coords[0]; $lng = $coords[1]; @endphp
                    <iframe width="100%" height="250" frameborder="0" scrolling="no" class="rounded-sm border border-line" src="https://www.openstreetmap.org/export/embed.html?bbox={{ $lng-0.005 }},{{ $lat-0.005 }},{{ $lng+0.005 }},{{ $lat+0.005 }}&layer=mapnik&marker={{ $lat }},{{ $lng }}"></iframe>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}" target="_blank" class="block text-center mt-3 text-sm text-green-700 font-bold hover:underline">🗺️ Buka di Google Maps</a>
                @else
                    <p class="text-ink-500 italic text-center py-10">Lokasi GPS tidak tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Jurnal & Catatan Admin -->
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border border-line">
            <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4">📖 Jurnal Mengajar</h3>
            <div class="space-y-2 text-ink-700">
                <p><span class="font-bold text-ink-900">Materi:</span> {{ $ceklok->jurnal->materi ?? '-' }}</p>
                <p><span class="font-bold text-ink-900">Metode:</span> {{ $ceklok->jurnal->metode ?? '-' }}</p>
                <p><span class="font-bold text-ink-900">Kendala:</span> {{ $ceklok->jurnal->kendala ?? '-' }}</p>
            </div>

            <form method="POST" action="/admin/catatan/{{ $ceklok->id }}" class="mt-6 pt-6 border-t border-line">
                @csrf
                <h4 class="font-heading font-semibold text-ink-900 mb-2">📝 Catatan Teguran / Pembinaan Admin:</h4>
                <textarea name="catatan" rows="3" class="w-full px-4 py-2 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" placeholder="Tulis catatan untuk guru ini...">{{ $ceklok->catatan_admin }}</textarea>
                <button type="submit" class="mt-3 bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-2 px-6 rounded-sm transition border border-gold-600">💾 Simpan Catatan</button>
            </form>
        </div>

        <!-- Rekap Absensi -->
        <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
            <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4">👥 Rekap Absensi Siswa</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-green-900 text-paper uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left font-heading">Nama Siswa</th>
                            <th class="py-3 px-4 text-center font-heading">Status</th>
                            <th class="py-3 px-4 text-left font-heading">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ceklok->absensi as $abs)
                        <tr class="border-b border-line hover:bg-green-050">
                            <td class="py-3 px-4 font-bold text-ink-900">{{ $abs->siswa->nama }}</td>
                            <td class="py-3 px-4 text-center font-bold {{ $abs->status == 'H' ? 'text-green-700' : ($abs->status == 'A' ? 'text-red-600' : 'text-gold-600') }}">{{ $abs->status }}</td>
                            <td class="py-3 px-4 text-ink-700">{{ $abs->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>