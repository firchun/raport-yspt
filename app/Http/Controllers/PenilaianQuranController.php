<?php

namespace App\Http\Controllers;

use App\Models\PengasuhQuran;
use App\Models\PenilaianQuran;
use App\Models\Santri;
use Illuminate\Http\Request;

class PenilaianQuranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Penilaian Quran Santri',
        ];
        return view('admin.penilaian_quran.index', $data);
    }
    public function report($id_santri)
    {
        $santri = Santri::findOrFail($id_santri);
        $data = [
            'title' => 'Laporan Quran Santri : ' . $santri->nama,
            'santri' => $santri
        ];
        return view('admin.penilaian_quran.report', $data);
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_pengasuh' => 'required|integer|exists:pengasuh,id',
            'id_tahun_ajaran' => 'required|integer|exists:tahun_ajaran,id',
            'id_santri' => 'required|integer|exists:santri,id',
            'id_kategori' => 'required|array',
            'id_kategori.*' => 'integer',
            'nilai' => 'required|array',
            'nilai.*' => 'integer|min:0|max:3',
        ]);

        $idPengasuh = $request->input('id_pengasuh');
        $idTahunAjaran = $request->input('id_tahun_ajaran');
        $idSantri = $request->input('id_santri');
        $idKategori = $request->input('id_kategori');
        $nilai = $request->input('nilai');

        // Simpan setiap nilai ke tabel PenilaianQuran
        foreach ($idKategori as $key => $idKategori) {
            PenilaianQuran::create([
                'id_tahun_ajaran' => $idTahunAjaran,
                'id_santri' => $idSantri,
                'id_kategori_quran' => $idKategori[$key],
                'komentar' => $nilai[$key],
            ]);
        }

        // Simpan data pengasuh Quran
        PengasuhQuran::updateOrCreate(
            [
                'id_tahun_ajaran' => $idTahunAjaran,
                'id_santri' => $idSantri,
                'id_pengasuh' => $idPengasuh,
            ]
        );

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
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
}