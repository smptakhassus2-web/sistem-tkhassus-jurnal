<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi Pagi - SMP Takhassus 2</title>
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
            <h1 class="text-lg font-heading font-semibold">📝 FORM ABSENSI PAGI</h1>
            <a href="/absensi-pagi" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-5xl">
        <form method="POST" action="/absensi-pagi/simpan">
            @csrf
            <input type="hidden" name="tipe" value="{{ $tipe }}">
            <input type="hidden" name="tanggal" value="{{ $tanggalHariIni }}">

            <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
                <h2 class="text-xl font-heading font-semibold text-ink-900">
                    @if($tipe == 'piket') Absensi Kegiatan Pagi (Reguler)
                    @elseif($tipe == 'tahfidz') Absensi Program Tahfidz
                    @else Absensi {{ $kelompok->nama_kelompok ?? 'BTQ' }}
                    @endif
                </h2>
                <p class="text-ink-500 text-sm mt-1">Tanggal: {{ \Carbon\Carbon::parse($tanggalHariIni)->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>

            @if($tipe == 'piket')
                @foreach($dataKelas as $kodeKelas => $siswaKelas)
                <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border border-line">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-heading font-bold text-ink-900">Kelas {{ $kodeKelas }}</h3>
                        <label class="flex items-center space-x-2 cursor-pointer bg-green-050 px-3 py-1 rounded-sm border border-green-700">
                            <input type="checkbox" class="check-all-kelas form-checkbox h-4 w-4 text-green-700" data-kelas="{{ $kodeKelas }}">
                            <span class="text-sm font-bold text-green-900">✅ Tandai Semua Hadir</span>
                        </label>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-green-900 text-paper uppercase">
                                <tr>
                                    <th class="py-2 px-4 text-left font-heading">Nama</th>
                                    <th class="py-2 px-4 text-center w-32 font-heading">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswaKelas as $item)
                                <tr class="border-b border-line hover:bg-green-050">
                                    <td class="py-2 px-4 font-medium text-ink-900">{{ $item->siswa->nama }}</td>
                                    <td class="py-2 px-4 text-center">
                                        <select name="absensi[{{ $item->siswa->id }}]" class="status-select-{{ $kodeKelas }} w-full border border-line bg-white rounded-sm px-2 py-1 text-sm outline-none">
                                            <option value="Hadir" selected>Hadir</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Alpha">Alpha</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            @else
                <div class="bg-paper rounded-sm shadow-md p-6 border border-line">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-heading font-bold text-ink-900">Daftar Peserta</h3>
                        <label class="flex items-center space-x-2 cursor-pointer bg-green-050 px-3 py-1 rounded-sm border border-green-700">
                            <input type="checkbox" id="check-all" class="form-checkbox h-4 w-4 text-green-700">
                            <span class="text-sm font-bold text-green-900">✅ Tandai Semua Hadir</span>
                        </label>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-green-900 text-paper uppercase">
                                <tr>
                                    <th class="py-2 px-4 text-left font-heading">Nama</th>
                                    <th class="py-2 px-4 text-center w-32 font-heading">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta as $item)
                                <tr class="border-b border-line hover:bg-green-050">
                                    <td class="py-2 px-4 font-medium text-ink-900">{{ $item->siswa->nama }} <span class="text-xs text-ink-500">({{ $item->siswa->rombels->first()->kode ?? '-' }})</span></td>
                                    <td class="py-2 px-4 text-center">
                                        <select name="absensi[{{ $item->siswa->id }}]" class="status-select w-full border border-line bg-white rounded-sm px-2 py-1 text-sm outline-none">
                                            <option value="Hadir" selected>Hadir</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Alpha">Alpha</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="flex justify-end sticky bottom-4 mt-6">
                <button type="submit" class="bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 px-8 rounded-sm shadow-lg transition transform hover:-translate-y-1 border border-gold-600">
                    💾 Simpan Absensi Pagi
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('check-all')?.addEventListener('change', function() {
            document.querySelectorAll('.status-select').forEach(s => s.value = this.checked ? 'Hadir' : 'Hadir');
        });

        document.querySelectorAll('.check-all-kelas').forEach(cb => {
            cb.addEventListener('change', function() {
                const kelas = this.dataset.kelas;
                document.querySelectorAll('.status-select-' + kelas).forEach(s => s.value = this.checked ? 'Hadir' : 'Hadir');
            });
        });
    </script>
</body>
</html>