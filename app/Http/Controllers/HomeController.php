<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     // $role = Auth::user()->role->name;
    //     return view('home');
    // }

    public function superadmin()
    {
        return view('dashboard.superadmin');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }

    public function agency()
    {
        return view('dashboard.agency');
    }

    public function mentor()
    {
        return view('dashboard.mentor');
    }

    public function dosen()
    {
        return view('dashboard.dosen');
    }

    public function mahasiswa()
    {
        return view('dashboard.mahasiswa');
    }
}
