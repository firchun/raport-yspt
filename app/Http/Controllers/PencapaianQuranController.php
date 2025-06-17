<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PencapaianQuranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pencapaian Quran Santri',
        ];
        return view('admin.pencapaian_quran.index', $data);
    }
}