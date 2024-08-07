<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\ScoreValue;
use App\Models\Intern;
use Auth;

class ScoreValueController extends Controller
{
    // Controller yang digunakan untuk mengisi nilai prakerin

    public function index($intern)
    {
        $magang = Intern::where('id',$intern)->first();
        $prodi = $magang->mahasiswa->prodi_id;
        $score = Score::where('prodi_id', $prodi)->get();
        return view('agency.mentor.nilai',compact('score','magang'));
    }

    public function store($intern, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'numeric' => ucwords(':attribute harus berupa angka'),
        ];

        $attributes = [
            'nilai' => ucfirst('nilai'),
        ];

        $request->validate([
            'nilai' => 'required|numeric',
        ], $messages, $attributes);

        ScoreValue::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'score_id' => $request->score_id,
                'intern_id' => $intern,
                'value' => $request->nilai,
            ]
        );

        return redirect()->back()->with('success','Berhasil Memasukan Nilai');



    }


}
