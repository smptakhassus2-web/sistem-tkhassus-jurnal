@extends('layouts.admin')

@section('title', 'Jurnal BTQ - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
        <h2 class="text-2xl font-heading font-semibold text-ink-900">📗 Jurnal BTQ</h2>
        <p class="text-ink-500 text-sm mt-1">Monitoring penilaian bacaan Iqro' dan Al-Qur'an seluruh siswa.</p>
    </div>

    {{-- STATISTIK SINGKAT --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-green-700 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Catatan Penilaian</p>
            <p class="text-3xl font-heading font-semibold text-green-700 mt-1">{{ $penilaians->count() }}</p>
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.btq.cetak') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm flex items-center gap-2">
            🖨️ Cetak Laporan
        </a>
    </div>

    {{-- TABEL REKAP --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Tanggal</th>
                        <th class="p-4 font-heading font-semibold">Nama Siswa</th>
                        <th class="p-4 font-heading font-semibold">Kelompok</th>
                        <th class="p-4 font-heading font-semibold">Pembina</th>
                        <th class="p-4 font-heading font-semibold">Materi</th>
                        <th class="p-4 font-heading font-semibold">Nilai</th>
                        <th class="p-4 font-heading font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($penilaians as $item)
                        <tr class="hover:bg-green-050 transition">
                            <td class="p-4 text-sm text-ink-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}
                            </td>
                            
                            {{-- Nullsafe operator (?->) agar tidak error jika data relasi dihapus --}}
                            <td class="p-4 text-sm font-bold text-ink-900">
                                {{ $item->siswa?->nama ?? 'Siswa Dihapus' }}
                            </td>
                            <td class="p-4 text-sm text-ink-700">
                                {{ $item->kelompok?->nama_kelompok ?? '-' }}
                            </td>
                            <td class="p-4 text-sm text-ink-700">
                                {{ $item->pembina?->nama ?? '-' }}
                            </td>
                            
                            <td class="p-4 text-sm text-ink-700">
                                @if($item->jilid)
                                    <div class="text-xs font-bold text-blue-800">📘 {{ $item->jilid }}</div>
                                    <div class="text-xs text-blue-600">Hal: {{ $item->halaman ?? '-' }}</div>
                                @elseif($item->juz)
                                    <div class="text-xs font-bold text-green-800">📗 Juz {{ $item->juz }}</div>
                                    <div class="text-xs text-green-600">{{ $item->surat ?? '-' }} ({{ $item->ayat_awal ?? '-' }}-{{ $item->ayat_akhir ?? '-' }})</div>
                                @else
                                    <span class="text-xs text-ink-500 italic">-</span>
                                @endif
                            </td>

                            <td class="p-4 text-sm">
                                <span class="text-xs font-bold px-2 py-1 rounded-sm border {{ $item->nilai == 'Lancar' ? 'bg-green-050 text-green-800 border-green-700' : ($item->nilai == 'Kurang' ? 'bg-red-50 text-red-700 border-red-600' : 'bg-gold-500 text-green-900 border-gold-600') }}">
                                    {{ $item->nilai ?? '-' }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-sm text-ink-500 italic max-w-xs">
                                {{ Str::limit($item->catatan, 40) ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-ink-500 italic">
                                Belum ada data penilaian BTQ yang diinput.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection