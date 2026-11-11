<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Pagi - SMP Takhassus 2</title>
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
            <h1 class="text-lg font-heading font-semibold">🌅 ABSENSI PAGI (JAM 0)</h1>
            <a href="/guru" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-4xl">
        @if(session('success'))
            <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-line font-bold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Selamat Pagi, {{ $user->nama }}!</h2>
            <p class="text-ink-500 text-sm mt-1">Silakan pilih tugas absensi yang tersedia untuk Anda hari ini.</p>
        </div>

        @forelse($tasks as $task)
        <a href="/absensi-pagi/form/{{ $task['tipe'] }}" class="bg-paper rounded-sm shadow-md p-6 mb-4 border border-line hover:shadow-lg transition transform hover:-translate-y-1 block">
            <div class="flex items-center space-x-4">
                <div class="bg-green-050 text-4xl p-3 rounded-full border border-green-700">{{ $task['icon'] }}</div>
                <div>
                    <h3 class="text-lg font-heading font-semibold text-ink-900">{{ $task['judul'] }}</h3>
                    <p class="text-sm text-ink-500 mt-1">{{ $task['deskripsi'] }}</p>
                    <span class="inline-block mt-3 text-xs font-bold text-green-800 bg-green-050 px-2 py-1 rounded-sm border border-green-700">Mulai Absensi →</span>
                </div>
            </div>
        </a>
        @empty
        <div class="bg-paper-dim p-8 text-center rounded-sm border border-line">
            <p class="text-ink-500 font-heading italic">Anda tidak memiliki tugas absensi pagi hari ini.</p>
        </div>
        @endforelse
    </div>
</body>
</html>