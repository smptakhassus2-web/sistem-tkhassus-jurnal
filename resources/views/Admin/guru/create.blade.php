@extends('layouts.admin')

@section('title', 'Tambah Guru Baru - Admin')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-heading font-semibold text-ink-900">Tambah Guru Baru</h2>
            <p class="text-ink-500 text-sm mt-1">Isi data lengkap guru untuk didaftarkan ke sistem.</p>
        </div>
        <a href="{{ route('admin.guru.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
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

    {{-- FORM TAMBAH GURU --}}
    <form method="POST" action="{{ route('admin.guru.store') }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Ahmad Rosyem, S.Pd." class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Email (Username Login) <span class="text-red-600">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: nama@smptaqdua.sch.id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Password <span class="text-red-600">*</span></label>
            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Role / Hak Akses <span class="text-red-600">*</span></label>
            <select name="role" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                <option value="guru_mapel" {{ old('role') == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
                <option value="kepsek" {{ old('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
        </div>

        {{-- No HP --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Nomor HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
        </div>

        {{-- Jabatan --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Jabatan (Opsional)</label>
            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Waka Kurikulum / Kepala Lab" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
        </div>

        {{-- Wali Kelas --}}
        <div>
            <label class="block text-sm font-bold text-ink-900 mb-1">Tunjuk Sebagai Wali Kelas (Opsional)</label>
            <select name="wali_kelas_id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                <option value="">-- Tidak Ditunjuk --</option>
                @foreach($rombels as $rombel)
                    <option value="{{ $rombel->id }}" {{ old('wali_kelas_id') == $rombel->id ? 'selected' : '' }}>
                        Kelas {{ $rombel->kode }} {{ $rombel->wali_kelas_id ? '(Sudah ada wali)' : '(Kosong)' }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-ink-500 mt-1">💡 Jika kelas sudah punya wali, wali lama akan otomatis diganti.</p>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end space-x-3 pt-4 border-t border-line">
            <a href="{{ route('admin.guru.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Simpan Guru</button>
        </div>
    </form>
@endsection