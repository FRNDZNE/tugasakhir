<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Models\Agency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgencyImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $role = Role::where('name','agency')->first();
        $user = User::create([
            'role_id' => $role->id,
            'email' => $row['email'],
            'password' => bcrypt($row['kode_mitra']),
        ]);
        return new Agency([
            'user_id' => $user->id,
            'uuid' => $row['kode_mitra'],
            'name' => $row['nama'],
            'address' => $row['alamat'],
            'contact' => $row['kontak'],
            'day' => $row['hari'],
        ]);
    }
}
