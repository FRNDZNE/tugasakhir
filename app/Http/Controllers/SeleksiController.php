<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Period;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\User;
use Auth;
use App\Notifications\AcceptIntern;
use App\Notifications\DeniedIntern;
use App\Notifications\ProcessIntern;
use App\Notifications\SelectedMentor;
use App\Notifications\StaffProdi;
use Illuminate\Support\Facades\Notification;

class SeleksiController extends Controller
{
    public function index_year()
    {
        $year = Year::all();
        return view('agency.seleksi.year',compact('year'));
    }

    public function index_period($year)
    {
        if (Auth::user()->role->name == 'mentor') {
            $user = Auth::user()->mentor->agency_id;
        }elseif (Auth::user()->role->name == 'agency') {
            $user = Auth::user()->agency->id;
        }
        $tahun = Year::where('id',$year)->first();
        $period = Period::where('year_id', $year)
        ->whereHas('quota', function($q) use ($user){
            $q->where('agency_id', $user);
        })
        ->get();
        return view('agency.seleksi.period',compact('period','tahun'));
    }

    public function index($year, $period)
    {

        $tahun = Year::where('id',$year)->first();
        $periode = Period::where('id',$period)->first();
        if (Auth::user()->role->name == 'agency') {
            # code...
            $agency = Auth::user()->agency->id;
            $intern = Intern::where('period_id', $period)
            ->where('agency_id', $agency)
            ->with('mahasiswa')
            ->withTrashed()
            ->orderBy('status','DESC')
            ->get();
            $mentor = Mentor::where('agency_id', $agency)->get();
        }elseif (Auth::user()->role->name == 'mentor') {
            # code...
            $mentor = Auth::user()->mentor;
            $intern = Intern::where('period_id', $period)
            ->where('agency_id', $mentor->agency_id)
            ->where('mentor_id', $mentor->id)
            ->with('mahasiswa')
            ->get();
            // return $intern;
        }

        return view('agency.seleksi.index',compact('intern','tahun','periode','mentor'));
    }

    // Proses Seleksi Magang Yang Dilakukan Oleh Mitra Magang
    public function proses($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'p';
        $intern->save();

        // Cari User Mahasiswa
        $mahasiswa = User::whereHas('mahasiswa', function($q) use ($intern) {
            $q->where('id', $intern->mahasiswa_id);
        })->with('mahasiswa')->first();
        // Send Notifikasi Ke Mahasiswa
        Notification::send($mahasiswa, new ProcessIntern($intern->agency->name));
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }
    public function terima($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'a';
        $intern->save();
        // Cari User Mahasiswa
        $mahasiswa = User::whereHas('mahasiswa', function($q) use ($intern) {
            $q->where('id', $intern->mahasiswa_id);
        })->with('mahasiswa')->first();
        // Send Notifikasi Ke Mahasiswa
        Notification::send($mahasiswa, new AcceptIntern($intern->agency->name));
        // Send Notifikasi Ke Staf Prodi
        $prodi = User::whereHas('staff', function($q) use ($intern) {
            $q->where('prodi_id', $intern->mahasiswa->prodi_id);
        })->with('staff')->first();
        Notification::send($prodi, new StaffProdi($intern->mahasiswa->name, $intern->mahasiswa->year->name, $intern->agency->name));
        return redirect()->back()->with('success','Berhasil Mengubah Status');
    }
    public function tolak($year, $period, Request $request)
    {
        $intern = Intern::where('id', $request->id)->first();
        $intern->status = 'd';
        $intern->save();
        $intern->delete();
        // Cari User Mahasiswa
        $mahasiswa = User::whereHas('mahasiswa', function($q) use ($intern) {
            $q->where('id', $intern->mahasiswa_id);
        })->with('mahasiswa')->first();
        // Send Notifikasi Ke Mahasiswa
        Notification::send($mahasiswa, new DeniedIntern($intern->agency->name));
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

        $mentor = User::whereHas('mentor', function($q) use ($intern) {
            $q->where('id', $intern->mentor_id);
        })->with('mentor')->first();
        // Send Notifikasi Ke mentor
        Notification::send($mentor, new SelectedMentor($intern->mahasiswa->name, $intern->mahasiswa->year->name, $intern->mahasiswa->prodi->display_name));
        return redirect()->back()->with('success','Berhasil Memilih Mentor');
    }

    public function profile($intern)
    {
        $magang = Intern::where('id', $intern)->with('mahasiswa')->first();
        return view('agency.seleksi.profile',compact('magang'));
    }


}
