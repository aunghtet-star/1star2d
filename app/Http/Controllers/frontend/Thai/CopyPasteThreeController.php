<?php

namespace App\Http\Controllers\frontend\Thai;

use App\Http\Controllers\Controller;
use App\ShowHide;
use App\Three;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyanLottery\Lottery\Threed;



class CopyPasteThreeController extends Controller
{
    public function index(){

        $threeform = ShowHide::where('name', 'threeform')->first();

        return view('frontend.three.three-copy-paste', compact('threeform'));
    }

    public function threeconfirm(Request $request){
        $threes = preg_split("/\r\n|\n|\r/", $request->three);


        foreach ($threes as $three){

            $forth_word_array = str_split($three,4)[0];
            $last_word = substr($forth_word_array,3)[0];


            $threeD = new Threed();



            if ($last_word === '='){
                $forth_word = explode('=',$three);
                $amount = $forth_word[1];

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === '.'){
                $forth_word = explode('.',$three);
                $amount = $forth_word[1];

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ','){
                $forth_word = explode(',',$three);
                $amount = $forth_word[1];

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ' '){
                $forth_word = explode(' ',$three);
                $amount = $forth_word[1];

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === '@'){
                $forth_word = explode('@',$three);
                $amount = $forth_word[1];
                foreach ($threeD->r_origin_string($forth_word[0])->getData()->data as $data){
                    $response[] = [$data,$amount];
                }
            }

            if ($last_word === 'R'){
                $forth_word = explode('R',$three);
                $amount = $forth_word[1];
                foreach ($threeD->r_origin_string($forth_word[0])->getData()->data as $data){
                    $response[] = [$data,$amount];
                }
            }

        }


        foreach ($response as $three){
            Three::create([
                'user_id' => Auth::user()->id,
                'admin_user_id' => Auth::user()->admin_user_id,
                'three' => $three[0],
                'amount' => $three[1],
                'date' => now()
            ]);
        }


        return back();
    }
}
