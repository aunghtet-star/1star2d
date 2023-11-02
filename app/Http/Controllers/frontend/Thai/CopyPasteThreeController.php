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

        return view('frontend.three.three-copy-confirm',compact('threes'));
    }

    public function threeresult(Request $request){


        foreach ($request->threes as $three){

            $forth_word_array = str_split($three,4)[0];
            $last_word = substr($forth_word_array,3)[0];


            $threeD = new Threed();

            if ($last_word === '='){
                $forth_word = explode('=',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === '-'){
                $forth_word = explode('-',$three);
                ;
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }


            if ($last_word === '.'){
                $forth_word = explode('.',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ','){
                $forth_word = explode(',',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ':'){
                $forth_word = explode(':',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ';'){
                $forth_word = explode(';',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === '*'){
                $forth_word = explode('*',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === '/'){
                $forth_word = explode('/',$three);
                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }

            if ($last_word === ' '){

                $forth_word = explode(' ',$three);

                $amount = end($forth_word);

                $response[] = [$forth_word[0],$amount];
            }



            if ($last_word === '@'){
                $forth_word = explode('@',$three);
                $amount = end($forth_word);
                foreach ($threeD->r_origin_string($forth_word[0])->getData()->data as $data){
                    $response[] = [$data,$amount];
                }
            }

            if ($last_word === 'R'){
                $forth_word = explode('R',$three);
                $amount = end($forth_word);
                foreach ($threeD->r_origin_string($forth_word[0])->getData()->data as $data){
                    $response[] = [$data,$amount];
                }

            }

            if ($last_word === 'r'){
                $forth_word = explode('r',$three);
                $amount = end($forth_word);
                foreach ($threeD->r_origin_string($forth_word[0])->getData()->data as $data){
                    $response[] = [$data,$amount];
                }

            }

        }

        $total = 0;

        foreach ($response as $amount){
            $total += $amount[1];
        }



        return view('frontend.three.three-copy-result',compact('response','total'));


    }

    public function three(Request $request){

        foreach ($request->threes as $three){
            $response[] = explode(',',$three);
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

        $threeform = ShowHide::where('name', 'threeform')->first();

        return redirect('/copy-paste-three')->with('create', 'Done');
    }
}
