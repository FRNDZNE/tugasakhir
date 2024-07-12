<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Prodi;
use Auth;

class ProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin,admin'])->except('index');
    }
    public function index($jurusan)
    {
        $data['jurusan'] = Jurusan::where('id', $jurusan)->first();
        if (Auth::user()->role->name == 'superadmin') {
            $data['prodi'] = Prodi::where('jurusan_id', $jurusan)->get();
        }else if (Auth::user()->role->name == 'admin') {
            $data['prodi'] = Prodi::where('jurusan_id', Auth::user()->admin->jurusan->id)->get();
        }

        return view('master.prodi',compact('data'));
    }


    public function store($jurusan, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucwords('kode'),
            'display' => ucwords('nama prodi'),
        ];

        $request->validate([
            'name' => 'required',
            'display' => 'required',
        ], $messages, $attributes);

        Prodi::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->name,
                'jurusan_id' => $jurusan,
                'display_name' => $request->display,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function delete($jurusan, $prodi)
    {
        Prodi::find($prodi)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }

}
