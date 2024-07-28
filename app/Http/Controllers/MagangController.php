<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Quota;
use App\Models\Intern;
use Illuminate\Http\Request;
class MagangController extends Controller
{
    // POV Mahasiswa Daftar
    public function index()
    {
        $prodi = Auth::user()->mahasiswa->prodi_id;
        $year = Auth::user()->mahasiswa->year_id;
        $data = Quota::select('quotas.*', DB::raw('count(it.id) as intern_count'))
            ->whereHas('period', function($query) use ($year, $prodi) {
            $query->where('prodi_id', $prodi)
            ->whereHas('year', function($query) use ($year){
                $query->where('year_id', $year);
            });
        })
        ->with(['agency'])
        ->join('agencies as ag', 'ag.id', '=', 'quotas.agency_id')
        ->leftJoin('interns as it', function($join) {
            $join->on('it.agency_id', '=', 'quotas.agency_id');
            $join->on('it.period_id', '=', 'quotas.period_id');
            $join->where('it.status', 'a');
        })
        ->groupBy('quotas.id')
        ->groupBy('quotas.agency_id')
        ->groupBy('quotas.period_id')
        ->get();

        // return $data;

        return view('mahasiswa.magang',compact('data'));
    }

    public function apply(Request $request)
    {
        $kuota = Quota::where('agency_id', $request->mitra)
            ->where('period_id', $request->period)
            ->first();

        $accepted = Intern::where('period_id', $request->period)
            ->where('agency_id', $request->mitra)
            ->where('status', 'a')
            ->count();

        if ($kuota->total - $accepted == 0) {
            return redirect()->back()->with('error', 'Kuota sudah penuh');
        }

        $user = Auth::user()->mahasiswa->intern();

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
