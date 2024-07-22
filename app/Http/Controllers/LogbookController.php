<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\LogbookImage;
use App\Models\Intern;
// use Image;
use Auth;

class LogbookController extends Controller
{
    public function index()
    {

        $user = Auth::user()->mahasiswa->id;
        $data = Logbook::whereHas('intern', function($q) use ($user){
            $q->where('mahasiswa_id', $user);
        } )->get();
        return view('mahasiswa.logbook',compact('data'));
    }

    public function store(Request $request)
    {
        $intern = Auth::user()->mahasiswa->intern->id;
        $datePicker = Intern::where('id', $intern)
        ->with('period')
        ->first();

        $dateStart = $datePicker->period->start;
        $dateEnd = $datePicker->period->end;

        if ($request->date <= $dateStart || $request->date > $dateEnd) {
            # code...
            return redirect()->back()->with('error', 'Melewati Tanggal Periode Magang');
        }
        $logbook = Logbook::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'intern_id' => $intern,
                'date' => $request->date,
                'title' =>  $request->title,
                'desc' => $request->desc,
            ]
        );

        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function delete(){

    }
}
