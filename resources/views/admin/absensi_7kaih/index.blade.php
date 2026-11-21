@extends('layouts.admin')

@section('title', 'Rekap Absensi 7 KAIH - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
        <h2 class="text-2xl font-heading font-semibold text-ink-900">📋 Rekap Absensi 7 KAIH</h2>
        <p class="text-ink-500 text-sm mt-1">Monitoring kehadiran siswa pada kegiatan 7 Pilar Karakter (Upacara, Sholat Dhuha, Senam, Ziarah BTQ, Dzuhur, Refleksi).</p>
    </div>

    {{-- KARTU RINGKASAN STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-green-700 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Hadir</p>
            <p class="text-3xl font-heading font-semibold text-green-700 mt-1">{{ $totalHadir }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-yellow-500 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Sakit</p>
            <p class="text-3xl font-heading font-semibold text-yellow-600 mt-1">{{ $totalSakit }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-blue-500 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Izin</p>
            <p class="text-3xl font-heading font-semibold text-blue-600 mt-1">{{ $totalIzin }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-red-600 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Alpha</p>
            <p class="text-3xl font-heading font-semibold text-red-600 mt-1">{{ $totalAlpha }}</p>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="bg-paper rounded-sm shadow-md p-5 mb-6 border border-line">
        <form method="GET" action="{{ route('admin.absensi_7kaih.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-ink-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $filterTanggal }}"
                       class="px-3 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-ink-700 mb-1">Kelas</label>
                <select name="rombel_id" class="px-3 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}" {{ $filterRombel == $rombel->id ? 'selected' : '' }}>
                            {{ $rombel->kode }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition">🔍 Tampilkan</button>
                <a href="{{ route('admin.absensi_7kaih.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">↺ Reset</a>
                {{-- 🔴 BARU: Tombol Cetak Laporan --}}
                <button type="button" onclick="cetakLaporan()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">🖨️ Cetak Laporan</button>
            </div>
        </form>
    </div>

    {{-- INFO JUMLAH DATA --}}
    <div class="flex justify-between items-center mb-3 px-1">
        <p class="text-sm text-ink-700">
            Menampilkan <strong>{{ $absensis->count() }}</strong> data detail untuk tanggal <strong>{{ \Carbon\Carbon::parse($filterTanggal)->isoFormat('dddd, D MMMM Y') }}</strong>
            @if($filterRombel)
                • Kelas <strong>{{ optional($absensis->first()->rombel)->kode ?? 'terpilih' }}</strong>
            @endif
        </p>
    </div>

    {{-- TABEL REKAP --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Kegiatan</th>
                        <th class="p-4 font-heading font-semibold">Kelas</th>
                        <th class="p-4 font-heading font-semibold">Nama Siswa</th>
                        <th class="p-4 font-heading font-semibold">Status</th>
                        <th class="p-4 font-heading font-semibold">Input Oleh</th>
                        <th class="p-4 font-heading font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($absensis as $absensi)
                        <tr class="hover:bg-green-050 transition">
                            <td class="p-4 text-sm font-medium text-ink-900">
                                {{ str_replace('_', ' ', $absensi->jenis_kegiatan) }}
                            </td>
                            <td class="p-4 text-sm">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-sm text-xs font-bold">
                                    {{ $absensi->rombel->kode ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-bold text-ink-900">
                                {{ $absensi->siswa->nama ?? '-' }}
                            </td>
                            <td class="p-4 text-sm">
                                @php
                                    $statusMap = [
                                        'Hadir'  => 'bg-green-100 text-green-800 border-green-700',
                                        'Sakit'  => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                        'Izin'   => 'bg-blue-100 text-blue-800 border-blue-600',
                                        'Alpha'  => 'bg-red-100 text-red-800 border-red-600',
                                    ];
                                    $kelasWarna = $statusMap[$absensi->status] ?? 'bg-gray-100 text-gray-800 border-gray-400';
                                @endphp
                                <span class="{{ $kelasWarna }} px-2 py-1 rounded-sm text-xs font-bold border">
                                    {{ $absensi->status }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-ink-700">
                                {{ $absensi->inputOleh->nama ?? '-' }}
                            </td>
                            <td class="p-4 text-sm text-ink-500 italic">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-ink-500">
                                Tidak ada data absensi untuk tanggal/kelas yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 🔴 BARU: Script untuk Tombol Cetak --}}
    <script>
    function cetakLaporan() {
        const tanggal = document.querySelector('input[name="tanggal"]').value;
        const rombel = document.querySelector('select[name="rombel_id"]').value;
        let url = "{{ route('admin.absensi_7kaih.cetak') }}?tanggal=" + tanggal;
        if(rombel) url += "&rombel_id=" + rombel;
        window.open(url, '_blank');
    }
    </script>
@endsection