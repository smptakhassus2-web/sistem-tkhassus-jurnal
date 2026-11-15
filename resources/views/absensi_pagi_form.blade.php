<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi {{ $jenisKegiatan }} - SMP Takhassus 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                'green-900': '#0a3a20', 'green-800': '#0d4a29', 'green-700': '#106b33', 'green-050': '#eef6ee',
                'gold-500': '#c99a2c', 'gold-400': '#e3b944',
                'paper': '#faf6ec', 'paper-dim': '#f2ecdc',
                'ink-900': '#1c2117', 'ink-700': '#3c4536', 'ink-500': '#6b7362', 'line': '#dcd3ba',
            }, fontFamily: { 'serif': ['Fraunces', 'serif'], 'sans': ['Karla', 'sans-serif'] } } }
        }
    </script>
    <style>
        body { font-family: 'Karla', sans-serif; background-color: #faf6ec; }
        .font-heading { font-family: 'Fraunces', serif; }
    </style>
</head>
<body>
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-heading font-semibold">🌅 ABSENSI {{ strtoupper($jenisKegiatan) }}</h1>
            <a href="/absensi-pagi" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        @if(session('success'))
            <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-line font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($inputOleh)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-5 mb-6 rounded-sm shadow border border-yellow-200">
            <div class="flex items-start space-x-3">
                <div class="text-3xl">⚠️</div>
                <div>
                    <h3 class="font-heading font-bold text-yellow-900 text-lg">Absensi {{ $jenisKegiatan }} Sudah Diisi!</h3>
                    <p class="text-sm text-yellow-800 mt-1">
                        Data terakhir disimpan oleh <strong>{{ $inputOleh }}</strong> pada pukul <strong>{{ $waktuInput }}</strong>.
                    </p>
                    <p class="text-sm text-yellow-800 mt-2 italic">
                        💡 Menyimpan ulang akan <strong>menimpa data sebelumnya</strong>. Pastikan koordinasi dengan guru lain sebelum menyimpan.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-paper rounded-sm shadow-md p-5 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-xl font-heading font-semibold text-ink-900">📋 {{ $jenisKegiatan }} - {{ $hariIni }}</h2>
            <p class="text-ink-500 text-sm mt-1">
                {{ \Carbon\Carbon::parse($tanggalHariIni)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} 
                • Petugas: <strong>{{ $user->nama }}</strong>
                • Total Siswa: <strong>{{ $siswaList->count() }}</strong>
            </p>
        </div>

        <form method="POST" action="/absensi-pagi/simpan" id="formAbsensi">
            @csrf
            <input type="hidden" name="tipe" value="{{ $tipe }}">
            <input type="hidden" name="tanggal" value="{{ $tanggalHariIni }}">

            <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
                <div class="bg-paper-dim px-6 py-3 border-b border-line flex justify-between items-center">
                    <span class="font-bold text-ink-900">Nama Siswa</span>
                    <div class="flex space-x-4 text-xs font-bold">
                        <span class="text-green-700">✅ H</span>
                        <span class="text-yellow-600">🤒 S</span>
                        <span class="text-blue-600">📝 I</span>
                        <span class="text-red-600">❌ A</span>
                    </div>
                </div>

                <div class="divide-y divide-line">
                    @forelse($siswaList as $index => $siswa)
                    @php
                        $statusTersimpan = $absensiTersimpan[$siswa->id] ?? 'Hadir';
                        $rombel = $siswa->rombels->first();
                    @endphp
                    <div class="px-6 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2 hover:bg-paper-dim transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-xs text-ink-500 w-6 font-bold">{{ $index + 1 }}</span>
                            <div>
                                <p class="font-bold text-ink-900 text-sm">{{ $siswa->nama }}</p>
                                <p class="text-xs text-ink-500">{{ $rombel ? $rombel->kode : '-' }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <label class="flex items-center space-x-1 cursor-pointer" title="Hadir">
                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Hadir" class="w-4 h-4" {{ $statusTersimpan === 'Hadir' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-green-700">H</span>
                            </label>
                            <label class="flex items-center space-x-1 cursor-pointer" title="Sakit">
                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Sakit" class="w-4 h-4" {{ $statusTersimpan === 'Sakit' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-yellow-600">S</span>
                            </label>
                            <label class="flex items-center space-x-1 cursor-pointer" title="Izin">
                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Izin" class="w-4 h-4" {{ $statusTersimpan === 'Izin' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-blue-600">I</span>
                            </label>
                            <label class="flex items-center space-x-1 cursor-pointer" title="Alpha">
                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Alpha" class="w-4 h-4" {{ $statusTersimpan === 'Alpha' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-red-600">A</span>
                            </label>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-ink-500">Tidak ada data siswa untuk diabsen.</div>
                    @endforelse
                </div>

                <div class="bg-paper-dim px-6 py-4 border-t border-line flex justify-between items-center sticky bottom-0">
                    <div class="text-sm text-ink-500">
                        <strong id="counter">0</strong> siswa ditandai sebagai Alpha/Sakit/Izin
                    </div>
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-8 rounded-sm transition shadow-md">
                        💾 SIMPAN ABSENSI
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const radios = document.querySelectorAll('input[type="radio"]');
        const counter = document.getElementById('counter');
        function updateCounter() {
            let count = 0;
            document.querySelectorAll('input[type="radio"]:checked').forEach(r => {
                if(r.value !== 'Hadir') count++;
            });
            counter.textContent = count;
        }
        radios.forEach(r => r.addEventListener('change', updateCounter));
        updateCounter();
    </script>
</body>
</html>