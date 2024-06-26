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

        $elektro = ['informatika','elektronika','listrik'];
        $elektro2 = ['Informatika','Rekayasa Sistem Elektronika','Listrik'];
        $findJurusan1 = Jurusan::where('name','elektro')->first();
        if(count($elektro) == count($elektro2)) {
            foreach ($elektro as $index => $e) {
                Prodi::create([
                    'jurusan_id' => $findJurusan1->id,
                    'name' => $e,
                    'display_name' => "Teknik ". $elektro2[$index],
                ]);
            }
        }
    }
}
