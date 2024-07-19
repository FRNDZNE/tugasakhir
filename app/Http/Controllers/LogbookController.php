<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\LogbookImage;
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

    public function store()
    {

    }

    public function delete(){

    }
}
