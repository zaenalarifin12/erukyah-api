<?php

use Illuminate\Database\Seeder;
use App\Models\KondisiDinding;

class KondisiDindingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        KondisiDinding::insert([
            [
                "namaKondisiDinding"   => "baik",
                "skorKondisiDinding"   => 1
            ],
            [
                "namaKondisiDinding"   => "jelek",
                "skorKondisiDinding"   => 2
            ]
        ]);
    }
}
