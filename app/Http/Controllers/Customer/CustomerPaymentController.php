<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Transaction;
use App\Customer;
use App\CustomerBudget;
use App\ModeOfPayment;
use Auth;
use Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerPaymentController extends Controller
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
    public function Oldstore(Request $request)
    {
        // dd($request->all());

        $rules = [
            'total_amount' => 'required|max:11|min:3',
            'payment_mode' => 'required'
        ];

        if ($request->payment_mode == 2) {

            $rules += [
                'teller_payment_id'  => 'required|min:5|max:20',
            ];
        }
        if ($request->payment_mode == 3) {

            $rules += [
                'internetBanking_payment_id'  => 'required|min:5|max:20',
            ];
        }
        if ($request->payment_mode == 4) {

            $rules += [
                'pointOfSale_payment_id'  => 'required|min:5|max:20',
            ];
        }

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {

            $msg = 'Please check your inputs and be sure all fields are completed.';
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {
            $customer_details = Customer::find($request->id);
            // dd($customer_details);
            $customer_name    = $customer_details->fullname;
            $customer_type_id = $customer_details->customer_type_id;

            $checkTrans = Transaction::where('transaction_no', '=', $request->trans)->first();

            if (!empty($checkTrans)) {
                $msg = 'Transaction Number ' . $checkTrans->transaction_no . ' already exist for the Client please confirm.';
                return redirect()->back()->with('toast_error', $msg)->withInput();
            } else {
                $transaction   = new Transaction();
                $transaction->transaction_no   = $request->trans;
                $transaction->transaction_type = "Payment to Account";
                $transaction->customer_name    = $customer_name;
                $transaction->total_amount     = $request->total_amount;
                $transaction->deposit_b4       = $request->current_deposit;
                $transaction->credit_b4        = $request->current_credit;
                $transaction->current_deposit  = 00;
                $transaction->current_credit = 00;
                $transaction->customer_type_id = $customer_type_id;

                $transaction->mode_of_payment_id = $request->payment_mode;

                if ($request->payment_mode == 1) {
                    $transaction->bank_transaction_payment_id = $request->cash_payment_id;
                }

                if ($request->payment_mode == 2) {
                    $transaction->bank_transaction_payment_id = $request->teller_payment_id;
                }

                if ($request->payment_mode == 3) {
                    $transaction->bank_transaction_payment_id = $request->internetBanking_payment_id;
                }

                if ($request->payment_mode == 4) {
                    $transaction->bank_transaction_payment_id = $request->pointOfSale_payment_id;
                }

                $transaction->bank_name = 00;
                $transaction->store_id = 5;
                $transaction->staff_id = Auth::user()->id;
                $transaction->supply = 0;
                $transaction->supply_date = 0000 - 00 - 00;
                $transaction->bank_transaction_id = $request->id;

                $transaction->tr_date = \Carbon\Carbon::now();
                $transaction->tr_year = \Carbon\Carbon::now();

                if ($transaction->save()) {
                    if ($customer_details->deposit > 0  && $customer_details->creadit == 0) {
                        $my_deposit = $customer_details->deposit + $request->total_amount;
                        $my_creadit = 0;
                    } elseif ($customer_details->deposit > 0) {
                        $my_deposit = $request->total_amount + $customer_details->deposit;
                        $my_creadit = 0;
                    } elseif ($customer_details->deposit == 0  && $customer_details->creadit == 0) {
                        $my_deposit = $request->total_amount;
                        $my_creadit = 0;
                    } elseif ($customer_details->creadit > $request->total_amount) {
                        $my_deposit = 0;
                        $my_creadit = $customer_details->creadit - $request->total_amount;
                    } elseif ($customer_details->creadit == $request->total_amount) {
                        $my_deposit = 0;
                        $my_creadit = 0;
                    } elseif ($customer_details->creadit > 0  && $customer_details->creadit < $request->total_amount) {
                        $my_deposit = $request->total_amount - $customer_details->creadit;
                        $my_creadit = 0;
                    }

                    $customer_details->deposit     = $my_deposit;
                    $customer_details->creadit     = $my_creadit;
                    $customer_details->credit_b4   = $request->current_credit;
                    $customer_details->deposit_b4  = $request->current_deposit;
                    $customer_details->tootal_deposite  = $customer_details->tootal_deposite + $request->total_amount;
                    $customer_details->update();

                    $trans = Transaction::where('transaction_no', "=", $request->trans)->first();
                    $trans->current_deposit  = $my_deposit;
                    $trans->current_credit   = $my_creadit;
                    $trans->update();
                    $apps = appsettings();
                    return view('admin.customers.customerPayment', compact('trans', 'apps'));
                } else {

                    $msg = 'Something went wrong. Please try again later, information not save.';
                    return redirect()->back()->with('toast_error', $msg)->withInput();
                }
            }
        }
    }
    
    public function store(Request $request)
    {
        // dd($request->all());

        // dd(getBudgetYear());

        $rules = [
            'total_amount' => 'required|max:11|min:3'
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            $msg = 'Please cheak Your Inputs .';
            //flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        } else {


            $customer_details = Customer::find($request->id);
            // dd($customer_details);
            $customer_name    = $customer_details->fullname;
            $customer_type_id = $customer_details->customer_type_id;

            $checkCustmerBudget = CustomerBudget::where('customer_id', '=', $request->id)->where('budget_year_id', '=', getBudgetYear())->first();

            if(!empty($checkCustmerBudget)){

                $msg = 'The Budget Amount and Details have already being set for this year';
                return redirect(route('customers.index'))->with('toast_error', $msg)->withInput();
            }

            $customer_bodget                 = new CustomerBudget;
            $customer_bodget->customer_id     = $request->id;
            $customer_bodget->budget_year_id = getBudgetYear(); //$request->budget_year;
            $customer_bodget->amount         = $request->total_amount;
            $customer_bodget->balance        = 0;
            $customer_bodget->visible       = 1;
            $customer_bodget->spending       = 0;





            // $transaction   = new Transaction();
            // $transaction->transaction_no   =$request->trans;
            // $transaction->transaction_type = "Payment to Account";
            // $transaction->customer_name    = $customer_name;
            // $transaction->total_amount     = $request->total_amount;
            // $transaction->deposit_b4       = $request->current_deposit;
            // $transaction->credit_b4        = $request->current_credit;
            // $transaction->current_deposit  = 00;
            // $transaction->current_credit = 00;
            // $transaction->customer_type_id = $customer_type_id;
            // $transaction->mode_of_payment_id = $request->payment_mode;
            // $transaction->bank_name = 00;
            // $transaction->store_id = 5;
            // $transaction->staff_id = Auth::user()->id;
            // $transaction->supply = 0;
            // $transaction->supply_date = 0000-00-00;
            // $transaction->bank_transaction_id = $request->id;  

            // $transaction->tr_date = \Carbon\Carbon::now();
            // $transaction->tr_year = \Carbon\Carbon::now();
            $customer_bodget->save();
            # code...

            if ($customer_details->deposit > 0  && $customer_details->creadit == 0) {
                $my_deposit = $customer_details->deposit + $request->total_amount;
                $my_creadit = 0;
            } elseif ($customer_details->deposit > 0) {
                $my_deposit = $request->total_amount + $customer_details->deposit;
                $my_creadit = 0;
            } elseif ($customer_details->deposit == 0  && $customer_details->creadit == 0) {
                $my_deposit = $request->total_amount;
                $my_creadit = 0;
            } elseif ($customer_details->creadit > $request->total_amount) {
                $my_deposit = 0;
                $my_creadit = $customer_details->creadit - $request->total_amount;
            } elseif ($customer_details->creadit == $request->total_amount) {
                $my_deposit = 0;
                $my_creadit = 0;
            } elseif ($customer_details->creadit > 0  && $customer_details->creadit < $request->total_amount) {
                $my_deposit = $request->total_amount - $customer_details->creadit;
                $my_creadit = 0;
            }

            $customer_details->deposit     = $request->total_amount; // $my_deposit;
            $customer_details->creadit     = 0; //$my_creadit; 
            $customer_details->credit_b4   = 0; // $request->current_credit;
            $customer_details->deposit_b4  = 0; //$request->current_deposit;
            //  $customer_details->tootal_deposite  = $customer_details->tootal_deposite + $request->total_amount;
            $customer_details->tootal_deposite  = 0;
            $customer_details->update();
            $trans = 000;
            $msg = 'Budget Created Successfully!';
            // $trans = Transaction::where('transaction_no',"=", $request->trans)->first();
            // $trans->current_deposit  = $my_deposit;
            // $trans->current_credit   = $my_creadit; 
            // $trans->update();
            //    $apps = appsettings();
            // return view('admin.customers.customerPayment', compact('trans','apps'));
            return redirect(route('customers.index'))->with('toast_success', $msg);
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

            if (Auth::user()) {
                $trans = generateTransactionId();
                $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
                $customers     = Customer::find($id);
                return view('admin.customers.make_payment', compact('customers', 'trans', 'payment_mode'));
            } else {
                return view('customers.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
