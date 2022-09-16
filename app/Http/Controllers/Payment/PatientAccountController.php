<?php

namespace App\Http\Controllers\Payment;

use App\Lab;
use App\User;
use Auth;
use App\Clinic;
use App\Patient;
use App\LabService;
use App\PaymentItem;
use App\Transaction;
use App\NurseService;
use App\MedicalReport;
use App\ModeOfPayment;
use App\PatientAccount;
use App\ApplicationStatu;
use App\PatientLabService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class PatientAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
        $patients = Patient::where('visible', 1)
            ->orWhere('visible', 2)
            ->orWhere('visible', 3)
            ->orWhere('visible', 4)
            ->with(['user'])
            ->get();
        return view('admin.patients.patients_account', compact('payment_mode', 'patients'));
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
     * create a new account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'patient_id'          => 'required',
            'total_amount'          => 'required',
            'payment_mode'         => 'required',
        ];

        $trans = generateTransactionId();

        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {
                $account                       = new PatientAccount;
                $account->user_id              = explode('_', $request->patient_id)[0];
                $account->file_no              = explode('_', $request->patient_id)[1];
                $account->credit_b4            = 00;
                $account->deposite_b4          = 00;
                $account->deposit              = $request->total_amount;
                $account->creadit              = 00;
                $account->visible              = 1;
                $account->last_amount_paid     = $request->total_amount;
                $account->last_payment_date    = \Carbon\Carbon::now();

                if ($account->save()) {
                    if (PatientAccount::find($request->patient_id)) {
                        $msg = 'This Patient Already Has An Account, Deposit Into That Account';
                        Alert::Error('Error Title', $msg);
                        return redirect()->back()->with('error', $msg)->withInput();
                    }
                    $transaction   = new Transaction();
                    $transaction->transaction_no   = $trans;
                    $transaction->budget_year_id   = 1;
                    $transaction->transaction_type = "Patient Account";
                    $transaction->customer_name    = userfullname($account->user_id);
                    $transaction->total_amount     = $request->total_amount;
                    $transaction->deposit_b4       = 00;
                    $transaction->credit_b4        = 00;
                    $transaction->current_deposit  = 00;
                    $transaction->current_credit   = 00;
                    $transaction->customer_type_id = 1; //admitted Patient

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
                    $transaction->supply = 1;
                    $transaction->supply_date = 0000 - 00 - 00;
                    $transaction->bank_transaction_id = $request->patient_id;

                    $transaction->tr_date = \Carbon\Carbon::now();
                    $transaction->tr_year = \Carbon\Carbon::now();
                    if ($transaction->save()) {
                        $msg = 'payment Success.' . '' . $request->tottal_amount;
                        Alert::success('Success ', $msg);
                        return redirect()->route('hospital-receipts.show', $trans)->withMessage($msg,)->withMessageType('success');
                    }
                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    Alert::Error('Error Title', $msg);
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    /**
     * deposit into an existing account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        //dd($request);

        $rules = [
            'user_id'          => 'required',
            'total_amount'          => 'required',
            'payment_mode'         => 'required',
        ];

        $trans = generateTransactionId();
        //dd($request);

        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {

                $account              =  PatientAccount::where('user_id',$request->user_id)->first();
                $old_creadit          = $account->creadit;
                $old_deposit          = $account->deposit;
                $account->credit_b4   = $old_creadit;
                $account->deposite_b4 = $old_deposit;


                //i decided to use both psostive values(deposit/debit) and negatve values(credit)
                //in the deposit colun thus the credit colums are obselete
                $account->deposit =  (int) $account->deposit +  (int) $request->total_amount;
                $account->creadit     = 0;

                $account->visible           = 1;
                $account->last_amount_paid  = $request->total_amount;
                $account->last_payment_date = \Carbon\Carbon::now();


                if ($account->update()) {
                    $transaction   = new Transaction();
                    $transaction->transaction_no   = $trans;
                    $transaction->budget_year_id   = 1;
                    $transaction->transaction_type = "Patient Account";
                    $transaction->customer_name    = userfullname($account->user_id);
                    $transaction->total_amount     = $request->total_amount;
                    $transaction->deposit_b4       = $old_deposit;
                    $transaction->credit_b4        = $old_creadit;
                    $transaction->current_deposit  = 00;
                    $transaction->current_credit   = 00;
                    $transaction->customer_type_id = 1; //admitted Patient

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
                    $transaction->supply = 1;
                    $transaction->supply_date = 0000 - 00 - 00;
                    $transaction->bank_transaction_id = $request->user_id;

                    $transaction->tr_date = \Carbon\Carbon::now();
                    $transaction->tr_year = \Carbon\Carbon::now();
                    if ($transaction->save()) {
                        $msg = 'payment Success.' . '' . $request->tottal_amount;
                        Alert::success('Success ', $msg);
                        return redirect()->route('hospital-receipts.show', $trans)->withMessage($msg,)->withMessageType('success');
                    }
                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch (\Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
    public function patientsAccountList()
    {

        $pc = PatientAccount::where('visible', '=', 1)->get();

        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 1) ? "Inactive" : "Active");
            })
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user_id));
            })

            ->editColumn('file_no', function ($pc) {
                //  return showFileNumber($pc->user_id);
                $patientFileNumber = $pc->patient->file_no;
                return $patientFileNumber;
            })

            ->addColumn('clinic', function ($pc) {

                $patient = Patient::with('clinic')->where('user_id', '=', $pc->user_id)->first();
                $clinics = $patient->clinic->clinic_name;
                return $clinics;
            })

            ->addColumn('make_payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                return '<a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->user_id . '" title="Enter Charges"> <i class="fas fa-plus-circle"></i> Make Payment </a> ';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> View Request Services</a>';
                // }
            })

            ->rawColumns(['fullname', 'status', 'file_no', 'clinic', 'make_payment'])

            ->make(true);
    }
}
