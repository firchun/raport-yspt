<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriPenilaianController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori Penilaian',
        ];
        return view('admin.kategori.index', $data);
    }
    public function getKategoriDataTable()
    {
        $KategoriPenilaian = KategoriPenilaian::orderByDesc('id');

        return DataTables::of($KategoriPenilaian)
            ->addColumn('action', function ($KategoriPenilaian) {
                return view('admin.kategori.components.actions', compact('KategoriPenilaian'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        $KategoriPenilaianData = [
            'kategori' => $request->input('kategori'),
        ];

        if ($request->filled('id')) {
            $KategoriPenilaian = KategoriPenilaian::find($request->input('id'));
            if (!$KategoriPenilaian) {
                return response()->json(['message' => 'KategoriPenilaian not found'], 404);
            }

            $KategoriPenilaian->update($KategoriPenilaianData);
            $message = 'KategoriPenilaian updated successfully';
        } else {
            KategoriPenilaian::create($KategoriPenilaianData);
            $message = 'KategoriPenilaian created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $KategoriPenilaian = KategoriPenilaian::find($id);

        if (!$KategoriPenilaian) {
            return response()->json(['message' => 'KategoriPenilaian not found'], 404);
        }

        $KategoriPenilaian->delete();

        return response()->json(['message' => 'KategoriPenilaian deleted successfully']);
    }
    public function edit($id)
    {
        $KategoriPenilaian = KategoriPenilaian::find($id);

        if (!$KategoriPenilaian) {
            return response()->json(['message' => 'KategoriPenilaian not found'], 404);
        }

        return response()->json($KategoriPenilaian);
    }
}