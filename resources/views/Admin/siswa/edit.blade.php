@extends('layouts.admin')

@section('title', 'Edit Siswa - Admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- HEADER --}}
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Edit Data Siswa</h2>
                <p class="text-ink-500 text-sm mt-1">Memperbarui data untuk: <strong>{{ $siswa->nama }}</strong></p>
            </div>
            <a href="{{ route('admin.siswa.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
        </div>

        {{-- TAMPIL ERROR VALIDASI --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-900 p-4 mb-6 rounded-sm shadow border border-red-200">
                <p class="font-bold mb-2">⚠️ Ada kesalahan input:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM EDIT SISWA --}}
        <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" placeholder="Contoh: 2026001" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-2">Jenis Kelamin <span class="text-red-600">*</span></label>
                <div class="flex space-x-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }} required class="w-4 h-4 text-green-700 border-line focus:ring-gold-500">
                        <span class="text-sm font-bold text-ink-900">Laki-laki</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }} required class="w-4 h-4 text-green-700 border-line focus:ring-gold-500">
                        <span class="text-sm font-bold text-ink-900">Perempuan</span>
                    </label>
                </div>
            </div>

            {{-- Kelas (Pindah Kelas) --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Tempatkan di Kelas</label>
                <select name="rombel_id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Belum Ditempatkan / Keluar dari Kelas --</option>
                    @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}" {{ old('rombel_id', $rombel_id) == $rombel->id ? 'selected' : '' }}>
                            Kelas {{ $rombel->kode }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-ink-500 mt-1">💡 Pilih kelas baru untuk memindahkan siswa ini. Pilih "-- Belum Ditempatkan --" untuk mencopot siswa dari kelas saat ini.</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-line">
                <a href="{{ route('admin.siswa.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Update Data Siswa</button>
            </div>
        </form>
    </div>
@endsection