<?php

namespace App\Http\Controllers\MedicalReport;

use Auth;
use App\Bed;
use App\Hmo;
use App\User;
use App\Ward;
use App\Clinic;
use App\Doctor;
use App\Patient;
use App\Dependant;
use App\VitalSign;
use App\LabService;
use App\MedicalReport;
use App\Product;
use App\PatientAssignBed;
use App\PatientLabService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\InconclusiveMedicalReport;
use App\Http\Controllers\Controller;
use DateTime;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;

class MedicalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * lab_status =0 No payment *
     * lab_status =1 payment Sussefuly*
     * lab_status =2 sample take
     * lab_status =3 result Submite
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

    public function remove_editable($the_string){
        //make all contenteditable section uneditable, so that they wont be editable when they show up in medical history
        $the_string = str_replace('contenteditable="true"', 'contenteditable="false"', $the_string);
        $the_string = str_replace("contenteditable='true'", "contenteditable='false'", $the_string);
        $the_string = str_replace('contenteditable = "true"', 'contenteditable="false"', $the_string);
        $the_string = str_replace("contenteditable ='true'", "contenteditable='false'", $the_string);
        $the_string = str_replace('contenteditable= "true"', 'contenteditable="false"', $the_string);

        //remove all black borders
        $the_string = str_replace(' black', ' gray', $the_string);

        //reemove the ids to avoid conflicts when the medical record is rendered later
        $the_string = str_replace('parm_tbl_body', '', $the_string);

        //reemove the js to avoid running js for removing tr's when the medical record is rendered later
        $the_string = str_replace('remove_pharm_tr_row(this)', '', $the_string);

        //reemove the js to avoid running js for removing tr's when the medical record is rendered later
        $the_string = str_replace('fa fa-times text-danger', 'fa fa-check text-success', $the_string);

        return $the_string;
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
            'pateintDiagnosisReport'          => 'required',
        ];

        //make all contenteditable section uneditable, so that they wont be editable when they show up in medical history
        $request->pateintDiagnosisReport  = $this->remove_editable($request->pateintDiagnosisReport);

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            // Alert::error('Error Title', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $report                            = new MedicalReport;
            $report->user_id                   = $request->patient_user_id;
            $report->doctor_id                 = Auth::user()->id;
            $report->pharmacy_id               = 0;
            $report->nurse_id                  = 0;
            if ($request->dependant_id == '') {
                $report->dependant_id              = null;
            } else {
                $report->dependant_id              = $request->dependant_id;
            }
            $report->transaction_no            = generateTransactionId();
            $report->pateintDiagnosisReport    = $request->pateintDiagnosisReport;

            if (!empty($request->nurseContent)) {

                $report->nurseContent_status  = 1;
                $report->nurseContent         = $request->nurseContent;
            } else {

                $report->nurseContent_status  = 0;
                $report->nurseContent         = "";
            }

            if (!empty($request->pharmacy)) {

                $report->pharmacy_status      = 1;
                $report->pharmacy             = $this->remove_editable($request->pharmacy);
            } else {

                $report->pharmacy_status  = 0;
                $report->pharmacy         = "";
            }

            if ($request->admission == 1) {

                $report->admission_status  = 1;
                $report->admission = 1;

                $report->discharge        = 0;
                $report->dischargeChannel        = 0;
            } else {
                $report->admission_status  = 0;
                $report->admission = 0;
            }
            $report->lab_status  = 0;
            $report->visible     = 1;

            if ($request->discharge == 'on') {
                # code...
                $report->admission_status  = 0;
                $report->admission = 0;

                $report->discharge        = ($request->discharge) ? 1 : 0;
                $report->dischargeChannel        = $request->dischargeChannel;

                $report->nurseContent_status = 2;
                $report->visible = 2;
            }

            if ($report->save()) {

                // Update Patient and set the visible value to 3(listed among pending consultation) cos doctor has attend to the patient
                if ($request->dependant_id == '') {
                    $patient_details = Patient::where('user_id', '=', $request->patient_user_id)->first();
                } else {
                    $patient_details = Patient::where('user_id', '=', $request->patient_user_id)->first();
                    $patient_details = Dependant::where('id', '=', $request->dependant_id)->first();

                    //dd($patient_details);
                    $request->dependant_id = $patient_details->id;
                }

                if ($request->discharge == 'on') {

                    $patient_details->visible = 4;
                } else {
                    $patient_details->visible = 3;
                }
                // Then Update the patient table with the right details...
                //dd($patient_details);
                if ($patient_details->update()) {
                    if (!empty($request->service)) {

                        foreach ($request->service as $key => $value) {

                            $createService = new PatientLabService();
                            $createService->patient_user_id = $request->patient_user_id;
                            $createService->lab_user_id = $request->lab_user_id;
                            $createService->medical_report_id = $report->id;
                            $createService->lab_id = getLabId($value);
                            $createService->lab_service_id = $value;
                            $createService->payment_status = 0;
                            $createService->status_id = 1;
                            $createService->sampeTaken = 0;
                            $createService->sampeDate = 0;
                            $createService->resultReport = 0;
                            $createService->resultDate = 0;
                            if ($request->dependant_id == '') {
                                $createService->dependant_id = null;
                            } else {

                                $createService->dependant_id = $request->dependant_id;
                            }
                            $createService->save();
                        }
                    }
                    $msg = 'Report Generated.';
                    Alert::success('Success ', $msg);
                    return redirect()->route('CurrentConsultationRequestlist')->withMessage($msg)->withMessageType('success');
                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            } else {
                $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                return redirect()->back()->with('error', $msg)->withInput();
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

    public function listMedicalHistory($id, $dependant_id = null)
    {
        if ($dependant_id == null) {
            $medicalReportsHistory = MedicalReport::with(['user'])
                ->where('dependant_id', null)
                ->where('user_id', '=', $id)
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $medicalReportsHistory = MedicalReport::with(['user'])
                ->where('dependant_id', $dependant_id)
                ->where('user_id', '=', $id)
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        //  dd($medicalReportsHistory);

        return Datatables::of($medicalReportsHistory)
            ->addIndexColumn()
            ->editColumn('user_id', function ($medicalReportsHistory) {
                if (null != $medicalReportsHistory->dependant_id) {
                    $dependant = Dependant::find($medicalReportsHistory->dependant_id);
                    $fullname = $dependant->fullname . ' ('.$medicalReportsHistory->user->surname . " " . $medicalReportsHistory->user->firstname . " " . $medicalReportsHistory->user->othername.')';
                } else {
                    $fullname = $medicalReportsHistory->user->surname . " " . $medicalReportsHistory->user->firstname . " " . $medicalReportsHistory->user->othername;
                }

                return $fullname;
            })
            ->addColumn('pateintDiagnosisReport', function ($medicalReportsHistory) {

                return $medicalReportsHistory->pateintDiagnosisReport;
            })
            ->addColumn('discharge', function ($medicalReportsHistory) {
                $dischargeName = $medicalReportsHistory->discharge;
                $discharge = (($medicalReportsHistory->discharge == 1) ? "<span class='badge badge-pill badge-secondary'>Discharged</span>" : "<span class='badge badge-pill badge-success'>Not Discharged</span>");

                return $discharge;
            })
            ->editColumn('updated_at', function ($medicalReportsHistory) {
                return date('h:i a D M j, Y', strtotime($medicalReportsHistory->created_at));
            })
            ->editColumn('doctor_id', function ($medicalReportsHistory) {
                return userfullname($medicalReportsHistory->doctor->user_id);
            })
            // ->addColumn('view', function ($medicalReportsHistory) {

            //     if (Auth::user()->hasPermissionTo('user-show') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

            //         $url =  route('medical-report.show', $medicalReportsHistory->id);
            //         return '<a href="' . $url . '" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>';
            //     } else {

            //         $label = '<span class="badge badge-sm badge-warning">Not Allowed</span>';
            //         return $label;
            //     }
            // })
            // ->addColumn('edit', function ($medicalReportsHistory) {

            //     if (Auth::user()->hasPermissionTo('user-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

            //         $url =  route('medical-report.edit', $medicalReportsHistory->id);
            //         return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> </a>';
            //     } else {

            //         $label = '<span class="label label-warning">Not Allow</span>';
            //         return $label;
            //     }
            // })
            // ->addColumn('delete', function ($medicalReportsHistory) {

            //     if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
            //         $id = $medicalReportsHistory->id;
            //         return '<button type="button" class="delete-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-eye"></i></button>';
            //     } else {
            //         $label = '<span class="label label-danger">Not Allow</span>';
            //         return $label;
            //     }
            // })

            ->editColumn('pharmacy', function ($pc) {
                $phc             = $pc->pharmacy;
                //$pharmacy        ="<span class='badge badge-pill badge-dark'>".userfullname($pc->pharmacy_id).'</span>';
                //$pharmacy_report = $phc .'<br>' .'by: Phc' .'' .'<b>'.$pharmacy;
                return ($phc);
            })
            ->editColumn('nurce', function ($pc) {
                $ns               = $pc->nurseContent;
                // $nurce         ="<span class='badge badge-pill badge-dark'>".userfullname($pc->nurse_id).'</span>';
                //$nurce_report  = $ns .'<br>' .'by: Ns' .'' .'<b>'.$nurce;
                return ($ns);
            })

            ->rawColumns(['pateintDiagnosisReport', 'discharge', 'pharmacy', 'nurce'])
            ->make(true);
    }

    public function AdmittedPatients()
    {
        return view('admin.patients.admitted.index');
    }

    public function ListAdmittedPatients()
    {
        $current_doc = Auth::user()->id;
        $md = MedicalReport::with(['user', 'patient'])
            // ->where('doctor_id', $current_doc)
            ->where('admission', 1)
            ->where('admission_status', 1)
            ->get();


        //if the patient has a pending consultation

        return Datatables::of($md)
            ->addIndexColumn()
            ->editColumn('fullname', function ($md) {
                if (null == $md->dependant_id) {
                    return (userfullname($md->user->id));
                } else {
                    $dependant = Dependant::find($md->dependant_id);
                    return $dependant->fullname .' ('.userfullname($md->user_id).')';
                }
            })
            ->editColumn('gender', function ($md) {
                return (($md->user->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($md) {
                $p = Patient::where('user_id', $md->user_id)->first()->file_no;
                return $p;
            })
            ->editColumn('clinic', function ($md) {
                if ($md->dependant_id == null) {
                    $clinic = Clinic::find($md->patient->clinic_id)->clinic_name;
                    return ($clinic);
                } else {
                    $clinic = Clinic::find(Dependant::find($md->dependant_id)->clinic_id)->clinic_name;
                    return ($clinic);
                }
            })
            ->editColumn('updated_at', function ($md) {
                return date('h:i a D M j, Y', strtotime($md->created_at));
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('user_id', $pc->user_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->addColumn('discharge', function ($md) {
                $url =  url('DischargePatients', $md->id);
                return '<a href="' . $url . '" class="btn btn-warning btn-sm" onclick = "return confirm(\'Are You sure you wish to Discharge this Patient?\')"><i class="fa fa-plus nav-icon text-success"> </i> Discharge</a>';
            })
            ->addColumn('attend', function ($md) {
                $pc = Patient::where('user_id', $md->user->id)->first();
                if ($pc->visible == '3') {
                    if ($md->dependant_id == null) {
                        $url =  route('AttendPendingConsultation', $pc->id);
                        return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                    } else {
                        $d = Dependant::find($md->dependant_id);
                        $url =  route('AttendPendingConsultation', [$pc->id, $d->id]);
                        return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                    }
                } else {
                    $url =  route('AttendPendingConsultation', $pc->id);
                    return '<a href="#" class="btn btn-secondary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                }
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type', 'discharge'])
            ->make(true);
    }

    public function ListBookedPatients()
    {
        $current_doc = Auth::user()->id;
        $md = MedicalReport::with(['user', 'patient'])
            // ->where('doctor_id', $current_doc)
            ->where('admission', 1)
            ->where('admission_status', 1)
            ->get();


        //if the patient has a pending consultation

        return Datatables::of($md)
            ->addIndexColumn()
            ->editColumn('fullname', function ($md) {
                return (userfullname($md->user->id));
            })
            ->editColumn('gender', function ($md) {
                return (($md->user->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($md) {
                $p = Patient::where('user_id', $md->user_id)->first()->file_no;
                return $p;
            })
            ->editColumn('clinic', function ($md) {
                $clinic = Clinic::find($md->patient->clinic_id)->clinic_name;
                return ($clinic);
            })
            ->addColumn('discharge', function ($md) {
                $url =  url('DischargePatients', $md->id);
                return '<a href="' . $url . '" class="btn btn-warning btn-sm" onclick = "return confirm(\'Are You sure you wish to Discharge this Patient?\')"><i class="fa fa-plus nav-icon text-success"> </i> Discharge</a>';
            })
            ->addColumn('hmo', function ($md) {
                $patient_hmo = Patient::where('user_id', $md->user_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->editColumn('updated_at', function ($md) {
                return date('h:i a D M j, Y', strtotime($md->created_at));
            })
            ->addColumn('attend', function ($md) {
                $pc = Patient::where('user_id', $md->user->id)->first();
                // if ($pc->visible == '3') {
                $url =  route('AttendPendingConsultation', $pc->id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                // } else {
                //     $url =  route('AttendPendingConsultation', $pc->id);
                //     return '<a href="#" class="btn btn-secondary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                // }
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type', 'discharge', 'hmo'])
            ->make(true);
    }

    public function DischargePatients($md)
    {
        $md = MedicalReport::find($md);
        //dd($md);
        $md->nurseContent_status = 2;
        $md->visible = 2;
        $md->admission_status  = 0;
        $md->admission = 0;
        $md->discharge = 1;
        if ($md->update()) {
            $pacient = Patient::where('user_id', '=', $md->user_id)->first();
            $pacient->visible = 4;
            if ($pacient->update()) {
                $bed_assign = PatientAssignBed::where('medical_report_id', $md->id)->first();
                if (!empty($bed_assign)) {
                    $bed_assign->disChargeDate = \Carbon\Carbon::now();
                    if ($bed_assign->update()) {
                        $bed = Bed::find($bed_assign->bed_id);
                        $bed->status = 0;
                        if ($bed->save()) {
                            $msg = 'Successfully Dicharged.' . '' . User::find($md->user_id)->surname;
                            Alert::success('Success ', $msg);
                            return back()->withMessage($msg)->withMessageType('success');
                        } else {
                            $msg = 'Something is went wrong. Please try again later.';
                            return redirect()->back()->with('error', $msg);
                        }
                    } else {
                        $msg = 'Something is went wrong. Please try again later.';
                        return redirect()->back()->with('error', $msg);
                    }
                } else {
                    $msg = 'Successfully Dicharged.' . '' . User::find($md->user_id)->surname;
                    Alert::success('Success ', $msg);
                    return back()->withMessage($msg)->withMessageType('success');
                }
            } else {
                $msg = 'Something is went wrong. Please try again later.';
                return redirect()->back()->with('error', $msg);
            }
        } else {
            $msg = 'Something is went wrong. Please try again later.';
            return redirect()->back()->with('error', $msg);
        }
    }


    public function PendingConsultationlist()
    {
        return view('admin.patients.pendings.index');
    }

    public function PreviousConsultationlist()
    {
        return view('admin.patients.pendings.prev');
    }

    public function allConsultationlist()
    {
        return view('admin.patients.pendings.all');
    }

    public function listPendingPatients()
    {
        $doc_id = Auth::id();
        $doc_clinic = Doctor::where('user_id', $doc_id)->first()->clinic_id;
        $pc = Patient::where('visible', '=', 3)->where('clinic_id', $doc_clinic)
        ->where('updated_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())
        ->with('user', 'clinic')->orderBy('updated_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user->id));
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($pc) {
                $p = Patient::where('user_id', $pc->user_id)->first()->file_no;
                return $p;
            })
            ->editColumn('clinic', function ($pc) {
                return ($pc->clinic->clinic_name);
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->addColumn('attend', function ($pc) {
                $url =  route('AttendPendingConsultation', $pc->id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('user_id', $pc->user_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->addColumn('end', function ($pc) {
                $md = MedicalReport::where('visible', '=', 1)->where('dependant_id', null)->where('user_id', '=', $pc->user_id)->first() ??  MedicalReport::where('user_id', '=', $pc->user_id)->where('dependant_id', null)->first() ?? MedicalReport::where('visible', '=', 1)->where('user_id', '=', $pc->user_id)->first();
                $url =  route('noCharges', $md->id );
                return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> End Consultation</a>';
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type', 'end'])
            ->make(true);
    }

    public function listPendingDependants()
    {
        $doc_id = Auth::id();
        $doc_clinic = Doctor::where('user_id', $doc_id)->first()->clinic_id;
        $pc = Dependant::where('visible', '=', 3)->where('clinic_id', $doc_clinic)
        ->where('updated_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())
        ->with('patient', 'clinic')->orderBy('created_at', 'DESC')->get();
        // $pc = Patient::where('visible', '=', 3)->where('clinic_id', $doc_clinic)->with('user', 'clinic')->orderBy('created_at', 'DESC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return $pc->fullname.' ('.userfullname($pc->patient->user_id).')';
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($pc) {
                $p = Patient::where('id', $pc->patient_id)->first()->file_no;
                return $p;
            })
            ->editColumn('clinic', function ($pc) {
                return ($pc->clinic->clinic_name);
            })
            // ->editColumn('phone_number', function ($pc) {
            //     return ($pc->user->phone_number);
            // })
            ->addColumn('attend', function ($pc) {
                $url =  route('AttendPendingConsultation', [$pc->patient_id, $pc->id]);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('id', $pc->patient_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->addColumn('end', function ($pc) {
                $md = MedicalReport::where('visible', '=', 1)->where('dependant_id', '=', $pc->id)->first() ??  MedicalReport::where('dependant_id', '=', $pc->user_id)->first();
                $url =  route('noCharges', [$md->id, $pc->id]);
                return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> End Consultation</a>';
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type', 'end'])
            ->make(true);
    }

    public function listAllConsultation()
    {
        //return $doc_id;
        $pc = MedicalReport::with('user')->orderBy('updated_at', 'DESC')->get();
        //dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                //if the report belongs to a dependat rather than a principal
                if (null != $pc->dependant_id) {
                    $dependant = Dependant::find($pc->dependant_id);
                    return $dependant->fullname .' ('.userfullname($pc->user_id).')';
                } else {
                    return (userfullname($pc->user_id));
                }
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($pc) {
                $p = Patient::where('user_id', $pc->user_id)->first()->file_no;
                return $p;
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->addColumn('attend', function ($pc) {
                if ($pc->dependant_id == null) {
                    $patient_id = Patient::where('user_id', $pc->user_id)->first()->id;
                    $url =  route('viewConsultation', $patient_id);
                    //dd($url);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> View</a>';
                } else {
                    $patient_id = Patient::where('user_id', $pc->user_id)->first()->id;
                    $dep_id = Dependant::where('patient_id', $patient_id)->first()->id;
                    $url =  route('viewConsultation', [$patient_id, $dep_id]);
                    //dd($url);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> View</a>';
                }
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('user_id', $pc->user_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->addColumn('hmo_no', function ($pc) {
                //if the report belongs to a dependat rather than a principal
                if (null != $pc->dependant_id) {
                    $dependant = Dependant::find($pc->dependant_id);
                    return $dependant->hmo_no;
                } else {
                    return Patient::where('user_id',$pc->user_id)->first()->hmo_no;
                }
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type'])
            ->make(true);
    }

    public function listPreviousPatients()
    {
        $doc_user_id = Auth::id();
        $doc_id = Doctor::where('user_id', $doc_user_id)->first()->id;
        //return $doc_id;
        $pc = MedicalReport::where('doctor_id', '=', $doc_id)->groupBy('user_id')->with('user')->get();
        //dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                //if the report belongs to a dependat rather than a principal
                if (null != $pc->dependant_id) {
                    $dependant = Dependant::find($pc->dependant_id);
                    return $dependant->fullname .' ('.userfullname($pc->user_id).')';
                } else {
                    return (userfullname($pc->user_id));
                }
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->patient->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('file_no', function ($pc) {
                $p = Patient::where('user_id', $pc->user_id)->first()->file_no;
                return $p;
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('user_id', $pc->user_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->addColumn('attend', function ($pc) {
                if (null == $pc->dependant_id) {
                    $patient_id = Patient::where('user_id', $pc->user_id)->first()->id;
                    $url =  route('AttendPendingConsultation', $patient_id);
                    //dd($url);
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> View</a>';
                } else {
                    $patient_id = Patient::where('user_id', $pc->user_id)->first()->id;
                    $url =  route('AttendPendingConsultation', [$patient_id, $pc->dependant_id]);
                    //dd($url);
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> View</a>';
                }
            })
            ->addColumn('type', function ($pc) {

                // $mr = MedicalReport::where('visible', '=', 1)->where('user_id','=', $pc->user_id)->first();
                // // dd($mr);
                // if ($mr->admission_status == 1) {

                //     $pbed = PatientAssignBed::with('bed')->where('medical_report_id', '=', $mr->id)->first();
                //     // dd($pbed);
                //     return "<span class='badge badge-pill badge-dark'>" .$pbed->bed->bed_name .'</span>';
                // } else {
                //     return "<span class='badge badge-pill badge-success'>Out Patient </span>";
                // }


            })
            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'type'])
            ->make(true);
    }

    public function AttendPendingConsultation($id, $dependant_id = null)
    {
        if ($dependant_id == null) {
            // dd($id);
            $patient = Patient::where('id', '=', $id)->first();
            $dependant = Dependant::find($dependant_id) ?? null;
            //    dd($patient);
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_id')->orderBy('lab_service_name')->get();
            $wards = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id', null)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
            $md = MedicalReport::where('visible', '=', 1)->where('user_id', '=', $patient->user_id)->where('dependant_id', null)->first() ??  MedicalReport::where('user_id', '=', $patient->user_id)->where('dependant_id', null)->first();
            $clinics = Clinic::where('visible', 1)->get();

            $url =  route('noCharges', $md->id);
            if ($md->lab_status == 1) {

                $labservices = PatientLabService::where('medical_report_id', '=', $md->id)->where('dependant_id', null)->get();
            } else {

                $labservices = "";
            }



            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', null)->where('status_id', 1)->get();
            $products       = Product::with(['price'])->whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();

            $rp  = $md->pateintDiagnosisReport;
            $doctor        = "<span class='badge badge-pill badge-dark'>" . userfullname($md->doctor_id) . '</span>';
            $doctor_report = $rp;
        } else {
            // dd($id);
            $patient = Patient::where('id', '=', $id)->first();
            $dependant = Dependant::find($dependant_id);
            //    dd($patient);
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_id')->orderBy('lab_service_name')->get();
            $wards = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
            $md = MedicalReport::where('visible', '=', 1)->where('dependant_id', $dependant_id)->where('user_id', '=', $patient->user_id)->first() ??  MedicalReport::where('user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->first();
            $clinics = Clinic::where('visible', 1)->get();

            $url =  route('noCharges', [$md->id, $dependant_id]);
            if ($md->lab_status == 1) {
                $labservices = PatientLabService::where('medical_report_id', '=', $md->id)->where('dependant_id', $dependant_id)->get();
            } else {

                $labservices = "";
            }


            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->where('status_id', 1)->get();
            $products       = Product::with(['price'])->whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();

            $rp  = $md->pateintDiagnosisReport;
            $doctor        = "<span class='badge badge-pill badge-dark'>" . userfullname($md->doctor_id) . '</span>';
            $doctor_report = $rp;
        }
        return view('admin.patients.pendings.pending_consultation_file', compact('patient', 'lab_services', 'wards', 'vitalSign', 'md', 'labservices', 'tests', 'doctor_report', 'doctor', 'url', 'clinics', 'dependant','products'));
    }

    public function viewConsultation($id, $dependant_id = null)
    {
        if (null == $dependant_id) {
            // dd($id);
            $patient = Patient::where('id', '=', $id)->first();
            //    dd($patient);
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_service_name')->get();
            $wards = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id', null)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
            $md = MedicalReport::where('user_id', '=', $patient->user_id)->where('dependant_id', null)->first();
            $clinics = Clinic::where('visible', 1)->get();

            $url =  route('noCharges', $md->id);
            if ($md->lab_status == 1) {

                $labservices = PatientLabService::where('medical_report_id', '=', $md->id)->where('dependant_id', null)->get();
            } else {

                $labservices = "";
            }



            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', null)->where('status_id', 1)->get();


            $rp  = $md->pateintDiagnosisReport;
            $doctor        = "<span class='badge badge-pill badge-dark'>" . userfullname($md->doctor_id) . '</span>';
            $doctor_report = $rp;
            return view('admin.patients.pendings.all_consultation_file', compact('patient', 'lab_services', 'wards', 'vitalSign', 'md', 'labservices', 'tests', 'doctor_report', 'doctor', 'url', 'clinics'));
        } else {
            // dd($id);
            $patient = Patient::where('id', '=', $id)->first();
            $dependant = Dependant::find($dependant_id);
            //    dd($patient);
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_id')->orderBy('lab_service_name')->get();
            $wards = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
            $md = MedicalReport::where('user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->first();
            $clinics = Clinic::where('visible', 1)->get();

            $url =  route('noCharges', $md->id);
            if ($md->lab_status == 1) {

                $labservices = PatientLabService::where('medical_report_id', '=', $md->id)->where('dependant_id', $dependant_id)->get();
            } else {

                $labservices = "";
            }



            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->where('status_id', 1)->get();


            $rp  = $md->pateintDiagnosisReport;
            $doctor        = "<span class='badge badge-pill badge-dark'>" . userfullname($md->doctor_id) . '</span>';
            $doctor_report = $rp;
            return view('admin.patients.pendings.all_consultation_file', compact('patient', 'lab_services', 'wards', 'vitalSign', 'md', 'labservices', 'tests', 'doctor_report', 'doctor', 'url', 'clinics', 'dependant'));
        }
    }

    public function listCurentRecord($id)
    {
        //dd($id);

        $pc = InconclusiveMedicalReport::where('medical_report_id', '=', $id)->orderBy('id', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('doctorReport', function ($pc) {
                $rp            = $pc->pateintDiagnosisReport;
                $doctor        = "<span class='badge badge-pill badge-dark'>" . userfullname($pc->doctor_id) . '</span>';
                $doctor_report = $rp . '<br>' . 'by: Dr' . '' . '<b>' . $doctor;
                return ($doctor_report);
            })

            ->editColumn('pharmacy', function ($pc) {
                $phc             = $pc->pharmacy;
                //$pharmacy        ="<span class='badge badge-pill badge-dark'>".userfullname($pc->pharmacy_id).'</span>';
                //$pharmacy_report = $phc .'<br>' .'by: Phc' .'' .'<b>'.$pharmacy;
                return ($phc);
            })
            ->editColumn('nurce', function ($pc) {
                $ns               = $pc->nurseContent;
                // $nurce         ="<span class='badge badge-pill badge-dark'>".userfullname($pc->nurse_id).'</span>';
                //$nurce_report  = $ns .'<br>' .'by: Ns' .'' .'<b>'.$nurce;
                return ($ns);
            })


            ->rawColumns(['doctorReport', 'pharmacy', 'nurce'])

            ->make(true);
    }

    public function addMedicalReport(Request $request)
    {
        //dd($request->all());

        $rules = [
            'pateintDiagnosisReport'          => 'required',
        ];
        //make all contenteditable section uneditable, so that they wont be editable when they show up in medical history
        $request->pateintDiagnosisReport = $this->remove_editable($request->pateintDiagnosisReport);

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {

            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {
            $report                            = new MedicalReport;
            $report->user_id                   = $request->patient_user_id;
            $report->doctor_id                 = Auth::user()->id;
            $report->pharmacy_id               = 0;
            $report->nurse_id                  = 0;
            if ($request->dependant_id == '') {
                $report->dependant_id              = null;
            } else {
                $report->dependant_id              = $request->dependant_id;
            }
            $report->transaction_no            = generateTransactionId();
            $report->pateintDiagnosisReport    = $request->pateintDiagnosisReport;

            if (!empty($request->nurseContent)) {

                $report->nurseContent_status  = 1;
                $report->nurseContent         = $request->nurseContent;
            } else {

                $report->nurseContent_status  = 0;
                $report->nurseContent         = "";
            }

            if (!empty($request->pharmacy)) {

                $report->pharmacy_status      = 1;
                $report->pharmacy             = $this->remove_editable($request->pharmacy);
            } else {

                $report->pharmacy_status  = 0;
                $report->pharmacy         = "";
            }

            if ($request->admission == 1) {

                $report->admission_status  = 1;
                $report->admission = 1;

                $report->discharge        = 0;
                $report->dischargeChannel        = 0;
            } else {
                $report->admission_status  = 0;
                $report->admission = 0;
            }
            $report->lab_status  = 0;
            $report->visible     = 1;


            //$report = MedicalReport::find($request->mdedical_id);
            //dd($report->admission);
            // $inconclusive = new MedicalReport;
            // $inconclusive->medical_report_id  = $request->mdedical_id;
            // $inconclusive->transaction_no  = $report->transaction_no;
            // $inconclusive->user_id         = $report->user_id;
            // $inconclusive->doctor_id       = $report->doctor_id;
            // $inconclusive->pharmacy_id     = $report->pharmacy_id;
            // $inconclusive->nurse_id        = $report->nurse_id;
            // $inconclusive->pateintDiagnosisReport  = $report->pateintDiagnosisReport;
            // $inconclusive->pharmacy        = $report->pharmacy;
            // $inconclusive->pharmacy_status = $report->pharmacy_status;
            // $inconclusive->lab_status      = $report->lab_status;
            // $inconclusive->admission_status = $report->admission_status;
            // $inconclusive->nurseContent    = $report->nurseContent;
            // $inconclusive->nurseContent_status  = $report->nurseContent_status;
            // $inconclusive->visible         = $report->visible;
            // $inconclusive->admission       = $report->admission ?? 0;
            // $inconclusive->report_date     = $report->updated_at;
            // $inconclusive->save();
            // // end inconclusive
            // $report->doctor_id                 = Auth::user()->id;
            // $report->pharmacy_id               = 0;
            // $report->nurse_id                  = 0;
            // $report->transaction_no            = generateTransactionId();
            // $report->pateintDiagnosisReport    = $request->pateintDiagnosisReport;

            // if (!empty($request->nurseContent)) {

            //     $report->nurseContent_status  = 1;
            //     $report->nurseContent         = $request->nurseContent;
            // } else {

            //     $report->nurseContent_status  = 0;
            //     $report->nurseContent         = "";
            // }

            // if (!empty($request->pharmacy)) {

            //     $report->pharmacy_status      = 1;
            //     $report->pharmacy             = $request->pharmacy;
            // } else {

            //     $report->pharmacy_status  = 0;
            //     $report->pharmacy         = "";
            // }

            // if ($report->admission == 1) {

            //     $report->admission_status  = 1;
            //     $report->admission = 1;
            // }

            // if (!empty($request->service)) {
            //     $report->lab_status  = 0;
            // }


            // $report->visible     = 1;



            if ($report->save()) {

                // Update Patient and set the visible value to 3 cos doctor has attended to the patient
                $patient_details = Patient::where('user_id', '=', $request->patient_user_id)->first();
                // dd($patient_details);
                $patient_details->visible = 3;
                $patient_details->update();

                if (!empty($request->service)) {

                    //dd($request->service);

                    foreach ($request->service as $key => $value) {

                        //    $myId = $createService;
                        // dd($key);

                        $createService = new PatientLabService();

                        $createService->patient_user_id = $request->patient_user_id;
                        $createService->lab_user_id = $request->lab_user_id;
                        $createService->medical_report_id = $report->id;
                        $createService->lab_id = getLabId($value);
                        $createService->lab_service_id = $value;
                        $createService->payment_status = 0;
                        $createService->status_id = 1;
                        $createService->sampeTaken = 0;
                        $createService->sampeDate = 0;
                        $createService->resultReport = 0;
                        $createService->resultDate = 0;
                        $createService->save();
                    }
                }

                $msg = 'Report Generated.';
                Alert::success('Success ', $msg);
                return redirect('PendingConsultationlist')->withMessage($msg)->withMessageType('success');
            } else {
                $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        }
    }
}
