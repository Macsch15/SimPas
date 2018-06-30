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
        factory(\SimPas\Models\User::class, 50)->create();
        factory(\SimPas\Models\PastebinRecord::class, 150)->create();
    }
}
