<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMP Takhassus Al-Qur'an 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Karla:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-900': '#0a3a20',
                        'green-800': '#0d4a29',
                        'green-700': '#106b33',
                        'green-600': '#158a3d',
                        'green-050': '#eef6ee',
                        'gold-600': '#a9791a',
                        'gold-500': '#c99a2c',
                        'gold-400': '#e3b944',
                        'paper': '#faf6ec',
                        'paper-dim': '#f2ecdc',
                        'ink-900': '#1c2117',
                        'ink-700': '#3c4536',
                        'ink-500': '#6b7362',
                        'line': '#dcd3ba',
                    },
                    fontFamily: {
                        'serif': ['Fraunces', 'Georgia', 'serif'],
                        'sans': ['Karla', 'Segoe UI', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Karla', sans-serif; }
        .font-heading { font-family: 'Fraunces', serif; }
        .pattern-stars {
            background-image: radial-gradient(circle, rgba(201, 154, 44, 0.12) 1px, transparent 1px);
            background-size: 28px 28px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-gradient-to-br from-green-900 via-green-800 to-green-700">
    
    <!-- Dekorasi Bintang -->
    <div class="absolute top-10 left-10 text-gold-400 opacity-20 text-6xl">★</div>
    <div class="absolute top-20 right-20 text-gold-400 opacity-20 text-4xl">★</div>
    <div class="absolute bottom-10 left-1/4 text-gold-400 opacity-20 text-5xl">★</div>
    <div class="absolute bottom-20 right-10 text-gold-400 opacity-20 text-3xl">★</div>
    <div class="absolute top-1/2 left-5 text-gold-400 opacity-10 text-3xl">★</div>
    <div class="absolute top-1/3 right-5 text-gold-400 opacity-10 text-4xl">★</div>
    
    <div class="bg-paper rounded-sm shadow-2xl w-full max-w-md overflow-hidden relative z-10 border border-line">
        
        <!-- Header dengan Logo -->
        <div class="bg-green-900 p-8 text-center pattern-stars relative">
            <div class="bg-paper rounded-full w-20 h-20 mx-auto mb-3 flex items-center justify-center shadow-lg ring-4 ring-gold-500/30">
                <img src="/images/logo.png" alt="Logo SMP TAQ 2" class="w-16 h-16 object-contain" 
                     onerror="this.parentElement.innerHTML='<span class=\'text-2xl font-bold text-green-900 font-heading\'>TAQ2</span>'">
            </div>
            <h1 class="text-paper text-2xl font-heading font-semibold tracking-wide">SMP Takhassus Al-Qur'an 2</h1>
            <p class="text-gold-400 text-sm font-bold mt-1 font-heading italic">Yayasan Al-Asy'ariyyah</p>
            <div class="mt-3 pt-3 border-t border-white/20">
                <p class="text-green-050 text-xs">Sistem Informasi Akademik & Kokurikuler</p>
            </div>
        </div>
        
        <!-- Form Login -->
        <div class="p-8">
            <h2 class="text-2xl font-heading font-semibold text-ink-900 mb-1">Selamat Datang</h2>
            <p class="text-ink-500 text-sm mb-6">Silakan masuk dengan akun Bapak/Ibu</p>
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-sm mb-4 text-sm">
                    <p class="font-bold">⚠️ {{ $errors->first('email') }}</p>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-ink-900 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           placeholder="contoh@email@smptaqdua.sch.id"
                           class="w-full px-4 py-3 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition font-sans" 
                           required>
                </div>
                <div>
                    <label class="block text-ink-900 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" 
                           placeholder="Masukkan password Anda"
                           class="w-full px-4 py-3 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition font-sans" 
                           required>
                </div>
                <button type="submit" 
                        class="w-full bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 px-4 rounded-sm shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 font-sans">
                    Masuk ke Sistem
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="bg-paper-dim px-8 py-4 text-center border-t border-line">
            <p class="text-xs text-ink-500">© 2026 SMP Takhassus Al-Qur'an 2</p>
            <p class="text-xs text-ink-500 mt-1">Mojotengah, Wonosobo</p>
        </div>
    </div>
</body>
</html>