@extends('layouts.admin')

@section('title', 'Manajemen Guru - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Manajemen Data Guru</h2>
            <p class="text-ink-500 text-sm mt-1">Kelola data guru, jabatan, dan penunjukan Wali Kelas.</p>
        </div>
        <a href="{{ route('admin.guru.create') }}" class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition shadow-sm">
            + Tambah Guru Baru
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="bg-green-050 border-l-4 border-green-700 text-green-900 p-4 mb-6 rounded-sm shadow border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DAFTAR GURU --}}
    <div class="bg-paper rounded-sm shadow-md overflow-hidden border border-line">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-paper-dim text-ink-700 border-b-2 border-gold-500">
                    <tr>
                        <th class="p-4 font-heading font-semibold">Nama Guru</th>
                        <th class="p-4 font-heading font-semibold">Email</th>
                        <th class="p-4 font-heading font-semibold">Role</th>
                        <th class="p-4 font-heading font-semibold">Jabatan</th>
                        <th class="p-4 font-heading font-semibold">Wali Kelas</th>
                        <th class="p-4 font-heading font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($gurus as $guru)
                        @php
                            $waliRombel = $rombels->firstWhere('wali_kelas_id', $guru->id);
                        @endphp
                        <tr class="hover:bg-green-050 transition">
                            <td class="p-4 font-bold text-ink-900">{{ $guru->nama }}</td>
                            <td class="p-4 text-sm text-ink-700">{{ $guru->email }}</td>
                            <td class="p-4 text-sm">
                                <span class="bg-gold-500 text-green-900 px-2 py-1 rounded-sm text-xs font-bold uppercase">
                                    {{ str_replace('_', ' ', $guru->role) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-ink-700">{{ $guru->jabatan ?? '-' }}</td>
                            <td class="p-4 text-sm font-bold text-green-800">
                                {{ $waliRombel ? 'Kelas ' . $waliRombel->kode : '-' }}
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Edit</a>
                                
                                <form method="POST" action="{{ route('admin.guru.destroy', $guru->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-sm text-xs font-bold transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-ink-500">Belum ada data guru yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection