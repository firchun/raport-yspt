<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>MRAPOR PROGRAM TAHFIDZUL QUR'AN</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            margin: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 100px;
        }

        .title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        .no-border {
            border: none;
            padding: 2px;
        }

        .section-title {
            font-weight: bold;
            margin: 10px 0 5px 0;
        }

        .signature {
            width: 30%;
            text-align: center;
            float: left;
            margin-top: 40px;
        }

        .clear {
            clear: both;
        }

        .small-text {
            font-size: 10pt;
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="no-border">
            <tr class="no-border">
                <td class="no-border" style="width: 15%; text-align: center;">
                    <img src="{{ public_path('/img') }}/MTs-SPT.png" alt="Logo Pesantren">
                </td>
                <td class="no-border" style="width: 70%; text-align: center;">
                    <div style="font-size: 14pt; font-weight: bold;">MADRASAH TSANAWIYAH</div>
                    <div style="font-size: 14pt; font-weight: bold;">SANTRI PERBATASAN TIMUR</div>
                    <div class="small-text">
                        Alamat: Jl. Arafura – Gg. Santri, Kel. Samkai, Kec.<br> Merauke, Prov. Papua Selatan
                        Telp: (0971)3336630
                    </div>
                </td>
                <td class="no-border" style="width: 15%; text-align: center;">
                    <img src="{{ public_path('/img') }}/logo-yayasan.png" alt="Logo Yayasan">
                </td>
            </tr>
        </table>
    </div>

    <hr>

    <div class="title">
        RAPOR PROGRAM TAHFIDZUL QUR’AN <br> MADRASAH TSANAWIYAH SANTRI PERBATASAN TIMUR
    </div>

    <table style="border-collapse: collapse; width: 100%; border: 1px solid orange; font-size: 12px;">
        <tr>
            <td style="border: none;"><b>Nama Santri/ Santriyah</b></td>
            <td style="border: none;">: {{ $data[0]->santri->nama }}</td>
            <td style="border: none;"><b>Semester/ Tahun Ajar</b></td>
            <td style="border: none;">: {{ $data[0]->tahun_ajaran->semester }} /
                {{ $data[0]->tahun_ajaran->tahun }}</td>
            </td>
        </tr>
        <tr>
            <td style="border: none;"><b>Kelas</b></td>
            <td style="border: none;">: {{ $data[0]->santri->kelas }}</td>
            <td style="border: none;"><b>Musyrif/ah Qur’an</b></td>
            <td style="border: none;">:
                {{ App\Models\PengasuhQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->pengasuh->nama }}
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px;">TINGKAT PENCAPAIAN</div>

    <table style="border: none; border-collapse: collapse; width: 100%; font-weight: bold;">
        <tr>
            <td style="border: none; ">
                <table style="border-collapse: collapse;  font-size: 12px; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; padding: 5px;">No</th>
                            <th style="border: 1px solid black; padding: 5px;">Indikator Pencapaian</th>
                            <th style="border: 1px solid black; padding: 5px;">Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">1</td>
                            <td style="border: 1px solid black; padding: 5px;">Kelancaran</td>
                            <td style="border: 1px solid black; padding: 5px;text-align: center;">
                                {{ App\Models\PencapaianQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->kelancaran }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">2</td>
                            <td style="border: 1px solid black; padding: 5px;">Makhraj</td>
                            <td style="border: 1px solid black; padding: 5px;text-align: center;">
                                {{ App\Models\PencapaianQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->makhraj }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">3</td>
                            <td style="border: 1px solid black; padding: 5px;">Tajwid</td>
                            <td style="border: 1px solid black; padding: 5px;text-align: center;">
                                {{ App\Models\PencapaianQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->tajwid }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="border-collapse: collapse;  font-size: 12px; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; padding: 5px;">No</th>
                            <th style="border: 1px solid black; padding: 5px;">Kriteria Sikap</th>
                            <th style="border: 1px solid black; padding: 5px;">Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">1</td>
                            <td style="border: 1px solid black; padding: 5px;">Kegigihan</td>
                            <td style="border: 1px solid black; padding: 5px;text-align: center;">
                                {{ App\Models\PencapaianQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->kegigihan }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">2</td>
                            <td style="border: 1px solid black; padding: 5px;">Adab</td>
                            <td style="border: 1px solid black; padding: 5px;text-align: center;">
                                {{ App\Models\PencapaianQuran::where('id_santri', $data[0]->id_santri)->where('id_tahun_ajaran', $data[0]->id_tahun_ajaran)->latest()->first()->adab }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="border: none; vertical-align: top; text-align: left; font-weight: bold;">
                Keterangan :
                <p>84 - 90 : Jayyid Jiddan / Sangat Baik</p>
                <p>79 - 83 : Jayyid / Baik</p>
                <p>75 - 78 : Maqbul / Cukup</p>
                <p>60 - 74 : Perlu Bimbingan</p>
            </td>
        </tr>
    </table>

    <table style="width: 90%">
        @foreach ($data as $item)
            <tr>
                <td>
                    <strong>{{ $item->kategori->kategori }}</strong>
                    <p>{{ $item->komentar }}</p>
                </td>
            </tr>
        @endforeach

    </table>

    <table style="border:none; width: 100%; margin-top: 30px; ">
        <tr>
            <td style="border:none; text-align: center; width: 25%;">
                <br>Orangtua/Wali<br><br><br><br><br><br>
                .........................
            </td>
            <td style="border:none;  text-align: center; width: 40%;">
                <br>Koordinator Qur’an<br><br><br><br><br><br>
                <u>Usth. Darma Herma Watik</u><br>
                NIPY.1999082320210720007
            </td>
            <td style="border:none;  width: 35%; ">
                <span style="text-align: left;">Merauke,{{ date('d F Y') }}</span><br>
                <span style="text-align: center;"> Kepala Sekolah</span><br><br><br><br><br><br>
                <span style="text-align: center;"><u>Ust. T. Vianney Angwarmase, S.Kom.</u><br>
                    NIPY. 1998030220210710006</span>
                </span>
            </td>
        </tr>
    </table>


</body>

</html>
