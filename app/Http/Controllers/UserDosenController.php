<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Dosen;
use App\Models\Prodi;
use Auth;


class UserDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin');
    }

    // CRUD untuk role Dosen
    public function index()
    {
        $data['prodi'] = Prodi::all();
        $data['user'] = User::whereHas('dosen')->get();
        return view('superadmin.user.dosen',compact('data'));
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
            'contact' => ucwords('no telepon'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'fullname' => 'required',
            'uuid' => 'required|unique:dosens',
            'contact' => 'required',
            'prodi' => 'required|array|min:1',
            'prodi.*' => 'integer|exists:prodis,id',

        ], $messages, $attributes);

        $role = Role::where('name','dosen')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $dosen = new Dosen;
        $dosen->user_id = $user->id;
        $dosen->name = $request->fullname;
        $dosen->uuid = $request->uuid;
        $dosen->phone = $request->contact;
        $dosen->save();
        foreach ($request->prodi as $prodi) {
            $dosen->prodi()->attach($prodi);
        }
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
            'contact' => ucwords('no telepon'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'fullname' => 'required',
            'uuid' => 'required|unique:dosens,uuid,'. $request->uuid . ',uuid',
            'prodi' => 'gt:0',
            'contact' => 'required',
            'prodi' => 'required|array|min:1',
            'prodi.*' => 'integer|exists:prodis,id',
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

        $dosen = Dosen::where('user_id',$request->id)->first();
        $dosen->name = $request->fullname;
        if ($dosen->uuid != $request->uuid) {
            $dosen->uuid = $request->uuid;
        }
        $dosen->phone = $request->contact;
        $dosen->save();

        foreach ($dosen->prodi as $prodiLama) {
            $dosen->prodi()->detach($prodiLama);
        }
        foreach ($request->prodi as $prodi) {
            $dosen->prodi()->attach($prodi);
        }

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }


}