<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SantriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Santri',
        ];
        return view('admin.santri.index', $data);
    }
    public function getSantriDataTable()
    {

        $santri = Santri::orderByDesc('id');

        return DataTables::of($santri)
            ->addColumn('action', function ($Santri) {
                return view('admin.santri.components.actions', compact('Santri'));
            })
            ->addColumn('action_nilai', function ($Santri) {
                return view('admin.penilaian.components.actions', compact('Santri'));
            })

            ->rawColumns(['action', 'action_nilai'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $SantriData = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
        ];

        if ($request->filled('id')) {
            $Santri = Santri::find($request->input('id'));
            if (!$Santri) {
                return response()->json(['message' => 'Santri not found'], 404);
            }

            $Santri->update($SantriData);
            $message = 'Santri updated successfully';
        } else {
            Santri::create($SantriData);
            $message = 'Santri created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $santri = Santri::find($id);

        if (!$santri) {
            return response()->json(['message' => 'Santri not found'], 404);
        }

        $santri->delete();

        return response()->json(['message' => 'Santri deleted successfully']);
    }
    public function edit($id)
    {
        $Santri = Santri::find($id);

        if (!$Santri) {
            return response()->json(['message' => 'Santri not found'], 404);
        }

        return response()->json($Santri);
    }
}