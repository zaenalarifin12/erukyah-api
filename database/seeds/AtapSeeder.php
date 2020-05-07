<?php

use Illuminate\Database\Seeder;
use App\Models\Atap;

class AtapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Atap::insert([
            [
                "namaAtap"  => "Beton / GentengBeton",
                "skorAtap"  => 1
            ],
            [
                "namaAtap"  => "Genteng Keramik",
                "skorAtap"  => 2
            ],
            [
                "namaAtap"  => "Genteng Metal",
                "skorAtap"  => 3
            ],
            [
                "namaAtap"  => "Genteng Tanah Liat",
                "skorAtap"  => 4
            ],
            [
                "namaAtap"  => "Asbes",
                "skorAtap"  => 5
            ],
            [
                "namaAtap"  => "Seng",
                "skorAtap"  => 6
            ],
            [
                "namaAtap"  => "Sirap",
                "skorAtap"  => 7
            ],
            [
                "namaAtap"  => "Bambu",
                "skorAtap"  => 8
            ],
            [
                "namaAtap"  => "Jerami / Ijuk / Daun / Rumbia",
                "skorAtap"  => 9
            ],
            [
                "namaAtap"  => "Lainnya",
                "skorAtap"  => 10
            ],
        ]);
    }
}
