<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use App\ApplicationStatu;
use Illuminate\Support\Facades\Validator;
use Response;
use App\User;
use App\BudgetYear;
use App\CustomerBudget;
use App\Customer;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class BudgetYearController extends Controller
{
    public function listBudgetYear()
    {

        $list = BudgetYear::where('id', '>', 0)->orderBy('id', 'DESC')->get();


        return Datatables::of($list)
            ->addIndexColumn()

            ->addColumn('status', function ($list) {
                $url = '<a href="' . route('closedBudget', $list->id) . '" class="btn btn-success btn-sm"><i class="fa fa-closed"></i> Closed</a>';
                return (($list->closed == 1) ? "Closed" : $url);
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function closedBudget($id)
    {
        // dd(getBudgetYear());
        $customers = Customer::where('visible', '=', 1)->get();

        foreach ($customers as $customer) {

            $closedBudget = CustomerBudget::where('customer_id', '=', $customer->id)->where('budget_year_id', '=', getBudgetYear())->first();
            //dd($closedBudget);
            $closedBudget->id = $closedBudget->id;

            if ($customer->deposit > 0) {
                $closedBudget->spending =  $closedBudget->amount - $customer->deposit;
                $closedBudget->balance =   $customer->deposit;
            } elseif ($customer->creadit > 0) {
                $closedBudget->spending = $closedBudget->amount + $customer->creadit;
                $closedBudget->balance = "-" . $customer->creadit;
            } else {
                $closedBudget->spending = $closedBudget->amount;
                $closedBudget->balance = 0;
            }

            $closedBudget->save();
        }
        // $sumBudget = CustomerBudget::where('visible', '=',1)->sum('amount');
        // $sumspending = CustomerBudget::where('visible', '=',1)->sum('spending');
        // $sumbalance = CustomerBudget::where('visible', '=',1)->sum('balance');

        $sumBudget = 0;
        $sumspending = 0;
        $sumbalance = 0;
        $counts = CustomerBudget::where('visible', '=', 1)->get();

        foreach ($counts as  $count) {
            $sumBudget   += $count->amount;
            $sumspending += $count->spending;
            $sumbalance  += $count->balance;
        }
        $BudgetYear = BudgetYear::find($id);
        $BudgetYear->closed        = 1;
        $BudgetYear->spending      = $sumspending;
        $BudgetYear->balance       = $sumBudget -  $sumspending;
        //$BudgetYear->total_amount  = $sumBudget;

        if ($BudgetYear->save()) {
            $msg = 'The new_year [' . $BudgetYear->budget_year . '] was successfully Closed.';
            Alert::success('Success ', $msg);
            return redirect()->route('budget-year.index')->withMessage($msg)->withMessageType('success');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.budget.budget_year');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.budget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rules = [
            'budget_year' => 'required',
            'total_amount' => 'required',
            'opening_date' => 'required',
            'closing_date' => 'required',
        ];
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            Alert::error('Error Title', 'One or more information is needed.');
            return redirect()->back()->withInput()->withErrors($v);
        } else {
            $check = BudgetYear::where('year_name', '=', $request->budget_year)->first();
            if (!empty($check)) {
                $msg = 'The budget_year [' . $request->budget_year . '] exist.';
                Alert::warning('warning Title', $msg);
                return redirect()->back()->withInput()->withMessage($msg)->withMessageType('warning');
            }
            $new_year              = new BudgetYear;
            $new_year->year_name    = $request->budget_year;
            $new_year->opening_date = $request->opening_date;
            $new_year->closing_date = $request->closing_date;
            $new_year->total_amount = $request->total_amount;
            $new_year->spending     = 0;
            $new_year->spending     = 0;
            $new_year->balance      = 0;
            $new_year->closed       = 0;
            $new_year->visible      = $request->visible;

            if ($new_year->save()) {
                $msg = 'The new_year [' . $request->budget_year . '] was successfully Saved.';
                Alert::success('Success ', $msg);
                return redirect()->route('budget-year.index')->withMessage($msg)->withMessageType('success');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
