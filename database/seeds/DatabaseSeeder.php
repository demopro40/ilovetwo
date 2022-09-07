<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Seeder\AdminSeeder;
use Illuminate\Database\Seeder\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(DBSeeder::class);
        $this->call(DB2Seeder::class);
    }
}
