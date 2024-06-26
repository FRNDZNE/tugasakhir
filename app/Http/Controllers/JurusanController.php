<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('superadmin.master.jurusan',compact('jurusan'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucfirst('kode'),
            'display' => ucwords('nama jurusan'),
        ];

        $request->validate([
            'name' => 'required',
            'display' => 'required',
        ], $messages, $attributes);

        // Proses Simpan Data
        $jurusan = new Jurusan;
        $jurusan->name = $request->name;
        $jurusan->display_name = $request->display;
        $jurusan->save();
        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucwords('kode'),
            'display' => ucwords('nama jurusan'),
        ];

        $request->validate([
            'name' => 'required',
            'display' => 'required',
        ], $messages, $attributes);

        Jurusan::updateOrCreate(
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

    public function delete($id)
    {
        Jurusan::find($id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }
}
