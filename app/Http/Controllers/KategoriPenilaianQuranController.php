<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaianQuran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriPenilaianQuranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Aspek Penilaian Quran',
        ];
        return view('admin.kategori_quran.index', $data);
    }
    public function getKategoriDataTable()
    {
        $KategoriPenilaianQuran = KategoriPenilaianQuran::orderByDesc('id');

        return DataTables::of($KategoriPenilaianQuran)
            ->addColumn('action', function ($KategoriPenilaianQuran) {
                return view('admin.kategori_quran.components.actions', compact('KategoriPenilaianQuran'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        $KategoriPenilaianQuranData = [
            'kategori' => $request->input('kategori'),
        ];

        if ($request->filled('id')) {
            $KategoriPenilaianQuran = KategoriPenilaianQuran::find($request->input('id'));
            if (!$KategoriPenilaianQuran) {
                return response()->json(['message' => 'KategoriPenilaianQuran not found'], 404);
            }

            $KategoriPenilaianQuran->update($KategoriPenilaianQuranData);
            $message = 'KategoriPenilaianQuran updated successfully';
        } else {
            KategoriPenilaianQuran::create($KategoriPenilaianQuranData);
            $message = 'KategoriPenilaianQuran created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $KategoriPenilaianQuran = KategoriPenilaianQuran::find($id);

        if (!$KategoriPenilaianQuran) {
            return response()->json(['message' => 'KategoriPenilaianQuran not found'], 404);
        }

        $KategoriPenilaianQuran->delete();

        return response()->json(['message' => 'KategoriPenilaianQuran deleted successfully']);
    }
    public function edit($id)
    {
        $KategoriPenilaianQuran = KategoriPenilaianQuran::find($id);

        if (!$KategoriPenilaianQuran) {
            return response()->json(['message' => 'KategoriPenilaianQuran not found'], 404);
        }

        return response()->json($KategoriPenilaianQuran);
    }
}