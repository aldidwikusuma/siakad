<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaMataKuliah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswa_matakuliah = [
            ['mahasiswa_id' => 11, 'matakuliah_id' => 13, 'nilai' => 'A'],
            ['mahasiswa_id' => 11, 'matakuliah_id' => 14, 'nilai' => 'A'],
            ['mahasiswa_id' => 11, 'matakuliah_id' => 15, 'nilai' => 'A'],
            ['mahasiswa_id' => 11, 'matakuliah_id' => 16, 'nilai' => 'A']
        ];
        DB::table('mahasiswa_matakuliah')->insert($mahasiswa_matakuliah);
    }
}