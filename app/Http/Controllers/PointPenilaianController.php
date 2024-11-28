<?php

namespace App\Http\Controllers;

use App\Models\PointPenilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PointPenilaianController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori Penilaian',
        ];
        return view('admin.point.index', $data);
    }
    public function getPointDataTable()
    {
        $PointPenilaian = PointPenilaian::with(['kategori'])->orderByDesc('id');

        return DataTables::of($PointPenilaian)
            ->addColumn('action', function ($PointPenilaian) {
                return view('admin.point.components.actions', compact('PointPenilaian'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'point' => 'required|string',
        ]);

        $PointPenilaianData = [
            'id_kategori' => $request->input('id_kategori'),
            'point' => $request->input('point'),
        ];

        if ($request->filled('id')) {
            $PointPenilaian = PointPenilaian::find($request->input('id'));
            if (!$PointPenilaian) {
                return response()->json(['message' => 'PointPenilaian not found'], 404);
            }

            $PointPenilaian->update($PointPenilaianData);
            $message = 'PointPenilaian updated successfully';
        } else {
            PointPenilaian::create($PointPenilaianData);
            $message = 'PointPenilaian created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $PointPenilaian = PointPenilaian::find($id);

        if (!$PointPenilaian) {
            return response()->json(['message' => 'PointPenilaian not found'], 404);
        }

        $PointPenilaian->delete();

        return response()->json(['message' => 'PointPenilaian deleted successfully']);
    }
    public function edit($id)
    {
        $PointPenilaian = PointPenilaian::find($id);

        if (!$PointPenilaian) {
            return response()->json(['message' => 'PointPenilaian not found'], 404);
        }

        return response()->json($PointPenilaian);
    }
}