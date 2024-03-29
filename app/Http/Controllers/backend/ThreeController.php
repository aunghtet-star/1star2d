<?php

namespace App\Http\Controllers\backend;

use App\FakeNumber;
use App\Helpers\ForThreeKyon;
use App\Helpers\ForThreeOverview;
use App\Helpers\ForTwoOverview;
use App\ThreeKyon;
use App\ThreeOverview;
use App\TwoOverview;
use App\User;
use App\Three;
use Carbon\Carbon;
use App\AllBrakeWithAmount;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreThree;
use App\Helpers\PermissionChecker;
use App\Http\Requests\UpdateThree;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ThreeController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('three');
        $numbers = Three::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.three.index', compact('numbers'));
    }

    public function ssd()
    {
        if(Auth::guard('adminuser')->user()->hasRole('Admin')){
            $threes = Three::query();
        }else{
            $threes = Three::where('admin_user_id', Auth()->user()->id)->limit(10);
        }
        return Datatables::of($threes)
        ->addColumn('name', function ($each) {
            return $each->users ? $each->users->name : '_';
        })
        ->editColumn('updated_at', function ($each) {
            return Carbon::parse($each->updated_at)->format('d-m-Y h:i:s A');
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/three/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/three/'.$each->id).'" data-id="'.$each->id.'"  data-three="'.$each->three.'" data-amount="'.$each->amount.'"  class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';


            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }

    public function create()
    {
        PermissionChecker::CheckPermission('three');
        $users = User::where('admin_user_id', Auth()->user()->id)->get();
        return view('backend.three.create', compact('users'));
    }

    public function store(StoreThree $request)
    {
        $number = new Three();
        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->three = $request->three;
        $number->amount = $request->amount;
        $number->save();

        return redirect('admin/three')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        PermissionChecker::CheckPermission('three');
        $number = Three::findOrFail($id);
        $users = User::where('admin_user_id', Auth()->user()->id)->get();

        return view('backend.three.edit', compact('number', 'users'));
    }

    public function update(UpdateThree $request, $id)
    {
        $number = Three::findOrFail($id);

        $number->user_id = $request->user_id;
        $number->admin_user_id = Auth::guard('adminuser')->user()->id;
        $number->date = now();
        $number->three = $request->three;
        $number->amount = $request->amount;
        $number->update();

        return redirect('admin/three')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $number = Three::findOrFail($id);
        $number->delete();

        return 'success';
    }

    public function threeHistory(Request $request)
    {
//        dd($request->all());
        PermissionChecker::CheckPermission('three_overview');

        //dd(Carbon::now()->format('Y-m-d'));
        if (Carbon::now()->format('Y-m-d') < Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d')){
            if (Carbon::now()->format('Y-m-d H:i:s') < Carbon::now()->startOfMonth()->addDays(5)->format('Y-m-d 23:00:00')){
                $from = $request->startdate ?? Carbon::now()->subMonths(1)->addDays(16)->format('Y-m-d');
                $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(4)->format('Y-m-d');

            }else{
                $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(5)->format('Y-m-d');
                $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d');
            }
    }else{
        $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d');
        $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(4)->format('Y-m-d');
    }


        //$from = $from->format('Y-m-d');
        //$to = $to->format('Y-m-d');


        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $threes = DB::table('threes')->orderBy('created_at')->select('three', DB::raw('SUM(amount) as total'))->groupBy('three')->whereBetween('date', [$from,$to]);


        //to store three overview table if exist to update
        ForThreeOverview::Overview($threes,$from,new ThreeOverview);

        $three_overviews = DB::table('three_overviews')->whereDate('date', $from)->orderBy('three','asc')->paginate(110);

        //ThreeOverview Total Amount
        $overview_total = ForThreeOverview::OverviewTotal(new ThreeOverview,$from);

        $amount_total = $overview_total['amount'];
        $new_amount_total = $overview_total['new_amount'];
        $kyon_amount_total = $overview_total['kyon_amount'];

        //dd($overview_total);
        //$three_overviews->withPath('/admin/three-overview/history?startdate='.$from.'&enddate='.$to);
        //dd($from);

       // $threes_total = Three::select('amount')->whereBetween('date', [$from,$to])->sum('amount');

        $fake_number = FakeNumber::first();

        return view('backend.three_overview.history', compact('threes','three_overviews', 'three_brake', 'from', 'to','fake_number','amount_total','new_amount_total','kyon_amount_total'));
    }

    public function threeKyon(Request $request)
    {
        PermissionChecker::CheckPermission('three_kyon');
        if (Carbon::now()->format('Y-m-d')  < Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d')){

            if (Carbon::now()->format('Y-m-d H:i:s') < Carbon::now()->startOfMonth()->addDays(5)->format('Y-m-d 23:00:00')){
                $from = $request->startdate ?? Carbon::now()->subMonths(1)->addDays(16)->format('Y-m-d');
                $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(4)->format('Y-m-d');
            }else{
                $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(5)->format('Y-m-d');
                $to = $request->enddate ?? Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d');
            }

        }else{
            $from = $request->startdate ?? Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d');
            $to = $request->enddate ?? Carbon::now()->endOfMonth()->addDays(4)->format('Y-m-d');
        }

        //$from = $from->format('Y-m-d');
        //$to = $to->format('Y-m-d');

        $three_brake = AllBrakeWithAmount::select('amount')->where('type', '3D')->first();

        $three_overviews = DB::table('three_overviews')->whereDate('date', $from)->orderBy('three','asc');



        //To Store Three kyon table
        ForThreeKyon::Kyon($three_overviews,$from,new ThreeKyon);




        $three_kyons = DB::table('three_kyons')->where('date',$from)->whereRaw('three_kyons.amount != three_kyons.kyon_amount != three_kyons.new_amount')->orderBy('three','asc')->paginate(110);

        $total_amount = DB::table('three_kyons')->where('date',$from)->orderBy('three','asc')->sum('amount');
        $total_new_amount = DB::table('three_kyons')->where('date',$from)->orderBy('three','asc')->sum('new_amount');
        $total_kyon_amount = DB::table('three_kyons')->where('date',$from)->orderBy('three','asc')->sum('kyon_amount');

         $total = $total_amount - $total_new_amount - $total_kyon_amount;

//        dd($three_kyons);

        //$three_kyons = ThreeKyon::where('date',$from)->get();
        //$three_kyons->withPath('/admin/three-overview/kyon?startdate='.$from.'&enddate='.$to);

        return view('backend.three_overview.threekyon', compact('three_kyons', 'three_brake', 'from', 'to','total'));
    }
}
