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
    // CRUD ADMIN JURUSAN
    public function index_admin()
    {
        $data['jurusan'] = Jurusan::all();
        $data['user'] = User::whereHas('admin')->get();
        return view('superadmin.user.admin',compact('data'));
    }

    public function store_admin(Request $request)
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
            'email' => 'required|unique:users',
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

    public function update_admin(Request $request)
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
            'email' => 'required|unique:users,email,' . $request->id,
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

    // CRUD STAFF PRODI
    public function index_staff()
    {
        $data['prodi'] = Prodi::all();
        $data['user'] = User::whereHas('staff')->get();
        return view('superadmin.user.staff',compact('data'));
    }

    public function store_staff(Request $request)
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
            'email' => 'required|unique:users',
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

    public function update_staff(Request $request)
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
            'email' => 'required|unique:users,email,' . $request->id,
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

    // CRUD Untuk Menambah Mitra Magang
    public function index_agency()
    {
        $data['user'] = User::whereHas('agency')->get();
        return view ('superadmin.user.agency',compact('data'));
    }

    public function store_agency(Request $request)
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
            'email' => 'required|unique:users',
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

    public function update_agency(Request $request)
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
            'email' => 'required|unique:users,email,' . $request->id,
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

    public function delete_agency($id)
    {
        User::where('id',$id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Mengahapus Data');
    }

    // CRUD Untuk Role Mentor
    public function index_mentor()
    {
        $data['user'] = User::whereHas('mentor')->get();
        $data['mitra'] = Agency::all();
        return view ('superadmin.user.mentor',compact('data'));
    }

    public function store_mentor(Request $request)
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
            'email' => 'required|unique:users',
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

    public function update_mentor(Request $request)
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
            'email' => 'required|unique:users,email,' . $request->id,
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

    // CRUD untuk role Dosen
    public function index_dosen()
    {
        $data['prodi'] = Prodi::all();
        $data['user'] = User::whereHas('dosen')->get();
        return view('superadmin.user.dosen',compact('data'));
    }

    public function store_dosen(Request $request)
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
            'email' => 'required|unique:users',
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

    public function update_dosen(Request $request)
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
            'email' => 'required|unique:users,email,' . $request->id,
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
            'email' => 'required|unique:users',
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
            'email' => 'required|unique:users,email,' . $request->id,
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
        $mahasiswa->save();

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

    public function delete($id)
    {
        User::where('id', $id)->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Data');
    }

}
