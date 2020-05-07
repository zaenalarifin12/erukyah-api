<?php

use Illuminate\Database\Seeder;
use App\Models\Lantai;

class LantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        


        Lantai::insert([
            [
                "namaLantai" => "Marmer/Granit",
                "skorLantai" => 1    
            ],
            [
                "namaLantai" => "Keramik",
                "skorLantai" => 2
            ],
            [   "namaLantai" => "Parker/Vinil/Permadani",
                "skorLantai" => 3
            ],
            [   "namaLantai" => "Ubin/Tegel/Teraso",
                "skorLantai" => 4
            ],
            [   "namaLantai" => "Kayu/Papan",
                "skorLantai" => 5
            ],
            [   "namaLantai" => "Semen/BataMerah",
                "skorLantai" => 6
            ],  
            [   "namaLantai" => "Bambu",
                "skorLantai" => 7
            ],
            [   "namaLantai" => "Tanah",
                "skorLantai" => 8
            ],
            [   "namaLantai" => "Lainnya",
                "skorLantai" => 9
            ]
        ]);        
    }
}
