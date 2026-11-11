<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul Tahfidz - SMP Takhassus 2</title>
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
                <div><h1 class="text-lg font-heading font-semibold">MODUL TAHFIDZ</h1><p class="text-xs text-gold-400 font-heading italic">SMP Takhassus Al-Qur'an 2</p></div>
            </div>
            <div class="flex items-center space-x-4">
                <p class="text-sm font-bold hidden md:block">{{ auth()->user()->nama }}</p>
                <form method="POST" action="/logout">@csrf<button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition">Keluar</button></form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        @if (session('success'))<div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-line font-bold">✅ {{ session('success') }}</div>@endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Input -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line h-fit">
                <h2 class="text-xl font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">📖 Input Setoran Hafalan</h2>
                <form method="POST" action="/tahfidz" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-ink-900 text-sm font-bold mb-2">Nama Siswa</label>
                        <select name="siswa_id" class="w-full px-4 py-2 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswaList as $siswa)<option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->nisn }})</option>@endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-ink-900 text-sm font-bold mb-2">Juz</label><input type="number" name="juz" min="1" max="30" class="w-full px-4 py-2 border border-line bg-white rounded-sm outline-none" required></div>
                        <div><label class="block text-ink-900 text-sm font-bold mb-2">Nama Surat</label><input type="text" name="surat" class="w-full px-4 py-2 border border-line bg-white rounded-sm outline-none" required></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-ink-900 text-sm font-bold mb-2">Ayat Awal</label><input type="number" name="ayat_awal" class="w-full px-4 py-2 border border-line bg-white rounded-sm outline-none" required></div>
                        <div><label class="block text-ink-900 text-sm font-bold mb-2">Ayat Akhir</label><input type="number" name="ayat_akhir" class="w-full px-4 py-2 border border-line bg-white rounded-sm outline-none" required></div>
                    </div>
                    <div>
                        <label class="block text-ink-900 text-sm font-bold mb-2">Nilai Hafalan</label>
                        <select name="nilai" class="w-full px-4 py-2 border border-line bg-white rounded-sm outline-none" required>
                            <option value="Lancar">🌟 Lancar</option><option value="Baik">✅ Baik</option><option value="Cukup">⚠️ Cukup</option><option value="Kurang">❌ Kurang</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 rounded-sm transition border border-gold-600">💾 Simpan Setoran</button>
                </form>
            </div>

            <!-- Riwayat -->
            <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                <h2 class="text-xl font-heading font-semibold text-ink-900 mb-4 border-b border-line pb-2">🕒 Riwayat Setoran Terbaru</h2>
                <div class="space-y-3 max-h-[600px] overflow-y-auto">
                    @forelse($riwayat as $item)
                    <div class="bg-paper-dim p-3 rounded-sm border border-line">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-ink-900">{{ $item->siswa->nama }}</p>
                                <p class="text-xs text-ink-500">Juz {{ $item->juz }} • {{ $item->surat }} : {{ $item->ayat_awal }}-{{ $item->ayat_akhir }}</p>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 rounded-sm {{ $item->nilai == 'Lancar' ? 'bg-green-050 text-green-800 border border-green-700' : ($item->nilai == 'Kurang' ? 'bg-red-50 text-red-700 border border-red-600' : 'bg-gold-500 text-green-900 border border-gold-600') }}">{{ $item->nilai }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-ink-500 italic text-center py-10">Belum ada data setoran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>