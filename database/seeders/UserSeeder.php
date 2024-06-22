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

        //membuat akun admin
        $findRoleAdmin = Role::where('name','admin')->first();
        $findJurusan = Jurusan::where('name','elektro')->first();
        $admin = User::create([
            'role_id' => $findRoleAdmin->id,
            'name' => 'admin',
            'email' => 'admin@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);

        Admin::create([
            'name' => 'Hafiz Putra Pratama',
            'uuid' => '6171021408020003',
            'user_id' => $admin->id,
            'jurusan_id' => $findJurusan->id,
        ]);

        // create akun staff prodi
        $findRoleStaff = Role::where('name','staff')->first();
        $findProdi = Prodi::where('name','informatika')->first();
        $staff = User::create([
            'role_id' => $findRoleStaff->id,
            'name' => 'staff',
            'email' => 'staff@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);

        Staff::create([
            'name' => 'Siti Sarah',
            'uuid' => '958746583657465426',
            'user_id' => $staff->id,
            'prodi_id' => $findProdi->id,
        ]);

        // Create Agenct User
        $findRoleAgency = Role::where('name','agency')->first();
        $agency = User::create([
            'role_id' => $findRoleAgency->id,
            'name' => 'agency',
            'email' => 'agency@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);

        $magang = Agency::create([
            'user_id' => $agency->id,
            'name' => 'PT. Pelabuhan Indonesia',
            'uuid' => '12345',
            'address' => 'Coming Soon',
            'contact' => 'Coming Soon',
            'desc' => 'Coming Soon',
            'day' => 6,
        ]);

        // Create Mentor Account 
        $findRoleMentor = Role::where('name','mentor')->first();
        $mentor = User::create([
            'role_id' => $findRoleMentor->id,
            'name' => 'mentor',
            'email' => 'mentor@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);

        Mentor::create([
            'user_id' => $mentor->id,
            'agency_id' => $magang->id,
            'name' => 'John Doe',
            'uuid' => '86756473645',
        ]);

        // Create Account Mahasiswa
        $findRoleMahasiswa = Role::where('name','mahasiswa')->first();
        $mahasiswa = User::create([
            'role_id' => $findRoleMahasiswa->id,
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);

        Mahasiswa::create([
            'user_id' => $mahasiswa->id,
            'prodi_id' => $findProdi->id,
            'year_id' => 1,
            'uuid' => '3202116021',
            'name' => 'Hafiz Putra Pratama',
            'grade' => '6',
            'class' => 'B',
            'phone' => '085157267750',
        ]);

        // Create Account Dosen
        $findRoleDosen = Role::where('name','dosen')->first();
        $dosen = User::Create([
            'role_id' => $findRoleDosen->id,
            'name' => 'dosen',
            'email' => 'dosen@polnep.com',
            'password' => bcrypt('polnepmantap'),
        ]);        

        $dosen2 = Dosen::create([
            'user_id' => $dosen->id,
            'uuid' => '868574656745674',
            'name' => 'Dosen Senang',
            'phone' => '078767564'
        ]);

        $dosen2->prodi()->attach($findProdi);

        
    }
}
