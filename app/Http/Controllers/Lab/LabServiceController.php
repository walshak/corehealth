<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lab;
use App\LabService;
use App\ApplicationStatu;
use App\User;
use App\Hmo;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Patient;
use App\PaymentItem;
use App\ModeOfPayment;
use App\Clinic;
use App\MedicalReport;
use App\PatientLabService;
use App\PatientAccount;
use App\Dependant;
use App\Doctor;
use App\Notifications\LabResultNotification;
use Illuminate\Support\Facades\Notification;
use Auth;

class LabServiceController extends Controller
{
    public function listshowLabServices($id)
    {
        $pc = LabService::where('lab_id', '=', $id)->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('visible', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })
            ->addColumn('edit', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('lab-services.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil nav-icon "> </i> Edit</a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Edit</a>';
                }
            })

            ->addColumn('price', function ($pc) {

                if ($pc->price_assing == 0) {

                    return '<a class="btn btn-success btn-sm" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->lab_service_name . '" title="Set Price"> <i class="fa fa-plus-circle"></i> Price
                            </a> ';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-default"></i> Price</a>';
                }
            })
            ->rawColumns(['visible', 'edit', 'price'])

            ->make(true);
    }
    public function listLabServices()
    {
        $pc = LabService::where('id', '>', 0)->with('lab')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('visible', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })
            ->editColumn('labname', function ($pc) {
                return ($pc->lab->lab_name);
            })


            ->rawColumns(['visible', 'labname'])

            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lab_services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'lab_service_name'          => 'required',
            'description'         => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {

                $lab                     = new LabService;
                // dd($lab);
                $lab->lab_id             = $request->lab_id;
                $lab->lab_service_name   = $request->lab_service_name;
                $lab->description        = $request->description;
                $lab->visible            = 1;
                $lab->price_assing       = 0;
                $msg = 'lab Saved.';
                if ($lab->save()) {
                    return redirect(route('labs.index'))->with('toast_success', $msg);
                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
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
        $lab = Lab::find($id);
        return view('admin.lab_services.create', compact('lab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lab = LabService::find($id);

        return view('admin.lab_services.edite', compact('lab'));
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
        //dd($request);

        $rules = [
            'lab_service_name'  => 'required',
            'description'  => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {

                $lab                     =  LabService::find($id);
                $name =  $lab->lab_service_name;
                $lab->lab_service_name   = $request->lab_service_name;
                $lab->description        = $request->description;
                $lab->visible            = $request->visible;
                $payment_items = PaymentItem::where('item_name', '=', $name)->first();
                //dd($payment_items);
                if ($lab->update()) {

                    $payment_items->item_name = $request->lab_service_name;
                    $payment_items->update();
                    $msg = 'lab Updated Successfuly.';
                    return redirect(route('showLabServices', $lab->lab_id))->with('toast_success', $msg);
                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
    public function ShowLabServices($id)
    {
        $lab = Lab::find($id);
        return view('admin.lab_services.show_Lab_services', compact('lab'));
    }

    public function LabServicesPrice($id)
    {
        $lab = LabService::find($id);
        return ($lab->lab_service_name);
    }

    public function labServicesPaymentRequest()
    {
        return view('admin.lab_services.lab_services_payment_request');
    }

    public function labServicesPaymentRequestList()
    {

        $pc = MedicalReport::where('lab_status', '=', 0)->orderBy('created_at','DESC')->get();
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 1) ? "Inactive" : "Active");
            })
            ->editColumn('fullname', function ($pc) {
                if ($pc->dependant_id == null) {
                    return (userfullname($pc->user_id));
                } else {
                    $dep = Dependant::find($pc->dependant_id);
                    return $dep->fullname . ' (' . userfullname($pc->user_id) . ')';
                }
            })
            ->editColumn('file_no', function ($pc) {
                if ($pc->user_id != 44) {
                    return (showFileNumber($pc->user_id));
                } else {
                    return $pc->pateintDiagnosisReport;
                }
            })

            ->addColumn('view_Request_Sevices', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    if ($pc->dependant_id == null) {
                        $url =  route('PatientlabServicesRequest', $pc->id);
                    } else {
                        $url =  route('PatientlabServicesRequest', [$pc->id, $pc->dependant_id]);
                    }
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-eye nav-icon "> </i> View Request Services</a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> View Request Services</a>';
                }
            })

            ->rawColumns(['visible', 'view_Request_Sevices', 'status', 'file_no'])

            ->make(true);
    }

    public function PatientlabServicesRequestList($id)
    {

        $pc = PatientLabService::where('medical_report_id', '=', $id)->where('payment_status', '=', 0)->where('status_id', '=', 1)->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })

            ->editColumn('lab', function ($pc) {
                $lap = Lab::find($pc->lab_id);
                return ($pc->lab->lab_name);
            })

            ->editColumn('labService', function ($pc) {
                $labs = LabService::find($pc->lab_service_id);
                return ($labs->lab_service_name);
            })
            ->addColumn('makepayment', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('lab-services.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil nav-icon "> </i>Make Payment</a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Make Payment</a>';
                }
            })
            ->addColumn('price', function ($pc) {
                $labI = LabService::find($pc->lab_service_id);

                $price = PaymentItem::where('item_name', '=',  $labI->lab_service_name)->first();
                //dd($price);
                $getprices = $price->amount;
                return ($getprices);
            })

            ->rawColumns(['status', 'makepayment', 'lab', 'labService', 'price',])

            ->make(true);
    }

    public function randerServicesList()
    {

        $pc = PatientLabService::where('payment_status', '=', 1)->where('sampeTaken', '=', 0)->where('status_id', '=', 1)->groupBy('medical_report_id')->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })

            ->editColumn('lab', function ($pc) {
                $lap = Lab::find($pc->lab_id);
                return ($pc->lab->lab_name);
            })


            ->addColumn('file_no', function ($pc) {
                return Patient::where('user_id', $pc->patient_user_id)->first()->file_no;
            })
            ->addColumn('hmo', function ($pc) {
                $hmo = Patient::where('user_id', $pc->patient_user_id)->first()->hmo_id;
                return Hmo::where('id', $hmo)->first()->name;
            })

            ->editColumn('patient', function ($pc) {
                if ($pc->dependant_id == null) {
                    return (userfullname($pc->patient_user_id));
                } else {
                    $dep = Dependant::find($pc->dependant_id);
                    return $dep->fullname . ' (' . userfullname($pc->patient_user_id) . ')';
                }
            })
            ->editColumn('labService', function ($pc) {
                $labs = LabService::find($pc->lab_service_id);
                return ($labs->lab_service_name);
            })
            ->addColumn('sample', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('takeSampleShow', $pc->medical_report_id);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil nav-icon "> </i> Take Sample </a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Take sample</a>';
                }
            })
            ->addColumn('price', function ($pc) {
                $labI = LabService::find($pc->lab_service_id);

                $price = PaymentItem::where('item_name', '=',  $labI->lab_service_name)->first();
                //dd($price);
                $getprices = $price->amount;
                return ($getprices);
            })

            ->rawColumns(['status', 'sample', 'lab', 'labService', 'price', 'patient'])

            ->make(true);
    }

    public function randerResultList()
    {

        $pc = PatientLabService::where('payment_status', '=', 1)->where('sampeTaken', '=', 1)->where('status_id', '=', 1)->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })

            ->editColumn('lab', function ($pc) {
                $lap = Lab::find($pc->lab_id);
                return ($pc->lab->lab_name);
            })

            ->addColumn('file_no', function ($pc) {
                return Patient::where('user_id', $pc->patient_user_id)->first()->file_no;
            })
            ->addColumn('hmo', function ($pc) {
                $hmo = Patient::where('user_id', $pc->patient_user_id)->first()->hmo_id;
                return Hmo::where('id', $hmo)->first()->name;
            })

            ->editColumn('labService', function ($pc) {
                $labs = LabService::find($pc->lab_service_id);
                return ($labs->lab_service_name);
            })
            ->editColumn('sample_by', function ($pc) {
                return (userfullname($pc->sample_taken_by));
            })

            ->addColumn('result', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {



                    return '<a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->id . '" title="Create a project"> <i class="fas fa-plus-circle"></i> Enter
                            </a> ';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> sample</a>';
                }
            })->addColumn('patient', function ($pc) {

                if ($pc->dependant_id == null) {
                    return (userfullname($pc->patient_user_id));
                } else {
                    $dep = Dependant::find($pc->dependant_id);
                    return $dep->fullname . ' (' . userfullname($pc->patient_user_id) . ')';
                }
            })
            ->addColumn('price', function ($pc) {
                $labI = LabService::find($pc->lab_service_id);

                $price = PaymentItem::where('item_name', '=',  $labI->lab_service_name)->first();
                //dd($price);
                $getprices = $price->amount;
                return ($getprices);
            })

            ->rawColumns(['status', 'lab', 'labService', 'price', 'result', 'sample_by', 'patient'])

            ->make(true);
    }

    public function viewResultList()
    {

        $pc = PatientLabService::where('payment_status', '=', 1)->where('sampeTaken', '=', 2)->where('status_id', '=', 1)->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('status', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })

            ->addColumn('file_no', function ($pc) {
                return Patient::where('user_id', $pc->patient_user_id)->first()->file_no;
            })
            ->addColumn('hmo', function ($pc) {
                $hmo = Patient::where('user_id', $pc->patient_user_id)->first()->hmo_id;
                return Hmo::where('id', $hmo)->first()->name;
            })

            ->editColumn('lab', function ($pc) {
                $lap = Lab::find($pc->lab_id);
                return ($pc->lab->lab_name);
            })

            ->editColumn('labService', function ($pc) {
                $labs = LabService::find($pc->lab_service_id);
                return ($labs->lab_service_name);
            })
            ->editColumn('sample_by', function ($pc) {
                return (userfullname($pc->sample_taken_by));
            })
            ->editColumn('result_by', function ($pc) {
                return (userfullname($pc->resultReport_by));
            })

            ->addColumn('result', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Labs']) || Auth::user()->hasPermissionTo('customer-edit')) {



                    return "<a class=\"btn btn-success text-light\" data-toggle=\"modal\" id=\"mediumButton\" data-target=\"#mediumModal\" data-attr='$pc->resultReport'> <i class=\"fas fa-plus-circle\"></i> Read
                            </a>";
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Result</a>';
                }
            })->addColumn('patient', function ($pc) {

                if ($pc->dependant_id == null) {
                    return (userfullname($pc->patient_user_id));
                } else {
                    $dep = Dependant::find($pc->dependant_id);
                    return $dep->fullname . ' (' . userfullname($pc->patient_user_id) . ')';
                }
            })
            ->addColumn('price', function ($pc) {
                $labI = LabService::find($pc->lab_service_id);

                $price = PaymentItem::where('item_name', '=',  $labI->lab_service_name)->first();
                //dd($price);
                $getprices = $price->amount;
                return ($getprices);
            })

            ->rawColumns(['status', 'lab', 'labService', 'price', 'result', 'sample_by', 'patient', 'result_by'])

            ->make(true);
    }

    public function PatientlabServicesRequest($id, $dependant_id = null)
    {
        $trans = generateTransactionId();
        $pc = MedicalReport::find($id);

        $payment_mode = ModeOfPayment::whereVisible(1)->where('id', '!=', 5)->orderBy('created_at', 'DESC')->pluck('payment_mode', 'id');
        if ($pc->dependant_id == null) {
            $patient = (userfullname($pc->user_id));
        } else {
            $dep = Dependant::find($pc->dependant_id);
            $patient = $dep->fullname;
        }
        $userid = $pc->user_id;

        $sum = 0;

        $labPs = PatientLabService::where('medical_report_id', '=', $pc->id)->where('payment_status', '=', 0)->get();
        foreach ($labPs as $lab) {
            $labs = LabService::find($lab->lab_service_id);
            $price = PaymentItem::where('item_name', '=',  $labs->lab_service_name)->first();
            $sum  = $price->amount + $sum;
        }
        $patient_account = PatientAccount::where('visible', 1)->where('user_id', $userid)->first() ?? null;
        $hmo = Patient::with(['hmo'])->where('user_id', $userid)->first()->hmo ?? 'Private';


        $payment_items = 3;

        return view('admin.lab_services.patient_lab_services__request', compact('pc', 'patient', 'trans', 'payment_mode', 'userid', 'payment_items', 'sum', 'patient_account', 'hmo'));
    }

    public function randerServices()
    {
        $patients = Patient::with(['user'])
            ->where('visible', '1')
            ->orWhere('visible', '2')
            ->orWhere('visible', '3')
            ->orWhere('visible', '4')
            ->get();

        $labs = LabService::with(['lab'])
            ->where('visible', 1)
            ->get();
        return view('admin.lab_services.rander_services', compact('patients', 'labs'));
    }

    public function createLabRequest(Request $request)
    {

        $rules = [
            'patient_id'  => 'required',
            'lab_id'  => 'required',
            'service_description'  => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {
                if ($request->patient_id == 'not-apply') {
                    //create a copy-cat med report, so that this new listing will show among lab request payments
                    $report                            = new MedicalReport;
                    $report->user_id                   = 44;
                    $report->doctor_id                 = Auth::user()->id;
                    $report->pharmacy_id               = 0;
                    $report->nurse_id                  = 0;
                    $report->transaction_no            = generateTransactionId();
                    $report->pateintDiagnosisReport    = $request->service_description;
                    $report->lab_status                = 0;
                } else {
                    //create a copy-cat med report, so that this new listing will show among lab request payments
                    $report                            = new MedicalReport;
                    $report->user_id                   = $request->patient_id;
                    $report->doctor_id                 = Auth::user()->id;
                    $report->pharmacy_id               = 0;
                    $report->nurse_id                  = 0;
                    $report->transaction_no            = generateTransactionId();
                    $report->pateintDiagnosisReport    = $request->service_description;
                    $report->lab_status                = 0;
                }
                if ($report->save()) {
                    $createService = new PatientLabService();

                    if ($request->patient_id != 'not-apply') {
                        $createService->patient_user_id = $request->patient_id;
                        $createService->lab_user_id = $request->lab_user_id;
                        $createService->medical_report_id = $report->id;
                        $createService->lab_id = getLabId($request->lab_id);
                        $createService->lab_service_id = $request->lab_id;
                        $createService->payment_status = 0;
                        $createService->status_id = 1;
                        $createService->sampeTaken = 0;
                        $createService->sampeDate = 0;
                        $createService->resultReport = 0;
                        $createService->resultDate = 0;
                    } else {
                        $createService->patient_user_id = 44;
                        $createService->lab_user_id = $request->lab_user_id;
                        $createService->medical_report_id = $report->id;
                        $createService->lab_id = getLabId($request->lab_id);
                        $createService->lab_service_id = $request->lab_id;
                        $createService->payment_status = 0;
                        $createService->status_id = 1;
                        $createService->sampeTaken = 0;
                        $createService->sampeDate = 0;
                        $createService->resultReport = 0;
                        $createService->resultDate = 0;
                    }
                    if ($createService->save()) {
                        $msg = 'lab Service Request created Successfuly.';
                        return redirect(url('randerServices'))->with('toast_success', $msg);
                    } else {
                        $msg = 'Something is went wrong. Please try again later, Request not Saved.';
                        //flash($msg, 'danger');
                        return redirect()->back()->with('error', $msg)->withInput();
                    }
                } else {
                    $msg = 'Something is went wrong. Please try again later, Request not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    public function randerResult($id = null)
    {
        if (null == $id) {
            return view('admin.lab_services.RanderResult');
        } else {
            $sample                  = PatientLabService::find($id);
            $template                = $sample->lab_service->template;
            return json_encode(['template' => $template]);
        }
    }

    public function takeSample(Request $request)
    {
        // dd($request->lab_services);
        $err = 0;
        $request->validate([
            'lab_services' => 'required'
        ]);
        if ($request->reject_selected == '1') {
            foreach($request->lab_services as $id){
                $sample                  = PatientLabService::find($id);
                $sample->status_id       = 0;
                if($sample->update()){
                    continue;
                }else{
                    $err++;
                }
            }

            if($err == 0){
                $msg = 'Requests Declined successfuly .';
                Alert::success('Success ', $msg);
                return redirect()->route('randerServices')->withMessage($msg)->withMessageType('success');
            }else{
                $msg = 'Some Errors Occured.';
                Alert::error('Error ', $msg);
                return redirect()->back()->withMessage($msg)->withMessageType('warning');
            }
        } else {
            foreach ($request->lab_services as $id) {
                $sample                  = PatientLabService::find($id);
                $sample->sampeTaken      = 1;
                $sample->sampeDate       = \Carbon\Carbon::now();
                $sample->sample_taken_by =  Auth::user()->id;
                if ($sample->update()) {
                    continue;
                } else {
                    $err++;
                }
            }

            if ($err == 0) {
                $msg = 'Sample Taked successfuly .';
                Alert::success('Success ', $msg);
                return redirect()->route('randerServices')->withMessage($msg)->withMessageType('success');
            } else {
                $msg = 'Some Errors Occured.';
                Alert::error('Error ', $msg);
                return redirect()->back()->withMessage($msg)->withMessageType('warning');
            }
        }
    }

    public function takeSampleShow($medicalReportId)
    {
        $lab_requests = PatientLabService::with(['user', 'lab_service', 'lab'])
            ->where('payment_status', '=', 1)
            ->where('sampeTaken', '=', 0)
            ->where('status_id', '=', 1)
            ->where('medical_report_id', $medicalReportId)
            ->orderBy('created_at', 'DESC')
            ->get();
        // $price = PaymentItem::where('item_name', '=',  $labI->lab_service_name)->first();
        return view('admin.lab_services.take_sample_show', compact('lab_requests', 'medicalReportId'));
    }

    public function testResult(Request $request)
    {
        //make all contenteditable section uneditable, so that they wont be editable when they show up in medical history
        $request->result = str_replace('contenteditable="true"', 'contenteditable="false"', $request->result);
        $request->result = str_replace("contenteditable='true'", "contenteditable='false'", $request->result);
        $request->result = str_replace('contenteditable = "true"', 'contenteditable="false"', $request->result);
        $request->result = str_replace("contenteditable ='true'", "contenteditable='false'", $request->result);
        $request->result = str_replace('contenteditable= "true"', 'contenteditable="false"', $request->result);

        //remove all black borders and replace with gray
        $request->result = str_replace(' black', ' gray', $request->result);

        $sample                  = PatientLabService::with(['medical_report','lab_service','user'])->where('id', $request->item_name)->first();

        $sample->resultReport      = $request->result;
        $sample->sampeTaken      = 2;
        $sample->resultDate       = \Carbon\Carbon::now();
        $sample->resultReport_by =  Auth::user()->id;
        $sample->update();

        $medical_report = MedicalReport::find($sample->medical_report_id);
        $medical_report->lab_status = 1;
        $medical_report->update();
        $msg = 'Result saved successfuly .';

        //Alert::success('Success ', $msg);

        //post notification to the requeting doctor
        $the_requesting_doc = User::find($sample->medical_report->doctor_id);
        $the_patient = userfullname($sample->user->id);
        $the_lab_service = $sample->lab_service->lab_service_name;
        $the_timestamp = $sample->updated_at;
        Notification::send(User::all(), new LabResultNotification($the_patient,$the_lab_service,$the_timestamp));
        return redirect()->route('randerResult')->withMessage($msg)->withMessageType('success');
    }

    public function viewResult()
    {
        return view('admin.lab_services.viewResult');
    }
}
