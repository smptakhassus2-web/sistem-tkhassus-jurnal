<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Pagi 7 KAIH - SMP Takhassus 2</title>
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
    <style>body { font-family: 'Karla', sans-serif; background-color: #faf6ec; } .font-heading { font-family: 'Fraunces', serif; }</style>
</head>
<body>
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-heading font-semibold">🌅 ABSENSI PAGI 7 KAIH</h1>
            <a href="/guru" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-4xl">
        @if(session('success'))
            <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-line font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Selamat Pagi, {{ $user->nama }}!</h2>
            <p class="text-ink-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • Hari {{ $hariIni }}</p>
        </div>

        @if(count($tasks) > 0)
            <div class="space-y-4">
                @foreach($tasks as $task)
                <div class="bg-paper rounded-sm shadow-md p-5 border border-line hover:shadow-lg transition flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="font-heading font-bold text-ink-900 text-lg">{{ $task['icon'] }} {{ $task['judul'] }}</h3>
                        <p class="text-sm text-ink-500 mt-1">{{ $task['deskripsi'] }}</p>
                    </div>
                    <a href="/absensi-pagi/form/{{ $task['tipe'] }}" class="bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 px-6 rounded-sm transition shadow-sm border border-gold-600 whitespace-nowrap">
                        📋 Mulai Absen
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-paper rounded-sm shadow-md p-8 border border-line text-center">
                <div class="text-6xl mb-4">☕</div>
                <h3 class="text-xl font-heading font-semibold text-ink-900 mb-2">Tidak Ada Tugas Pagi Hari Ini</h3>
                <p class="text-ink-500">Anda tidak bertugas sebagai Piket, Pembina BTQ, maupun Pembina Tahfidz hari {{ $hariIni }}.</p>
            </div>
        @endif
    </div>
</body>
</html>