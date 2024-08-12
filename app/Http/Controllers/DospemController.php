<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Period;
use App\Models\Intern;
use App\Models\User;
use Auth;

class DospemController extends Controller
{
    // Controller Untuk Staff
    public function index_year()
    {
        $year = Year::all();
        return view('staff.dospem.year',compact('year'));
    }

    public function index_period($year)
    {
        $tahun = Year::where('id', $year)->first();
        $prodi = Auth::user()->staff->prodi->id;
        $period = Period::where('year_id', $year)->where('prodi_id', $prodi)->get();
        return view('staff.dospem.period',compact('tahun','period'));
    }

    public function index($year, $period)
    {
        $tahun = Year::where('id', $year)->first();
        $prodi = Auth::user()->staff->prodi->id;
        $periode = Period::where('id', $period)->first();
        $intern = Intern::where('period_id', $periode->id)
        ->where('status','a')
        ->orderBy('agency_id')
        ->get();
        $dosen = User::whereHas('dosen', function($q) use ($prodi) {
            $q->whereHas('prodi', function($e) use ($prodi) {
                $e->where('prodi_id', $prodi);
            });
            })->with(['dosen.prodi' => function($e) use ($prodi) {
                $e->where('prodi_id', $prodi);
            }])->get();
        return view('staff.dospem.index',compact('tahun','periode','intern','dosen'));
    }

    public function store_dospem($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->dosen_id = $request->dosen;
        $intern->save();

        return redirect()->back()->with('success','Berhasil Memilih Dosen Pembimbing');
    }
}
