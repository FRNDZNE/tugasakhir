<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Jurusan;
use App\Models\Role;

class UserAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:superadmin']);
    }
    public function index()
    {
        $data['jurusan'] = Jurusan::all();
        $data['user'] = User::whereHas('admin')->get();
        return view('users.admin',compact('data'));
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
            'jurusan' => ucfirst('jurusan'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'fullname' => 'required',
            'uuid' => 'required|unique:admins',
            'jurusan' => 'gt:0',
        ], $messages, $attributes);

        $role = Role::where('name','admin')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $admin = new Admin;
        $admin->user_id = $user->id;
        $admin->jurusan_id = $request->jurusan;
        $admin->name = $request->fullname;
        $admin->uuid = $request->uuid;
        $admin->save();
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
            'jurusan' => ucfirst('jurusan'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'fullname' => 'required',
            'uuid' => 'required|unique:admins,uuid,' . $request->uuid .',uuid',
            'jurusan' => 'gt:0',
        ], $messages, $attributes);

        $user = User::where('id', $request->id)->first();
        if ($user->email != $request->email) {
            $user->email = $request->email;
        }
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $admin = Admin::where('user_id',$request->id)->first();
        $admin->name = $request->fullname;
        if ($admin->uuid != $request->uuid) {
            $admin->uuid = $request->uuid;
            # code...
        }
        $admin->jurusan_id = $request->jurusan;
        $admin->save();

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

}
