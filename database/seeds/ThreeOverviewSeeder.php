<?php

use App\Three;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreeOverviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $periods =new CarbonPeriod('2023-5-15', '2023-5-31');
            foreach ($periods as $period) {
                $three = new Three();
                $three->user_id = $user->id;
                $three->three = rand(100, 999);
                $three->amount = '5000';
                $three->date = $period->format('Y-m-d');
                $three->created_at = $period->format('Y-m-d'). ' '. '09:00:00';
                $three->updated_at = $period->format('Y-m-d'). ' '. '13:00:00';
                $three->save();
            }
        }
    }
}
