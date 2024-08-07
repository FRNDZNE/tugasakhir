<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;
use App\Models\Period;
use Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
// POV mahasiswa
    public function index()
    {
        $user = Auth::user()->mahasiswa->intern;
        $absen = Attendance::where('intern_id', $user->id)->get();

        $periodStart = $user->period->start;
        $periodEnd = $user->period->end;
        $today = Carbon::parse(today())->format('Y-m-d');
        $dates = $this->periodIntern($periodStart, $periodEnd);
        // return $dates;
        return view('mahasiswa.absen',[
            'absen' => $absen,
            'tanggal' => $dates,
            'today' => $today,
        ]);
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'day' => ucwords('Tanggal'),
            'status' => ucwords('status'),
        ];

        $request->validate([
            'day' => 'required',
            'status' => 'required',
        ], $messages, $attributes);

        $user = Auth::user()->mahasiswa->intern->id;
        Attendance::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'intern_id' => $user,
                'date' => $request->day,
                'status' => $request->status,
                'reason' => $request->desc,
            ]
        );

        return redirect()->back()->with('success','Berhasil Menyimpan Absen');
    }
// End POV Mahasiswa
    // Filter Tanggal Periode Magang
    public function periodIntern($start, $end)
    {
        $dates = [];
        $mulai = Carbon::parse($start);
        $selesai = Carbon::parse($end);

        for ($date = $mulai; $date->lte($selesai); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

// Validation for agency and mentor
    public function absen_mahasiswa($intern)
    {
        $user = Intern::where('id', $intern)->first();
        $absen = Attendance::where('intern_id', $user->id)->get();

        $periodStart = $user->period->start;
        $periodEnd = $user->period->end;
        $today = Carbon::parse(today())->format('Y-m-d');
        $dates = $this->periodIntern($periodStart, $periodEnd);
        // return $dates;
        return view('mahasiswa.absen',[
            'user' => $user,
            'absen' => $absen,
            'tanggal' => $dates,
            'today' => $today,
        ]);
    }

    public function absen_store($intern, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'day' => ucwords('Tanggal'),
            'status' => ucwords('status'),
        ];

        $request->validate([
            'day' => 'required',
            'status' => 'required',
        ], $messages, $attributes);

        $user = Intern::where('id', $intern)->first();

        Attendance::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'intern_id' => $user->id,
                'date' => $request->day,
                'status' => $request->status,
                'reason' => $request->desc,
                'isvalid' => $request->validation,
            ]
        );
        return redirect()->back()->with('success','Berhasil Menyimpan Absen');

    }

}


