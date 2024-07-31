<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Period;
use App\Models\Intern;
use App\Models\Mentor;
use Auth;

class SeleksiController extends Controller
{
    public function index_year()
    {
        $year = Year::all();
        return view('agency.seleksi.year',compact('year'));
    }

    public function index_period($year)
    {
        $tahun = Year::where('id',$year)->first();
        $period = Period::where('year_id', $year)->get();
        return view('agency.seleksi.period',compact('period','tahun'));
    }

    public function index($year, $period)
    {
        $tahun = Year::where('id',$year)->first();
        $periode = Period::where('id',$period)->first();
        $agency = Auth::user()->agency->id;
        $intern = Intern::where('period_id', $period)
        ->where('agency_id', $agency)
        ->with('mahasiswa')
        ->withTrashed()
        ->get();
        $mentor = Mentor::where('agency_id', $agency)->get();
        return view('agency.seleksi.index',compact('intern','tahun','periode','mentor'));
    }

    public function proses($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'p';
        $intern->save();
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }
    public function terima($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'a';
        $intern->save();
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }
    public function tolak($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'd';
        $intern->save();
        $intern->delete();
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }

    public function restore($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->onlyTrashed()->first();
        $intern->restore();
        $intern->status = 'p';
        $intern->save();
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }

    public function mentor($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->mentor_id = $request->mentor;
        $intern->save();

        return redirect()->back()->with('success','Berhasil Memilih Mentor');
    }

}