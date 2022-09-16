<?php

namespace App\Http\Controllers\Payment;

use Auth;
use App\Hmo;
use App\User;
use App\Clinic;
use App\Patient;
use App\Payment;
use App\Dependant;
use App\VitalSign;
use App\PaymentItem;
use App\PaymentType;
use App\Transaction;
use App\NurseService;
use App\DoctorBooking;
use App\MedicalReport;
use App\ModeOfPayment;
use App\PatientAccount;
use App\PatientLabService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
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
        //$cheek_payment = Payment::where('transactionid', '=',$request->trans)->fist();
        if ($request->payment_mode == 6) {

            $msg = ' You are not allowed to use this channel';
            $msg = 'Payment Success.' . '' . $pc->charge_amount;
            return redirect()->back()->withInput()->withMessage($msg,)->withMessageType('success');
        }
        $trans = generateTransactionId();
        $rules = [
            'total_amount' => 'required|max:11|min:2',
            'id' => 'required',
            'clinic' => 'required',
            'payment_items' => 'required',
            'payment_mode' => 'required',
            'file_no' => 'required|unique:patients,file_no'
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            $msg = 'Please check Your Inputs .';
            //flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        } else {
            // $payment_type_id = PaymentType::find($request->payment_items);

            $transaction   = new Transaction();
            $transaction->transaction_no    = $trans;
            $transaction->budget_year_id    = 1;



            $transaction->transaction_type  = "Registration Fee";
            $transaction->customer_name     = $request->patient;
            $transaction->total_amount      = $request->total_amount;
            $transaction->deposit_b4        = 00;
            $transaction->credit_b4         = 00;
            $transaction->current_deposit   = 00;
            $transaction->current_credit    = 00;
            $transaction->customer_type_id  = 4; //$customer_type_id;
            $transaction->bank_name         = 00;
            $transaction->staff_id          = Auth::user()->id;
            $transaction->supply            = 1;

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

            // if ($customer_type_id == 2 || $customer_type_id == 3) {

            //     $transaction->mode_of_payment_id    = 5;
            //     $transaction->bank_transaction_id   = $request->customer;
            // } else {

            $transaction->bank_transaction_id   = $request->id;
            $transaction->mode_of_payment_id    = $request->payment_mode;
            //}

            $transaction->store_id = 0;
            $transaction->tr_date = \Carbon\Carbon::now();
            $transaction->tr_year = \Carbon\Carbon::now();


            if ($transaction->save()) {

                $transaction_number = Transaction::whereTransaction_no($trans)->first()->id;
                $patient            = new Patient;
                $patient->user_id   = $request->id;
                // $patient->file_no   = generateFileNo();
                $patient->file_no   = $request->file_no;
                $patient->clinic_id = $request->clinic;
                if($request->payment_items == 1){
                    $patient->visible   = 1;
                }else{
                    $patient->visible   = 99;
                }
                $patient->save();
                $user          = User::find($request->id);
                $user->id      = $request->id;
                $user->visible = 1;
                $user->update();

                $msg = 'payment Success.' . '' . $request->payment_mode;
                //return redirect()->route('hospital-receipts.show',$trans)->withMessage($msg,)->withMessageType('success');
                return redirect()->route('newPatients', $trans)->withMessage($msg,)->withMessageType('success');
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
    public function storePatientLabServices(Request $request)
    {
        // dd('ggg');//$cheek_payment = Payment::where('transactionid', '=',$request->trans)->fist();


        $trans = $request->trans;
        $rules = [
            'total_amount' => 'required|max:11|min:3',
            'id' => 'required',
            // 'clinic' => 'required',
            //'payment_items' => 'required',
            'payment_mode'
        ];
        $hmo = Hmo::find($request->hmo);
        $hmo_discount = $hmo->discount ?? 0;
        if ($request->payment_mode == 'from_account') {
            $request->payment_mode = $request->from_account_id;
            $account              =  PatientAccount::find($request->payment_mode);
            $old_creadit          = $account->creadit;
            $old_deposit          = $account->deposit;
            $account->credit_b4   = $old_creadit;
            $account->deposite_b4 = $old_deposit;

            if ($request->use_hmo) {
                $amount_paid       = (int) $request->total_amount - (int) ($hmo_discount / 100) * (int) $request->total_amount;
            } else {
                $amount_paid       = (int) $request->total_amount;
            }

            $account->deposit     = (int) $account->deposit - (int) $amount_paid;

            $account->visible           = 1;
            $account->last_amount_paid  = $request->total_amount;
            $account->last_payment_date = \Carbon\Carbon::now();
            if ($account->update()) {
                $v = validator()->make($request->all(), $rules);

                if ($v->fails()) {
                    $msg = 'Please check Your Inputs .';
                    //flash($msg, 'danger');
                    return redirect()->back()->withInput()->withErrors($v);
                } else {
                    $transaction   = new Transaction();
                    $transaction->transaction_no    = $trans;
                    $transaction->budget_year_id    = 1;
                    $transaction->bank_transaction_payment_id    = 00;
                    $transaction->transaction_type  = "Lab Services";
                    $transaction->customer_name     = userfullname($request->id);
                    $transaction->total_amount      = ($request->total_amount);
                    if ($request->use_hmo && isset($hmo)) {
                        $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                        $transaction->hmo_id            = $request->hmo;
                    } else {
                        $transaction->amount_paid       = $request->total_amount;
                        $transaction->hmo_id            = null;
                    }
                    $transaction->deposit_b4        = 00;
                    $transaction->credit_b4         = 00;
                    $transaction->current_deposit   = 00;
                    $transaction->current_credit    = 00;
                    $transaction->customer_type_id  = 2; //$customer_type_id;
                    $transaction->bank_name         = 00;
                    $transaction->staff_id          = Auth::user()->id;
                    $transaction->supply            = 1;
                    // if ($customer_type_id == 2 || $customer_type_id == 3) {

                    //     $transaction->mode_of_payment_id    = 5;
                    //     $transaction->bank_transaction_id   = $request->customer;
                    // } else {

                    $transaction->bank_transaction_id   = 00;
                    $transaction->mode_of_payment_id    = $request->payment_mode;

                    $transaction->bank_transaction_payment_id = $request->payment_id;
                    $transaction->store_id = 0;
                    $transaction->tr_date = \Carbon\Carbon::now();
                    $transaction->tr_year = \Carbon\Carbon::now();

                    if ($transaction->save()) {

                        $transaction_number = Transaction::whereTransaction_no($trans)->first()->id;
                        $medical_report = MedicalReport::find($request->medical_report_id);
                        //dd($medical_report);
                        $medical_report->lab_status = 1;
                        $medical_report->save();
                        $labPs = PatientLabService::where('medical_report_id', '=', $request->medical_report_id)->where('payment_status', '=', 0)->get();
                        //dd($labPs);
                        foreach ($labPs as $lab) {

                            $lab->transaction_id = $transaction_number;
                            $lab->payment_status = 1;
                            $lab->payment_date = \Carbon\Carbon::now();
                            $lab->update();
                        }
                    }


                    $msg = 'lab payment Success.' . '' . $request->total_amount;
                    return redirect()->route('hospital-receipts.show', $trans)->withMessage($msg,)->withMessageType('success');
                }
            }
        } else {
            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                $msg = 'Please check Your Inputs .';
                //flash($msg, 'danger');
                return redirect()->back()->withInput()->withErrors($v);
            } else {
                $transaction   = new Transaction();
                $transaction->transaction_no    = $trans;
                $transaction->budget_year_id    = 1;
                $transaction->bank_transaction_payment_id    = 00;
                $transaction->transaction_type  = "Lab Services";
                $transaction->customer_name     = userfullname($request->id);
                $transaction->total_amount      = ($request->total_amount);
                if ($request->use_hmo && isset($hmo)) {
                    $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                    $transaction->hmo_id            = $request->hmo;
                } else {
                    $transaction->amount_paid       = $request->total_amount;
                    $transaction->hmo_id            = null;
                }
                $transaction->deposit_b4        = 00;
                $transaction->credit_b4         = 00;
                $transaction->current_deposit   = 00;
                $transaction->current_credit    = 00;
                $transaction->customer_type_id  = 2; //$customer_type_id;
                $transaction->bank_name         = 00;
                $transaction->staff_id          = Auth::user()->id;
                $transaction->supply            = 1;
                // if ($customer_type_id == 2 || $customer_type_id == 3) {

                //     $transaction->mode_of_payment_id    = 5;
                //     $transaction->bank_transaction_id   = $request->customer;
                // } else {

                $transaction->bank_transaction_id   = 00;
                $transaction->mode_of_payment_id    = $request->payment_mode;

                $transaction->bank_transaction_payment_id = $request->payment_id;

                $transaction->store_id = 0;
                $transaction->tr_date = \Carbon\Carbon::now();
                $transaction->tr_year = \Carbon\Carbon::now();


                if ($transaction->save()) {

                    $transaction_number = Transaction::whereTransaction_no($trans)->first()->id;
                    $medical_report = MedicalReport::find($request->medical_report_id);
                    //dd($medical_report);
                    $medical_report->lab_status = 1;
                    $medical_report->save();
                    $labPs = PatientLabService::where('medical_report_id', '=', $request->medical_report_id)->where('payment_status', '=', 0)->get();
                    // dd($labPs);
                    foreach ($labPs as $lab) {

                        $lab->transaction_id = $transaction_number;
                        $lab->payment_status = 1;
                        $lab->payment_date = \Carbon\Carbon::now();
                        $lab->update();
                    }
                }


                $msg = 'lab payment Success.' . '' . $request->total_amount;
                return redirect()->route('hospital-receipts.show', $trans)->withMessage($msg,)->withMessageType('success');
            }
        }
    }
    public function paidCharges(Request $request)
    {


        $pc = NurseService::find($request->payment_id);
        if ($request->payment_mode == 6) {
            $acc = PatientAccount::where('user_id', '=', $pc->user_id)->first();
            if (empty($acc)) {
                $msg = ' Patient does not have an Account.';
                Alert::warning('Warning Title', $msg);
                return redirect()->back()->withMessage($msg)->withMessageType('warning');
            }
            if (!empty($acc) && ($pc->charge_amount > $acc->deposit)) {
                $balance = $pc->charge_amount - $acc->deposit;
                $msg = ' Insuficient Balance you need to deposit' . '' . $balance;
                Alert::warning('Warning Title', $msg);
                return redirect()->back()->withMessage($msg)->withMessageType('warning');
            }
            if (!empty($acc) && ($pc->charge_amount < $acc->deposit)) {
                $balance = $acc->deposit - $pc->charge_amount;

                $acc->credit_b4   = $acc->deposit;
                $acc->deposite_b4 = $acc->deposit;
                $acc->creadit     = 0;
                $acc->deposit     = $balance;
                $acc->update();
            }
            if (!empty($acc) && ($pc->charge_amount == $acc->deposit)) {
                $balance = $acc->deposit - $pc->charge_amount;
                $acc->credit_b4   = $acc->deposit;
                $acc->deposite_b4 = $acc->deposit;
                $acc->creadit     = 0;
                $acc->deposit     = 0;
                $acc->update();
            }
        }

        //$cheek_payment = Payment::where('transactionid', '=',$request->trans)->fist();
        $trans = generateTransactionId();
        $rules = [
            'payment_id' => 'required',
            // 'clinic' => 'required',
            //'payment_items' => 'required',
            'payment_mode'  => 'required',
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            $msg = 'Please check Your Inputs .';
            //flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        } else {
            $transaction   = new Transaction();
            $transaction->transaction_no    = $trans;
            $transaction->budget_year_id    = 1;



            $transaction->transaction_type  = "Doctor/Nurse Services ";
            $transaction->customer_name     = userfullname($pc->user_id);
            $transaction->total_amount      = $pc->charge_amount;
            $transaction->deposit_b4        = 00;
            $transaction->credit_b4         = 00;
            $transaction->current_deposit   = 00;
            $transaction->current_credit    = 00;
            $transaction->customer_type_id  = 2; //$customer_type_id;
            $transaction->bank_name         = 00;
            $transaction->staff_id          = Auth::user()->id;
            $transaction->supply            = 1;

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
            if ($request->payment_mode == 6) {
                $transaction->bank_transaction_payment_id    = $pc->user_id;
            }
            // if ($customer_type_id == 2 || $customer_type_id == 3) {

            //     $transaction->mode_of_payment_id    = 5;
            //     $transaction->bank_transaction_id   = $request->customer;
            // } else {

            $transaction->bank_transaction_id   = 00;
            $transaction->mode_of_payment_id    = $request->payment_mode;
            //}

            $transaction->store_id = 0;
            $transaction->tr_date = \Carbon\Carbon::now();
            $transaction->tr_year = \Carbon\Carbon::now();


            if ($transaction->save()) {

                $transaction_number = Transaction::whereTransaction_no($trans)->first();

                $pc->payment_status = 1;
                $pc->transaction_id = $transaction_number->id;
                $pc->payment_date = \Carbon\Carbon::now();
                $pc->visible = 2;
                $pc->update();
            }

            $msg = ' Payment successfuly.';
            $msg = 'payment Success.' . '' . $pc->charge_amount;
            return redirect()->route('hospital-receipts.show', $trans)->withMessage($msg,)->withMessageType('success');
        }
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
    public function newRegistrationFee($id)
    {
        try {

            if (Auth::user()) {

                $trans = generateTransactionId();
                $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
                $patient     = userfullname($id);
                $userid = $id;
                $payment_items = PaymentItem::whereVisible(1)->where('payment_type_id', '=', 1)->orderBy('item_name', 'asc')->pluck('item_name', 'id');
                $clinic = Clinic::where('visible', '=', 1)->orderBy('id', 'asc')->pluck('clinic_name', 'id');

                return view('admin.payments.new_registration_fee', compact('patient', 'trans', 'payment_mode', 'clinic', 'userid', 'payment_items'));
            } else {
                $msg  = "something wrong";
                return redirect(route('newPatients'))->withMessage($msg)->withMessageType('warning')->with($msg);
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }
    public function myItemprice($id)
    {
        // dd($id);
        # code...
        $price = PaymentItem::find($id);

        // dd($price);

        return json_encode($price);
    }

    public function returningPatientFee($id, $dependant_id = null)
    {
        if ($dependant_id == null) {
            $trans = generateTransactionId();
            $userid = $id;
            $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
            $patient     = userfullname($id);

            $payment_items = PaymentItem::whereVisible(1)->where('payment_type_id', '=', 6)->orderBy('item_name', 'asc')->pluck('item_name', 'id');
            $clinic = Clinic::where('visible', '=', 1)->orderBy('id', 'asc')->pluck('clinic_name', 'id');
            $patient_account = PatientAccount::where('visible', 1)->where('user_id', $userid)->first() ?? null;
            $hmo = Patient::with(['hmo'])->where('user_id', $userid)->first()->hmo ?? 'Private';
            //dd($hmo);

            return view('admin.patients.returningPatients.returningPatientsFee', compact('patient', 'trans', 'payment_mode', 'clinic', 'userid', 'payment_items', 'patient_account', 'hmo'));
        } else {
            $trans = generateTransactionId();
            $userid = $id;
            $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
            $dependant = Dependant::find($dependant_id);
            $patient     = $dependant->fullname;

            $payment_items = PaymentItem::whereVisible(1)->where('payment_type_id', '=', 6)->orderBy('item_name', 'asc')->pluck('item_name', 'id');
            $clinic = Clinic::where('visible', '=', 1)->orderBy('id', 'asc')->pluck('clinic_name', 'id');
            $patient_account = PatientAccount::where('visible', 1)->where('user_id', $userid)->first() ?? null;
            $hmo = Patient::with(['hmo'])->where('user_id', $userid)->first()->hmo ?? 'Private';
            //dd($hmo);

            return view('admin.patients.returningPatients.returningPatientsFee', compact('patient', 'trans', 'payment_mode', 'clinic', 'userid', 'payment_items', 'patient_account', 'hmo', 'dependant'));
        }
    }

    public function returningPatientBookingFee($id)
    {
        $trans = generateTransactionId();
        $booking = DoctorBooking::find($id);
        $userid = $booking->patient->user_id;
        $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
        $patient     = userfullname($userid);
        $doc = userfullname($booking->doctor->user_id);

        //$payment_items = PaymentItem::whereVisible(1)->where('payment_type_id', '=', 6)->orderBy('item_name', 'asc')->pluck('item_name', 'id');
        $clinic = Clinic::where('visible', '=', 1)->orderBy('id', 'asc')->pluck('clinic_name', 'id');
        $patient_account = PatientAccount::where('visible', 1)->where('user_id', $userid)->first() ?? null;
        $hmo = Patient::with(['hmo'])->where('user_id', $userid)->first()->hmo ?? 'Private';
        //dd($hmo);

        return view('admin.patients.returningPatients.payBooking', compact('patient', 'trans', 'payment_mode', 'clinic', 'userid', 'patient_account', 'hmo', 'booking', 'doc'));
    }

    public function returningPatientCardPayment(Request $request)
    {
        $hmo = Hmo::find($request->hmo);
        $hmo_discount = $hmo->discount ?? 0;
        if ($request->payment_mode == 'from_account') {
            $request->payment_mode = $request->from_account_id;
            $account              =  PatientAccount::find($request->payment_mode);
            $old_creadit          = $account->creadit;
            $old_deposit          = $account->deposit;
            $account->credit_b4   = $old_creadit;
            $account->deposite_b4 = $old_deposit;

            if ($request->use_hmo) {
                $amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
            } else {
                $amount_paid       = $request->total_amount;
            }


            $account->deposit     = (int) $account->deposit - (int) $amount_paid;

            $account->visible           = 1;
            $account->last_amount_paid  = $request->total_amount;
            $account->last_payment_date = \Carbon\Carbon::now();

            if ($account->update()) {
                $transaction                        = new Transaction();
                $transaction->transaction_no        = $request->trans;
                $transaction->budget_year_id        = 1;
                $transaction->bank_transaction_payment_id = $request->payment_id;
                $transaction->transaction_type      = $request->payment_items;
                $transaction->customer_name         = userfullname($request->id);
                $transaction->total_amount          = $request->total_amount;
                if ($request->use_hmo && isset($hmo)) {
                    $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                    $transaction->hmo_id            = $request->hmo;
                } else {
                    $transaction->amount_paid       = $request->total_amount;
                    $transaction->hmo_id            = null;
                }
                $transaction->deposit_b4            = 00;
                $transaction->credit_b4             = 00;
                $transaction->current_deposit       = 00;
                $transaction->current_credit        = 00;
                $transaction->customer_type_id      = 2; //$customer_type_id;
                $transaction->bank_name             = 00;
                $transaction->staff_id              = Auth::user()->id;
                $transaction->supply                = 1;
                $transaction->bank_transaction_id   = 00;
                $transaction->mode_of_payment_id    = $request->payment_mode;

                $transaction->store_id = 0;
                $transaction->tr_date = \Carbon\Carbon::now();
                $transaction->tr_year = \Carbon\Carbon::now();
            } else {
                $msg  = "something went wrong";
                return back()->withMessage($msg)->withMessageType('warning')->with($msg);
            }
        } else {
            $hmo = Hmo::find($request->hmo);
            $hmo_discount = $hmo->discount ?? 0;
            $transaction                        = new Transaction();
            $transaction->transaction_no        = $request->trans;
            $transaction->budget_year_id        = 1;
            $transaction->bank_transaction_payment_id = $request->payment_id;
            $transaction->transaction_type      = $request->payment_items;
            $transaction->customer_name         = userfullname($request->id);
            $transaction->total_amount          = $request->total_amount;
            if ($request->use_hmo && isset($hmo)) {
                $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                $transaction->hmo_id            = $request->hmo;
            } else {
                $transaction->amount_paid       = $request->total_amount;
                $transaction->hmo_id            = null;
            }
            $transaction->deposit_b4            = 00;
            $transaction->credit_b4             = 00;
            $transaction->current_deposit       = 00;
            $transaction->current_credit        = 00;
            $transaction->customer_type_id      = 2; //$customer_type_id;
            $transaction->bank_name             = 00;
            $transaction->staff_id              = Auth::user()->id;
            $transaction->supply                = 1;
            $transaction->bank_transaction_id   = 00;
            $transaction->mode_of_payment_id    = $request->payment_mode;

            $transaction->store_id = 0;
            $transaction->tr_date = \Carbon\Carbon::now();
            $transaction->tr_year = \Carbon\Carbon::now();
        }

        if ($transaction->save()) {
            //if the principal was also selected
            if ($request->dependant_id == '') {
                $patient            = Patient::where('user_id', '=', $request->id)->first();
                $patient->clinic_id = $request->clinic_name;
                $patient->visible   = 2;



                if ($patient->save()) {
                    //modify the vitals of the principal
                    $resAck = VitalSign::where('user_id', '=', $request->id)->where('paymentVisibility', '=', 0)->first();
                    $resAck->status = 0;
                    $resAck->paymentVisibility = 1;

                    if ($resAck->update()) {
                        //get all selected dependants using the vital signs
                        $vital_deps = DB::select("SELECT * FROM `vital_signs` WHERE `user_id` = :user_id AND `status` IN ('1','-1') AND `dependant_id` IS NOT NULL",
                            array('user_id'=>$request->id));
                        //$vital_deps = VitalSign::where('user_id', '=', $request->id)->where('status','IN',"('1','-1')" )->where('dependant_id', '!=', null)->get();
                        foreach ($vital_deps as $vital_dep) {
                            //set them to be visible to the doc
                            $dep = Dependant::find($vital_dep->dependant_id);
                            $dep->visible = 2;
                            $dep->update();
                            //make thier vitals visible to the nurse
                            $vital_dep = VitalSign::find($vital_dep->id);
                            $vital_dep->paymentVisibility = 1;
                            $vital_dep->status = 0;
                            $vital_dep->update();
                        }
                        $msg = 'Payment made successfully';
                        Alert::success('Success ', $msg);
                        return redirect()->route('returningPatients')->withMessage($msg)->withMessageType('success');
                    }
                } else {
                    $msg  = "something went wrong";
                    return back()->withMessage($msg)->withMessageType('warning')->with($msg);
                }
            } else {
                //get all selected dependants using the vital signs
                // $vital_deps = VitalSign::where('user_id', '=', $request->id)->where('status','IN',"('1','-1')" )->where('dependant_id','IS NOT','NULL')->get();
                $vital_deps = DB::select("SELECT * FROM `vital_signs` WHERE `user_id` = :user_id AND `status` IN ('1','-1') AND `dependant_id` IS NOT NULL",
                    array('user_id'=>$request->id));
                //dd(collect($vital_deps));
                $vital_deps = collect($vital_deps);
                foreach ($vital_deps as $vital_dep) {
                    $dep = Dependant::find($vital_dep->dependant_id);
                    $dep->visible = 2;
                    $dep->update();
                    //make thier vitals visible to the nurse
                    $vital_dep = VitalSign::find($vital_dep->id);
                    $vital_dep->paymentVisibility = 1;
                    $vital_dep->status = 0;
                    $vital_dep->update();
                }
                $msg = 'Payment made successfully';
                Alert::success('Success ', $msg);
                return redirect()->route('returningPatients')->withMessage($msg)->withMessageType('success');
            }
        } else {
            $msg  = "something went wrong";
            return back()->withMessage($msg)->withMessageType('warning')->with($msg);
        }
    }

    public function returningPatientBookingPayment(Request $request)
    {
        $hmo = Hmo::find($request->hmo);
        $hmo_discount = $hmo->discount ?? 0;
        if ($request->payment_mode == 'from_account') {
            $request->payment_mode = $request->from_account_id;
            $account              =  PatientAccount::find($request->payment_mode);
            $old_creadit          = $account->creadit;
            $old_deposit          = $account->deposit;
            $account->credit_b4   = $old_creadit;
            $account->deposite_b4 = $old_deposit;

            if ($request->use_hmo) {
                $amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
            } else {
                $amount_paid       = $request->total_amount;
            }


            $account->deposit     = (int) $account->deposit - (int) $amount_paid;

            $account->visible           = 1;
            $account->last_amount_paid  = $request->total_amount;
            $account->last_payment_date = \Carbon\Carbon::now();

            if ($account->update()) {
                $transaction                        = new Transaction();
                $transaction->transaction_no        = $request->trans;
                $transaction->budget_year_id        = 1;
                $transaction->bank_transaction_payment_id = $request->payment_id;
                $transaction->transaction_type      = 'Appointment Booking';
                $transaction->customer_name         = userfullname($request->id);
                $transaction->total_amount          = $request->total_amount;
                if ($request->use_hmo && isset($hmo)) {
                    $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                    $transaction->hmo_id            = $request->hmo;
                } else {
                    $transaction->amount_paid       = $request->total_amount;
                    $transaction->hmo_id            = null;
                }
                $transaction->deposit_b4            = 00;
                $transaction->credit_b4             = 00;
                $transaction->current_deposit       = 00;
                $transaction->current_credit        = 00;
                $transaction->customer_type_id      = 2; //$customer_type_id;
                $transaction->bank_name             = 00;
                $transaction->staff_id              = Auth::user()->id;
                $transaction->supply                = 1;
                $transaction->bank_transaction_id   = 00;
                $transaction->mode_of_payment_id    = $request->payment_mode;

                $transaction->store_id = 0;
                $transaction->tr_date = \Carbon\Carbon::now();
                $transaction->tr_year = \Carbon\Carbon::now();
            } else {
                $msg  = "something went wrong";
                return back()->withMessage($msg)->withMessageType('warning')->with($msg);
            }
        } else {
            $hmo = Hmo::find($request->hmo);
            $hmo_discount = $hmo->discount ?? 0;
            $transaction                        = new Transaction();
            $transaction->transaction_no        = $request->trans;
            $transaction->budget_year_id        = 1;
            $transaction->bank_transaction_payment_id = $request->payment_id;
            $transaction->transaction_type      = 'Appointment Booking';
            $transaction->customer_name         = userfullname($request->id);
            $transaction->total_amount          = $request->total_amount;
            if ($request->use_hmo && isset($hmo)) {
                $transaction->amount_paid       = $request->total_amount - ($hmo_discount / 100) * $request->total_amount;
                $transaction->hmo_id            = $request->hmo;
            } else {
                $transaction->amount_paid       = $request->total_amount;
                $transaction->hmo_id            = null;
            }
            $transaction->deposit_b4            = 00;
            $transaction->credit_b4             = 00;
            $transaction->current_deposit       = 00;
            $transaction->current_credit        = 00;
            $transaction->customer_type_id      = 2; //$customer_type_id;
            $transaction->bank_name             = 00;
            $transaction->staff_id              = Auth::user()->id;
            $transaction->supply                = 1;
            $transaction->bank_transaction_id   = 00;
            $transaction->mode_of_payment_id    = $request->payment_mode;

            $transaction->store_id = 0;
            $transaction->tr_date = \Carbon\Carbon::now();
            $transaction->tr_year = \Carbon\Carbon::now();
        }

        if ($transaction->save()) {
            $patient            = Patient::where('user_id', '=', $request->id)->first();
            $booking            = DoctorBooking::find($request->booking_id);
            $patient->clinic_id = $request->clinic_name;
            // $patient->visible   = 2;

            if ($patient->save()) {
                $booking            = DoctorBooking::find($request->booking_id);
                $booking->paid = 1;
                $booking->transaction_id = $transaction->id;
                if ($booking->update()) {
                    $msg = 'Booking Payment made successfully';
                    Alert::success('Success ', $msg);
                    return redirect()->route('returningPatientsBooking')->withMessage($msg)->withMessageType('success');
                }
            } else {
                $msg  = "something went wrong";
                return back()->withMessage($msg)->withMessageType('warning')->with($msg);
            }
        } else {
            $msg  = "something went wrong";
            return back()->withMessage($msg)->withMessageType('warning')->with($msg);
        }
    }
}
