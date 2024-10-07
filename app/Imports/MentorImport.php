<?php

namespace App\Imports;


use Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\Mentor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MentorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // define role
        $role = Role::where('name','mentor')->first();
        // find agency
        $agency = Auth::user()->agency;
        // Buat Akun pada model User
        $user = User::create([
            'role_id' => $role->id,
            'email' => $row['email'],
            'password' => bcrypt($row['nomor_pegawai']),
        ]);

        // Proses Import data Mentor
        return new Mentor([
            'user_id' => $user->id,
            'agency_id' => $agency->id,
            'uuid' => $row['nomor_pegawai'],
            'name' => $row['nama'],
            'contact' => preg_replace('/^0/', '62', $row['kontak']),
        ]);
    }
}
