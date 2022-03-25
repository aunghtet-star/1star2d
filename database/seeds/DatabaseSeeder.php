<?php

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ShowHideSeeder;
use Database\Seeders\AdminRoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(ShowHideSeeder::class);
        $this->call(AdminRoleSeeder::class);
    }
}
