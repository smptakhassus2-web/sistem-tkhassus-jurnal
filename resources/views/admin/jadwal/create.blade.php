@extends('layouts.admin')

@section('title', 'Tambah Jadwal Pelajaran - Admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- HEADER --}}
        <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-heading font-semibold text-ink-900">Tambah Jadwal Pelajaran Baru</h2>
                <p class="text-ink-500 text-sm mt-1">Isi data lengkap jadwal mengajar.</p>
            </div>
            <a href="{{ route('admin.jadwal.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-4 py-2 rounded-sm text-sm font-bold transition border border-line">← Kembali</a>
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

        {{-- FORM TAMBAH JADWAL --}}
        <form method="POST" action="{{ route('admin.jadwal.store') }}" class="bg-paper rounded-sm shadow-md p-6 border border-line space-y-5">
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

            {{-- Jam Ke --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Jam Ke <span class="text-red-600">*</span></label>
                <input type="number" name="jam_ke" value="{{ old('jam_ke', '1') }}" required min="0" max="10" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
                <p class="text-xs text-ink-500 mt-1">💡 Gunakan <strong>0</strong> untuk kegiatan pagi (Upacara, Asmaul Husna, dll).</p>
            </div>

            {{-- Waktu --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-ink-900 mb-1">Waktu Mulai <span class="text-red-600">*</span></label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-ink-900 mb-1">Waktu Selesai <span class="text-red-600">*</span></label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm">
                </div>
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Kelas (Rombel) <span class="text-red-600">*</span></label>
                <select name="rombel_id" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                            Kelas {{ $rombel->kode }} ({{ ucfirst($rombel->jenis) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mata Pelajaran (Opsional) --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Mata Pelajaran</label>
                <select name="mapel_id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Tidak Ada (Untuk Kegiatan Umum) --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama }} ({{ $mapel->kode }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-ink-500 mt-1">💡 Kosongkan untuk jadwal Upacara, Asmaul Husna, atau kegiatan tanpa mapel.</p>
            </div>

            {{-- Guru (Opsional) --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-1">Guru Pengampu</label>
                <select name="guru_id" class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Tidak Ada (Untuk Kegiatan Umum) --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }} ({{ str_replace('_', ' ', $guru->role) }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-ink-500 mt-1">💡 Kosongkan untuk jadwal tanpa guru pengampu.</p>
            </div>

            {{-- Jenis --}}
            <div>
                <label class="block text-sm font-bold text-ink-900 mb-2">Jenis Kegiatan <span class="text-red-600">*</span></label>
                <select name="jenis" required class="w-full px-4 py-2 rounded-sm border border-line focus:border-gold-500 focus:outline-none text-sm bg-white">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="intrakurikuler" {{ old('jenis') == 'intrakurikuler' ? 'selected' : '' }}>Intrakurikuler (KBM Reguler)</option>
                    <option value="kokurikuler" {{ old('jenis') == 'kokurikuler' ? 'selected' : '' }}>Kokurikuler (Upacara, Pagi, dll)</option>
                    <option value="ekstra" {{ old('jenis') == 'ekstra' ? 'selected' : '' }}>Ekstrakurikuler</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-line">
                <a href="{{ route('admin.jadwal.index') }}" class="bg-paper-dim hover:bg-paper text-ink-900 px-6 py-2 rounded-sm text-sm font-bold transition border border-line">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-paper px-6 py-2 rounded-sm text-sm font-bold transition shadow-sm">💾 Simpan Jadwal</button>
            </div>
        </form>
    </div>
@endsection