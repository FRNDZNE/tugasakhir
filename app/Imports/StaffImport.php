<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Role;
use App\Models\User;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $role = Role::where('name','staff')->first();
        $prodi = Prodi::where('name', $row['kode_prodi'])->first();

        $user = User::create([
            'role_id' => $role->id,
            'email' => $row['email'],
            'password' => bcrypt($row['nip']),
        ]);

        return new Staff([
            'user_id' => $user->id,
            'prodi_id' => $prodi->id,
            'uuid' => $row['nip'],
            'name' => $row['nama'],
        ]);

    }
}
