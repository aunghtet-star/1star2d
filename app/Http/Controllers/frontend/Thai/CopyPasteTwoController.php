<?php

namespace App\Http\Controllers\frontend\Thai;

use App\Http\Controllers\Controller;
use App\ShowHide;
use App\Two;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyanLottery\Lottery\Twod;

class CopyPasteTwoController extends Controller
{
    public function index(){

        $twoform = ShowHide::where('name', 'twoform')->first();

        return view('frontend.two.two-copy-paste', compact('twoform'));
    }

    public function twoconfirm(Request $request){
        $twos = preg_split("/\r\n|\n|\r/", $request->two);

        return view('frontend.two.two-copy-confirm',compact('twos'));

    }


    public function result(Request $request){

        foreach ($request->twos as $two) {

            $newTwo = new Twod();

            // For normal Two
            $third_word_array = str_split($two, 3)[0];
            $last_word = substr($third_word_array, 2)[0];


            //For Normal and r
            if (strpos($two, '.')!==false and substr_count($two, "r") === 1) {

                // For normal and R
                $split_numbers = explode('.',$two);
                $last_array_of_split_number =  end($split_numbers);
                $amount_for_normal_and_r =  explode(' ',$last_array_of_split_number);


                $dae_amount = $amount_for_normal_and_r[1];
                $r_amount = $amount_for_normal_and_r[3];



                unset($split_numbers[count($split_numbers)-1]);

                foreach ($split_numbers as $split_number){

                    //for date
                    $response[] = [$split_number,$dae_amount];

                    //for R
                    $r_two = $newTwo->reverse_string($split_number)->getData()->data;
                    $response[] = [$r_two,$r_amount];
                }


                // For the last two D number
                $response[] = [$amount_for_normal_and_r[0],$dae_amount];
                $response[] = [$newTwo->reverse_string($amount_for_normal_and_r[0])->getData()->data,$r_amount];


            }


            //For R multi

            if (substr_count($two, "r") > 1){
                $split_numbers = explode('.',$two);

                $last_array_of_split_number =  end($split_numbers);
                $amount_array =  explode(' rr ',$last_array_of_split_number);



                $dae_amount = $amount_array[1];

                unset($split_numbers[count($split_numbers)-1]);



                foreach ($split_numbers as $split_number) {
                    $response[] = [$split_number, $dae_amount];

                    //for R
                    $r_two = $newTwo->reverse_string($split_number)->getData()->data;
                    $response[] = [$r_two,$dae_amount];
                }




                // For the last two D number
                $response[] = [$amount_array[0],$dae_amount];

                $r_two = $newTwo->reverse_string($amount_array[0])->getData()->data;

                $response[] = [$r_two,$dae_amount];


            }



            // For normal multi

            if (substr_count($two, ".") > 1 and !strpos($two, 'r')!== false){
                $split_numbers = explode('.',$two);

                $last_array_of_split_number =  end($split_numbers);
                $amount_array =  explode(' ',$last_array_of_split_number);



                $dae_amount = $amount_array[1];

                unset($split_numbers[count($split_numbers)-1]);


                foreach ($split_numbers as $split_number) {
                    $response[] = [$split_number, $dae_amount];
                }

                // For the last two D number
                $response[] = [$amount_array[0],$dae_amount];


            }




            if ($last_word === '=') {
                $third_word = explode('=', $two);
                $amount = end($third_word);
                $response[] = [$third_word[0], $amount];

            }

            if (substr_count($two, ".") === 1 and !strpos($two, 'r')!== false) {
                $third_word = explode('.', $two);
                $amount = end($third_word);
                $response[] = [$third_word[0], $amount];
            }



            if ($last_word === ' ') {
                $third_word = explode(' ', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === '/') {
                $third_word = explode('/', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === ':') {
                $third_word = explode(':', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === ';') {
                $third_word = explode(';', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === ',') {
                $third_word = explode(',', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === '*') {
                $third_word = explode(',', $two);
                $amount = end($third_word);

                $response[] = [$third_word[0], $amount];

            }

            if ($last_word === 'r') {
                $third_word = explode('r', $two);
                $amount = end($third_word);
                $r_two = $newTwo->reverse_string($third_word[0])->getData()->data;

                $response[] = [$third_word[0], $amount];
                $response[] = [$r_two, $amount];

            }

            if ($last_word === 'R') {
                $third_word = explode('R', $two);
                $amount = end($third_word);
                $r_two = $newTwo->reverse_string($third_word[0])->getData()->data;

                $response[] = [$third_word[0], $amount];
                $response[] = [$r_two, $amount];

            }

        }


        $total = 0;
        foreach ($response as $res){
            $total += $res[1];
        }

        return view('frontend.two.two-copy-result',compact('response','total'));

    }

    public function two(Request $request)
    {

        foreach ($request->twos as $two){
            $response[] = explode(',',$two);
        }



        foreach ($response as $two) {
            Two::create([
                'user_id' => Auth::user()->id,
                'admin_user_id' => Auth::user()->admin_user_id,
                'two' => $two[0],
                'amount' => $two[1],
                'date' => now()
            ]);
        }

        return redirect('/copy-paste-two')->with('create', 'Done');
    }


}
