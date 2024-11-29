<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Santri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
    </style>
</head>

<body>
    <h1>Laporan Penilaian Santri</h1>
    <!-- Informasi Santri -->
    @if ($data->isNotEmpty())
        <h3>Informasi Santri</h3>
        <table class="info-table">
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $data->first()->santri->nama }}</td>
            </tr>
            <tr>
                <td><strong>Kelas/Semester/TA</strong></td>
                <td>:{{ $data->first()->santri->kelas }}/{{ $data->first()->tahun_ajaran->semester }}/{{ $data->first()->tahun_ajaran->tahun }}
                </td>
            </tr>
            <tr>
                <td><strong>Kamar</strong></td>
                <td>: {{ $data->first()->santri->kamar }}</td>
            </tr>
        </table>

        <!-- Tabel Penilaian -->
        <h3>Penilaian</h3>
        @foreach ($data->groupBy('id_kategori') as $kategoriId => $kategoriData)
            <table>
                <thead>
                    <tr class="category">
                        <th colspan="3">{{ $kategoriData->first()->kategori->kategori }}</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Point</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriData as $index => $penilaian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penilaian->point->point }}</td>
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
                            <i>{{ App\Models\KomentarPenilaian::where('id_kategori', $kategoriId)->where('id_santri', $penilaian->id_santri)->where('id_tahun_ajaran', $penilaian->id_tahun_ajaran)->first()->komentar ?? '-' }}</i>
                            "
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @else
        <p>Data tidak tersedia untuk Santri dan Tahun Ajaran yang dipilih.</p>
    @endif

    <!-- Tanda Tangan -->
    <div style="margin-top: 50px;">
        <div style="width: 50%; float: left; text-align: center;">
            <p>Mengetahui,</p>
            <p style="margin-top: 70px;">
                {{ App\Models\PengasuhPenilaian::where('id_santri', $data->first()->santri->id)->where('id_tahun_ajaran', $data->first()->tahun_ajaran->id)->first()->pengasuh->nama ?? '-' }}<br>(Biro
                Pengasuhan)
            </p>
        </div>
        <div style="width: 50%; float: right; text-align: center;">
            <p>Penanggung Jawab,</p>
            <p style="margin-top: 70px;">Buya M. Dic Hidayat Ratuloly, S.PdI, MPS.<br>(Pimpinan Pondok Pesantren)</p>
        </div>
    </div>
</body>

</html>
