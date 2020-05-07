<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AtapSeeder::class,
            DindingSeeder::class,
            KondisiAtapSeeder::class,
            KondisiDindingSeeder::class,
            LantaiSeeder::class
        ]);
    }
}