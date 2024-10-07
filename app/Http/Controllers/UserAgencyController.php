<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\Models\Role;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Imports\AgencyImport;

class UserAgencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin');
    }

    // CRUD Untuk Menambah Mitra Magang
    public function index()
    {
        $data['user'] = User::whereHas('agency')->get();
        return view ('users.agency',compact('data'));
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
            'name' => ucwords('nama instansi'),
            'address' => ucfirst('alamat'),
            'contact' => ucfirst('kontak'),
            // 'desc' => ucwords('tentang perusahaan'),
            'day' => ucwords('hari kerja'),
            'uuid' => ucwords('kode perusahaan'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            'uuid' => 'required|unique:agencies',
            'address' => 'required',
            'contact' => 'required',
            // 'desc' => 'required',
            'day' => 'required|',
        ], $messages, $attributes);

        $role = Role::where('name','agency')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $agent = new Agency;
        $agent->user_id = $user->id;
        $agent->name = $request->name;
        $agent->uuid = $request->uuid;
        $agent->address = $request->address;
        $agent->contact = $request->contact;
        if (isset($request->desc)) {
            $agent->desc = $request->desc;
        }
        $agent->day = $request->day;
        $agent->save();
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
            'name' => ucwords('nama instansi'),
            'address' => ucfirst('alamat'),
            'contact' => ucfirst('kontak'),
            // 'desc' => ucwords('tentang perusahaan'),
            'day' => ucwords('hari kerja'),
            'uuid' => ucwords('kode perusahaan'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'name' => 'required',
            'uuid' => 'required|unique:agencies,uuid,' . $request->uuid . ',uuid',
            'address' => 'required',
            'contact' => 'required',
            // 'desc' => 'required',
            'day' => 'required|',
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

        $agent = Agency::where('user_id', $request->id)->first();
        $agent->name = $request->name;
        if ($agent->uuid != $request->uuid) {
            $agent->uuid = $request->uuid;
        }
        $agent->address = $request->address;
        $agent->contact = $request->contact;
        if (isset($request->desc)) {
            $agent->desc = $request->desc;
        }
        $agent->day = $request->day;
        $agent->save();
        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function import(Request $request)
    {
        try {
            //code...
            Excel::import(new AgencyImport, $request->file('file'));
            return redirect()->back()->with('success','Berhasil Upload');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
