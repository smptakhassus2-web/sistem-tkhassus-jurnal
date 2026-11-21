<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penilaian BTQ - SMP Takhassus 2</title>
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
                <img src="/images/logo.png" alt="Logo" class="w-10 h-10 object-contain bg-paper rounded-full p-1">
                <div>
                    <h1 class="text-lg font-heading font-semibold">REKAP PENILAIAN BTQ</h1>
                    <p class="text-xs text-gold-400 font-heading italic">Monitoring & Evaluasi Program BTQ</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-gold-400">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                </div>
                <!-- PERBAIKAN: Tombol Kembali Dinamis -->
                <a href="{{ url()->previous() }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-sm text-sm font-bold transition border border-green-600">&larr; Kembali</a>
                <form method="POST" action="/logout">@csrf<button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button></form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-7xl">
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Daftar Penilaian BTQ Seluruh Siswa</h2>
                <p class="text-ink-500 text-sm mt-1">Data real-time dari seluruh pembina BTQ. Total: {{ $penilaians->count() }} catatan.</p>
            </div>
            <a href="/admin/btq/cetak" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-sm text-sm font-bold transition shadow-sm flex items-center gap-2">
                🖨️ Cetak Laporan
            </a>
        </div>

        <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-paper-dim text-ink-900 uppercase text-xs font-bold border-b-2 border-gold-500">
                        <tr>
                            <th class="px-4 py-3 w-10">No</th>
                            <th class="px-4 py-3 w-24">Tanggal</th>
                            <th class="px-4 py-3 w-40">Nama Siswa</th>
                            <th class="px-4 py-3 w-32">Kelompok</th>
                            <th class="px-4 py-3 w-32">Pembina</th>
                            <th class="px-4 py-3">Materi (Jilid/Hal atau Juz/Surat)</th>
                            <th class="px-4 py-3 w-24 text-center">Nilai</th>
                            <th class="px-4 py-3">Catatan Pembina</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse($penilaians as $index => $item)
                        <tr class="hover:bg-paper-dim transition">
                            <td class="px-4 py-3 text-ink-500 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-ink-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}</td>
                            <td class="px-4 py-3 font-bold text-ink-900">{{ $item->siswa->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-ink-700">{{ $item->kelompok->nama_kelompok ?? '-' }}</td>
                            <td class="px-4 py-3 text-ink-700">{{ $item->pembina->nama ?? '-' }}</td>
                            
                            <!-- PERBAIKAN: Tampilan Materi yang Sangat Eksplisit -->
                            <td class="px-4 py-3 text-ink-700">
                                @if($item->jilid)
                                    <div class="text-xs font-bold text-blue-800">📘 {{ $item->jilid }}</div>
                                    <div class="text-xs text-blue-600">Halaman: {{ $item->halaman ?? '-' }}</div>
                                @elseif($item->juz)
                                    <div class="text-xs font-bold text-green-800">📗 Juz {{ $item->juz }}</div>
                                    <div class="text-xs text-green-600">{{ $item->surat ?? '-' }} (Ayat {{ $item->ayat_awal ?? '-' }} s/d {{ $item->ayat_akhir ?? '-' }})</div>
                                @else
                                    <span class="text-xs text-ink-500 italic">Tidak ada detail materi</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span class="text-xs font-bold px-2 py-1 rounded-sm {{ $item->nilai == 'Lancar' ? 'bg-green-050 text-green-800 border border-green-700' : ($item->nilai == 'Kurang' ? 'bg-red-50 text-red-700 border border-red-600' : 'bg-gold-500 text-green-900 border border-gold-600') }}">
                                    {{ $item->nilai }}
                                </span>
                            </td>
                            
                            <!-- Kolom Catatan -->
                            <td class="px-4 py-3 text-ink-700 italic text-xs max-w-xs">
                                {{ $item->catatan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-ink-500 italic">Belum ada data penilaian BTQ yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>