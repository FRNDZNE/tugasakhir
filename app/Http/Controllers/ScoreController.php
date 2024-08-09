<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Prodi;
use Auth;

class ScoreController extends Controller
{
    public function menu()
    {
        $prodi = Prodi::all();
        return view('score.prodi',compact('prodi'));
    }
    public function index($prodi)
    {
        $getProdi = Prodi::where('id',$prodi)->first();
        $data = Score::where('prodi_id',$prodi)->get();
        return view('score.score',compact('data','getProdi'));
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
            'weight' => ucfirst('penilaian')
        ];

        $request->validate([
            'name' => 'required',
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

    // For Admin

    public function admin_index($prodi)
    {
        // $role = Auth::user()->admin->jurusan->id;
        // $data['score'] = Score::whereHas('prodi', function($query) use ($role){
        //     $query->where('jurusan_id', $role);
        // })->where('prodi',$prodi)->get();
        $data['prodi'] = Prodi::where('id',$prodi)->first();
        $data['score'] = Score::where('prodi_id',$prodi)->get();
        return view('admin.master.score',compact('data'));
    }
    public function store_update($prodi, Request $request)
    {
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucfirst('tahun'),
            'weight' => ucfirst('penilaian'),
        ];

        $request->validate([
            'name' => 'required',
            'weight' => 'gt:0|required',
        ], $messages, $attributes);
        Score::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'prodi_id' => $prodi,
                'name' => $request->name,
                'weight' => $request->weight,
            ],
        );
        return redirect()->back()->with('success','Berhasil Menyimpan Data');
    }

    public function admin_delete($prodi, $id)
    {
        Score::find($id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }

}
