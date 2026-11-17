@extends('layouts.admin')

@section('title', 'Rekap Progres Tahfidz - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
        <h2 class="text-2xl font-heading font-semibold text-ink-900">📖 Rekap Progres Tahfidz</h2>
        <p class="text-ink-500 text-sm mt-1">Monitoring setoran hafalan Al-Qur'an seluruh siswa (Progres & Mutqin).</p>
    </div>

    {{-- KARTU RINGKASAN STATISTIK --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-green-700 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Total Setoran</p>
            <p class="text-3xl font-heading font-semibold text-green-700 mt-1">{{ $totalSetoran }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-gold-500 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Sudah Mutqin</p>
            <p class="text-3xl font-heading font-semibold text-gold-600 mt-1">{{ $totalMutqin }}</p>
        </div>
        <div class="bg-paper rounded-sm shadow-md p-4 border-t-4 border-blue-500 border border-line">
            <p class="text-xs font-bold text-ink-500 uppercase">Masih Proses</p>
            <p class="text-3xl font-heading font-semibold text-blue-600 mt-1">{{ $totalProses }}</p>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="bg-paper rounded-sm shadow-md p-5 mb-6 border border-line">
        <form method="GET" action="{{ route('admin.tahfidz.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-ink-700 mb-1">Bulan</label>
                <input type="month" name="bulan" value="{{ $filterBulan }}"
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
                <a href="{{ route('admin.tahfidz.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">↺ Reset</a>
                <button type="button" onclick="cetakLaporan()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">🖨️ Cetak</button>
            </div>
        </form>
    </div>

    {{-- INFO JUMLAH DATA --}}
    <div class="flex justify-between items-center mb-3 px-1">
        <p class="text-sm text-ink-700">
            Menampilkan <strong>{{ $progresList->count() }}</strong> setoran untuk bulan <strong>{{ \Carbon\Carbon::parse($filterBulan)->isoFormat('MMMM Y') }}</strong>
            @if($filterRombel)
                • Kelas <strong>{{ optional($rombels->firstWhere('id', $filterRombel))->kode ?? 'terpilih' }}</strong>
            @endif
        </p>
    </div>

    {{-- TABEL REKAP --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Tanggal</th>
                        <th class="p-4 font-heading font-semibold">Nama Siswa</th>
                        <th class="p-4 font-heading font-semibold">Kelas</th>
                        <th class="p-4 font-heading font-semibold">Surat</th>
                        <th class="p-4 font-heading font-semibold">Jumlah Ayat</th>
                        <th class="p-4 font-heading font-semibold">Status</th>
                        <th class="p-4 font-heading font-semibold">Penguji</th>
                        <th class="p-4 font-heading font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($progresList as $progres)
                        <tr class="hover:bg-green-050 transition">
                            {{-- Tanggal --}}
                            <td class="p-4 text-sm text-ink-700">
                                {{ \Carbon\Carbon::parse($progres->tanggal_setor)->isoFormat('D MMM Y') }}
                            </td>

                            {{-- Nama Siswa (null-safe) --}}
                            <td class="p-4 text-sm font-bold text-ink-900">
                                {{ $progres->siswa->nama ?? '-' }}
                            </td>

                            {{-- Kelas (ambil dari relasi many-to-many rombels) --}}
                            <td class="p-4 text-sm">
                                @if($progres->siswa && $progres->siswa->rombels->isNotEmpty())
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-sm text-xs font-bold">
                                        {{ $progres->siswa->rombels->first()->kode }}
                                    </span>
                                @else
                                    <span class="text-ink-500 italic text-xs">-</span>
                                @endif
                            </td>

                            {{-- Surat --}}
                            <td class="p-4 text-sm font-medium text-ink-900">
                                {{ $progres->surat }}
                            </td>

                            {{-- Jumlah Ayat --}}
                            <td class="p-4 text-sm text-ink-700 text-center">
                                {{ $progres->jumlah_ayat }} ayat
                            </td>

                            {{-- Status --}}
                            <td class="p-4 text-sm">
                                @if($progres->status === 'mutqin')
                                    <span class="bg-green-100 text-green-800 border border-green-700 px-2 py-1 rounded-sm text-xs font-bold">MUTQIN</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 border border-yellow-600 px-2 py-1 rounded-sm text-xs font-bold">PROSES</span>
                                @endif
                            </td>

                            {{-- Penguji --}}
                            <td class="p-4 text-sm text-ink-700">
                                {{ $progres->penguji->nama ?? '-' }}
                            </td>

                            {{-- Catatan --}}
                            <td class="p-4 text-sm text-ink-500 italic max-w-xs">
                                {{ Str::limit($progres->catatan, 40) ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-ink-500">
                                Tidak ada data setoran tahfidz untuk bulan/kelas yang dipilih.
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
        const bulan = document.querySelector('input[name="bulan"]').value;
        const rombel = document.querySelector('select[name="rombel_id"]').value;
        let url = "{{ route('admin.tahfidz.cetak') }}?bulan=" + bulan;
        if(rombel) url += "&rombel_id=" + rombel;
        window.open(url, '_blank');
    }
    </script>
@endsection