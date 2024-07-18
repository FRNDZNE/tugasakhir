<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Period;
use App\Models\Prodi;
use Auth;

class PeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,staff')->except('index');
    }
    public function index($year)
    {
        $data['year'] = Year::where('id', $year)->first();
        $data['period'] = Period::where('year_id',$year)->get();
        if (Auth::user()->role->name == 'superadmin') {
            $data['prodi'] = Prodi::all();
        } else if (Auth::user()->role->name == 'admin') {
            $data['prodi'] = Prodi::where('jurusan_id', Auth::user()->admin->jurusan->id)->get();
        } else if (Auth::user()->role->name == 'staff') {
            $data['period'] = Period::where('year_id', $year)
            ->where('prodi_id', Auth::user()->staff->prodi->id)
            ->get();

        }
        return view('master.period',compact('data'));
    }

    public function store($year, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong'),
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

        $prodi = Auth::user()->role->name == 'staff' ? Auth::user()->staff->prodi->id : $request->prodi;
        Period::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'year_id' => $year,
                'prodi_id' => $prodi,
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
