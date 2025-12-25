<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jadwal Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        .sppg-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .sppg-title {
            background-color: #4e73df;
            color: white;
            padding: 8px 10px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .periode-section {
            margin-bottom: 20px;
        }
        .periode-title {
            background-color: #f8f9fc;
            border-left: 4px solid #4e73df;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background-color: #5a5c69;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        .hari-badge {
            display: inline-block;
            background-color: #4e73df;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        .menu-item {
            margin-bottom: 4px;
            line-height: 1.4;
        }
        .kategori-label {
            font-weight: bold;
            color: #4e73df;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN JADWAL MENU</h1>
        <p>Tanggal Cetak: {{ $tanggalCetak }}</p>
    </div>

    @if(count($jadwalData) > 0)
        @foreach($jadwalData as $sppgId => $data)
            <div class="sppg-section">
                <div class="sppg-title">
                    {{ $data['sppg']->nama_dapur }}
                </div>

                @foreach($data['periodes'] as $periodeKey => $jadwalGroup)
                    @php
                        $firstJadwal = $jadwalGroup->first();
                        $periodeText = 'Periode: ';
                        if ($firstJadwal->tanggal_mulai && $firstJadwal->tanggal_selesai) {
                            $periodeText .= $firstJadwal->tanggal_mulai->format('d/m/Y') . ' - ' . $firstJadwal->tanggal_selesai->format('d/m/Y');
                        } else {
                            $periodeText .= 'Tidak Ditentukan';
                        }

                        $hariLabels = [
                            'senin' => 'Senin',
                            'selasa' => 'Selasa',
                            'rabu' => 'Rabu',
                            'kamis' => 'Kamis',
                            'jumat' => 'Jumat'
                        ];
                    @endphp

                    <div class="periode-section">
                        <div class="periode-title">{{ $periodeText }}</div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Hari</th>
                                    <th style="width: 90%;">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hariLabels as $hariKey => $hariLabel)
                                    @php
                                        $jadwalHari = $jadwalGroup->firstWhere('hari', $hariKey);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="hari-badge">{{ $hariLabel }}</span>
                                        </td>
                                        <td>
                                            @if($jadwalHari && $jadwalHari->details->isNotEmpty())
                                                @foreach($jadwalHari->details as $detail)
                                                    <div class="menu-item">
                                                        <span class="kategori-label">{{ $detail->kategoriMenu->nama_kategori }}:</span>
                                                        {{ $detail->menu->nama_menu }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <span style="color: #999; font-style: italic;">Menu belum diatur</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-data">
            Tidak ada data jadwal menu yang tersedia.
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>
