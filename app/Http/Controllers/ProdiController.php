<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function index($jurusan)
    {
        $data['jurusan'] = Jurusan::where('id', $jurusan)->first();
        $data['prodi'] = Prodi::where('jurusan_id',$jurusan)->get();
        return view('superadmin.master.prodi',compact('data'));
    }

    public function store($jurusan, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucfirst('kode'),
            'display' => ucwords('nama prodi'),
        ];

        $request->validate([
            'name' => 'required',
            'display' => 'required',
        ], $messages, $attributes);

        // Proses Simpan Data
        $prodi = new Prodi;
        $prodi->jurusan_id = $jurusan;
        $prodi->name = $request->name;
        $prodi->display_name = $request->display;
        $prodi->save();
        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update($jurusan, Request $request)
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
