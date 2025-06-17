<?php

namespace App\Http\Controllers;

use App\Models\KomentarPenilaian;
use App\Models\PenilaianQuran;
use App\Models\PenilaianSantri;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Tahun Ajaran',
        ];
        return view('admin.tahun_ajaran.index', $data);
    }
    public function getTahunAjaranDataTable(Request $request)
    {
        $TahunAjaran = TahunAjaran::orderByDesc('id');
        $id_santri = $request->input('id_santri');

        return DataTables::of($TahunAjaran)
            ->addColumn('action', function ($TahunAjaran) {
                return view('admin.tahun_ajaran.components.actions', compact('TahunAjaran'));
            })
            ->addColumn('action_report', function ($TahunAjaran) use ($id_santri) {
                $output = '';

                // Cek ID tahun ajaran terbaru
                $latestTahunAjaranId = TahunAjaran::max('id');

                // Cek penilaian
                $penilaian = PenilaianSantri::where('id_tahun_ajaran', $TahunAjaran->id)
                    ->where('id_santri', $id_santri)
                    ->count();

                // Cek komentar
                $komentar = KomentarPenilaian::where('id_tahun_ajaran', $TahunAjaran->id)
                    ->where('id_santri', $id_santri)
                    ->count();

                // Jika data tahun ajaran TERBARU
                if ($TahunAjaran->id == $latestTahunAjaranId) {
                    if ($penilaian <= 0) {
                        $output .= '<button class="btn btn-sm btn-primary" onclick="editCustomer(' . $TahunAjaran->id . ')">Tambah Penilaian</button> ';
                    }

                    if ($komentar <= 0) {
                        $output .= '<button class="btn btn-sm btn-warning" onclick="komentarCustomer(' . $TahunAjaran->id . ', ' . $id_santri . ')">Tambah Komentar</button>';
                    } else {
                        $output .= '<button class="btn btn-sm btn-info" onclick="editKomentar(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-pencil-square"></i> Edit Komentar</button>';
                    }

                    if ($penilaian > 0) {
                        $output .= ' <button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button>';
                    }
                }
                // Jika BUKAN data terbaru
                else {
                    if ($penilaian > 0) {
                        $output .= '<button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button>';
                    } else {
                        $output .= '<span class="text-muted">-</span>';
                    }
                }

                return $output;
            })
            ->addColumn('action_quran', function ($TahunAjaran) use ($id_santri) {
                $output = '';

                // Cek ID tahun ajaran terbaru
                $latestTahunAjaranId = TahunAjaran::max('id');

                // Cek penilaian
                $penilaian = PenilaianQuran::where('id_tahun_ajaran', $TahunAjaran->id)
                    ->where('id_santri', $id_santri)
                    ->count();

                // Cek komentar
                $komentar = KomentarPenilaian::where('id_tahun_ajaran', $TahunAjaran->id)
                    ->where('id_santri', $id_santri)
                    ->count();

                // Jika data tahun ajaran TERBARU
                if ($TahunAjaran->id == $latestTahunAjaranId) {
                    if ($penilaian <= 0) {
                        $output .= '<button class="btn btn-sm btn-primary" onclick="editCustomer(' . $TahunAjaran->id . ')">Pencapaian Quran</button> ';
                    }

                    if ($komentar <= 0) {
                        $output .= '<button class="btn btn-sm btn-warning" onclick="komentarCustomer(' . $TahunAjaran->id . ', ' . $id_santri . ')">Komentar</button>';
                    } else {
                        $output .= '<button class="btn btn-sm btn-info" onclick="editKomentar(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-pencil-square"></i> Edit Komentar</button>';
                    }

                    if ($penilaian > 0) {
                        $output .= ' <button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button>';
                    }
                } else {
                    if ($penilaian > 0) {
                        $output .= '<button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button>';
                    } else {
                        $output .= '-';
                    }
                }

                return $output;
            })
            ->addColumn('action_all_report', function ($TahunAjaran) use ($id_santri) {
                $output = '';

                $output .= '<button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button> ';

                return $output;
            })
            ->rawColumns(['action', 'action_report', 'action_quran', 'action_all_report'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:255',
            'semester' => 'required|string',
        ]);

        $TahunAjaranData = [
            'tahun' => $request->input('tahun'),
            'semester' => $request->input('semester'),
        ];

        if ($request->filled('id')) {
            $TahunAjaran = TahunAjaran::find($request->input('id'));
            if (!$TahunAjaran) {
                return response()->json(['message' => 'TahunAjaran not found'], 404);
            }

            $TahunAjaran->update($TahunAjaranData);
            $message = 'TahunAjaran updated successfully';
        } else {
            TahunAjaran::create($TahunAjaranData);
            $message = 'TahunAjaran created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $TahunAjaran = TahunAjaran::find($id);

        if (!$TahunAjaran) {
            return response()->json(['message' => 'TahunAjaran not found'], 404);
        }

        $TahunAjaran->delete();

        return response()->json(['message' => 'TahunAjaran deleted successfully']);
    }
    public function edit($id)
    {
        $TahunAjaran = TahunAjaran::find($id);

        if (!$TahunAjaran) {
            return response()->json(['message' => 'TahunAjaran not found'], 404);
        }

        return response()->json($TahunAjaran);
    }
}