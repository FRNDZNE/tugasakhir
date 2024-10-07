<?php

namespace App\Imports;

use Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find Role
        $role = Role::where('name','mahasiswa')->first();
        // Cari Prodi Berdasarkan Akun Staff Prodi
        $prodi = Auth::user()->staff->prodi_id;
        // Cari Tahun Akademik
        $year = Year::where('name', $row['tahun'])->first();
        // Buat Akun User Role Mahasiswa
        $user = User::create([
            'role_id' => $role->id,
            'email' => $row['email'],
            'password' => bcrypt($row['nim']),
        ]);

        // Lengkapi Data Prodi berdasarkan data import
        return new Mahasiswa([
            'user_id' => $user->id,
            'prodi_id' => $prodi,
            'year_id' => $year->id,
            'uuid' => $row['nim'],
            'name' => $row['nama'],
            'grade' => $row['semester'],
            'class' => $row['kelas'],
            'phone' => $row['kontak'],
        ]);
    }
}
