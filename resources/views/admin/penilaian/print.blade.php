<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Kepesantrenan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 5px;
            margin-right: 5px;
            font-size: 12px;
        }

        h1,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eb960e;
            color: white;
        }

        .info-table td {
            border: none;
            padding: 5px;
        }

        .category {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Informasi Santri -->


    @if ($data->isNotEmpty())
        @foreach ($data->groupBy('id_santri') as $idSantri => $santriData)
            <table class="info-table" style="margin-bottom: 0px !important;">
                <tr>
                    <td> <img src="{{ public_path('/img') }}/logo-pesantren.png" alt="Logo Kiri" class="logo"
                            style="width: 80px;"></td>
                    <td>
                        <h1>Laporan Kepesantrenan</h1>
                    </td>
                    <td> <img src="{{ public_path('/img') }}/logo-yayasan.png" alt="Logo Kanan" class="logo"
                            style="width: 100px;"></td>
                </tr>
            </table>
            @php
                $santri = $santriData->first()->santri ?? null;
                $tahunAjaran = $santriData->first()->tahun_ajaran ?? null;
            @endphp

            <!-- Informasi Santri -->

            <table class="info-table">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>: {{ $santri->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kelas/Semester/TA</strong></td>
                    <td>:
                        {{ $santri->kelas ?? '-' }}/{{ $tahunAjaran->semester ?? '-' }}/{{ $tahunAjaran->tahun ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Kamar</strong></td>
                    <td>: {{ $santri->kamar ?? '-' }}</td>
                </tr>
            </table>

            <!-- Tabel Penilaian -->
            @foreach ($santriData->groupBy('id_kategori') as $kategoriId => $kategoriData)
                <table>
                    <thead>
                        <tr class="category">
                            <th colspan="3">{{ $kategoriData->first()->kategori->kategori ?? '-' }}</th>
                        </tr>
                        <tr>
                            <th style="width: 10px;">No.</th>
                            <th>Aspek Penilaian</th>
                            <th style="width: 50px;">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoriData as $index => $penilaian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $penilaian->point->point ?? '-' }}</td>
                                <td>
                                    @if ($penilaian->nilai == 1)
                                        Belum Tampak
                                    @elseif($penilaian->nilai == 2)
                                        Berkembang
                                    @elseif($penilaian->nilai == 3)
                                        Mandiri
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">
                                Komentar Tambahan : "
                                <i>{{ App\Models\KomentarPenilaian::where('id_kategori', $kategoriId)->where('id_santri', $penilaian->id_santri)->where('id_tahun_ajaran', $penilaian->id_tahun_ajaran)->orderBy('id', 'desc')->first()->komentar ?? '-' }}</i>
                                "
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
            <!-- Tanda Tangan -->
            <div style="margin-top: 60px; clear: both;">
                <div style="width: 50%; float: left; text-align: center;">
                    <p></p>
                    <p style="margin-top: 80px;">
                        <b>
                            @php
                                $pengasuh =
                                    App\Models\PengasuhPenilaian::where('id_santri', $santri->id ?? 0)
                                        ->where('id_tahun_ajaran', $tahunAjaran->id ?? 0)
                                        ->first()->pengasuh->nama ?? '-';
                            @endphp
                            {{ $pengasuh }}
                        </b><br>(Biro Pengasuhan)
                    </p>
                </div>
                <div style="width: 50%; float: right; text-align: center;">
                    <p>Merauke, {{ date('d F Y') }}<br>Mengetahui</p>
                    <p style="margin-top: 60px;"><b>Buya M. Dic Hidayat Ratuloly, S.PdI, MPS.</b><br>(Pimpinan Pondok
                        Pesantren)</p>
                </div>
            </div>
            <div class="page-break"></div>
        @endforeach
    @else
        <p>Data tidak tersedia untuk Santri dan Tahun Ajaran yang dipilih.</p>
    @endif


</body>

</html>
