@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran - Admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- HEADER --}}
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Tambah Mata Pelajaran Baru</h2>
                <p class="text-ink-500 text-sm mt-1">Isi data lengkap mata pelajaran untuk didaftarkan ke sistem.</p>
            </div>
            <a href="{{ route('admin.mapel.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
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

        {{-- FORM TAMBAH MAPEL --}}
        <form method="POST" action="{{ route('admin.mapel.store') }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
            @csrf

            {{-- Kode Mapel --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Kode Mapel <span class="text-red-600">*</span></label>
                <input type="text" name="kode" value="{{ old('kode') }}" required placeholder="Contoh: [H] ARAB, MTK, PAI" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm uppercase">
                <p class="text-xs text-ink-500 mt-1">💡 Harus unik. Disarankan menggunakan format kode guru + mapel (misal: [H] ARAB) agar sesuai dengan data jadwal.</p>
            </div>

            {{-- Nama Mapel --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Nama Mata Pelajaran <span class="text-red-600">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Bahasa Arab, Matematika" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-2">Kategori <span class="text-red-600">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="wajib" {{ old('kategori') == 'wajib' ? 'selected' : '' }}>Wajib (Kurikulum Nasional)</option>
                    <option value="mulok" {{ old('kategori') == 'mulok' ? 'selected' : '' }}>Muatan Lokal (Misal: Bahasa Jawa)</option>
                    <option value="ciri_khas" {{ old('kategori') == 'ciri_khas' ? 'selected' : '' }}>Ciri Khas Yayasan (Misal: Ke-NU-an, Tahfidz)</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-line">
                <a href="{{ route('admin.mapel.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Simpan Mapel</button>
            </div>
        </form>
    </div>
@endsection