<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Prodi;
use Auth;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,staff');
    }
    public function index()
    {
        if (Auth::user()->role->name == 'superadmin') {
            $data['score'] = Score::all();
            $data['prodi'] = Prodi::all();
        } else if (Auth::user()->role->name == 'admin') {
            $data['score'] = Score::all();
            $data['prodi'] = Prodi::all();
        } else if (Auth::user()->role->staff == 'staff') {
            $data['score'] = Score::whereHas();
        }

        return view('master.score',compact('data'));
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
