<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Agency;
use App\Models\Mentor;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Admin;
use App\Models\Staff;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $findRole = Role::where('name','superadmin')->first();
        User::create([
            'role_id' => $findRole->id,
            'name' => 'superadmin',
            'email' => 'superadmin@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);



    }
}
