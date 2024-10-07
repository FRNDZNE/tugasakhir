<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $role = Role::where('name','dosen')->first();
        // Buat user
        $user = User::create([
            'role_id' => $role->id,
            'email' => $row['email'],
            'password' => bcrypt($row['nip']),
        ]);

        // Buat dosen dengan user_id yang baru saja dibuat
        $dosen = new Dosen([
            'user_id' => $user->id,
            'uuid' => $row['nip'],
            'name' => $row['nama'],
            'phone' => $row['kontak'],
        ]);

        return new Dosen([
            'user_id' => $user->id,
            'uuid' => $row['nip'],
            'name' => $row['nama'],
            'phone' => preg_replace('/^0/', '62', $row['kontak']),
        ]);
    }
}
