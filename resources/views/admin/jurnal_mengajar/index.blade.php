@extends('layouts.admin')

@section('title', 'Rekap Jurnal Mengajar - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
        <h2 class="text-2xl font-heading font-semibold text-ink-900">📝 Rekap Jurnal Mengajar</h2>
        <p class="text-ink-500 text-sm mt-1">Monitoring jurnal yang diisi guru setelah mengajar (materi, metode, kehadiran, kendala).</p>
    </div>

    {{-- KARTU RINGKASAN STATISTIK --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-green-700 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Jurnal Terisi</p>
            <p class="text-3xl font-heading font-semibold text-green-700 mt-1">{{ $totalJurnal }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-gold-500 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Guru Mengajar</p>
            <p class="text-3xl font-heading font-semibold text-gold-600 mt-1">{{ $totalGuruMengajar }}</p>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="bg-paper rounded-sm shadow-md p-5 mb-6 border border-line">
        <form method="GET" action="{{ route('admin.jurnal_mengajar.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-ink-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $filterTanggal }}"
                       class="px-3 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition">🔍 Tampilkan</button>
                <a href="{{ route('admin.jurnal_mengajar.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">↺ Reset</a>
                
                {{-- Tombol Cetak --}}
                <button type="button" onclick="cetakLaporan()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">🖨️ Cetak Laporan</button>
            </div>
        </form>
    </div>

    {{-- INFO JUMLAH DATA --}}
    <div class="flex justify-between items-center mb-3 px-1">
        <p class="text-sm text-ink-700">
            Menampilkan <strong>{{ $jurnals->count() }}</strong> jurnal untuk tanggal <strong>{{ \Carbon\Carbon::parse($filterTanggal)->isoFormat('dddd, D MMMM Y') }}</strong>
        </p>
    </div>

    {{-- TABEL REKAP --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Waktu</th>
                        <th class="p-4 font-heading font-semibold">Guru</th>
                        <th class="p-4 font-heading font-semibold">Mapel</th>
                        <th class="p-4 font-heading font-semibold">Kelas</th>
                        <th class="p-4 font-heading font-semibold">Materi</th>
                        <th class="p-4 font-heading font-semibold">Metode</th>
                        <th class="p-4 font-heading font-semibold">Kehadiran</th>
                        <th class="p-4 font-heading font-semibold">Kendala</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($jurnals as $jurnal)
                        <tr class="hover:bg-green-050 transition">
                            {{-- Waktu Ceklok --}}
                            <td class="p-4 text-sm text-ink-700">
                                {{ $jurnal->ceklok->waktu_mulai ? \Carbon\Carbon::parse($jurnal->ceklok->waktu_mulai)->format('H:i') : '-' }}
                            </td>

                            {{-- Nama Guru (null-safe) --}}
                            <td class="p-4 text-sm font-bold text-ink-900">
                                {{ $jurnal->ceklok->guru->nama ?? '-' }}
                            </td>

                            {{-- Mapel (null-safe, bertingkat) --}}
                            <td class="p-4 text-sm text-ink-700">
                                {{ $jurnal->ceklok->jadwal->mapel->nama ?? '-' }}
                            </td>

                            {{-- Kelas (null-safe, bertingkat) --}}
                            <td class="p-4 text-sm">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-sm text-xs font-bold">
                                    {{ $jurnal->ceklok->jadwal->rombel->kode ?? '-' }}
                                </span>
                            </td>

                            {{-- Materi --}}
                            <td class="p-4 text-sm text-ink-700 max-w-xs">
                                {{ Str::limit($jurnal->materi, 50) }}
                            </td>

                            {{-- Metode --}}
                            <td class="p-4 text-sm text-ink-500 italic">
                                {{ $jurnal->metode ?? '-' }}
                            </td>

                            {{-- 🔴 KOLOM KEHADIRAN SISWA (BARU) --}}
                            <td class="p-4 text-sm text-ink-700 max-w-xs">
                                @php
                                    $absensi = $jurnal->ceklok->absensiSiswa ?? collect();
                                    $h = $absensi->where('status', 'H')->count();
                                    $s = $absensi->where('status', 'S')->count();
                                    $i = $absensi->where('status', 'I')->count();
                                    $a = $absensi->where('status', 'A')->count();
                                    
                                    $sakitNames = $absensi->where('status', 'S')->pluck('siswa.nama')->filter()->implode(', ');
                                    $izinNames = $absensi->where('status', 'I')->pluck('siswa.nama')->filter()->implode(', ');
                                    $alphaNames = $absensi->where('status', 'A')->pluck('siswa.nama')->filter()->implode(', ');
                                @endphp
                                
                                <div class="text-xs font-bold mb-1 text-ink-900">
                                    H: {{ $h }} | S: {{ $s }} | I: {{ $i }} | A: {{ $a }}
                                </div>
                                
                                @if($s > 0 || $i > 0 || $a > 0)
                                    <div class="text-xs text-ink-500 italic leading-tight space-y-1">
                                        @if($s > 0) <div>• Sakit: {{ $sakitNames }}</div> @endif
                                        @if($i > 0) <div>• Izin: {{ $izinNames }}</div> @endif
                                        @if($a > 0) <div>• Alpha: {{ $alphaNames }}</div> @endif
                                    </div>
                                @else
                                    <span class="text-xs text-green-600 font-medium">Semua hadir</span>
                                @endif
                            </td>

                            {{-- Kendala --}}
                            <td class="p-4 text-sm text-ink-500 italic">
                                {{ $jurnal->kendala ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-ink-500">
                                Tidak ada jurnal mengajar untuk tanggal yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script untuk Tombol Cetak --}}
    <script>
    function cetakLaporan() {
        const tanggal = document.querySelector('input[name="tanggal"]').value;
        let url = "{{ route('admin.jurnal_mengajar.cetak') }}?tanggal=" + tanggal;
        window.open(url, '_blank');
    }
    </script>
@endsection