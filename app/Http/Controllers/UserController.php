<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Mentor;
use App\Models\Agency;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Year;
use App\Models\Quota;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete($id)
    {
        User::where('id', $id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }

}



