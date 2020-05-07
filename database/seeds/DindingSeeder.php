<?php

use Illuminate\Database\Seeder;
use App\Models\Dinding;

class DindingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        Dinding::insert([
            
                [
                    "namaDinding"   => "Tembok",
                    "skorDinding"   => 1
                ],
                [
                    "namaDinding"   => "Kayu",
                    "skorDinding"   => 2
                ],
                [
                    "namaDinding"   => "Kalsiboard",
                    "skorDinding"   => 3
                ],
                [
                    "namaDinding"   => "Triplek",
                    "skorDinding"   => 4
                ],
                [
                    "namaDinding"   => "Bambu",
                    "skorDinding"   => 5
                ],
                [
                    "namaDinding"   => "Seng",
                    "skorDinding"   => 6
                ],
                [
                    "namaDinding"   => "Lainnya",
                    "skorDinding"   => 7
                ]
            
        ]);
    }
}
