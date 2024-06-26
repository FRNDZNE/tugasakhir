<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Period;
use App\Models\Prodi;

class PeriodController extends Controller
{
    public function index($year)
    {
        $data['year'] = Year::where('id', $year)->first();
        $data['period'] = Period::where('year_id',$year)->get();
        $data['prodi'] = Prodi::all();
        return view('superadmin.master.period',compact('data'));
    }

    public function store($year, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !')
        ];

        $attributes = [
            'prodi' => ucwords('program studi'),
            'start' => ucfirst('mulai'),
            'end' => ucfirst('selesai'),
        ];

        $request->validate([
            'prodi' => 'gt:0',
            'start' => 'required',
            'end' => 'required',
        ], $messages, $attributes);

        // Proses Simpan Data
        $period = new Period;
        $period->prodi_id = $request->prodi;
        $period->year_id = $year;
        $period->start = $request->start;
        $period->end = $request->end;
        $period->save();
        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update($year, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'prodi' => ucwords('program studi'),
            'start' => ucfirst('mulai'),
            'end' => ucfirst('selesai'),
        ];

        $request->validate([
            'prodi' => 'gt:0',
            'start' => 'required',
            'end' => 'required',
        ], $messages, $attributes);

        Period::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'year_id' => $year,
                'prodi_id' => $request->prodi,
                'start' => $request->start,
                'end' => $request->end,
            ]
        );

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function delete($year, $id)
    {
        Period::find($id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }
}
