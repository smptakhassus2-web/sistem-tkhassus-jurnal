@extends('layouts.admin')

@section('title', 'Portal Orang Tua - SMP Takhassus 2')

@section('content')
    {{-- HEADER --}}
    <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border-l-4 border-gold-500 border border-line">
        <h2 class="text-2xl font-heading font-semibold text-ink-900">👨‍👩‍👧 Portal Orang Tua / Wali Murid</h2>
        <p class="text-ink-500 text-sm mt-1">Selamat datang, {{ auth()->user()->nama }}. Pantau perkembangan putra/putri Anda di sini.</p>
    </div>

    {{-- CEK APAKAH ADA ANAK YANG TERHUBUNG --}}
    @if($anakList->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-900 p-6 rounded-sm shadow border border-yellow-200">
            <p class="font-bold text-lg mb-2">⚠️ Belum Ada Data Anak Terhubung</p>
            <p class="text-sm">Akun Anda belum dihubungkan dengan data siswa di sistem. Silakan hubungi Admin Sekolah atau Wali Kelas untuk mengaitkan akun Anda dengan data anak.</p>
        </div>
    @else
        {{-- LOOPING UNTUK SETIAP ANAK --}}
        @foreach($anakList as $anak)
            <div class="bg-paper rounded-sm shadow-md p-6 mb-6 border border-line">
                
                {{-- INFO ANAK --}}
                <div class="flex justify-between items-start border-b border-line pb-4 mb-4">
                    <div>
                        <h3 class="text-xl font-heading font-bold text-ink-900">{{ $anak->nama }}</h3>
                        <p class="text-sm text-ink-500 mt-1">
                            NIS: {{ $anak->nis }} • 
                            Kelas: <span class="font-bold text-green-700">{{ $anak->rombels->first()->kode ?? 'Belum ada kelas' }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block bg-gold-500 text-green-900 text-xs font-bold px-3 py-1 rounded-sm uppercase">
                            {{ $anak->pivot->hubungan ?? 'Wali' }}
                        </span>
                    </div>
                </div>

                {{-- KARTU RINGKASAN ABSENSI 7 KAIH --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-green-050 rounded-sm p-3 border border-green-700 text-center">
                        <p class="text-xs font-bold text-ink-500 uppercase">Hadir</p>
                        <p class="text-2xl font-heading font-semibold text-green-700 mt-1">{{ $anak->totalHadir }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-sm p-3 border border-yellow-600 text-center">
                        <p class="text-xs font-bold text-ink-500 uppercase">Sakit</p>
                        <p class="text-2xl font-heading font-semibold text-yellow-600 mt-1">{{ $anak->totalSakit }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-sm p-3 border border-blue-600 text-center">
                        <p class="text-xs font-bold text-ink-500 uppercase">Izin</p>
                        <p class="text-2xl font-heading font-semibold text-blue-600 mt-1">{{ $anak->totalIzin }}</p>
                    </div>
                    <div class="bg-red-50 rounded-sm p-3 border border-red-600 text-center">
                        <p class="text-xs font-bold text-ink-500 uppercase">Alpha</p>
                        <p class="text-2xl font-heading font-semibold text-red-600 mt-1">{{ $anak->totalAlpha }}</p>
                    </div>
                </div>

                {{-- RINGKASAN TAHFIDZ --}}
                <div class="bg-green-050 rounded-sm p-4 border border-green-700 mb-6">
                    <h4 class="font-heading font-bold text-ink-900 mb-2">📖 Progres Tahfidz</h4>
                    <div class="flex gap-6">
                        <div>
                            <p class="text-xs text-ink-500">Total Setoran</p>
                            <p class="text-xl font-bold text-green-700">{{ $anak->totalSetoranTahfidz }} <span class="text-sm font-normal">kali</span></p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-500">Sudah Mutqin</p>
                            <p class="text-xl font-bold text-gold-600">{{ $anak->totalMutqin }} <span class="text-sm font-normal">surat</span></p>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL DETAIL --}}
                <div class="flex gap-3">
                    <a href="{{ route('wali_murid.absensi_detail', $anak->id) }}" 
                       class="bg-green-700 hover:bg-green-800 text-paper px-4 py-2 rounded-sm text-sm font-bold transition">
                       📋 Lihat Detail Absensi
                    </a>
                    <a href="{{ route('wali_murid.tahfidz_detail', $anak->id) }}" 
                       class="bg-gold-500 hover:bg-gold-600 text-green-900 px-4 py-2 rounded-sm text-sm font-bold transition">
                       📖 Lihat Detail Tahfidz
                    </a>
                </div>

            </div>
        @endforeach
    @endif
@endsection