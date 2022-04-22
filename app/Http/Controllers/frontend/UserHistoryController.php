<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\ForUserHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserHistoryController extends Controller
{
    public function history()
    {
        return view('frontend.user.history');
    }

    public function historyTwo(Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        if ($time == 'all'){
            $two = ForUserHistory::Two($date,'00:00:00','23:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];


            $three = ForUserHistory::Three($date,'00:00:00','23:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];

        }

        if ($time == 'true') {

            $two = ForUserHistory::Two($date,'00:00:00','11:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];

            $three = ForUserHistory::Three($date,'00:00:00','11:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];

        }

        if ($time == 'false') {

            $two = ForUserHistory::Two($date,'11:59:00','23:59:00');
            $twototals = $two['two_totals'];
            $twousers = $two['two_users'];


            $three = ForUserHistory::Three($date,'11:59:00','23:59:00');
            $threetotals = $three['three_totals'];
            $threeusers = $three['three_users'];
        }

        return view('frontend.components.history', compact('twousers', 'twototals', 'threeusers', 'threetotals'))->render();
    }

    public function DubaiHistory(){
        return view('frontend.user.dubai_history');
    }

    public function historyOfDubaiTwo(Request $request){
        $date = $request->date;
        $time = $request->time;

        if ($time == 'all'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'00:00:00','23:59:00');
        }
        if ($time == '11am'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'00:00:00','11:00:00');
        }

        if ($time == '1pm'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'11:00:00','13:00:00');
        }

        if ($time == '3pm'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'13:00:00','15:00:00');
        }

        if ($time == '5pm'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'15:00:00','17:00:00');
        }

        if ($time == '7pm'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'17:00:00','19:00:00');
        }

        if ($time == '9pm'){
            $dubai_two = ForUserHistory::DubaiTwo($date,'19:00:00','23:59:00');
        }

        $dubai_twototals = $dubai_two['dubai_two_totals'];
        $dubai_twousers = $dubai_two['dubai_two_users'];

        return view('frontend.components.dubai_history', compact('dubai_twousers','dubai_twototals'))->render();
    }
}
