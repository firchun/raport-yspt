<?php

namespace App\Http\Controllers;

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
                $penilaian = PenilaianSantri::where('id_tahun_ajaran', $TahunAjaran->id)->count();
                if ($penilaian <= 0) {
                    return ' <button class="btn btn-sm btn-primary" onclick="editCustomer(' . $TahunAjaran->id . ')">Update Laporan</button>';
                } else {
                    return ' <button class="btn btn-sm btn-danger" onclick="printCustomer(' . $TahunAjaran->id . ',' . $id_santri . ')"><i class="bi bi-file-pdf"></i> Download Laporan</button>';
                }
            })

            ->rawColumns(['action', 'action_report'])
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
