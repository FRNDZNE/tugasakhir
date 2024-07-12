<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;


class YearController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,staff')->except('index');
    }
    public function index()
    {
        $year = Year::all();
        return view('master.year',compact('year'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'name' => ucwords('kode'),
        ];

        $request->validate([
            'name' => 'required',
        ], $messages, $attributes);

        Year::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->name,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function delete($id)
    {
        Year::find($id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }
}
