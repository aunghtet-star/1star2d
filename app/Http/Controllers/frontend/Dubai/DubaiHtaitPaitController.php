<?php

namespace App\Http\Controllers\frontend\Dubai;

use App\AdminUser;
use App\BetHistory;
use App\DubaiTwo;
use App\Helpers\ForWalletAndBetHistory;
use App\Helpers\HtaitPaitForeach;
use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHtaitPait;
use App\ShowHide;
use App\Two;
use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DubaiHtaitPaitController extends Controller
{
    public function index()
    {
        $htaitpaitform = ShowHide::where('name', 'dubai_htaitpaitform')->first();

        return view('frontend.dubai-two.htaitpait', compact('htaitpaitform'));
    }


    public function confirm(StoreHtaitPait $request)
    {
        $zerohtaits = $onehtaits = $twohtaits = $threehtaits = $fourhtaits = $fivehtaits = $sixhtaits = $sevenhtaits = $eighthtaits = $ninehtaits = '';
        $amount = $request->amount ;

        if (!is_null($request->zerohtait)) {
            $zerohtaits =  explode('-', $request->zerohtait);
            $zerohtaits = HtaitPaitForeach::Brake($zerohtaits,$amount);
        }

        if (!is_null($request->onehtait)) {
            $onehtaits =  explode('-', $request->onehtait);
            $onehtaits = HtaitPaitForeach::DubaiBrake($onehtaits,$amount);
        }

        if (!is_null($request->twohtait)) {
            $twohtaits =  explode('-', $request->twohtait);
            $twohtaits = HtaitPaitForeach::DubaiBrake($twohtaits,$amount);
        }

        if (!is_null($request->threehtait)) {
            $threehtaits =  explode('-', $request->threehtait);
            $threehtaits = HtaitPaitForeach::DubaiBrake($threehtaits,$amount);
        }

        if (!is_null($request->fourhtait)) {
            $fourhtaits =  explode('-', $request->fourhtait);
            $fourhtaits = HtaitPaitForeach::DubaiBrake($fourhtaits,$amount);
        }

        if (!is_null($request->fivehtait)) {
            $fivehtaits =  explode('-', $request->fivehtait);
            $fivehtaits = HtaitPaitForeach::DubaiBrake($fivehtaits,$amount);
        }

        if (!is_null($request->sixhtait)) {
            $sixhtaits =  explode('-', $request->sixhtait);
            $sixhtaits = HtaitPaitForeach::DubaiBrake($sixhtaits,$amount);
        }


        if (!is_null($request->sevenhtait)) {
            $sevenhtaits =  explode('-', $request->sevenhtait);
            $sevenhtaits = HtaitPaitForeach::DubaiBrake($sevenhtaits,$amount);
        }

        if (!is_null($request->eighthtait)) {
            $eighthtaits =  explode('-', $request->eighthtait);
            $eighthtaits = HtaitPaitForeach::DubaiBrake($eighthtaits,$amount);
        }

        if (!is_null($request->ninehtait)) {
            $ninehtaits =  explode('-', $request->ninehtait);
            $ninehtaits = HtaitPaitForeach::DubaiBrake($ninehtaits,$amount);
        }


        $zeropaits = $onepaits = $twopaits = $threepaits = $fourpaits = $fivepaits = $sixpaits = $sevenpaits = $eightpaits = $ninepaits = '';

        if (!is_null($request->zeropait)) {
            $zeropaits =  explode('-', $request->zeropait);
            $zeropaits = HtaitPaitForeach::DubaiBrake($zeropaits,$amount);

        }

        if (!is_null($request->onepait)) {
            $onepaits =  explode('-', $request->onepait);
            $onepaits = HtaitPaitForeach::DubaiBrake($onepaits,$amount);
        }

        if (!is_null($request->twopait)) {
            $twopaits =  explode('-', $request->twopait);
            $twopaits = HtaitPaitForeach::DubaiBrake($twopaits,$amount);
        }

        if (!is_null($request->threepait)) {
            $threepaits =  explode('-', $request->threepait);
            $threepaits = HtaitPaitForeach::DubaiBrake($threepaits,$amount);
        }

        if (!is_null($request->fourpait)) {
            $fourpaits =  explode('-', $request->fourpait);
            $fourpaits = HtaitPaitForeach::DubaiBrake($fourpaits,$amount);
        }

        if (!is_null($request->fivepait)) {
            $fivepaits =  explode('-', $request->fivepait);
            $fivepaits = HtaitPaitForeach::DubaiBrake($fivepaits,$amount);
        }

        if (!is_null($request->sixpait)) {
            $sixpaits =  explode('-', $request->sixpait);
            $sixpaits = HtaitPaitForeach::DubaiBrake($sixpaits,$amount);
        }


        if (!is_null($request->sevenpait)) {
            $sevenpaits =  explode('-', $request->sevenpait);
            $sevenpaits = HtaitPaitForeach::DubaiBrake($sevenpaits,$amount);
        }

        if (!is_null($request->eightpait)) {
            $eightpaits =  explode('-', $request->eightpait);
            $eightpaits = HtaitPaitForeach::DubaiBrake($eightpaits,$amount);
        }

        if (!is_null($request->ninepait)) {
            $ninepaits =  explode('-', $request->ninepait);
            $ninepaits = HtaitPaitForeach::DubaiBrake($ninepaits,$amount);
        }

        $zerobrakes = $onebrakes = $twobrakes = $threebrakes = $fourbrakes = $fivebrakes = $sixbrakes = $sevenbrakes = $eightbrakes = $ninebrakes = '';

        if (!is_null($request->zerobrake)) {
            $zerobrakes =  explode('-', $request->zerobrake);
            $zerobrakes = HtaitPaitForeach::DubaiBrake($zerobrakes,$amount);

        }

        if (!is_null($request->onebrake)) {
            $onebrakes =  explode('-', $request->onebrake);
            $onebrakes = HtaitPaitForeach::DubaiBrake($onebrakes,$amount);
        }

        if (!is_null($request->twobrake)) {
            $twobrakes =  explode('-', $request->twobrake);
            $twobrakes = HtaitPaitForeach::DubaiBrake($twobrakes,$amount);
        }

        if (!is_null($request->threebrake)) {
            $threebrakes =  explode('-', $request->threebrake);
            $threebrakes = HtaitPaitForeach::DubaiBrake($threebrakes,$amount);
        }

        if (!is_null($request->fourbrake)) {
            $fourbrakes =  explode('-', $request->fourbrake);
            $fourbrakes = HtaitPaitForeach::DubaiBrake($fourbrakes,$amount);
        }

        if (!is_null($request->fivebrake)) {
            $fivebrakes =  explode('-', $request->fivebrake);
            $fivebrakes = HtaitPaitForeach::DubaiBrake($fivebrakes,$amount);
        }

        if (!is_null($request->sixbrake)) {
            $sixbrakes =  explode('-', $request->sixbrake);
            $sixbrakes = HtaitPaitForeach::DubaiBrake($sixbrakes,$amount);
        }


        if (!is_null($request->sevenbrake)) {
            $sevenbrakes =  explode('-', $request->sevenbrake);
            $sevenbrakes = HtaitPaitForeach::DubaiBrake($sevenbrakes,$amount);
        }

        if (!is_null($request->eightbrake)) {
            $eightbrakes =  explode('-', $request->eightbrake);
            $eightbrakes = HtaitPaitForeach::DubaiBrake($eightbrakes,$amount);
        }

        if (!is_null($request->ninebrake)) {
            $ninebrakes =  explode('-', $request->ninebrake);
            $ninebrakes = HtaitPaitForeach::DubaiBrake($ninebrakes,$amount);
        }


        $zeropars = $onepars = $twopars = $threepars = $fourpars = $fivepars = $sixpars = $sevenpars = $eightpars = $ninepars = '';

        if (!is_null($request->zeropar)) {
            $zeropars =  explode('-', $request->zeropar);
            $zeropars = HtaitPaitForeach::DubaiBrake($zeropars,$amount);

        }

        if (!is_null($request->onepar)) {
            $onepars =  explode('-', $request->onepar);
            $onepars = HtaitPaitForeach::DubaiBrake($onepars,$amount);
        }

        if (!is_null($request->twopar)) {
            $twopars =  explode('-', $request->twopar);
            $twopars = HtaitPaitForeach::DubaiBrake($twopars,$amount);
        }

        if (!is_null($request->threepar)) {
            $threepars =  explode('-', $request->threepar);
            $threepars = HtaitPaitForeach::DubaiBrake($threepars,$amount);
        }

        if (!is_null($request->fourpar)) {
            $fourpars =  explode('-', $request->fourpar);
            $fourpars = HtaitPaitForeach::DubaiBrake($fourpars,$amount);
        }

        if (!is_null($request->fivepar)) {
            $fivepars =  explode('-', $request->fivepar);
            $fivepars = HtaitPaitForeach::DubaiBrake($fivepars,$amount);
        }

        if (!is_null($request->sixpar)) {
            $sixpars =  explode('-', $request->sixpar);
            $sixpars = HtaitPaitForeach::DubaiBrake($sixpars,$amount);
        }


        if (!is_null($request->sevenpar)) {
            $sevenpars =  explode('-', $request->sevenpar);
            $sevenpars = HtaitPaitForeach::DubaiBrake($sevenpars,$amount);
        }

        if (!is_null($request->eightpar)) {
            $eightpars =  explode('-', $request->eightpar);
            $eightpars = HtaitPaitForeach::DubaiBrake($eightpars,$amount);
        }

        if (!is_null($request->ninepar)) {
            $ninepars =  explode('-', $request->ninepar);
            $ninepars = HtaitPaitForeach::DubaiBrake($ninepars,$amount);
        }

        $apuus = $tens = $powers = $natkhats = $brothers = '';
        if (!is_null($request->apuu)) {
            $apuus =  explode('-', $request->apuu);
            $apuus = HtaitPaitForeach::DubaiBrake($apuus,$amount);
        }

        if (!is_null($request->ten)) {
            $tens =  explode('-', $request->ten);
            $tens = HtaitPaitForeach::DubaiBrake($tens,$amount);
        }

        if (!is_null($request->power)) {
            $powers =  explode('-', $request->power);
            $powers = HtaitPaitForeach::DubaiBrake($powers,$amount);
        }

        if (!is_null($request->natkhat)) {
            $natkhats =  explode('-', $request->natkhat);
            $natkhats = HtaitPaitForeach::DubaiBrake($natkhats,$amount);
        }

        if (!is_null($request->brother)) {
            $brothers =  explode('-', $request->brother);
            $brothers = HtaitPaitForeach::DubaiBrake($brothers,$amount);
        }

        $from_account_wallet = Auth()->user()->user_wallet;
        $to_account = AdminUser::where('id', Auth()->user()->admin_user_id)->first();
        $to_account_wallet = Wallet::where('admin_user_id', $to_account->id)->where('status', 'admin')->first();

        $totals = 0;

        //-------------- insufficient condition for  htait---------------
        if ($zerohtaits) {
            foreach ($zerohtaits as $key=>$zerohtait) {
                $totals += $request->amount;
            }
        }

        if ($onehtaits) {
            foreach ($onehtaits as $key=>$onehtait) {
                $totals += $request->amount;
            }
        }

        if ($twohtaits) {
            foreach ($twohtaits as $key=>$twohtait) {
                $totals += $request->amount;
            }
        }

        if ($threehtaits) {
            foreach ($threehtaits as $key=>$threehtait) {
                $totals += $request->amount;
            }
        }

        if ($fourhtaits) {
            foreach ($fourhtaits as $key=>$fourhtait) {
                $totals += $request->amount;
            }
        }

        if ($fivehtaits) {
            foreach ($fivehtaits as $key=>$fivehtait) {
                $totals += $request->amount;
            }
        }

        if ($sixhtaits) {
            foreach ($sixhtaits as $key=>$sixhtait) {
                $totals += $request->amount;
            }
        }

        if ($sevenhtaits) {
            foreach ($sevenhtaits as $key=>$sevenhtait) {
                $totals += $request->amount;
            }
        }

        if ($eighthtaits) {
            foreach ($eighthtaits as $key=>$eighthtait) {
                $totals += $request->amount;
            }
        }

        if ($ninehtaits) {
            foreach ($ninehtaits as $key=>$ninehtait) {
                $totals += $request->amount;
            }
        }

        //------------------------ insufficient condition for a pait------------------------
        if ($zeropaits) {
            foreach ($zeropaits as $key=>$zeropait) {
                $totals += $request->amount;
            }
        }

        if ($onepaits) {
            foreach ($onepaits as $key=>$onepait) {
                $totals += $request->amount;
            }
        }

        if ($twopaits) {
            foreach ($twopaits as $key=>$twopait) {
                $totals += $request->amount;
            }
        }

        if ($threepaits) {
            foreach ($threepaits as $key=>$threepait) {
                $totals += $request->amount;
            }
        }

        if ($fourpaits) {
            foreach ($fourpaits as $key=>$fourpait) {
                $totals += $request->amount;
            }
        }

        if ($fivepaits) {
            foreach ($fivepaits as $key=>$fivepait) {
                $totals += $request->amount;
            }
        }

        if ($sixpaits) {
            foreach ($sixpaits as $key=>$sixpait) {
                $totals += $request->amount;
            }
        }

        if ($sevenpaits) {
            foreach ($sevenpaits as $key=>$sevenpait) {
                $totals += $request->amount;
            }
        }

        if ($eightpaits) {
            foreach ($eightpaits as $key=>$eightpait) {
                $totals += $request->amount;
            }
        }

        if ($ninepaits) {
            foreach ($ninepaits as $key=>$ninepait) {
                $totals += $request->amount;
            }
        }

        //------------------------ insufficient condition for a Brake------------------------
        if ($zerobrakes) {
            foreach ($zerobrakes as $key=>$zerobrake) {
                $totals += $request->amount;
            }
        }

        if ($onebrakes) {
            foreach ($onebrakes as $key=>$onebrake) {
                $totals += $request->amount;
            }
        }

        if ($twobrakes) {
            foreach ($twobrakes as $key=>$twobrake) {
                $totals += $request->amount;
            }
        }

        if ($threebrakes) {
            foreach ($threebrakes as $key=>$threebrake) {
                $totals += $request->amount;
            }
        }

        if ($fourbrakes) {
            foreach ($fourbrakes as $key=>$fourbrake) {
                $totals += $request->amount;
            }
        }

        if ($fivebrakes) {
            foreach ($fivebrakes as $key=>$fivebrake) {
                $totals += $request->amount;
            }
        }

        if ($sixbrakes) {
            foreach ($sixbrakes as $key=>$sixbrake) {
                $totals += $request->amount;
            }
        }

        if ($sevenbrakes) {
            foreach ($sevenbrakes as $key=>$sevenbrake) {
                $totals += $request->amount;
            }
        }

        if ($eightbrakes) {
            foreach ($eightbrakes as $key=>$eightbrake) {
                $totals += $request->amount;
            }
        }

        if ($ninebrakes) {
            foreach ($ninebrakes as $key=>$ninebrake) {
                $totals += $request->amount;
            }
        }


        //------------------------ insufficient condition for a parr ------------------------
        if ($zeropars) {
            foreach ($zeropars as $key=>$zeropar) {
                $totals += $request->amount;
            }
        }

        if ($onepars) {
            foreach ($onepars as $key=>$onepar) {
                $totals += $request->amount;
            }
        }

        if ($twopars) {
            foreach ($twopars as $key=>$twopar) {
                $totals += $request->amount;
            }
        }

        if ($threepars) {
            foreach ($threepars as $key=>$threepar) {
                $totals += $request->amount;
            }
        }

        if ($fourpars) {
            foreach ($fourpars as $key=>$fourpar) {
                $totals += $request->amount;
            }
        }

        if ($fivepars) {
            foreach ($fivepars as $key=>$fivepar) {
                $totals += $request->amount;
            }
        }

        if ($sixpars) {
            foreach ($sixpars as $key=>$sixpar) {
                $totals += $request->amount;
            }
        }

        if ($sevenpars) {
            foreach ($sevenpars as $key=>$sevenpar) {
                $totals += $request->amount;
            }
        }

        if ($eightpars) {
            foreach ($eightpars as $key=>$eightpar) {
                $totals += $request->amount;
            }
        }

        if ($ninepars) {
            foreach ($ninepars as $key=>$ninepar) {
                $totals += $request->amount;
            }
        }
        // insufficient condition balance for tens
        if ($tens) {
            foreach ($tens as $key=>$ten) {
                $totals += $request->amount;
            }
        }

        // insufficient condition balance for powers
        if ($powers) {
            foreach ($powers as $key=>$power) {
                $totals += $request->amount;
            }
        }


        // insufficient condition balance for natkhats
        if ($natkhats) {
            foreach ($natkhats as $key=>$natkhat) {
                $totals += $request->amount;
            }
        }


        // insufficient condition balance for brothers
        if ($brothers) {
            foreach ($brothers as $key=>$brother) {
                $totals += $request->amount;
            }
        }

        // insufficient condition balance for apuus
        if ($apuus) {
            foreach ($apuus as $key=>$apuu) {
                $totals += $request->amount;
            }
        }

        if ($from_account_wallet->amount < $totals) {
            return redirect('/dubai-two/htaitpait')->withErrors(['fail' => 'You have no sufficient balance']);
        }

        return view('frontend.dubai-two.htaitpaitconfirm', compact('amount', 'zerohtaits', 'onehtaits', 'twohtaits', 'threehtaits', 'fourhtaits', 'fivehtaits', 'sixhtaits', 'sevenhtaits', 'eighthtaits', 'ninehtaits', 'zeropaits', 'onepaits', 'twopaits', 'threepaits', 'fourpaits', 'fivepaits', 'sixpaits', 'sevenpaits', 'eightpaits', 'ninepaits', 'zerobrakes', 'onebrakes', 'twobrakes', 'threebrakes', 'fourbrakes', 'fivebrakes', 'sixbrakes', 'sevenbrakes', 'eightbrakes', 'ninebrakes', 'zeropars', 'onepars', 'twopars', 'threepars', 'fourpars', 'fivepars', 'sixpars', 'sevenpars', 'eightpars', 'ninepars', 'apuus', 'tens', 'powers', 'natkhats', 'brothers'));
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

        //----------------- A par ------------------------------
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

        //----------------- A Sone------------------------------

        $tens = $request->tens;
        $powers = $request->powers;
        $natkhats = $request->natkhats;
        $brothers = $request->brothers;
        $apuus = $request->apuus;


        $from_account_wallet = Auth()->user()->user_wallet;

        if(DubaiTwo::where('user_id',Auth::user()->id)->exists()){
            $twos = $request->except('amount','_token');

            $equal2 = [];
            foreach ($twos as $two){
                foreach ($two as $t){
                    array_push($equal2,$t);
                }
            }


            $batch = DubaiTwo::where('user_id',Auth::user()->id)->orderBy('batch','desc')->first();

            $equal1 = DubaiTwo::where('batch',$batch->batch)->pluck('two');

            $equation = $equal1->diff($equal2);

            if ($equation->isEmpty()){
                return redirect('/dubai-two/htaitpait')->withErrors(['Error' => 'အရင်ထိုးခဲ့သောအကွက်များနှင့်တူနေသဖြင့်အကွက်များအားနေရာပြောင်း၍ပြန်ထိုးပါ']);
            }
        }


        $totals = 0;



        //-------------- insufficient condition for  htait---------------

        if ($zerohtaits) {
            foreach ($zerohtaits as $key=>$zerohtait) {
                $totals += $request->amount;
            }
        }

        if ($onehtaits) {
            foreach ($onehtaits as $key=>$onehtait) {
                $totals += $request->amount;
            }
        }

        if ($twohtaits) {
            foreach ($twohtaits as $key=>$twohtait) {
                $totals += $request->amount;
            }
        }

        if ($threehtaits) {
            foreach ($threehtaits as $key=>$threehtait) {
                $totals += $request->amount;
            }
        }

        if ($fourhtaits) {
            foreach ($fourhtaits as $key=>$fourhtait) {
                $totals += $request->amount;
            }
        }

        if ($fivehtaits) {
            foreach ($fivehtaits as $key=>$fivehtait) {
                $totals += $request->amount;
            }
        }

        if ($sixhtaits) {
            foreach ($sixhtaits as $key=>$sixhtait) {
                $totals += $request->amount;
            }
        }

        if ($sevenhtaits) {
            foreach ($sevenhtaits as $key=>$sevenhtait) {
                $totals += $request->amount;
            }
        }

        if ($eighthtaits) {
            foreach ($eighthtaits as $key=>$eighthtait) {
                $totals += $request->amount;
            }
        }

        if ($ninehtaits) {
            foreach ($ninehtaits as $key=>$ninehtait) {
                $totals += $request->amount;
            }
        }

        //------------------------ insufficient condition for a pait------------------------
        if ($zeropaits) {
            foreach ($zeropaits as $key=>$zeropait) {
                $totals += $request->amount;
            }
        }

        if ($onepaits) {
            foreach ($onepaits as $key=>$onepait) {
                $totals += $request->amount;
            }
        }

        if ($twopaits) {
            foreach ($twopaits as $key=>$twopait) {
                $totals += $request->amount;
            }
        }

        if ($threepaits) {
            foreach ($threepaits as $key=>$threepait) {
                $totals += $request->amount;
            }
        }

        if ($fourpaits) {
            foreach ($fourpaits as $key=>$fourpait) {
                $totals += $request->amount;
            }
        }

        if ($fivepaits) {
            foreach ($fivepaits as $key=>$fivepait) {
                $totals += $request->amount;
            }
        }

        if ($sixpaits) {
            foreach ($sixpaits as $key=>$sixpait) {
                $totals += $request->amount;
            }
        }

        if ($sevenpaits) {
            foreach ($sevenpaits as $key=>$sevenpait) {
                $totals += $request->amount;
            }
        }

        if ($eightpaits) {
            foreach ($eightpaits as $key=>$eightpait) {
                $totals += $request->amount;
            }
        }

        if ($ninepaits) {
            foreach ($ninepaits as $key=>$ninepait) {
                $totals += $request->amount;
            }
        }

        //------------------------ insufficient condition for a Brake------------------------
        if ($zerobrakes) {
            foreach ($zerobrakes as $key=>$zerobrake) {
                $totals += $request->amount;
            }
        }

        if ($onebrakes) {
            foreach ($onebrakes as $key=>$onebrake) {
                $totals += $request->amount;
            }
        }

        if ($twobrakes) {
            foreach ($twobrakes as $key=>$twobrake) {
                $totals += $request->amount;
            }
        }

        if ($threebrakes) {
            foreach ($threebrakes as $key=>$threebrake) {
                $totals += $request->amount;
            }
        }

        if ($fourbrakes) {
            foreach ($fourbrakes as $key=>$fourbrake) {
                $totals += $request->amount;
            }
        }

        if ($fivebrakes) {
            foreach ($fivebrakes as $key=>$fivebrake) {
                $totals += $request->amount;
            }
        }

        if ($sixbrakes) {
            foreach ($sixbrakes as $key=>$sixbrake) {
                $totals += $request->amount;
            }
        }

        if ($sevenbrakes) {
            foreach ($sevenbrakes as $key=>$sevenbrake) {
                $totals += $request->amount;
            }
        }

        if ($eightbrakes) {
            foreach ($eightbrakes as $key=>$eightbrake) {
                $totals += $request->amount;
            }
        }

        if ($ninebrakes) {
            foreach ($ninebrakes as $key=>$ninebrake) {
                $totals += $request->amount;
            }
        }


        //------------------------ insufficient condition for a parr ------------------------
        if ($zeropars) {
            foreach ($zeropars as $key=>$zeropar) {
                $totals += $request->amount;
            }
        }

        if ($onepars) {
            foreach ($onepars as $key=>$onepar) {
                $totals += $request->amount;
            }
        }

        if ($twopars) {
            foreach ($twopars as $key=>$twopar) {
                $totals += $request->amount;
            }
        }

        if ($threepars) {
            foreach ($threepars as $key=>$threepar) {
                $totals += $request->amount;
            }
        }

        if ($fourpars) {
            foreach ($fourpars as $key=>$fourpar) {
                $totals += $request->amount;
            }
        }

        if ($fivepars) {
            foreach ($fivepars as $key=>$fivepar) {
                $totals += $request->amount;
            }
        }

        if ($sixpars) {
            foreach ($sixpars as $key=>$sixpar) {
                $totals += $request->amount;
            }
        }

        if ($sevenpars) {
            foreach ($sevenpars as $key=>$sevenpar) {
                $totals += $request->amount;
            }
        }

        if ($eightpars) {
            foreach ($eightpars as $key=>$eightpar) {
                $totals += $request->amount;
            }
        }

        if ($ninepars) {
            foreach ($ninepars as $key=>$ninepar) {
                $totals += $request->amount;
            }
        }
        // insufficient condition balance for tens
        if ($tens) {
            foreach ($tens as $key=>$ten) {
                $totals += $request->amount;
            }
        }

        // insufficient condition balance for powers
        if ($powers) {
            foreach ($powers as $key=>$power) {
                $totals += $request->amount;
            }
        }


        // insufficient condition balance for natkhats
        if ($natkhats) {
            foreach ($natkhats as $key=>$natkhat) {
                $totals += $request->amount;
            }
        }


        // insufficient condition balance for brothers
        if ($brothers) {
            foreach ($brothers as $key=>$brother) {
                $totals += $request->amount;
            }
        }

        // insufficient condition balance for apuus
        if ($apuus) {
            foreach ($apuus as $key=>$apuu) {
                $totals += $request->amount;
            }
        }

        if ($from_account_wallet->amount < $totals) {
            return redirect('/')->withErrors(['fail' => 'You have no sufficient balance']);
        }

        $amount = $request->amount;

        DB::beginTransaction();

        $batch_id = UUIDGenerator::DubaiBatch();

        try {

            // -------------------- detucted money From User -------------------
            $from_account_wallet->decrement('amount', $totals);
            $from_account_wallet->update();


            // -------------------- Store Htait -------------------
            if ($zerohtaits) {
                HtaitPaitForeach::DubaiHtaitPait($zerohtaits, $amount ,$batch_id);
            }

            if ($onehtaits) {
                HtaitPaitForeach::DubaiHtaitPait($onehtaits, $amount ,$batch_id);
            }

            if ($twohtaits) {
                HtaitPaitForeach::DubaiHtaitPait($twohtaits, $amount ,$batch_id);
            }

            if ($threehtaits) {
                HtaitPaitForeach::DubaiHtaitPait($threehtaits, $amount ,$batch_id);
            }


            if ($fourhtaits) {
                HtaitPaitForeach::DubaiHtaitPait($fourhtaits, $amount ,$batch_id);
            }

            if ($fivehtaits) {
                HtaitPaitForeach::DubaiHtaitPait($fivehtaits, $amount ,$batch_id);
            }


            if ($sixhtaits) {
                HtaitPaitForeach::DubaiHtaitPait($sixhtaits, $amount ,$batch_id);
            }

            if ($sevenhtaits) {
                HtaitPaitForeach::DubaiHtaitPait($sevenhtaits, $amount ,$batch_id);
            }

            if ($eighthtaits) {
                HtaitPaitForeach::DubaiHtaitPait($eighthtaits, $amount ,$batch_id);
            }

            if ($ninehtaits) {
                HtaitPaitForeach::DubaiHtaitPait($ninehtaits, $amount ,$batch_id);
            }


            //    -----------------------Store Pait -----------------------------

            if ($zeropaits) {
                $zeropaits = HtaitPaitForeach::DubaiHtaitPait($zeropaits, $amount ,$batch_id);
            }

            if ($onepaits) {
                HtaitPaitForeach::DubaiHtaitPait($onepaits, $amount ,$batch_id);
            }

            if ($twopaits) {
                HtaitPaitForeach::DubaiHtaitPait($twopaits, $amount ,$batch_id);
            }

            if ($threepaits) {
                HtaitPaitForeach::DubaiHtaitPait($threepaits, $amount ,$batch_id);
            }


            if ($fourpaits) {
                HtaitPaitForeach::DubaiHtaitPait($fourpaits, $amount ,$batch_id);
            }

            if ($fivepaits) {
                HtaitPaitForeach::DubaiHtaitPait($fivepaits, $amount ,$batch_id);
            }


            if ($sixpaits) {
                HtaitPaitForeach::DubaiHtaitPait($sixpaits, $amount ,$batch_id);
            }

            if ($sevenpaits) {
                HtaitPaitForeach::DubaiHtaitPait($sevenpaits, $amount ,$batch_id);
            }

            if ($eightpaits) {
                HtaitPaitForeach::DubaiHtaitPait($eightpaits, $amount ,$batch_id);
            }

            if ($ninepaits) {
                HtaitPaitForeach::DubaiHtaitPait($ninepaits, $amount ,$batch_id);
            }


            //----------------- Store Brake ------------------------------

            if ($zerobrakes) {
                $zerobrakes = HtaitPaitForeach::DubaiHtaitPait($zerobrakes, $amount ,$batch_id);
            }

            if ($onebrakes) {
                HtaitPaitForeach::DubaiHtaitPait($onebrakes, $amount ,$batch_id);
            }

            if ($twobrakes) {
                HtaitPaitForeach::DubaiHtaitPait($twobrakes, $amount ,$batch_id);
            }

            if ($threebrakes) {
                HtaitPaitForeach::DubaiHtaitPait($threebrakes, $amount ,$batch_id);
            }


            if ($fourbrakes) {
                HtaitPaitForeach::DubaiHtaitPait($fourbrakes, $amount ,$batch_id);
            }

            if ($fivebrakes) {
                HtaitPaitForeach::DubaiHtaitPait($fivebrakes, $amount ,$batch_id);
            }


            if ($sixbrakes) {
                HtaitPaitForeach::DubaiHtaitPait($sixbrakes, $amount ,$batch_id);
            }

            if ($sevenbrakes) {
                HtaitPaitForeach::DubaiHtaitPait($sevenbrakes, $amount ,$batch_id);
            }

            if ($eightbrakes) {
                HtaitPaitForeach::DubaiHtaitPait($eightbrakes, $amount ,$batch_id);
            }

            if ($ninebrakes) {
                HtaitPaitForeach::DubaiHtaitPait($ninebrakes, $amount ,$batch_id);
            }


            //-----------------Store a par ------------------------------


            if ($zeropars) {
                $zeropars = HtaitPaitForeach::DubaiHtaitPait($zeropars, $amount ,$batch_id);
            }

            if ($onepars) {
                HtaitPaitForeach::DubaiHtaitPait($onepars, $amount ,$batch_id);
            }

            if ($twopars) {
                HtaitPaitForeach::DubaiHtaitPait($twopars, $amount ,$batch_id);
            }

            if ($threepars) {
                HtaitPaitForeach::DubaiHtaitPait($threepars, $amount ,$batch_id);
            }


            if ($fourpars) {
                HtaitPaitForeach::DubaiHtaitPait($fourpars, $amount ,$batch_id);
            }

            if ($fivepars) {
                HtaitPaitForeach::DubaiHtaitPait($fivepars, $amount ,$batch_id);
            }


            if ($sixpars) {
                HtaitPaitForeach::DubaiHtaitPait($sixpars, $amount ,$batch_id);
            }

            if ($sevenpars) {
                HtaitPaitForeach::DubaiHtaitPait($sevenpars, $amount ,$batch_id);
            }

            if ($eightpars) {
                HtaitPaitForeach::DubaiHtaitPait($eightpars, $amount ,$batch_id);
            }

            if ($ninepars) {
                HtaitPaitForeach::DubaiHtaitPait($ninepars, $amount ,$batch_id);
            }

            //  -------------------- Apuus -----------------------------
            if ($apuus) {
                HtaitPaitForeach::DubaiHtaitPait($apuus, $amount ,$batch_id);
            }

            //  -------------------- Ten -----------------------------

            if ($tens) {
                HtaitPaitForeach::DubaiHtaitPait($tens, $amount ,$batch_id);
            }

            //  -------------------- Power -----------------------------
            if ($powers) {
                HtaitPaitForeach::DubaiHtaitPait($powers, $amount ,$batch_id);
            }

            //  -------------------- Natkhats -----------------------------
            if ($natkhats) {
                HtaitPaitForeach::DubaiHtaitPait($natkhats, $amount ,$batch_id);
            }

            //  -------------------- Brothers -----------------------------
            if ($brothers) {
                HtaitPaitForeach::DubaiHtaitPait($brothers, $amount ,$batch_id);
            }

            $trx_id = UUIDGenerator::TrxId();

            ForWalletAndBetHistory::Slip(new WalletHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$totals,'bet','user');

            ForWalletAndBetHistory::Slip(new BetHistory,Auth()->user()->admin_user_id,Auth()->user()->id,$trx_id,$totals,'bet','Dubai 2D');

            DB::commit();
            return redirect('dubai-two/htaitpait')->with('create', 'Done');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/dubai-two/htaitpait')->withErrors(['fail' => 'Something wrong'.$e->getMessage()]);
        }
    }
}
