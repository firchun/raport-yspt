<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            ->addColumn('action_quran', function ($Santri) {
                return view('admin.penilaian_quran.components.actions', compact('Santri'));
            })
            ->addColumn('qr_code', function ($Santri) {
                $url = url('/santri/' . $Santri->code);
                return \QrCode::format('svg')->size(100)->generate($url) . '<br><a href="' . url('/santri', $Santri->code) . '" target="__blank" class="text-link">' . $Santri->code . '</a>';
            })

            ->rawColumns(['action', 'action_nilai', 'qr_code'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kamar' => 'required|string',
            'kelas' => 'required|string',
        ]);

        $SantriData = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'kamar' => $request->input('kamar'),
            'kelas' => $request->input('kelas'),
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