<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Prodi;

class ScoreController extends Controller
{
    public function index()
    {
        $data['prodi'] = Prodi::all();
        $data['score'] = Score::all();
        return view('superadmin.master.score',compact('data'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucfirst('tahun'),
            'prodi' => ucfirst('prodi'),
            'weight' => ucfirst('penilaian')
        ];

        $request->validate([
            'name' => 'required',
            'prodi' => 'gt:0',
            'weight' => 'gt:0|required',
        ], $messages, $attributes);

        // Proses Simpan Data
        $score = new Score;
        $score->name = $request->name;
        $score->prodi_id = $request->prodi;
        $score->weight = $request->weight;
        $score->save();
        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucfirst('tahun'),
            'prodi' => ucfirst('prodi'),
            'weight' => ucfirst('penilaian')
        ];

        $request->validate([
            'name' => 'required',
            'prodi' => 'gt:0',
            'weight' => 'gt:0|required',
        ], $messages, $attributes);

        Score::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->name,
                'prodi_id' => $request->prodi,
                'weight' => $request->weight,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function delete($id)
    {
        Score::find($id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }
}
