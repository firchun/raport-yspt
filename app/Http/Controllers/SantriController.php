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
    public function create()
    {
        $data = [
            'title' => 'Tambah Santri',
        ];
        return view('admin.santri.create', $data);
    }
    public function editView($id)
    {
        $santri = Santri::find($id);
        $data = [
            'title' => 'Edit Santri : ' . $santri->nama,
            'santri' => $santri,
        ];
        return view('admin.santri.edit', $data);
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
                return \QrCode::format('svg')->size(100)->generate($url) . '<br><a href="' . url('/raport-santri', $Santri->code) . '" target="__blank" class="text-link">' . $Santri->code . '</a>';
            })

            ->rawColumns(['action', 'action_nilai', 'qr_code'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kamar' => 'nullable|string',
            'kelas' => 'nullable|string',
            // tambahan
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'hobi' => 'nullable|string',
            'cita_cita' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'status_rumah' => 'nullable|string',
            'alamat_rumah' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nik_siswa' => 'nullable|string',
            'nisn' => 'nullable|string',
            'no_induk' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'pendidikan_ayah' => 'nullable|string',
            'no_hp_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'pendidikan_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string',
        ]);

        $SantriData = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat') ?? $request->input('alamat_rumah'),
            'kamar' => $request->input('kamar'),
            'kelas' => $request->input('kelas'),
            //tambahan
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'hobi' => $request->input('hobi'),
            'cita_cita' => $request->input('cita_cita'),
            'golongan_darah' => $request->input('golongan_darah'),
            'status_rumah' => $request->input('status_rumah'),
            'alamat_rumah' => $request->input('alamat_rumah'),
            'no_kk' => $request->input('no_kk'),
            'nik_siswa' => $request->input('nik_siswa'),
            'nisn' => $request->input('nisn'),
            'no_induk' => $request->input('no_induk'),
            'nama_ayah' => $request->input('nama_ayah'),
            'pekerjaan_ayah' => $request->input('pekerjaan_ayah'),
            'pendidikan_ayah' => $request->input('pendidikan_ayah'),
            'no_hp_ayah' => $request->input('no_hp_ayah'),
            'nama_ibu' => $request->input('nama_ibu'),
            'pekerjaan_ibu' => $request->input('pekerjaan_ibu'),
            'pendidikan_ibu' => $request->input('pendidikan_ibu'),
            'no_hp_ibu' => $request->input('no_hp_ibu'),

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