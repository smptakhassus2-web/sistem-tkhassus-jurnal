@extends('layouts.admin')

@section('title', 'Tambah Kelas Baru - Admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- HEADER --}}
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Tambah Kelas Baru</h2>
                <p class="text-ink-500 text-sm mt-1">Isi data lengkap kelas untuk didaftarkan ke sistem.</p>
            </div>
            <a href="{{ route('admin.rombel.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
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

        {{-- FORM TAMBAH KELAS --}}
        <form method="POST" action="{{ route('admin.rombel.store') }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
            @csrf

            {{-- Kode --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Kode Kelas <span class="text-red-600">*</span></label>
                <input type="text" name="kode" value="{{ old('kode') }}" required placeholder="Contoh: 7A, 8B, TAHFIDZ-A" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
                <p class="text-xs text-ink-500 mt-1">💡 Harus unik (tidak boleh sama dengan kelas lain).</p>
            </div>

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Nama Kelas <span class="text-red-600">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Kelas 7A Reguler" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
            </div>

            {{-- Tingkat --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Tingkat <span class="text-red-600">*</span></label>
                <select name="tingkat" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>Kelas 7</option>
                    <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>Kelas 8</option>
                    <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>Kelas 9</option>
                </select>
            </div>

            {{-- Jenis --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Jenis Kelas <span class="text-red-600">*</span></label>
                <select name="jenis" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="utama" {{ old('jenis') == 'utama' ? 'selected' : '' }}>Utama (Reguler)</option>
                    <option value="tambahan" {{ old('jenis') == 'tambahan' ? 'selected' : '' }}>Tambahan (Tahfidz/BTQ/Ekstra)</option>
                </select>
            </div>

            {{-- Wali Kelas --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Wali Kelas (Opsional)</label>
                <select name="wali_kelas_id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Belum Ditunjuk --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }} ({{ str_replace('_', ' ', $guru->role) }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-ink-500 mt-1">💡 Bisa juga ditunjuk atau diganti nanti lewat menu Edit.</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-line">
                <a href="{{ route('admin.rombel.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Simpan Kelas</button>
            </div>
        </form>
    </div>
@endsection