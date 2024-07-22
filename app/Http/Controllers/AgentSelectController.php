<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Period;
use App\Models\Prodi;
use App\Models\Intern;


class AgentSelectController extends Controller
{
    public function index()
    {
        $data['year'] = Period::all();
        return view('agency.select');
    }

    public function search(Request $request)
    {

    }
}
