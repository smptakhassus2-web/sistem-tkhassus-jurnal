@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Piket - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Manajemen Jadwal Piket</h2>
            <p class="text-ink-500 text-sm mt-1">Kelola penjadwalan piket harian guru (Urutan 1, 2, dan 3).</p>
        </div>
        <a href="{{ route('admin.jadwal_piket.create') }}" class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">
            + Tambah Jadwal Piket
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DAFTAR JADWAL PIKET --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Hari</th>
                        <th class="p-4 font-heading font-semibold">Urutan Piket</th>
                        <th class="p-4 font-heading font-semibold">Guru Piket</th>
                        <th class="p-4 font-heading font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($jadwalPikets as $jadwalPiket)
                        <tr class="hover:bg-green-050 transition">
                            <td class="p-4 font-bold text-ink-900">{{ $jadwalPiket->hari }}</td>
                            <td class="p-4 text-sm">
                                <span class="bg-gold-500 text-green-900 px-3 py-1 rounded-sm text-xs font-bold uppercase">
                                    Piket Ke-{{ $jadwalPiket->urutan }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-medium text-ink-700">
                                {{ $jadwalPiket->guru->nama ?? '-' }}
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('admin.jadwal_piket.edit', $jadwalPiket->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Edit</a>
                                
                                <form method="POST" action="{{ route('admin.jadwal_piket.destroy', $jadwalPiket->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal piket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-ink-500">Belum ada data jadwal piket yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection