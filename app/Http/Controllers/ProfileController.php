<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Agency;
use App\Models\Mentor;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Auth;

class ProfileController extends Controller
{
    // Superadmin CORE
    public function index()
    {
        $user = Auth::user();
        $roles = ['superadmin', 'admin', 'staff', 'agency', 'mentor', 'dosen', 'mahasiswa'];
        if (in_array($user->role->name, $roles)) {
            return view('profile.' . $user->role->name, compact('user'));
        } else {
            return abort(403); // Menggunakan abort untuk menampilkan halaman 403
        }
    }

    public function update(Request $request)
    {
        // cari akun terlebih dahulu
        $user = Auth::user();
        $akun = User::where('id', $user->id)->first();
        // update akun di tabel USER
        if ($request->username != $akun->name) {
            $akun->name = $request->username;
        }
        if ($request->email != $akun->email) {
            $akun->email = $request->email;
        }
        if (isset($request->password)) {
            $akun->password = bcrypt($request->password);
        }
        $akun->save();

        switch ($user->role->name) {
            case 'agency';
                $agency = Agency::where('user_id', $user->id)->first();
                $agency->contact = $request->contact;
                $agency->day = $request->day;
                $agency->desc = $request->desc;
                $agency->address = $request->address;
                $agency->save();
                break;
            case 'mentor';
                $mentor = Mentor::where('user_id', $user->id)->first();
                $mentor->contact = preg_replace('/^0/', '62', $request->contact);
                $mentor->save();
                break;
            case 'dosen';
                $dosen = Dosen::where('user_id', $user->id)->first();
                $dosen->phone = preg_replace('/^0/', '62', $request->phone);
                $dosen->save();
                break;
            case 'mahasiswa';
                $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
                $mahasiswa->phone = preg_replace('/^0/', '62', $request->phone);
                $mahasiswa->save();
                break;
            default:
                # code...
                break;
        }

        return redirect()->back()->with('success','Berhasil Mengubah Data');
    }

}
