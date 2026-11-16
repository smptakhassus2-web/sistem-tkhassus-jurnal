@extends('layouts.admin')

@section('title', 'Tambah Jadwal Piket - Admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- HEADER --}}
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Tambah Jadwal Piket Baru</h2>
                <p class="text-ink-500 text-sm mt-1">Tentukan hari, urutan, dan guru yang bertugas piket.</p>
            </div>
            <a href="{{ route('admin.jadwal_piket.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
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

        {{-- FORM TAMBAH JADWAL PIKET --}}
        <form method="POST" action="{{ route('admin.jadwal_piket.store') }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
            @csrf

            {{-- Hari --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Hari <span class="text-red-600">*</span></label>
                <select name="hari" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Urutan Piket --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Urutan Piket <span class="text-red-600">*</span></label>
                <select name="urutan" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Urutan --</option>
                    <option value="1" {{ old('urutan') == '1' ? 'selected' : '' }}>Piket Urutan 1 (Pagi)</option>
                    <option value="2" {{ old('urutan') == '2' ? 'selected' : '' }}>Piket Urutan 2 (Siang)</option>
                    <option value="3" {{ old('urutan') == '3' ? 'selected' : '' }}>Piket Urutan 3 (Sore/Pulang)</option>
                </select>
                <p class="text-xs text-ink-500 mt-1">💡 Sistem akan menolak jika Hari dan Urutan yang sama sudah diisi oleh guru lain.</p>
            </div>

            {{-- Guru Piket --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Guru Piket <span class="text-red-600">*</span></label>
                <select name="guru_id" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }} ({{ str_replace('_', ' ', $guru->role) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-line">
                <a href="{{ route('admin.jadwal_piket.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Simpan Jadwal Piket</button>
            </div>
        </form>
    </div>
@endsection