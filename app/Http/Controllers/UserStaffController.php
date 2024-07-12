<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Staff;
use App\Models\Role;
use Auth;

class UserStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin');
    }

    // CRUD STAFF PRODI
    public function index()
    {
        if (Auth::user()->role->name == 'superadmin') {
            $data['prodi'] = Prodi::all();
            $data['user'] = User::whereHas('staff')->get();
        } else if (Auth::user()->role->name == 'admin') {
            # code...
            $jurusan = Auth::user()->admin->jurusan->id;
            $data['prodi'] = Prodi::where('jurusan_id', Auth::user()->admin->jurusan->id)->get();
            $data['user'] = User::whereHas('staff', function($query) use ($jurusan){
                $query->whereHas('prodi', function($q) use ($jurusan){
                    $q->where('jurusan_id', $jurusan);
                });
            })->get();
        }
        // return $data['user'];
        return view('users.staff',compact('data'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada !')
        ];

        $attributes = [
            'email' => ucfirst('email'),
            'password' => ucfirst('password'),
            'fullname' => ucwords('nama lengkap'),
            'uuid' => strtoupper('nip/nuptk'),
            'prodi' => ucfirst('prodi'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'fullname' => 'required',
            'uuid' => 'required|unique:staff',
            'prodi' => 'gt:0',
        ], $messages, $attributes);

        $role = Role::where('name','staff')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $staff = new Staff;
        $staff->user_id = $user->id;
        $staff->prodi_id = $request->prodi;
        $staff->name = $request->fullname;
        $staff->uuid = $request->uuid;
        $staff->save();
        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada !')
        ];

        $attributes = [
            'email' => ucfirst('email'),
            'fullname' => ucwords('nama lengkap'),
            'uuid' => strtoupper('nip/nuptk'),
            'prodi' => ucfirst('prodi'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'fullname' => 'required',
            'uuid' => 'required|unique:staff,uuid,'. $request->uuid . ',uuid',
            'prodi' => 'gt:0',
        ], $messages, $attributes);

        $user = User::where('id', $request->id)->first();
        if ($request->email != $user->email) {
            $user->email = $request->email;
        }
        if (isset($request->password)) {
            # code...
            $user->password = $request->password;
        }
        $user->save();

        $staff = Staff::where('user_id',$request->id)->first();
        $staff->name = $request->fullname;
        if ($staff->uuid != $request->uuid) {
            $staff->uuid = $request->uuid;
        }
        $staff->prodi_id = $request->prodi;
        $staff->save();

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }
}
