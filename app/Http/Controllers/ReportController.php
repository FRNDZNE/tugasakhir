<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user()->mahasiswa->id;
        $data = Submission::whereHas('intern', function($q) use ($user){
            $q->where('mahasiswa_id',$user);
        })->first();
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
