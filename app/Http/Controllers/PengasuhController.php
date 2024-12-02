<?php

namespace App\Http\Controllers;

use App\Models\Pengasuh;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengasuhController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Musyrif / Musyrifah',
        ];
        return view('admin.pengasuh.index', $data);
    }
    public function getPengasuhDataTable()
    {
        $Pengasuh = Pengasuh::orderByDesc('id');

        return DataTables::of($Pengasuh)
            ->addColumn('action', function ($Pengasuh) {
                return view('admin.pengasuh.components.actions', compact('Pengasuh'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $PengasuhData = [
            'nama' => $request->input('nama'),
        ];

        if ($request->filled('id')) {
            $Pengasuh = Pengasuh::find($request->input('id'));
            if (!$Pengasuh) {
                return response()->json(['message' => 'Pengasuh not found'], 404);
            }

            $Pengasuh->update($PengasuhData);
            $message = 'Pengasuh updated successfully';
        } else {
            Pengasuh::create($PengasuhData);
            $message = 'Pengasuh created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $Pengasuh = Pengasuh::find($id);

        if (!$Pengasuh) {
            return response()->json(['message' => 'Pengasuh not found'], 404);
        }

        $Pengasuh->delete();

        return response()->json(['message' => 'Pengasuh deleted successfully']);
    }
    public function edit($id)
    {
        $Pengasuh = Pengasuh::find($id);

        if (!$Pengasuh) {
            return response()->json(['message' => 'Pengasuh not found'], 404);
        }

        return response()->json($Pengasuh);
    }
}
