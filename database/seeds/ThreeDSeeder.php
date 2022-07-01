<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreeDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i++;$i<2){
            DB::table('threes')->insert([
                'master_id' => '1',
                'user_id' => '1',
                'admin_user_id' => '4',
                'batch'=>36,
                'three' => rand(100,999),
                'date' => '2022-06-17',
                'amount'=>500,
                'created_at'=>now()->format('Y-m-d H:i:s'),
                'updated_at'=>now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
