<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Intern;
use App\Models\Year;
use App\Models\Period;
use Auth;

class BimbinganController extends Controller
{
    public function index_year()
    {
        $year = Year::all();
        return view('staff.dospem.year',compact('year'));
    }

    public function index_period($year)
    {
        $user = Auth::user()->dosen->prodi->pluck('id')->toArray();
        $tahun = Year::where('id', $year)->first();
        $period = Period::where('year_id', $year)
        ->whereHas('prodi', function($q) use ($user){
            $q->whereIn('id', $user);
        })
        ->with('prodi')
        ->get();
        return view('dosen.bimbingan.period',compact('tahun','period'));
    }

    public function index($year, $period)
    {
        $tahun = Year::where('id', $year)->first();
        $periode = Period::where('id', $period)->first();
        $dosen = Auth::user()->dosen->id;
        $intern = Intern::where('period_id', $periode->id)
        ->where('dosen_id',$dosen)
        ->where('status','a')
        ->orderBy('agency_id')
        ->get();
        return view('dosen.bimbingan.index',compact('tahun','periode','intern'));
    }

    public function detail($intern)
    {
        $magang = Intern::where('id',$id)->first();
        return view('dosen.intern.detail',compact('magang'));

    }


}
