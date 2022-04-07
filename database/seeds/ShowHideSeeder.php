<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ShowHideSeeder;

class ShowHideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('show_hides')->insert([
            'admin_user_id' => '1',
            'name' => 'twoform',
            'status' => 'show'
        ]);

        DB::table('show_hides')->insert([
            'admin_user_id' => '1',
            'name' => 'threeform',
            'status' => 'show'
        ]);

        DB::table('show_hides')->insert([
            'admin_user_id' => '1',
            'name' => 'htaitpaitform',
            'status' => 'show'
        ]);
    }
}
