<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap Progres Tahfidz - {{ $filterBulan }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 15px 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .kop-surat { text-align: center; margin-bottom: 8px; }
        .kop-surat img { width: 100%; max-width: 100%; height: auto; display: block; }
        .kop-pembatas { border-bottom: 3px double #0a3a20; margin-bottom: 18px; }
        .judul-laporan { text-align: center; margin: 15px 0; text-decoration: underline; font-weight: bold; font-size: 14pt; }
        .judul-laporan span { font-size: 12pt; text-decoration: none; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px 8px; text-align: left; vertical-align: top; }
        th { background-color: #eef6ee; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .tanda-tangan { margin-top: 40px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .ttd-box { text-align: center; width: 40%; }
        .ttd-space { height: 70px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body>

    {{-- Tombol Print (Hilang saat dicetak) --}}
    <div class="no-print" style="text-align: right; margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 15px; background: #0a3a20; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">🖨️ Print / Simpan PDF</button>
        <button onclick="window.close()" style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Tutup</button>
    </div>

    {{-- KOP SURAT RESMI (GAMBAR) --}}
    <div class="kop-surat">
        <img src="{{ asset('assets/kop-sekolah.png') }}" alt="Kop Surat SMP Takhassus Al-Qur'an 2">
    </div>
    <div class="kop-pembatas"></div>

    {{-- JUDUL LAPORAN --}}
    <div class="judul-laporan">
        LAPORAN REKAP PROGRES TAHFIDZ<br>
        <span>Bulan: {{ \Carbon\Carbon::parse($filterBulan)->isoFormat('MMMM Y') }}</span>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 15%;">Surat</th>
                <th style="width: 10%;">Ayat</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 20%;">Penguji</th>
            </tr>
        </thead>
        <tbody>
            @forelse($progresList as $index => $progres)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($progres->tanggal_setor)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $progres->siswa->nama ?? '-' }}</td>
                    <td class="text-center">
                        @if($progres->siswa && $progres->siswa->rombels->isNotEmpty())
                            {{ $progres->siswa->rombels->first()->kode }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $progres->surat }}</td>
                    <td class="text-center">{{ $progres->jumlah_ayat }}</td>
                    <td class="text-center">{{ strtoupper($progres->status) }}</td>
                    <td>{{ $progres->penguji->nama ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data setoran tahfidz pada bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- KOLOM TANDA TANGAN --}}
    @if($progresList->isNotEmpty())
    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>Mengetahui,<br>Waka Tahfidz</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">( ................................... )</p>
        </div>
        <div class="ttd-box">
            <p>Mojotengah, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">Abdul Rohman Sholeh, S.Kom.</p>
        </div>
    </div>
    @endif

</body>
</html>