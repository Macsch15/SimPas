<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SimPas\Repository\User::class, 50)->create();
        factory(\SimPas\Repository\PastebinRecord::class, 150)->create();
    }
}
