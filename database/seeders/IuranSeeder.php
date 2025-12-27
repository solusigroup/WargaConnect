<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriIuran;

class IuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iurans = [
            [
                'nama_iuran' => 'Rukun Kematian',
                'nominal' => 5000,
                'is_active' => true,
                'is_mandatory' => true,
            ],
            [
                'nama_iuran' => 'Kas RW',
                'nominal' => 2000,
                'is_active' => true,
                'is_mandatory' => true,
            ],
            [
                'nama_iuran' => 'Kas RT',
                'nominal' => 3000,
                'is_active' => true,
                'is_mandatory' => true,
            ],
            [
                'nama_iuran' => 'PHBN',
                'nominal' => 2000,
                'is_active' => true,
                'is_mandatory' => true,
            ],
            [
                'nama_iuran' => 'Sosial',
                'nominal' => 3000,
                'is_active' => true,
                'is_mandatory' => true,
            ],
        ];

        foreach ($iurans as $iuran) {
            KategoriIuran::updateOrCreate(
                ['nama_iuran' => $iuran['nama_iuran']], 
                $iuran
            );
        }
    }
}
