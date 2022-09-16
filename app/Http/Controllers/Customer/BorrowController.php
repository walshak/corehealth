<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Transaction;
use App\Customer;
use App\ModeOfPayment;
use Auth;
use Carbon;
class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //dd($request);
        try {  
        $rules = [
                    'total_amount' => 'required|max:11|min:3',
                    'payment_mode' => 'required'
                ];

         $v = validator()->make($request->all(), $rules);

         if( $v->fails() )
         {
             $msg = 'Please cheak Your Inputs .';
             //flash($msg, 'danger');
             return redirect()->back()->withInput()->withErrors($v);

         } else {
        $customer_details = Customer::find($request->id);
           // dd($customer_details);
            $customer_name    = $customer_details->fullname;
            $customer_type_id = $customer_details->customer_type_id;

               
             
        $transaction   = new Transaction();
        $transaction->transaction_no   =$request->trans;
        $transaction->transaction_type = "Borrow";
        $transaction->customer_name    = $customer_name;
        $transaction->total_amount     = $request->total_amount;
        $transaction->deposit_b4       = $request->current_deposit;
        $transaction->credit_b4        = $request->current_credit;
        $transaction->current_deposit  =00;
        $transaction->current_credit =00;
        $transaction->customer_type_id = $customer_type_id;
        $transaction->mode_of_payment_id = $request->payment_mode;
        $transaction->bank_name =00;
        $transaction->store_id =5;
        $transaction->staff_id = Auth::user()->id;
        $transaction->supply =0;
        $transaction->supply_date =0000-00-00;
        $transaction->bank_transaction_id =$request->id;  
        
        $transaction->tr_date = \Carbon\Carbon::now();
        $transaction->tr_year = \Carbon\Carbon::now();
        if( $transaction->save() ) {
             if($customer_details->deposit > 0  && $customer_details->creadit == 0){
                   $my_deposit = $customer_details->deposit - $request->total_amount;
                   $my_creadit = 0;


               }elseif ($customer_details->deposit > 0 ) {
                   $my_deposit = $customer_details->deposit - $request->total_amount;
                   $my_creadit = 0 ;
                     
               }elseif ($customer_details->deposit == 0  && $customer_details->creadit == 0) {
                    $my_deposit = 0;
                    $my_creadit =$request->total_amount ;

                     
               
               }elseif( $customer_details->creadit>0  ){
                    $my_deposit = 0 ;
                    $my_creadit =$request->total_amount ;
                     
               }
              
               $customer_details->deposit     = $my_deposit;
               $customer_details->creadit     = $my_creadit; 
               $customer_details->credit_b4   = $request->current_credit;
               $customer_details->deposit_b4  = $request->current_deposit; 
               $customer_details->total_borrows  =$customer_details->total_borrows + $request->total_amount; 
               $customer_details->borrow = $request->total_amount;
               $customer_details->update();

                $trans = Transaction::where('transaction_no',"=", $request->trans)->first();
                $trans->current_deposit  = $my_deposit;
                $trans->current_credit   = $my_creadit; 
                $trans->update();
                 $apps = appsettings();
                return view('admin.customers.customerBorrow', compact('trans','apps'));
             } else {
                 $msg = 'Something is went wrong. Please try again later, information not save.';
                 //flash($msg, 'danger');
                 return redirect()->back()->withInput();
             }
         }
        } catch(Exception $e) {

                return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
       
        
         try {
                                    
            if(Auth::user()){
                   $trans = generateTransactionId();
                   $payment_mode = ModeOfPayment::whereVisible(1)->where("id","<",2)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
                   $customers     = Customer::find($id);
                return view('admin.customers.borrow', compact('customers','trans','payment_mode'));
            }else{
                 return view('customers.index');
             }
        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
        }
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
