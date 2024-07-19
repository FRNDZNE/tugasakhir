<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quota;
use App\Models\Intern;
use Auth;
use DB;
class MagangController extends Controller
{
    public function index()
    {
        $prodi = Auth::user()->mahasiswa->prodi_id;
        $year = Auth::user()->mahasiswa->year_id;
        $data = Quota::whereHas('period', function($query) use ($year, $prodi) {
            $query->where('prodi_id', $prodi)
            ->whereHas('year', function($query) use ($year){
                $query->where('year_id', $year);
            });
        })->get();
        return view('mahasiswa.magang',compact('data'));
    }

    public function apply(Request $request)
    {
        Intern::create([
            'agency_id' => $request->mitra,
            'period_id' => $request->period,
            'mahasiswa_id' => $request->mahasiswa,
        ]);
        return redirect()->back()->with('success','Berhasil Mengajukan Tempat PKL');
    }

    public function myIntern()
    {
        $data = Intern::where('mahasiswa_id', Auth::user()->mahasiswa->id)->first();
        // return $data;
        return view('mahasiswa.detail',compact('data'));
    }


}
