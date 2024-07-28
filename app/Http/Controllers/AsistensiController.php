<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assistance;
use Auth;

class AsistensiController extends Controller
{
    // path mahasiswa
    public function index()
    {
        $user = Auth::user()->mahasiswa->intern->id;
        $data = Assistance::where('intern_id', $user)->get();
        return view('mahasiswa.assistance',compact('data'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'topic' => ucwords('Topik Bimbingan'),
            'date' => ucwords('Tanggal'),
        ];

        $request->validate([
            'topic' => 'required',
            'date' => 'required',
        ], $messages, $attributes);

        $user = Auth::user()->mahasiswa->intern->id;
        $asistensi = Assistance::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'intern_id' => $user,
                'topic' => $request->topic,
                'date' => $request->date,
            ]
        );

        // Assuming 'status' is a field in your database that gets updated
        if ($asistensi->wasRecentlyCreated) {
            return redirect()->back()->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect()->back()->with('success', 'Berhasil Mengubah Data');
        }
    }

    public function delete($id)
    {
        Assistance::where('id', $id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }

    public function confirmed(Request $request)
    {
        Assistance::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'status' => true,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }

    public function unconfirmed(Request $request)
    {
        Assistance::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'status' => false,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }

    // Path Dosen

}
