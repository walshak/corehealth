<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Stock;
use App\Sale;
use App\Product;
use App\Transaction;
use App\Customer;
use App\Price;
use App\Store;
use App\ModeOfPayment;
use Auth;
use DB;
use Carbon;

class ReceiptContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
         $sale = Sale::with('product')->where('transaction_id',"=", $id)->get();

         $my_sums = 0;
        foreach ( $sale as $sum) {

           $my_sums +=  $sum->total_amount ;

        }

        //$tran = Transaction::find($id)->with('mode_of_payment')->first();
        $tran = Transaction::with('mode_of_payment')->where('id',"=", $id)->with('store')->first();
        if($tran->customer_type_id == 2 || $tran->customer_type_id ==3){

            $customer = Customer::find($tran->bank_transaction_id);
            // return $customer;
            $credit_b4   = $customer->creadit;
            $deposit_b4  = $customer->deposit;
            $customer->totalbuy = $customer->totalbuy + $my_sums;
           //**To Check if customer has Deposite or Creadit**\\
               if($customer->deposit > $my_sums  && $customer->creadit == 0){
                   $my_deposit = $customer->deposit - $my_sums;
                   $my_creadit = 0;

               }elseif ($customer->deposit < $my_sums  && $customer->creadit == 0) {
                   $my_deposit = 0;
                   $my_creadit = $my_sums - $customer->deposit ;

               }elseif ($customer->deposit == $my_sums  && $customer->creadit == 0) {
                    $my_deposit = 0;
                    $my_creadit = 0;

               }elseif ($customer->deposit == 0  && $customer->creadit == 0) {
                    $my_deposit = 0;
                    $my_creadit = $my_sums;
               }elseif($customer->deposit == 0  && $customer->creadit > 0 ){
                    $my_deposit = 0;
                    $my_creadit =  $customer->creadit + $my_sums;
               }

               $customer->deposit     = $my_deposit;
               $customer->creadit     = $my_creadit;
               $customer->credit_b4   = $credit_b4;
               $customer->deposit_b4  = $deposit_b4;
               $customer->date_line   = \Carbon\Carbon::now()->addDays(7);
               $customer->update();
                $trans = Transaction::where('id',"=", $id)->first();
                //dd($trans);
                $trans->current_deposit  = $my_deposit;
                $trans->current_credit   = $my_creadit;
                $trans->credit_b4        = $credit_b4;
                $trans->deposit_b4       = $deposit_b4;
                $trans->update();
                //dd($customer);
           //**To Check if customer has Deposite or Creadit**\\


        }else {
            # code...
            $customer = "casual";
        }
        // if($tran->customer_type_id != 2 || $tran->customer_type_id !=3) {
        //   $customer="casual";
        // }

         //dd($customer);
           $tran->total_amount     = $my_sums;
           $tran->update();
           $apps = appsettings();
      //dd($apps);
            $now       = \Carbon\Carbon::now();
            $lastDay_  =  explode(" ", $now);
            $lastDay   = $lastDay_[0];
            $rdate     = $tran->tr_date;
            $rdate__  = explode(" ", $rdate);
            $rdate_   = $rdate__[0];

        // return $customer;

         return view('admin.sales.receipt', compact('sale','my_sums','tran','customer','apps','lastDay','rdate_'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $sale = Sale::with('product')->where('transaction_id',"=", $id)->get();

         $my_sums = 0;
        foreach ( $sale as $sum) {

           $my_sums +=  $sum->total_amount ;

        }

        //$tran = Transaction::find($id)->with('mode_of_payment')->first();
        $tran = Transaction::with('mode_of_payment')->where('id',"=", $id)->first();

        // dd($customer);
        $tran->total_amount     = $my_sums;
        $tran->update();

         return view('admin.sales.receipt', compact('sale','my_sums','tran','customer'));
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
