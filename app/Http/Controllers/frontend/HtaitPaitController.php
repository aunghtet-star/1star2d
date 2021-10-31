<?php

namespace App\Http\Controllers\frontend;

use App\Two;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHtaitPait;
use Illuminate\Support\Facades\Auth;

class HtaitPaitController extends Controller
{
    public function index()
    {
        return view('frontend.two.htaitpait');
    }


    public function confirm(StoreHtaitPait $request)
    {
        $zerohtaits = $onehtaits = $twohtaits = $threehtaits = $fourhtaits = $fivehtaits = $sixhtaits = $sevenhtaits = $eighthtaits = $ninehtaits = '';
        $amount = $request->amount ;
        
        if (!is_null($request->zerohtait)) {
            $zerohtaits =  explode('-', $request->zerohtait);
        }

        if (!is_null($request->onehtait)) {
            $onehtaits =  explode('-', $request->onehtait);
        }

        if (!is_null($request->twohtait)) {
            $twohtaits =  explode('-', $request->twohtait);
        }

        if (!is_null($request->threehtait)) {
            $threehtaits =  explode('-', $request->threehtait);
        }

        if (!is_null($request->fourhtait)) {
            $fourhtaits =  explode('-', $request->fourhtait);
        }

        if (!is_null($request->fivehtait)) {
            $fivehtaits =  explode('-', $request->fivehtait);
        }

        if (!is_null($request->sixhtait)) {
            $sixhtaits =  explode('-', $request->sixhtait);
        }


        if (!is_null($request->sevenhtait)) {
            $sevenhtaits =  explode('-', $request->sevenhtait);
        }

        if (!is_null($request->eighthtait)) {
            $eighthtaits =  explode('-', $request->eighthtait);
        }

        if (!is_null($request->ninehtait)) {
            $ninehtaits =  explode('-', $request->ninehtait);
        }


        $zeropaits = $onepaits = $twopaits = $threepaits = $fourpaits = $fivepaits = $sixpaits = $sevenpaits = $eightpaits = $ninepaits = '';
        
        if (!is_null($request->zeropait)) {
            $zeropaits =  explode('-', $request->zeropait);
        }

        if (!is_null($request->onepait)) {
            $onepaits =  explode('-', $request->onepait);
        }

        if (!is_null($request->twopait)) {
            $twopaits =  explode('-', $request->twopait);
        }

        if (!is_null($request->threepait)) {
            $threepaits =  explode('-', $request->threepait);
        }

        if (!is_null($request->fourpait)) {
            $fourpaits =  explode('-', $request->fourpait);
        }

        if (!is_null($request->fivepait)) {
            $fivepaits =  explode('-', $request->fivepait);
        }

        if (!is_null($request->sixpait)) {
            $sixpaits =  explode('-', $request->sixpait);
        }


        if (!is_null($request->sevenpait)) {
            $sevenpaits =  explode('-', $request->sevenpait);
        }

        if (!is_null($request->eightpait)) {
            $eightpaits =  explode('-', $request->eightpait);
        }

        if (!is_null($request->ninepait)) {
            $ninepaits =  explode('-', $request->ninepait);
        }

        $zerobrakes = $onebrakes = $twobrakes = $threebrakes = $fourbrakes = $fivebrakes = $sixbrakes = $sevenbrakes = $eightbrakes = $ninebrakes = '';
        
        if (!is_null($request->zerobrake)) {
            $zerobrakes =  explode('-', $request->zerobrake);
        }

        if (!is_null($request->onebrake)) {
            $onebrakes =  explode('-', $request->onebrake);
        }

        if (!is_null($request->twobrake)) {
            $twobrakes =  explode('-', $request->twobrake);
        }

        if (!is_null($request->threebrake)) {
            $threebrakes =  explode('-', $request->threebrake);
        }

        if (!is_null($request->fourbrake)) {
            $fourbrakes =  explode('-', $request->fourbrake);
        }

        if (!is_null($request->fivebrake)) {
            $fivebrakes =  explode('-', $request->fivebrake);
        }

        if (!is_null($request->sixbrake)) {
            $sixbrakes =  explode('-', $request->sixbrake);
        }


        if (!is_null($request->sevenbrake)) {
            $sevenbrakes =  explode('-', $request->sevenbrake);
        }

        if (!is_null($request->eightbrake)) {
            $eightbrakes =  explode('-', $request->eightbrake);
        }

        if (!is_null($request->ninebrake)) {
            $ninebrakes =  explode('-', $request->ninebrake);
        }


        $zeropars = $onepars = $twopars = $threepars = $fourpars = $fivepars = $sixpars = $sevenpars = $eightpars = $ninepars = '';
        
        if (!is_null($request->zeropar)) {
            $zeropars =  explode('-', $request->zeropar);
        }

        if (!is_null($request->onepar)) {
            $onepars =  explode('-', $request->onepar);
        }

        if (!is_null($request->twopar)) {
            $twopars =  explode('-', $request->twopar);
        }

        if (!is_null($request->threepar)) {
            $threepars =  explode('-', $request->threepar);
        }

        if (!is_null($request->fourpar)) {
            $fourpars =  explode('-', $request->fourpar);
        }

        if (!is_null($request->fivepar)) {
            $fivepars =  explode('-', $request->fivepar);
        }

        if (!is_null($request->sixpar)) {
            $sixpars =  explode('-', $request->sixpar);
        }


        if (!is_null($request->sevenpar)) {
            $sevenpars =  explode('-', $request->sevenpar);
        }

        if (!is_null($request->eightpar)) {
            $eightpars =  explode('-', $request->eightpar);
        }

        if (!is_null($request->ninepar)) {
            $ninepars =  explode('-', $request->ninepar);
        }

        $apuus = $tens = $powers = $natkhats = $brothers = '';
        if (!is_null($request->apuu)) {
            $apuus =  explode('-', $request->apuu);
        }

        if (!is_null($request->ten)) {
            $tens =  explode('-', $request->ten);
        }

        if (!is_null($request->power)) {
            $powers =  explode('-', $request->power);
        }

        if (!is_null($request->natkhat)) {
            $natkhats =  explode('-', $request->natkhat);
        }

        if (!is_null($request->brother)) {
            $brothers =  explode('-', $request->brother);
        }

        return view('frontend.two.htaitpaitconfirm', compact('amount', 'zerohtaits', 'onehtaits', 'twohtaits', 'threehtaits', 'fourhtaits', 'fivehtaits', 'sixhtaits', 'sevenhtaits', 'eighthtaits', 'ninehtaits', 'zeropaits', 'onepaits', 'twopaits', 'threepaits', 'fourpaits', 'fivepaits', 'sixpaits', 'sevenpaits', 'eightpaits', 'ninepaits', 'zerobrakes', 'onebrakes', 'twobrakes', 'threebrakes', 'fourbrakes', 'fivebrakes', 'sixbrakes', 'sevenbrakes', 'eightbrakes', 'ninebrakes', 'zeropars', 'onepars', 'twopars', 'threepars', 'fourpars', 'fivepars', 'sixpars', 'sevenpars', 'eightpars', 'ninepars', 'apuus', 'tens', 'powers', 'natkhats', 'brothers'));
    }

    public function store(StoreHtaitPait $request)
    {
        //----------------- htait ------------------------------
        $zerohtaits = $request->zerohtaits;
        $onehtaits = $request->onehtaits;
        $twohtaits = $request->twohtaits;
        $threehtaits = $request->threehtaits;
        $fourhtaits = $request->fourhtaits;
        $fivehtaits = $request->fivehtaits;
        $sixhtaits = $request->sixhtaits;
        $sevenhtaits = $request->sevenhtaits;
        $eighthtaits = $request->eighthtaits;
        $ninehtaits = $request->ninehtaits;

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



        //----------------- Pait ------------------------------

        $zeropaits = $request->zeropaits;
        $onepaits = $request->onepaits;
        $twopaits = $request->twopaits;
        $threepaits = $request->threepaits;
        $fourpaits = $request->fourpaits;
        $fivepaits = $request->fivepaits;
        $sixpaits = $request->sixpaits;
        $sevenpaits = $request->sevenpaits;
        $eightpaits = $request->eightpaits;
        $ninepaits = $request->ninepaits;

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
        

        //----------------- Brake ------------------------------

        $zerobrakes = $request->zerobrakes;
        $onebrakes = $request->onebrakes;
        $twobrakes = $request->twobrakes;
        $threebrakes = $request->threebrakes;
        $fourbrakes = $request->fourbrakes;
        $fivebrakes = $request->fivebrakes;
        $sixbrakes = $request->sixbrakes;
        $sevenbrakes = $request->sevenbrakes;
        $eightbrakes = $request->eightbrakes;
        $ninebrakes = $request->ninebrakes;

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


        //----------------- a par ------------------------------

        $zeropars = $request->zeropars;
        $onepars = $request->onepars;
        $twopars = $request->twopars;
        $threepars = $request->threepars;
        $fourpars = $request->fourpars;
        $fivepars = $request->fivepars;
        $sixpars = $request->sixpars;
        $sevenpars = $request->sevenpars;
        $eightpars = $request->eightpars;
        $ninepars = $request->ninepars;

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

        $tens = $request->tens;

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
       
        $powers = $request->powers;

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
   
        $natkhats = $request->natkhats;

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
        
        $brothers = $request->brothers;

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
        
        $apuus = $request->apuus;

        if ($apuus) {
            foreach ($apuus as $key=>$apuu) {
                $htaitpait = new Two();
                $htaitpait->user_id = Auth()->user()->id;
                $htaitpait->date = now()->format('Y-m-d');
                $htaitpait->two = $apuu;
                $htaitpait->amount = $request->amount;
                $htaitpait->save();
            }
        }
        
       
        return redirect('two/htaitpait')->with('create', 'Done');
    }
}
