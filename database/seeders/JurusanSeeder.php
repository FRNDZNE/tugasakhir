<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = 'elektro';

            Jurusan::create([
                'name' => $jurusans,
                'display_name' => "Teknik ". ucfirst($jurusans),
            ]);

        $elektro = ['tif','trse','listrik'];
        $elektro2 = ['Informatika','Rekayasa Sistem Elektronika','Listrik'];
        $findJurusan1 = Jurusan::where('name','elektro')->first();
        foreach ($elektro as $e) {
            foreach ($elektro2 as $d) {
                Prodi::create([
                    'jurusan_id' => $findJurusan1->id,
                    'name' => $e,
                    'display_name' => "Teknik ". $d,
                ]);
            }
        }
    }
}
