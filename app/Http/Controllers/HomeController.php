<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserTwoD;
use App\Two;
use App\TwoOverview;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.home');
    }

    public function two(StoreUserTwoD $request)
    {
        $two = new Two();
        $two->user_id = Auth()->user()->id;

        $two->two = $request->two;
        $two->amount = $request->amount;

        $two->save();

       

        
        $two_overview = TwoOverview::where('two', $request->two)->exists();
        if ($two_overview) {
            $total = Two::where('two', $request->two)->get();
        
            $total = $total->pluck('amount')->toArray();
    
            $total = array_sum($total);
            
            TwoOverview::where('two', $request->two)->update([
                'amount' => $total
           ]);
        } else {
            $two_overview = new TwoOverview();
            $two_overview->two = $request->two;
            $two_overview->amount = $request->amount;
            $two_overview->save();
        }

        return back()->with('create', 'Done');
    }

    public function total(Request $request, $id)
    {
    }
}
