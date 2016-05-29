<?php

use Illuminate\Database\Seeder;

class PastebinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SimPas\PastebinRecord::class, 100)->create();
    }
}
