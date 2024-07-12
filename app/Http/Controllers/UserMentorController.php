<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Mentor;
use Auth;


class UserMentorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,agency');
    }

    // CRUD Untuk Role Mentor
    public function index($agency)
    {
        $data['mitra'] = Agency::all();
        $data['user'] = User::whereHas('mentor')->get();
        return view ('user.mentor',compact('data'));
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
            'name' => ucwords('nama'),
            'contact' => ucfirst('kontak'),
            'uuid' => ucwords('nomor mentor'),
            'agent' => ucwords('mitra')
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            'contact' => 'required',
            'uuid' => 'required|unique:mentors',
            'agent' => 'gt:0'
        ], $messages, $attributes);

        $role = Role::where('name','mentor')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $mentor = new Mentor;
        $mentor->user_id = $user->id;
        $mentor->agency_id = $request->agent;
        $mentor->name = $request->name;
        $mentor->uuid = $request->uuid;
        $mentor->contact = $request->contact;
        $mentor->save();
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
            'name' => ucwords('nama'),
            'contact' => ucfirst('kontak'),
            'uuid' => ucwords('nomor mentor'),
            'agent' => ucwords('mitra'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'name' => 'required',
            'contact' => 'required',
            'uuid' => 'required|unique:mentors,uuid,' . $request->uuid .',uuid',
            'agent' => 'gt:0'
        ], $messages, $attributes);

        $user = User::where('id', $request->id)->first();
        if ($user->email != $request->email) {
            # code...
            $user->email = $request->email;
        }
        if ($user->password != $request->password) {
            # code...
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $mentor = Mentor::where('user_id', $request->id)->first();
        $mentor->name = $request->name;
        $mentor->agency_id = $request->agent;
        if ($mentor->uuid != $request->uuid) {
            $mentor->uuid = $request->uuid;
        }
        $mentor->contact = $request->contact;
        $mentor->save();
        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }
}