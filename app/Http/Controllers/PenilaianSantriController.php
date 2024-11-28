<?php

namespace App\Http\Controllers;

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

        // Redirect atau response setelah penyimpanan
        return redirect()->back()->with('success', 'Data penilaian berhasil disimpan.');
    }
    public function print(Request $request)
    {
        $id_santri = $request->input('id_santri');
        $id_tahun_ajaran = $request->input('id_tahun_ajaran');
        $data = PenilaianSantri::where('id_santri', $id_santri)->where('id_tahun_ajaran', $id_tahun_ajaran)->get();
        $pdf = PDF::loadView('admin.penilaian.print', compact('data'))->setPaper('A4', 'potrait');
        return $pdf->download('laporan-santri.pdf');
    }
}
