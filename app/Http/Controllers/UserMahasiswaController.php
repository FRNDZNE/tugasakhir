<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,staff,agency,mentor,dosen');
    }

    // CRUD Untuk Role Mahasiswa
    public function index_mahasiswa()
    {
        $data['prodi'] = Prodi::all();
        $data['year'] = Year::all();
        $data['user'] = User::whereHas('mahasiswa')->get();
        return view('superadmin.user.mahasiswa',compact('data'));
    }

    public function store_mahasiswa(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada !'),
        ];

        $attributes = [
            'email' => ucfirst('email'),
            'password' => ucfirst('password'),
            'fullname' => ucwords('nama lengkap'),
            'uuid' => strtoupper('nim'),
            'prodi' => ucfirst('prodi'),
            'contact' => ucwords('no telepon'),
            'grade' => ucfirst('semester'),
            'class' => ucfirst('kelas'),
            'year' => ucwords('tahun ajaran'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'fullname' => 'required',
            'class' => 'required|max:1',
            'grade' => 'required|max:1',
            'uuid' => 'required|unique:mahasiswas',
            'contact' => 'required',
            'prodi' => 'gt:0',
            'year' => 'gt:0',

        ], $messages, $attributes);

        $role = Role::where('name','mahasiswa')->first();
        $user = new User;
        $user->role_id = $role->id;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $mahasiswa = new Mahasiswa;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->name = $request->fullname;
        $mahasiswa->uuid = $request->uuid;
        $mahasiswa->prodi_id = $request->prodi;
        $mahasiswa->year_id = $request->year;
        $mahasiswa->class = $request->class;
        $mahasiswa->grade = $request->grade;
        $mahasiswa->phone = $request->contact;
        $mahasiswa->save();

        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update_mahasiswa(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'gt' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada !'),
            'max' => ucwords('telah mencapai batas karakter')
        ];

        $attributes = [
            'email' => ucfirst('email'),
            'fullname' => ucwords('nama lengkap'),
            'uuid' => strtoupper('nim'),
            'prodi' => ucfirst('prodi'),
            'contact' => ucwords('no telepon'),
            'grade' => ucfirst('semester'),
            'class' => ucfirst('kelas'),
            'year' => ucwords('tahun ajaran'),
        ];

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'fullname' => 'required',
            'class' => 'required|max:1',
            'grade' => 'required|max:1',
            'uuid' => 'required|unique:mahasiswas,uuid,' . $request->uuid . ',uuid',
            'contact' => 'required',
            'prodi' => 'gt:0',
            'year' => 'gt:0',
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

        $mahasiswa = Mahasiswa::where('user_id',$request->id)->first();
        $mahasiswa->name = $request->fullname;
        $mahasiswa->phone = $request->contact;
        if ($mahasiswa->uuid != $request->uuid) {
            $mahasiswa->uuid = $request->uuid;
        }
        $mahasiswa->prodi_id = $request->prodi;
        $mahasiswa->year_id = $request->year;
        $mahasiswa->class = $request->class;
        $mahasiswa->grade = $request->grade;
        $mahasiswa->status = $request->status;
        $mahasiswa->save();

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }
}
