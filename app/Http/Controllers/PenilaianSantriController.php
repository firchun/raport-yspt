<?php

namespace App\Http\Controllers;

use App\Models\KomentarPenilaian;
use App\Models\PengasuhPenilaian;
use App\Models\PenilaianSantri;
use App\Models\Santri;
use Illuminate\Http\Request;
use PDF;

class PenilaianSantriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Penilaian Santri',
        ];
        return view('admin.penilaian.index', $data);
    }
    public function report($id_santri)
    {
        $santri = Santri::findOrFail($id_santri);
        $data = [
            'title' => 'Laporan Santri : ' . $santri->nama,
            'santri' => $santri
        ];
        return view('admin.penilaian.report', $data);
    }
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_pengasuh' => 'required|integer',
            'id_tahun_ajaran' => 'required|integer',
            'id_kategori' => 'required|array',
            'id_kategori.*' => 'integer',
            'id_santri' => 'required|integer',
            'id_point' => 'required|array',
            'id_point.*' => 'integer',
            'nilai' => 'required|array',
            'nilai.*' => 'integer|min:1|max:3',
        ]);

        // Proses penyimpanan data
        $idPengasuh = $request->input('id_pengasuh');
        $idTahunAjaran = $request->input('id_tahun_ajaran');
        $idKategori = $request->input('id_kategori');
        $idSantri = $request->input('id_santri');
        $idPoint = $request->input('id_point');
        $nilai = $request->input('nilai');

        // Looping untuk menyimpan tiap data ke database
        foreach ($idPoint as $key => $pointId) {
            PenilaianSantri::create([
                'id_tahun_ajaran' => $idTahunAjaran,
                'id_santri' => $idSantri,
                'id_kategori' => $idKategori[$key],
                'id_point' => $pointId,
                'nilai' => $nilai[$key],
            ]);
        }
        PengasuhPenilaian::create([
            'id_tahun_ajaran' => $idTahunAjaran,
            'id_santri' => $idSantri,
            'id_pengasuh' => $idPengasuh,
        ]);

        // Redirect atau response setelah penyimpanan
        return redirect()->back()->with('success', 'Data penilaian berhasil disimpan.');
    }
    public function storeKomentar(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_santri' => 'required|integer',
            'id_tahun_ajaran' => 'required|integer',
            'komentar' => 'required|array',
            'komentar.*' => 'nullable|string',
        ]);

        // Ambil data dari request
        $idSantri = $request->input('id_santri');
        $idTahunAjaran = $request->input('id_tahun_ajaran');
        $komentarArray = $request->input('komentar');
        $kategoriArray = $request->input('id_kategori');

        // Simpan data ke database
        if (is_array($kategoriArray) && is_array($komentarArray) && count($kategoriArray) === count($komentarArray)) {
            foreach ($komentarArray as $index => $komentar) {
                // Hanya proses jika `id_kategori` ada
                if (isset($kategoriArray[$index])) {
                    KomentarPenilaian::create([
                        'id_santri' => $idSantri,
                        'id_tahun_ajaran' => $idTahunAjaran,
                        'id_kategori' => $kategoriArray[$index],
                        'komentar' => $komentar,
                    ]);
                }
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }
    public function getKomentar($id, $id_santri)
    {
        $komentar = KomentarPenilaian::where('id_tahun_ajaran', $id)->where('id_santri', $id_santri)->get();
        return response()->json(['id_komentar' => $id, 'komentar' => $komentar]);
    }

    public function updateKomentar(Request $request)
    {
        $request->validate([
            'id_komentar' => 'required|array',
            'id_kategori' => 'required|array',
            'komentar' => 'required|array',
        ]);

        foreach ($request->id_komentar as $index => $id_komentar) {
            $komentarPenilaian = KomentarPenilaian::find($id_komentar);

            if ($komentarPenilaian) {
                $komentarPenilaian->update(['komentar' => $request->komentar[$index]]);
            }
        }

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui!');
    }

    public function getPenilaian($id)
    {
        $penilaian = PenilaianSantri::where('id_tahun_ajaran', $id)->get();
        return response()->json(['penilaian' => $penilaian]);
    }

    public function updatePenilaian(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_point' => 'required|array',
            'nilai' => 'required|array',
            // 'id_pengasuh' => 'required',
            'id_santri' => 'required',
        ]);
        $id_santri = $request->id_santri;
        foreach ($request->id_point as $index => $id_point) {
            // Update tabel penilaian_santri
            PenilaianSantri::where('id_point', $id_point)
                ->update(['nilai' => $request->nilai[$index]]);

            // Update atau insert di tabel pengasuh_penilaian
            // PengasuhPenilaian::updateOrCreate(
            //     [
            //         'id_santri' => $id_santri, // Kondisi untuk mencari data
            //     ],
            //     [
            //         'id_pengasuh' => $request->id_pengasuh, // Data yang akan diupdate atau diinsert
            //     ]
            // );
        }

        return redirect()->back()->with('success', 'Penilaian berhasil diperbarui!');
    }
    // public function print(Request $request)
    // {
    //     $id_santri = $request->input('id_santri');
    //     $id_tahun_ajaran = $request->input('id_tahun_ajaran');
    //     $data = PenilaianSantri::where('id_santri', $id_santri)->where('id_tahun_ajaran', $id_tahun_ajaran)->get();
    //     $pdf = PDF::loadView('admin.penilaian.print', compact('data'))->setPaper('A4', 'potrait');
    //     return $pdf->download('laporan-santri.pdf');
    // }
    public function print(Request $request)
    {
        $id_santri = $request->input('id_santri');
        $id_tahun_ajaran = $request->input('id_tahun_ajaran');

        // Cek apakah `id_santri` diberikan
        if ($id_santri) {
            // Jika `id_santri` diberikan, ambil data untuk santri tertentu
            $data = PenilaianSantri::where('id_santri', $id_santri)
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->get();
        } else {
            // Jika tidak, ambil data semua santri berdasarkan tahun ajaran
            $data = PenilaianSantri::where('id_tahun_ajaran', $id_tahun_ajaran)->get();
        }

        // Muat view dan buat PDF
        $pdf = PDF::loadView('admin.penilaian.print', compact('data'))->setPaper('A4', 'portrait');

        // Unduh PDF
        return $pdf->download('laporan-santri.pdf');
    }
}
