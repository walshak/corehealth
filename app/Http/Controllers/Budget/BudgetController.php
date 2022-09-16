<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use FFI\Exception;
use App\ApplicationStatu;
use App\User;
use App\Sale;
use App\CustomerBudget;
use App\StoreStoke;
use App\Stock;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listBudget()
    {

        $list = CustomerBudget::whereVisible(1)->with('budgetYear','customer')->get();

        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('customer', function ($list) {
                $customerName = $list->customer->fullname;
                return $customerName;
            })
            ->addColumn('budget', function ($list) {
                $budget = $list->budgetYear->year_name;
                
                return $budget;
            })
           
            ->rawColumns(['budget','customer'])
            ->make(true);
    }

    public function index()
    { 

         return view('admin.budget.index');
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
         $year_name = BudgetYear::where('closed','=',1)->where('visible','=', 1)->first();
         return view('admin.budget.show' ,compact('year_name'));
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
