<?php

namespace App\Http\Controllers\frontend;

use App\Two;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HtaitPaitController extends Controller
{
    public function index()
    {
        return view('frontend.two.htaitpait');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        
        //----------------- htait ------------------------------
        if (!is_null($request->zerohtait)) {
            $zerohtaits =  explode('-', $request->zerohtait);
        
            if ($zerohtaits) {
                foreach ($zerohtaits as $key=>$zerohtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $zerohtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->onehtait)) {
            $onehtaits =  explode('-', $request->onehtait);
        
            if ($onehtaits) {
                foreach ($onehtaits as $key=>$onehtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $onehtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->twohtait)) {
            $twohtaits =  explode('-', $request->twohtait);
        
            if ($twohtaits) {
                foreach ($twohtaits as $key=>$twohtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $twohtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }
        


        if (!is_null($request->threehtait)) {
            $threehtaits =  explode('-', $request->threehtait);
            if ($threehtaits) {
                foreach ($threehtaits as $key=>$threehtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $threehtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fourhtait)) {
            $fourhtaits =  explode('-', $request->fourhtait);
            if ($fourhtaits) {
                foreach ($fourhtaits as $key=>$fourhtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fourhtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fivehtait)) {
            $fivehtaits =  explode('-', $request->fivehtait);
            if ($fivehtaits) {
                foreach ($fivehtaits as $key=>$fivehtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fivehtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->sixhtait)) {
            $sixhtaits =  explode('-', $request->sixhtait);
            if ($sixhtaits) {
                foreach ($sixhtaits as $key=>$sixhtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sixhtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }


        if (!is_null($request->sevenhtait)) {
            $sevenhtaits =  explode('-', $request->sevenhtait);
            if ($sevenhtaits) {
                foreach ($sevenhtaits as $key=>$sevenhtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sevenhtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->eighthtait)) {
            $eighthtaits =  explode('-', $request->eighthtait);
            if ($eighthtaits) {
                foreach ($eighthtaits as $key=>$eighthtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $eighthtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->ninehtait)) {
            $ninehtaits =  explode('-', $request->ninehtait);
            if ($ninehtaits) {
                foreach ($ninehtaits as $key=>$ninehtait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $ninehtait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }



        //----------------- Pait ------------------------------

        if (!is_null($request->zeropait)) {
            $zeropaits =  explode('-', $request->zeropait);
        
            if ($zeropaits) {
                foreach ($zeropaits as $key=>$zeropait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $zeropait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->onepait)) {
            $onepaits =  explode('-', $request->onepait);
        
            if ($onepaits) {
                foreach ($onepaits as $key=>$onepait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $onepait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->twopait)) {
            $twopaits =  explode('-', $request->twopait);
        
            if ($twopaits) {
                foreach ($twopaits as $key=>$twopait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $twopait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }
        


        if (!is_null($request->threepait)) {
            $threepaits =  explode('-', $request->threepait);
            if ($threepaits) {
                foreach ($threepaits as $key=>$threepait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $threepait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fourpait)) {
            $fourpaits =  explode('-', $request->fourpait);
            if ($fourpaits) {
                foreach ($fourpaits as $key=>$fourpait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fourpait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fivepait)) {
            $fivepaits =  explode('-', $request->fivepait);
            if ($fivepaits) {
                foreach ($fivepaits as $key=>$fivepait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fivepait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->sixpait)) {
            $sixpaits =  explode('-', $request->sixpait);
            if ($sixpaits) {
                foreach ($sixpaits as $key=>$sixpait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sixpait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }


        if (!is_null($request->sevenpait)) {
            $sevenpaits =  explode('-', $request->sevenpait);
            if ($sevenpaits) {
                foreach ($sevenpaits as $key=>$sevenpait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sevenpait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->eightpait)) {
            $eightpaits =  explode('-', $request->eightpait);
            if ($eightpaits) {
                foreach ($eightpaits as $key=>$eightpait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $eightpait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->ninepait)) {
            $ninepaits =  explode('-', $request->ninepait);
            if ($ninepaits) {
                foreach ($ninepaits as $key=>$ninepait) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $ninepait;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        //----------------- Brake ------------------------------

        if (!is_null($request->zerobrake)) {
            $zerobrakes =  explode('-', $request->zerobrake);
        
            if ($zerobrakes) {
                foreach ($zerobrakes as $key=>$zerobrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $zerobrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->onebrake)) {
            $onebrakes =  explode('-', $request->onebrake);
        
            if ($onebrakes) {
                foreach ($onebrakes as $key=>$onebrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $onebrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->twobrake)) {
            $twobrakes =  explode('-', $request->twobrake);
        
            if ($twobrakes) {
                foreach ($twobrakes as $key=>$twobrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $twobrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }
        


        if (!is_null($request->threebrake)) {
            $threebrakes =  explode('-', $request->threebrake);
            if ($threebrakes) {
                foreach ($threebrakes as $key=>$threebrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $threebrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fourbrake)) {
            $fourbrakes =  explode('-', $request->fourbrake);
            if ($fourbrakes) {
                foreach ($fourbrakes as $key=>$fourbrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fourbrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fivebrake)) {
            $fivebrakes =  explode('-', $request->fivebrake);
            if ($fivebrakes) {
                foreach ($fivebrakes as $key=>$fivebrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fivebrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->sixbrake)) {
            $sixbrakes =  explode('-', $request->sixbrake);
            if ($sixbrakes) {
                foreach ($sixbrakes as $key=>$sixbrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sixbrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }


        if (!is_null($request->sevenbrake)) {
            $sevenbrakes =  explode('-', $request->sevenbrake);
            if ($sevenbrakes) {
                foreach ($sevenbrakes as $key=>$sevenbrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sevenbrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->eightbrake)) {
            $eightbrakes =  explode('-', $request->eightbrake);
            if ($eightbrakes) {
                foreach ($eightbrakes as $key=>$eightbrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $eightbrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->ninebrake)) {
            $ninebrakes =  explode('-', $request->ninebrake);
            if ($ninebrakes) {
                foreach ($ninebrakes as $key=>$ninebrake) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $ninebrake;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        //----------------- a par ------------------------------

        if (!is_null($request->zeropar)) {
            $zeropars =  explode('-', $request->zeropar);
        
            if ($zeropars) {
                foreach ($zeropars as $key=>$zeropar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $zeropar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->onepar)) {
            $onepars =  explode('-', $request->onepar);
        
            if ($onepars) {
                foreach ($onepars as $key=>$onepar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $onepar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->twopar)) {
            $twopars =  explode('-', $request->twopar);
        
            if ($twopars) {
                foreach ($twopars as $key=>$twopar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $twopar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }
        


        if (!is_null($request->threepar)) {
            $threepars =  explode('-', $request->threepar);
            if ($threepars) {
                foreach ($threepars as $key=>$threepar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $threepar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fourpar)) {
            $fourpars =  explode('-', $request->fourpar);
            if ($fourpars) {
                foreach ($fourpars as $key=>$fourpar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fourpar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->fivepar)) {
            $fivepars =  explode('-', $request->fivepar);
            if ($fivepars) {
                foreach ($fivepars as $key=>$fivepar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $fivepar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->sixpar)) {
            $sixpars =  explode('-', $request->sixpar);
            if ($sixpars) {
                foreach ($sixpars as $key=>$sixpar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sixpar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }


        if (!is_null($request->sevenpar)) {
            $sevenpars =  explode('-', $request->sevenpar);
            if ($sevenpars) {
                foreach ($sevenpars as $key=>$sevenpar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $sevenpar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->eightpar)) {
            $eightpars =  explode('-', $request->eightpar);
            if ($eightpars) {
                foreach ($eightpars as $key=>$eightpar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $eightpar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->ninepar)) {
            $ninepars =  explode('-', $request->ninepar);
            if ($ninepars) {
                foreach ($ninepars as $key=>$ninepar) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $ninepar;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->ten)) {
            $tens =  explode('-', $request->ten);
            if ($tens) {
                foreach ($tens as $key=>$ten) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $ten;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->power)) {
            $powers =  explode('-', $request->power);
            if ($powers) {
                foreach ($powers as $key=>$power) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $power;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->natkhat)) {
            $natkhats =  explode('-', $request->natkhat);
            if ($natkhats) {
                foreach ($natkhats as $key=>$natkhat) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $natkhat;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }

        if (!is_null($request->brother)) {
            $brothers =  explode('-', $request->brother);
            if ($brothers) {
                foreach ($brothers as $key=>$brother) {
                    $htaitpait = new Two();
                    $htaitpait->user_id = Auth()->user()->id;
                    $htaitpait->date = now()->format('Y-m-d');
                    $htaitpait->two = $brother;
                    $htaitpait->amount = $request->amount;
                    $htaitpait->save();
                }
            }
        }
       
        return back()->with('create', 'Done');
    }
}
