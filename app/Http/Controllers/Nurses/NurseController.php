<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lab;
use App\LabService;
use App\ApplicationStatu;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Patient;
use App\PaymentItem;
use App\ModeOfPayment;
use App\Clinic;
use App\Dependant;
use App\MedicalReport;
use App\NurseService;
use App\PatientLabService;
use Auth;

class NurseController extends Controller
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

        $rules = [
            'tottal_amount'          => 'required',
            'service_description'    => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {
                if (null == $request->patient_id) {
                    $user = MedicalReport::find($request->medical_report_id);
                    //dd($user);
                    $service                    = new NurseService;
                    $service->user_id           = $user->user_id;
                    $service->medical_report_id = $request->medical_report_id;
                    $service->transaction_id    = "";
                    $service->file_no           = showFileNumber($user->user_id);
                    $service->charge_amount     = $request->tottal_amount;
                    $service->service_description = $request->service_description;
                    $service->nurse_user_id     = Auth::user()->id;
                    $service->payment_status    = 0;
                    $service->payment_date      = "";
                    $service->visible           = 1;
                    if ($service->save()) {
                        $user->nurseContent_status = 2;
                        $user->update();
                        $msg = 'Charges Success.' . '' . $request->tottal_amount;
                        Alert::success('Success ', $msg);
                        return redirect()->route('nurseServiceRequest')->withMessage($msg)->withMessageType('success');
                    } else {
                        $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                        //flash($msg, 'danger');
                        return redirect()->back()->with('error', $msg)->withInput();
                    }
                } else {
                    $user = User::find($request->patient_id);
                    if (!empty($user)) {
                        //dd($user);
                        $service                    = new NurseService;
                        $service->user_id           = $user->id;
                        $service->medical_report_id = null;
                        $service->transaction_id    = "";
                        $service->file_no           = showFileNumber($user->id);
                        $service->charge_amount     = $request->tottal_amount;
                        $service->service_description = $request->service_description;
                        $service->nurse_user_id     = Auth::user()->id;
                        $service->payment_status    = 0;
                        $service->payment_date      = "";
                        $service->visible           = 1;
                        if ($service->save()) {
                            $msg = 'Charges Success.' . '' . $request->tottal_amount;
                            Alert::success('Success ', $msg);
                            return redirect()->route('nurseServiceRequest')->withMessage($msg)->withMessageType('success');
                        } else {
                            $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                            //flash($msg, 'danger');
                            return redirect()->back()->with('error', $msg)->withInput();
                        }
                    } else {
                        //dd($user);
                        $service                    = new NurseService;
                        $service->user_id           = 44;
                        $service->medical_report_id = null;
                        $service->transaction_id    = "";
                        $service->file_no           = null;
                        $service->charge_amount     = $request->tottal_amount;
                        $service->service_description = $request->service_description;
                        $service->nurse_user_id     = Auth::user()->id;
                        $service->payment_status    = 0;
                        $service->payment_date      = "";
                        $service->visible           = 1;
                        if ($service->save()) {
                            $msg = 'Charges Success.' . '' . $request->tottal_amount;
                            Alert::success('Success ', $msg);
                            return redirect()->route('nurseServiceRequest')->withMessage($msg)->withMessageType('success');
                        } else {
                            $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                            //flash($msg, 'danger');
                            return redirect()->back()->with('error', $msg)->withInput();
                        }
                    }
                }
            }
        } catch (Exception $e) {

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

    public function noCharges($id,$dependant_id = null)
    {
        $pc = MedicalReport::find($id);
        if ($pc->admission == 0) {
            $pc->nurseContent_status = 2;
            $pc->visible = 2;
            $pc->nurse_id =  Auth::user()->id;
            if($pc->update()){
                if($dependant_id == null){
                    $pacient = Patient::where('user_id', '=', $pc->user_id)->first();
                }else{
                    $pacient = Patient::where('user_id', '=', $pc->user_id)->first();
                    $pacient = Dependant::where('patient_id',$pacient->id)->where('id',$dependant_id)->first();
                }
                $pacient->visible = 4;
                if ($pacient->update()) {
                    $msg = 'Successfully Processed.' . '' . User::find($pc->user_id)->surname;
                    Alert::success('Success ', $msg);
                    return redirect('receptionists')->withMessage($msg)->withMessageType('success');
                }
            }else{
                $msg = 'Failed to dismiss service';
                Alert::warning('Warning ', $msg);
                return back()->withMessage($msg)->withMessageType('warning');
            }
        } else {
            $msg = 'Failed Proccess .' . '' . User::find($pc->user_id)->surname.' Is Currently on Admission You can discharge them on ward rounds';
            Alert::warning('Warning ', $msg);
            return back()->withMessage($msg)->withMessageType('warning');
        }
    }

    public function nurseServiceRequest()
    {
        $patients = Patient::with(['user'])
            ->where('visible', '1')
            ->orWhere('visible', '2')
            ->orWhere('visible', '3')
            ->orWhere('visible', '4')
            ->get();
        return view('admin.nurse.nurse_services_request', compact('patients'));
    }
    public function nurseServiceRequestList()
    {

        $pc = MedicalReport::where('nurseContent_status', '=', 1)->get();
        //dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 1) ? "Inactive" : "Active");
            })
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user_id));
            })
            ->editColumn('doctor', function ($pc) {
                return (userfullname($pc->doctor_id));
            })
            ->editColumn('file_no', function ($pc) {
                return (showFileNumber($pc->user_id));
            })

            ->addColumn('clinic', function ($pc) {

                $patient = Patient::where('user_id', '=', $pc->user_id)->first();
                $clinic = $patient->clinic->clinic_name;
                return $clinic;
            })
            ->addColumn('no_service_charge', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('noCharges', $pc->id);
                return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-eye nav-icon "> </i> No Charge</a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> No</a>';
                // }
            })
            ->addColumn('sevices_charge', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                return '<a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->id . '" title="Enter Charges"> <i class="fas fa-plus-circle"></i> Enter Charges
                            </a> ';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> View Request Services</a>';
                // }
            })

            ->rawColumns(['status', 'sevices_charge', 'status', 'file_no', 'no_service_charge', 'doctor', 'fullname', 'clinic'])

            ->make(true);
    }
    public function nurseServicePaymentRequest()
    {
        $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
        return view('admin.nurse.nurse_services_payment_request', compact('payment_mode'));
    }
    public function nurseServicePaymentRequestList()
    {

        $pc = NurseService::where('visible', '=', 1)->where('payment_status', '=', 0)->get();
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 1) ? "Inactive" : "Active");
            })
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user_id));
            })
            ->editColumn('billby', function ($pc) {
                return (userfullname($pc->nurse_user_id));
            })
            ->editColumn('file_no', function ($pc) {
                if ($pc->user_id !== 44) {
                    return (showFileNumber($pc->user_id));
                } else {
                    return ('N/A');
                }
            })

            ->addColumn('clinic', function ($pc) {
                if ($pc->user_id !== 44) {
                    $patient = Patient::where('user_id', '=', $pc->user_id)->first();
                    $clinic = $patient->clinic->clinic_name ?? null;
                    return $clinic;
                } else {
                    return "DECRIPTION OF SERVICE :" . $pc->service_description;
                }
            })

            ->addColumn('make_payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                return '<a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->id . '" title="Enter Charges"> <i class="fas fa-plus-circle"></i> Make Payment </a> ';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> View Request Services</a>';
                // }
            })

            ->rawColumns(['status', 'sevices_charge', 'status', 'file_no', 'billby', 'fullname', 'clinic', 'make_payment'])

            ->make(true);
    }
}
