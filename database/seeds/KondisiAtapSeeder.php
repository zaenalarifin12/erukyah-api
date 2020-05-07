<?php

use Illuminate\Database\Seeder;
use App\Models\KondisiAtap;

class KondisiAtapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KondisiAtap::insert([
            [
                "namaKondisiAtap"   => "baik",
                "skorKondisiAtap"   => 1
            ],
            [
                "namaKondisiAtap"   => "jelek",
                "skorKondisiAtap"   => 2
            ]
        ]);
    }
}
