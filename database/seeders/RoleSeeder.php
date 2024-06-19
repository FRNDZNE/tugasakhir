<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['superadmin','admin','staff','dosen','agency','mentor','mahasiswa'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'display_name' => ucfirst($role)
            ]);
        }
    }
}
