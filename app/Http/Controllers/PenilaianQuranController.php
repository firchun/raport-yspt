<?php

namespace App\Http\Controllers;

use App\Models\PencapaianQuran;
use App\Models\PengasuhQuran;
use App\Models\PenilaianQuran;
use App\Models\Santri;
use Illuminate\Http\Request;
use PDF;

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
        // Validasi sederhana
        $request->validate([
            'id_santri' => 'required',
            'id_kategori_quran' => 'required|array',
            'komentar' => 'nullable|array',
            'id_tahun_ajaran' => 'required', // Pastikan ini dikirim dari form
        ]);

        $id_santri = $request->id_santri; // sudah single value
        $id_kategori_quran = $request->id_kategori_quran; // array
        $komentar = $request->komentar; // array
        $id_tahun_ajaran = $request->id_tahun_ajaran;
        // dd($request->all());
        for ($i = 0; $i < count($id_kategori_quran); $i++) {
            PenilaianQuran::create([
                'id_kategori_quran' => $id_kategori_quran[$i],
                'id_santri' => $id_santri, // langsung single value
                'id_tahun_ajaran' => $id_tahun_ajaran,
                'komentar' => $komentar[$i],
            ]);
        }

        return redirect()->back()->with('success', 'Data penilaian Quran berhasil disimpan.');
    }

    public function storePencapaian(Request $request)
    {
        $request->validate([
            'id_tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'id_santri' => 'required|exists:santri,id',
            'id_pengasuh' => 'required|exists:pengasuh,id',
            'kelancaran' => 'required|in:Jayyid Jiddan,Jayyid,Maqbul,Perlu Bimbingan',
            'makhraj' => 'required|in:Jayyid Jiddan,Jayyid,Maqbul,Perlu Bimbingan',
            'tajwid' => 'required|in:Jayyid Jiddan,Jayyid,Maqbul,Perlu Bimbingan',
            'kegigihan' => 'required|in:Jayyid Jiddan,Jayyid,Maqbul,Perlu Bimbingan',
            'adab' => 'required|in:Jayyid Jiddan,Jayyid,Maqbul,Perlu Bimbingan',
        ]);

        $pencapaian = PencapaianQuran::create([
            'id_tahun_ajaran' => $request->id_tahun_ajaran,
            'id_santri' => $request->id_santri,
            'kelancaran' => $request->kelancaran,
            'makhraj' => $request->makhraj,
            'tajwid' => $request->tajwid,
            'kegigihan' => $request->kegigihan,
            'adab' => $request->adab,
        ]);
        // Simpan data pengasuh Quran
        PengasuhQuran::updateOrCreate(
            [
                'id_tahun_ajaran' => $request->id_tahun_ajaran,
                'id_santri' => $request->id_santri,
                'id_pengasuh' => $request->id_pengasuh,
            ]
        );

        return back()->with('success', 'Pencapaian Quran berhasil disimpan.');
    }
    public function getKomentar($id, $id_santri)
    {
        $komentar = PenilaianQuran::where('id_tahun_ajaran', $id)->where('id_santri', $id_santri)->get();
        return response()->json(['id_komentar' => $id, 'komentar' => $komentar]);
    }
    public function print(Request $request)
    {
        $id_santri = $request->input('id_santri');
        $id_tahun_ajaran = $request->input('id_tahun_ajaran');

        // Cek apakah `id_santri` diberikan
        if ($id_santri) {
            // Jika `id_santri` diberikan, ambil data untuk santri tertentu
            $data = PenilaianQuran::where('id_santri', $id_santri)
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->get()
                ->unique('id_kategori_quran')
                ->values();
        } else {
            // Jika tidak, ambil data semua santri berdasarkan tahun ajaran
            $data = PenilaianQuran::where('id_tahun_ajaran', $id_tahun_ajaran)
                ->get()
                ->unique('id_kategori_quran')
                ->values();
        }

        // Muat view dan buat PDF
        $pdf = PDF::loadView('admin.penilaian_quran.print', compact('data'))->setPaper([0, 0, 595, 935], 'portrait');

        // Unduh PDF
        return $pdf->download('laporan-santri.pdf');
        // return $pdf->stream('laporan-santri.pdf');
    }
}