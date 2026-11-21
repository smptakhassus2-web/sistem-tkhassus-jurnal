<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap Penilaian BTQ - SMP Takhassus 2</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #000; margin: 15px 20px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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
        .tanda-tangan { margin-top: 40px; display: flex; justify-content: flex-end; page-break-inside: avoid; }
        .ttd-box { text-align: center; width: 40%; }
        .ttd-space { height: 70px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }
        @media print { .no-print { display: none; } body { margin: 0; } @page { margin: 1.5cm; } }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 15px; background: #0a3a20; color: white; border: none; border-radius: 4px; cursor: pointer;">🖨️ Print / Simpan PDF</button>
        <button onclick="window.history.back()" style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Kembali</button>
    </div>

    <div class="kop-surat">
        <img src="{{ asset('assets/kop-sekolah.png') }}" alt="Kop Surat SMP Takhassus Al-Qur'an 2" onerror="this.style.display='none'">
        <div style="margin-top: 5px; font-weight: bold; font-size: 12pt;">
            SMP TAKHASSUS AL-QUR'AN 2<br>
            <span style="font-size: 10pt; font-weight: normal;">Wonosobo, Jawa Tengah</span>
        </div>
    </div>
    <div class="kop-pembatas"></div>

    <div class="judul-laporan">
        LAPORAN REKAP PENILAIAN BTQ SELURUH SISWA<br>
        <span>Tahun Ajaran 2026/2027</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 15%;">Kelompok</th>
                <th style="width: 15%;">Pembina</th>
                <th style="width: 18%;">Materi</th>
                <th style="width: 10%;">Nilai</th>
                <th style="width: 5%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaians as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                    <td>{{ $item->kelompok->nama_kelompok ?? '-' }}</td>
                    <td>{{ $item->pembina->nama ?? '-' }}</td>
                    <td>
                        @if($item->jilid)
                            {{ $item->jilid }} (Hal. {{ $item->halaman }})
                        @elseif($item->juz)
                            Juz {{ $item->juz }}: {{ $item->surat }} ({{ $item->ayat_awal }}-{{ $item->ayat_akhir }})
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center" style="font-weight: bold;">{{ $item->nilai }}</td>
                    <td style="font-style: italic; font-size: 10pt;">{{ $item->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Belum ada data penilaian yang diinput.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($penilaians->isNotEmpty())
    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>Mojotengah, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>Wakil Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">{{ auth()->user()->nama ?? '................................' }}</p>
        </div>
    </div>
    @endif
</body>
</html>