@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Pelajaran - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Manajemen Jadwal Pelajaran</h2>
            <p class="text-ink-500 text-sm mt-1">Kelola jadwal mengajar: Hari, Jam, Kelas, Mapel, dan Guru.</p>
        </div>
        <a href="{{ route('admin.jadwal.create') }}" class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">
            + Tambah Jadwal Baru
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES / ERROR --}}
    @if(session('success'))
        <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-600 text-red-900 p-4 mb-6 rounded-sm shadow border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    {{-- TABEL DAFTAR JADWAL --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Hari</th>
                        <th class="p-4 font-heading font-semibold">Jam Ke</th>
                        <th class="p-4 font-heading font-semibold">Waktu</th>
                        <th class="p-4 font-heading font-semibold">Kelas</th>
                        <th class="p-4 font-heading font-semibold">Mapel</th>
                        <th class="p-4 font-heading font-semibold">Guru</th>
                        <th class="p-4 font-heading font-semibold">Jenis</th>
                        <th class="p-4 font-heading font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($jadwals as $jadwal)
                        <tr class="hover:bg-green-050 transition">
                            <td class="p-4 font-bold text-ink-900">{{ $jadwal->hari }}</td>
                            <td class="p-4 text-sm text-ink-700 text-center">{{ $jadwal->jam_ke }}</td>
                            <td class="p-4 text-sm text-ink-700">
                                {{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }}
                            </td>
                            <td class="p-4 text-sm font-bold text-green-800">
                                {{ $jadwal->rombel->kode ?? '-' }}
                            </td>
                            <td class="p-4 text-sm text-ink-700">
                                <div class="font-medium">{{ $jadwal->mapel->nama ?? '-' }}</div>
                                <div class="text-xs text-ink-500">{{ $jadwal->mapel->kode ?? '' }}</div>
                            </td>
                            <td class="p-4 text-sm text-ink-700">{{ $jadwal->guru->nama ?? '-' }}</td>
                            <td class="p-4 text-sm">
                                @if($jadwal->jenis === 'intrakurikuler')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-sm text-xs font-bold uppercase">Intrakurikuler</span>
                                @elseif($jadwal->jenis === 'kokurikuler')
                                    <span class="bg-gold-500 text-green-900 px-2 py-1 rounded-sm text-xs font-bold uppercase">Kokurikuler</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-sm text-xs font-bold uppercase">Ekstra</span>
                                @endif
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Edit</a>
                                
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-ink-500">Belum ada data jadwal yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection