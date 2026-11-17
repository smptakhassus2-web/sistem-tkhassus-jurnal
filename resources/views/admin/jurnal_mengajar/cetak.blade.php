<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap Jurnal Mengajar - {{ $filterTanggal }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 15px 20px;
            /* 🔴 PENTING: Paksa browser mencetak warna asli kop (hijau), bukan hitam-putih */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        /* KOP SURAT RESMI BERGAMBAR */
        .kop-surat {
            text-align: center;
            margin-bottom: 8px;
        }
        .kop-surat img {
            width: 100%;
            max-width: 100%;
            height: auto;
            display: block;
        }
        /* Garis pembatas bawah kop */
        .kop-pembatas {
            border-bottom: 3px double #0a3a20;
            margin-bottom: 18px;
        }
        .judul-laporan {
            text-align: center;
            margin: 15px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
        }
        .judul-laporan span {
            font-size: 12pt;
            text-decoration: none;
            font-weight: normal;
        }
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
        LAPORAN REKAP JURNAL MENGAJAR<br>
        <span>Tanggal: {{ \Carbon\Carbon::parse($filterTanggal)->isoFormat('dddd, D MMMM Y') }}</span>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Waktu</th>
                <th style="width: 20%;">Guru</th>
                <th style="width: 15%;">Mapel</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 25%;">Materi</th>
                <th style="width: 15%;">Kendala</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $jurnal)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $jurnal->ceklok->waktu_mulai ? \Carbon\Carbon::parse($jurnal->ceklok->waktu_mulai)->format('H:i') : '-' }}</td>
                    <td>{{ $jurnal->ceklok->guru->nama ?? '-' }}</td>
                    <td>{{ $jurnal->ceklok->jadwal->mapel->nama ?? '-' }}</td>
                    <td class="text-center">{{ $jurnal->ceklok->jadwal->rombel->kode ?? '-' }}</td>
                    <td>{{ $jurnal->materi ?? '-' }}</td>
                    <td>{{ $jurnal->kendala ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data jurnal mengajar pada tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- KOLOM TANDA TANGAN --}}
    @if($jurnals->isNotEmpty())
    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>Mengetahui,<br>Waka Kurikulum</p>
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