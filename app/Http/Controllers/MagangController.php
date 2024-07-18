<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
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
}
