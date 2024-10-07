<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Imports\MahasiswaImport;

class UserMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,staff');
        // $this->middleware('role:staff')->except('menu');
    }

    // CRUD Untuk Role Mahasiswa
    public function menu()
    {
        if (Auth::user()->role->name == 'superadmin') {
            # code...
            $prodi = Prodi::all();
        }elseif (Auth::user()->role->name == 'admin') {
            # code...
            $prodi = Prodi::where('jurusan_id', Auth::user()->admin->jurusan->id)->get();
        }else{
            return abort(403,'Forbidden');
        }

        return view('users.menu.prodi',compact('prodi'));
    }
    public function index($prodi)
    {
        $data['prodi'] = Prodi::where('id',$prodi)->first();
        $data['year'] = Year::all();
        $data['user'] = User::whereHas('mahasiswa', function($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->get();
        return view('users.mahasiswa',compact('data'));
    }

    public function store(Request $request)
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
        $mahasiswa->phone = preg_replace('/^0/', '62', $request->contact);
        $mahasiswa->save();

        return redirect()->back()->with('success','Berhasil Menambah Data');
    }

    public function update( Request $request)
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
            'year' => 'gt:0',
        ], $messages, $attributes);

        $user = User::where('id', $request->id)->first();
        if ($request->email != $user->email) {
            $user->email = $request->email;
        }
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $mahasiswa = Mahasiswa::where('user_id',$request->id)->first();
        $mahasiswa->name = $request->fullname;
        $mahasiswa->phone = preg_replace('/^0/', '62', $request->contact);
        if ($mahasiswa->uuid != $request->uuid) {
            $mahasiswa->uuid = $request->uuid;
        }
        $mahasiswa->year_id = $request->year;
        $mahasiswa->class = $request->class;
        $mahasiswa->grade = $request->grade;
        $mahasiswa->save();

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function enabled( $id)
    {
        // Menggunakan find atau findOrFail untuk mengambil data mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $id)->first();
        // return $mahasiswa->status;
        // Mengupdate status menjadi true
        $mahasiswa->update([
            'status' => true,
        ]);

        // return $mahasiswa;
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil Mengaktifkan Akun');
    }

    public function disabled( $id)
    {
        // Menggunakan find atau findOrFail untuk mengambil data mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $id)->first();
        // return $mahasiswa->status;

        // Mengupdate status menjadi true
        $mahasiswa->update([
            'status' => false,
        ]);
        // return $mahasiswa;

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil Menonaktifkan Akun');
    }

    public function import(Request $request)
    {
        try {
            //code...
            Excel::import(new MahasiswaImport, $request->file);
            return redirect()->back()->with('success','Berhasil Upload');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', __($th->getMessage()));
        }
    }

}
