<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Jurnal & Absensi - SMP Takhassus 2</title>
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
    <style>
        body { font-family: 'Karla', sans-serif; background-color: #faf6ec; }
        .font-heading { font-family: 'Fraunces', serif; }
    </style>
</head>
<body class="pb-20">
    <nav class="bg-green-900 text-paper shadow-lg border-b-2 border-gold-500">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-heading font-semibold">📝 ISI JURNAL & ABSENSI</h1>
            <a href="/guru" class="text-sm bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm transition border border-line font-bold">← Kembali</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-4xl">
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
            <h2 class="text-xl font-heading font-semibold text-ink-900">{{ $ceklok->jadwal->mapel->nama ?? 'Mapel' }}</h2>
            <p class="text-ink-500 text-sm mt-1">Kelas: {{ $ceklok->jadwal->rombel->kode ?? '-' }} • Jam: {{ substr($ceklok->jadwal->waktu_mulai, 0, 5) }} - {{ substr($ceklok->jadwal->waktu_selesai, 0, 5) }}</p>
        </div>

        <form id="formJurnal" method="POST" action="/guru/jurnal/{{ $ceklok->id }}" enctype="multipart/form-data">
            @csrf
            
            <!-- 1. Jurnal Mengajar -->
            <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border border-line">
                <h3 class="text-lg font-heading font-semibold text-ink-900 mb-4 flex items-center"><span class="bg-green-050 text-green-800 p-2 rounded-sm mr-2 text-sm border border-green-700">📖</span> Jurnal Mengajar</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-ink-900 text-sm font-bold mb-2">Materi yang Diajarkan *</label>
                        <textarea name="materi" rows="3" class="w-full px-4 py-2 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" required placeholder="Contoh: Bab 1 - Menjelaskan konsep dasar...">{{ old('materi', $jurnal->materi ?? '') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-ink-900 text-sm font-bold mb-2">Metode Pembelajaran</label>
                            <input type="text" name="metode" class="w-full px-4 py-2 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" placeholder="Ceramah, Diskusi, dll" value="{{ old('metode', $jurnal->metode ?? '') }}">
                        </div>
                        <div>
                            <label class="block text-ink-900 text-sm font-bold mb-2">Kendala / Catatan</label>
                            <input type="text" name="kendala" class="w-full px-4 py-2 border border-line bg-white rounded-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" placeholder="Tidak ada" value="{{ old('kendala', $jurnal->kendala ?? '') }}">
                        </div>
                    </div>
                    
                    <!-- Upload Foto KBM -->
                    <div class="bg-green-050 p-4 rounded-sm border border-green-700">
                        <label class="block text-green-900 text-sm font-bold mb-2">📸 Foto KBM (Wajib)</label>
                        @if(isset($jurnal) && $jurnal->lampiran_url)
                            <p class="text-sm text-green-800 mb-2">✅ Foto sebelumnya: <a href="{{ asset('storage/' . $jurnal->lampiran_url) }}" target="_blank" class="underline font-bold">Lihat Foto</a></p>
                        @endif
                        <input type="file" name="foto" accept="image/*" capture="environment" class="w-full text-sm text-ink-700 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-bold file:bg-gold-500 file:text-green-900 hover:file:bg-gold-400">
                        <p class="text-xs text-ink-500 mt-2">💡 Tips: Kosongkan jika tidak ingin mengganti foto sebelumnya. Di HP, ini akan langsung membuka kamera.</p>
                        
                        <!-- PERBAIKAN DI SINI: Menambahkan pengecekan isset($jurnal) agar tidak error saat pertama kali buka -->
                        <div id="gps_status" class="text-xs text-ink-500 mt-1">📍 {{ (isset($jurnal) && $jurnal->lokasi_gps) ? 'Lokasi Tersimpan: ' . substr($jurnal->lokasi_gps, 0, 15) . '...' : 'Sedang mencari lokasi GPS...' }}</div>
                        <input type="hidden" name="lokasi_gps" id="lokasi_gps" value="{{ $jurnal->lokasi_gps ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- 2. Absensi Siswa -->
            <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border border-line">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-heading font-semibold text-ink-900 flex items-center"><span class="bg-green-050 text-green-800 p-2 rounded-sm mr-2 text-sm border border-green-700">👥</span> Absensi Siswa</h3>
                    <label class="flex items-center space-x-2 cursor-pointer bg-green-050 px-3 py-1 rounded-sm border border-green-700">
                        <input type="checkbox" id="check_all_hadir" class="form-checkbox h-4 w-4 text-green-700">
                        <span class="text-sm font-bold text-green-900">✅ Tandai Semua Hadir</span>
                    </label>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-green-900 text-paper uppercase">
                            <tr>
                                <th class="py-3 px-4 text-left w-10 font-heading">No</th>
                                <th class="py-3 px-4 text-left font-heading">Nama Siswa</th>
                                <th class="py-3 px-4 text-center w-32 font-heading">Status</th>
                                <th class="py-3 px-4 text-left font-heading">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_siswa">
                            @foreach($siswaList as $index => $item)
                            @php
                                $statusSiswa = $absensiData[$item->siswa->id]['status'] ?? 'H';
                                $ketSiswa = $absensiData[$item->siswa->id]['keterangan'] ?? '';
                            @endphp
                            <tr class="border-b border-line hover:bg-green-050 transition-colors" id="row-{{ $item->siswa->id }}">
                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-ink-900">{{ $item->siswa->nama }}</td>
                                <td class="py-3 px-4 text-center">
                                    <select name="absensi[{{ $item->siswa->id }}][status]" class="siswa-status w-full border border-line bg-white rounded-sm px-2 py-1 text-sm focus:ring-2 focus:ring-green-700 outline-none font-sans" onchange="updateRowColor(this)">
                                        <option value="H" {{ $statusSiswa == 'H' ? 'selected' : '' }}>Hadir (H)</option>
                                        <option value="S" {{ $statusSiswa == 'S' ? 'selected' : '' }}>Sakit (S)</option>
                                        <option value="I" {{ $statusSiswa == 'I' ? 'selected' : '' }}>Izin (I)</option>
                                        <option value="A" {{ $statusSiswa == 'A' ? 'selected' : '' }}>Alpha (A)</option>
                                    </select>
                                </td>
                                <td class="py-3 px-4">
                                    <input type="text" name="absensi[{{ $item->siswa->id }}][keterangan]" class="ket-siswa w-full border border-line bg-white rounded-sm px-2 py-1 text-sm focus:ring-2 focus:ring-green-700 outline-none font-sans {{ $statusSiswa == 'H' ? 'hidden' : '' }}" value="{{ $ketSiswa }}" placeholder="Alasan...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end space-x-3 sticky bottom-4">
                <button type="button" onclick="location.reload();" class="bg-paper-dim hover:bg-paper text-ink-700 font-bold py-3 px-6 rounded-sm transition border border-line">Reset</button>
                <button type="button" onclick="showVerificationModal()" class="bg-gold-500 hover:bg-gold-400 text-green-900 font-bold py-3 px-8 rounded-sm shadow-lg transition transform hover:-translate-y-1 border border-gold-600">
                    💾 Verifikasi & Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- MODAL VERIFIKASI -->
    <div id="modalVerifikasi" class="fixed inset-0 bg-green-900 bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-paper rounded-sm shadow-2xl w-full max-w-lg overflow-hidden border-2 border-gold-500">
            <div class="bg-gold-500 p-4 text-green-900 font-heading font-bold text-lg flex items-center justify-center border-b-2 border-gold-600">
                ⚠️ VERIFIKASI JURNAL & ABSEN
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <div class="mb-4">
                    <h4 class="font-heading font-bold text-ink-900 mb-2">📖 Jurnal:</h4>
                    <p class="text-sm text-ink-700 bg-paper-dim p-2 rounded-sm border border-line" id="v_materi">-</p>
                </div>
                <div class="mb-4">
                    <h4 class="font-heading font-bold text-ink-900 mb-2">📸 Lampiran:</h4>
                    <p class="text-sm text-ink-700" id="v_foto">Belum ada foto</p>
                </div>
                <div class="mb-4">
                    <h4 class="font-heading font-bold text-ink-900 mb-2">📍 Lokasi GPS:</h4>
                    <p class="text-sm text-ink-700" id="v_gps">Sedang memproses...</p>
                </div>
                <div class="border-t-2 border-line pt-4">
                    <h4 class="font-heading font-bold text-ink-900 mb-2">👥 Rekap Absensi:</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="bg-green-050 text-green-900 p-2 rounded-sm text-center border border-green-700 font-bold">✅ Hadir: <span id="v_hadir">0</span></div>
                        <div class="bg-paper-dim text-gold-600 p-2 rounded-sm text-center border border-gold-500 font-bold">🏥 Sakit: <span id="v_sakit">0</span></div>
                        <div class="bg-green-050 text-green-700 p-2 rounded-sm text-center border border-green-600 font-bold">📝 Izin: <span id="v_izin">0</span></div>
                        <div class="bg-red-50 text-red-700 p-2 rounded-sm text-center border border-red-600 font-bold">❌ Alpha: <span id="v_alpha">0</span></div>
                    </div>
                    <div id="v_list_tidak_hadir" class="mt-3 text-xs text-ink-700 space-y-1"></div>
                </div>
            </div>
            <div class="bg-paper-dim p-4 flex justify-end space-x-3 border-t border-line">
                <button onclick="closeVerificationModal()" class="px-4 py-2 bg-paper text-ink-700 rounded-sm hover:bg-paper-dim font-bold border border-line">❌ Batal, Periksa Lagi</button>
                <button onclick="submitFinalForm()" class="px-4 py-2 bg-gold-500 text-green-900 rounded-sm hover:bg-gold-400 font-bold shadow-md border border-gold-600">✅ Ya, Simpan Sekarang</button>
            </div>
        </div>
    </div>

    <script>
        // 1. Logic GPS Browser
        const existingGps = document.getElementById('lokasi_gps').value;
        if (!existingGps && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const gps = position.coords.latitude + ',' + position.coords.longitude;
                document.getElementById('lokasi_gps').value = gps;
                document.getElementById('gps_status').innerText = '✅ Lokasi Terkunci: ' + gps.substring(0, 15) + '...';
                document.getElementById('gps_status').classList.add('text-green-700', 'font-bold');
            }, function(error) {
                document.getElementById('gps_status').innerText = '⚠️ Gagal mengambil lokasi. Pastikan GPS aktif.';
                document.getElementById('gps_status').classList.add('text-red-600');
            });
        } else if (existingGps) {
            document.getElementById('gps_status').innerText = '✅ Lokasi Tersimpan: ' + existingGps.substring(0, 15) + '...';
            document.getElementById('gps_status').classList.add('text-green-700', 'font-bold');
        }

        // 2. Logic Bulk Absen
        document.getElementById('check_all_hadir').addEventListener('change', function() {
            const selects = document.querySelectorAll('.siswa-status');
            selects.forEach(select => {
                if (this.checked) {
                    select.value = 'H';
                    updateRowColor(select);
                }
            });
        });

        // 3. Logic Warna Baris & Keterangan
        function updateRowColor(select) {
            const row = select.closest('tr');
            const ketInput = row.querySelector('.ket-siswa');
            
            if (select.value === 'H') {
                row.className = 'border-b border-line hover:bg-green-050 transition-colors';
                ketInput.classList.add('hidden');
                ketInput.value = '';
            } else {
                ketInput.classList.remove('hidden');
                ketInput.required = true;
                if (select.value === 'S') row.className = 'border-b border-gold-500 bg-paper-dim transition-colors';
                else if (select.value === 'I') row.className = 'border-b border-green-600 bg-green-050 transition-colors';
                else if (select.value === 'A') row.className = 'border-b border-red-600 bg-red-50 transition-colors';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.siswa-status').forEach(select => {
                updateRowColor(select);
            });
        });

        // 4. Logic Popup Verifikasi
        function showVerificationModal() {
            const materi = document.querySelector('textarea[name="materi"]').value;
            if (!materi) { alert('Materi jurnal wajib diisi!'); return; }
            
            const fotoInput = document.querySelector('input[name="foto"]');
            const existingFoto = "{{ $jurnal->lampiran_url ?? '' }}";
            if (!fotoInput.files.length && !existingFoto) { 
                alert('Foto KBM wajib diupload!'); return; 
            }

            document.getElementById('v_materi').innerText = materi;
            document.getElementById('v_foto').innerText = fotoInput.files.length ? '📷 ' + fotoInput.files[0].name : '📷 Menggunakan foto sebelumnya';
            document.getElementById('v_gps').innerText = document.getElementById('lokasi_gps').value || '⚠️ Lokasi tidak terdeteksi';

            let h=0, s=0, i=0, a=0;
            let listTidakHadir = '';
            document.querySelectorAll('.siswa-status').forEach((select) => {
                const val = select.value;
                const nama = select.closest('tr').querySelector('td:nth-child(2)').innerText;
                const ket = select.closest('tr').querySelector('.ket-siswa').value;
                
                if (val === 'H') h++;
                else if (val === 'S') { s++; listTidakHadir += `<div>🏥 ${nama} - ${ket || 'Tanpa keterangan'}</div>`; }
                else if (val === 'I') { i++; listTidakHadir += `<div>📝 ${nama} - ${ket || 'Tanpa keterangan'}</div>`; }
                else if (val === 'A') { a++; listTidakHadir += `<div>❌ ${nama} - ${ket || 'Tanpa keterangan'}</div>`; }
            });

            document.getElementById('v_hadir').innerText = h;
            document.getElementById('v_sakit').innerText = s;
            document.getElementById('v_izin').innerText = i;
            document.getElementById('v_alpha').innerText = a;
            document.getElementById('v_list_tidak_hadir').innerHTML = listTidakHadir;

            document.getElementById('modalVerifikasi').classList.remove('hidden');
        }

        function closeVerificationModal() {
            document.getElementById('modalVerifikasi').classList.add('hidden');
        }

        function submitFinalForm() {
            document.getElementById('formJurnal').submit();
        }
    </script>
</body>
</html>