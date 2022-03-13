<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Attendance;
use App\Trainee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\LaravelRoles\Models\Role as Role;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Fund $model)
    {
        if (Auth::user()->hasRole('mr') || Auth::user()->hasRole('oic')) {

            return view('payment.paymentmethod.index', ['payments' => $model->paginate(15)]);
        }

        return redirect()->back();
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole('mr')) {
            
            return view('payment.paymentmethod.create');

        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('mr')) {
    
            $request->validate([
                'fund_name' => 'required',           
            ]);
    
            $scltype = request('fund_name');
    
            $funds = Fund::where(function ($query) use ($scltype) {
                $query->where(function ($query) use ($scltype) {
                    $query->orwhere('fund_name', 'LIKE', $scltype);
                });
            })->get();
    
            if (!$funds->isEmpty()) {
                return redirect()->back()->withStatus(__('This Scholarship is alrady exsist'));
            }
            
            if ($request->has('criteria')) {
                foreach ($request->input('criteria') as $value) {
                    $criteria[] = $value;
                }
            }
    
            $paymentmethod = new Fund;
            $paymentmethod->fund_name = request('fund_name');
            $paymentmethod->samurdi = (int) $request->has('samurdi');
            $paymentmethod->attendance = (int) $request->has('attendance');
            $paymentmethod->othercriteria  = json_encode($criteria);
            $paymentmethod->amount = request('amount');
            $paymentmethod->discription = request('discription');
            $paymentmethod->save();
    
            return redirect()->route('funds.index')->withStatus(__(' Scholarship successfully created.'));
        }

        return redirect()->back();        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $funds = Fund::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        return view('payment.select', compact('funds','attendanceYears', 'attendanceMonths'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund)
    {
        if (Auth::user()->hasRole('mr')) {

            return view('payment.paymentmethod.edit', compact('fund'));
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fund $fund)
    {
        if (Auth::user()->hasRole('mr')) {
            $request->validate([
                'fund_name' => 'required',           
            ]);

            if ($request->has('criteria')) {
                foreach ($request->input('criteria') as $value) {
                    $criteria[] = $value;
                }
            }else {
                foreach (json_decode($fund->othercriteria) as $value){               
                    $criteria[] = $value;
                }
            }

            $fund->fund_name = request('fund_name');
            $fund->samurdi = (int) $request->has('samurdi');
            $fund->attendance = (int) $request->has('attendance');
            $fund->othercriteria  = json_encode($criteria);
            $fund->amount = request('amount');
            $fund->discription = request('discription');
            $fund->save();

            return redirect()->route('funds.index')->withStatus(__('Scholarship successfully updated.'));
        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund)
    {
        if (Auth::user()->hasRole('mr')) {
            $fund->trainees()->detach($fund->trainees);
            $fund->delete();
            return redirect()->route('funds.index')->withStatus(__('Scholarship successfully deleted.'));
        }

        return redirect()->back();
    }

    public function viewPaymentEligibility(Request $request){


        $funds = Fund::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        $request->validate([
            'fund' => 'required',
            'year' => 'required',
            'month' => 'required',
        ]);
        $fund = request('fund');
        $year = request('year');
        $month = request('month');
        
        $requestedfund = Fund::where('id', '=' ,$fund)->get();
        $eligibleTrainees = DB::table('fund_trainee')->where('fund_id', $fund)->pluck('trainee_id');
        $trainees = Trainee::whereIn('id',$eligibleTrainees)->get();
        $recount = $trainees->count();         
        $attendances = Attendance::whereIn('trainee_id', $eligibleTrainees)->get();
               
        return view('payment.select',compact('funds', 'attendanceYears', 'attendanceMonths','trainees', 'attendances','requestedfund','month','recount'));
        // return redirect('payment.select',compact('funds', 'attendanceYears', 'attendanceMonths','trainees', 'attendances','requestedfund'));
    }
}
