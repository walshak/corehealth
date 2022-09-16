<?php

namespace App\Http\Controllers\Receptionists;

use App\Dependant;
use Auth;
use App\Hmo;
use App\User;
use Response;
use Validator;
use App\Patient;
use App\VitalSign;
use App\MedicalReport;
use App\PatientLabService;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\PatientAccount;
use RealRashid\SweetAlert\Facades\Alert;

class ReceptionistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listReturningPatients(Request $request)
    {

        // dd($request->all());
        $rules =
            [
                'q' => 'required',

            ];
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            // Alert::error('Require', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $getPatients = Patient::where('file_no', '=', $request->q)
                ->where('visible', '=', 4)
                ->with(['user'])
                //  ->orderBy('file_no')
                ->get();

            //dd($getPatients);
            $q = (!empty($request->q)) ? ($request->q) : ('');

            if (count($getPatients) > 0) {
                # code...
                $postsQuery = DB::select("select * from `patients` left join `users` on `patients`.`user_id` = `users`.`id`
                where `patients`.`visible` != :visibility and (`users`.`surname` like :q1 or `users`.`firstname` like :q2
                or `users`.`othername` like :q3 or `patients`.`file_no` like :q4)", array('visibility' => 'null', 'q1' => '%' . $q . '%', 'q2' => '%' . $q . '%', 'q3' => '%' . $q . '%', 'q4' => '%' . $q . '%'));

                $list = $postsQuery;
                return Datatables::of($list)
                    ->addIndexColumn()
                    ->addColumn('user_id', function ($list) {
                        $fullname = $list->surname . " " . $list->firstname . " " . $list->othername;
                        return $fullname;
                    })
                    // ->editColumn('session', function ($list) {
                    //     $session_name = $list->session->name;
                    //     return $session_name;
                    // })
                    // ->editColumn('paymentAmount', function ($list) {
                    //     return formatMoney($list->paymentAmount);
                    // })
                    // ->addColumn('file_no', function ($list) {
                    //     $fileNumber = "<span class='badge badge-sm badge-dark'>".$list->file_number."</span>";
                    //     return $fileNumber;
                    // })
                    ->addColumn('hmo', function ($list) {
                        $patient_hmo = Patient::where('user_id', $list->user_id)->first()->hmo_id;
                        $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                        return $hmo_name;
                    })
                    ->addColumn('acc_bal', function ($list) {
                        $patient_acc = PatientAccount::where('user_id', $list->user_id)->first();
                        if(null != $patient_acc){
                            $patient_acc_markup = "<span class= 'badge badge-success'>Deposit: NGN $patient_acc->deposit</span><br><span class= 'badge badge-danger'>Credit: NGN $patient_acc->credit</span>";
                            return $patient_acc_markup;
                        }else{
                            return "<span class= 'badge badge-success'>No Account</span>";
                        }
                    })
                    ->addColumn('phone', function ($list) {
                        $phone_number = User::where('id', $list->user_id)->first()->phone_number ?? 'N/A';
                        return $phone_number;
                    })
                    ->addColumn(
                        'process',
                        '<button type="button" class="edit-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}" data-user_id="{{$user_id}}" data-file_no="{{$file_no}}" data-receptionist_id={{Auth::user()->id}}><i class="fa fa-pencil"></i> Process</button>'
                        // function($list){
                        //     if($list->visible == 4){
                        //         return '<button type="button" class="edit-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}" data-user_id="{{$user_id}}" data-file_no="{{$file_no}}" data-receptionist_id={{Auth::user()->id}}><i class="fa fa-pencil"></i> Process</button>';
                        //     }else{
                        //         return '<a class="btn-success btn-sm" href="#">View</a>';
                        //     }
                        // }
                    )
                    ->rawColumns(['user_id', 'file_no', 'process','acc_bal'])
                    ->make(true);
            } else {
                // $q = (!empty($request->q)) ? ($request->q) : ('');

                $postsQuery = DB::select("select * from `patients` left join `users` on `patients`.`user_id` = `users`.`id`
                where `patients`.`visible` != :visibility and (`users`.`surname` like :q1 or `users`.`firstname` like :q2
                or `users`.`othername` like :q3 or `patients`.`file_no` like :q4)", array('visibility' => 'null', 'q1' => '%' . $q . '%', 'q2' => '%' . $q . '%', 'q3' => '%' . $q . '%', 'q4' => '%' . $q . '%'));

                $list = $postsQuery;
                return Datatables::of($list)
                    ->addIndexColumn()
                    ->addColumn('user_id', function ($list) {
                        $fullname = $list->surname . " " . $list->firstname . " " . $list->othername;
                        return $fullname;
                    })
                    // ->editColumn('session', function ($list) {
                    //     $session_name = $list->session->name;
                    //     return $session_name;
                    // })
                    // ->editColumn('paymentAmount', function ($list) {
                    //     return formatMoney($list->paymentAmount);
                    // })
                    // ->addColumn('file_no', function ($list) {
                    //     $fileNumber = "<span class='badge badge-sm badge-dark'>".$list->file_number."</span>";
                    //     return $fileNumber;
                    // })
                    ->addColumn('hmo', function ($list) {
                        $patient_hmo = Patient::where('user_id', $list->user_id)->first()->hmo_id;
                        $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                        return $hmo_name;
                    })
                    ->addColumn('acc_bal', function ($list) {
                        $patient_acc = PatientAccount::where('user_id', $list->user_id)->first();
                        if(null != $patient_acc){
                            $patient_acc_markup = "<span class= 'badge badge-success'>Deposit: NGN $patient_acc->deposit</span><br><span class= 'badge badge-danger'>Credit: NGN $patient_acc->credit</span>";
                            return $patient_acc_markup;
                        }else{
                            return "<span class= 'badge badge-success'>No Account</span>";
                        }

                    })
                    ->addColumn('phone', function ($list) {
                        $phone_number = User::where('id', $list->user_id)->first()->phone_number ?? 'N/A';
                        return $phone_number;
                    })
                    ->addColumn(
                        'process',
                        '<button type="button" class="edit-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}" data-user_id="{{$user_id}}" data-file_no="{{$file_no}}" data-receptionist_id={{Auth::user()->id}}><i class="fa fa-pencil"></i> Process</button>'
                        // function($list){
                        //     if($list->visible == 4){
                        //         return '<button type="button" class="edit-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}" data-user_id="{{$user_id}}" data-file_no="{{$file_no}}" data-receptionist_id={{Auth::user()->id}}><i class="fa fa-pencil"></i> Process</button>';
                        //     }else{
                        //         return '<a class="btn-success btn-sm" href="#">View</a>';
                        //     }
                        // }
                    )
                    // ->addColumn('process', function($list){
                    //     if($list->visible == 4){
                    //         return '<button type="button" class="edit-modal btn btn-dark btn-sm" data-toggle="modal" data-id="{{$id}}" data-user_id="{{$user_id}}" data-file_no="{{$file_no}}" data-receptionist_id={{Auth::user()->id}}><i class="fa fa-pencil"></i> Process</button>';
                    //     }else{
                    //         return '<a class="btn-success btn-sm" href="#">View</a>';
                    //     }
                    // })
                    ->rawColumns(['user_id', 'file_no', 'process','acc_bal'])
                    ->make(true);
            }
        }
    }

    public function index()
    {
        //this method is used to load the profile of not only recptionists
        $user = User::where('id', '=', Auth::user()->id)->first();
        $admitted = MedicalReport::where('admission_status', '=', 1)->count();
        $discharge = MedicalReport::where('admission_status', '=', 2)->count();
        $labPatients = PatientLabService::where('payment_status', '=', 1)
            ->where('resultReport', '=', '')
            ->where('resultReport_by', '=', 0)
            ->count();
        $newPatient = User::where('visible', '=', 0)->count();


        return view('admin.receptionists.index', compact('user', 'admitted', 'discharge', 'labPatients', 'newPatient'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.receptionists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // die();
        $rules =
            [
                'selected_dependants' => 'required|array|min:1',
            ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return Response::json(array('errors' => $v->getMessageBag()->toArray()));
        } else {

            $todayDate = \Carbon\Carbon::now();
            $i = 1;
            foreach ($request->selected_dependants as $selected_dependant) {
                if ($selected_dependant === '001') {
                    $checkVitalSign = VitalSign::where('file_no', '=', $request->file_no)->where('status', '=', -1)->first();
                    // dd($checkVitalSign);

                    if (empty($checkVitalSign)) {
                        $vitalSign = new VitalSign;
                        $vitalSign->user_id  = $request->user_id_edit;
                        $vitalSign->receptionist_id  = Auth::user()->id;
                        $vitalSign->nurse_id  = 0;
                        $vitalSign->medical_report_id  = 0;
                        $vitalSign->file_no  = $request->file_no_edit;
                        $vitalSign->temperature  = 0;
                        $vitalSign->weight  = 0;
                        $vitalSign->bloodPressure  = 0;
                        $vitalSign->vitalSignReport  = "";
                        $vitalSign->status  = -1;
                        $vitalSign->paymentVisibility  = 0;
                        $vitalSign->dateProccessed  = "";

                        $vitalSign->save();

                        //return response()->json($vitalSign);
                    } else {
                        // $msg = ["message" => "The Vital Sign have being sent to the nurse station",];

                        // return Response::json(array('errors' => $msg->toArray()));
                        return response()->json(['errors' => 'The patient information is still at the nurse station and not treated yet']);
                    }
                } else {
                    $checkVitalSign = VitalSign::where('file_no', '=', $request->file_no)->where('status', '=', -1)->first();
                    $dependant = Dependant::find($selected_dependant);
                    //dd($dependant);

                    if (empty($checkVitalSign)) {
                        $vitalSign = new VitalSign;
                        $vitalSign->user_id  = $request->user_id_edit;
                        $vitalSign->dependant_id = $dependant->id;
                        $vitalSign->receptionist_id  = Auth::user()->id;
                        $vitalSign->nurse_id  = 0;
                        $vitalSign->medical_report_id  = 0;
                        $vitalSign->file_no  = $request->file_no_edit;
                        $vitalSign->temperature  = 0;
                        $vitalSign->weight  = 0;
                        $vitalSign->bloodPressure  = 0;
                        $vitalSign->vitalSignReport  = "";
                        //if the principal is not selected, the vital sign of the first dependant shoul be used for card payment listing
                        if(!in_array('001',$request->selected_dependants,true)){
                            //if it is the first selected dependant...this is nessesary so that we wont create multiple payment listings for a single visit
                            if($i == 1){
                                $vitalSign->status  = -1;
                                $vitalSign->paymentVisibility  = 0;
                            }else{
                                $vitalSign->status  = 1;
                                $vitalSign->paymentVisibility  = 1;
                            }
                        }else{
                            $vitalSign->status  = 1;
                            $vitalSign->paymentVisibility  = 1;
                        }
                        $vitalSign->dateProccessed  = "";
                        $vitalSign->save();

                        //return response()->json('gggg');
                    } else {
                        // $msg = ["message" => "The Vital Sign have being sent to the nurse station",];

                        // return Response::json(array('errors' => $msg->toArray()));
                        return response()->json(['errors' => 'The patient information is still at the nurse station and not treated yet']);
                    }
                }
                $i++;
            }
            return response()->json('success');
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
        // dd(Request::method());
        dd($request->all());

        $rules =
            [
                'payment_validation' => 'required',

            ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return Response::json(array('errors' => $v->getMessageBag()->toArray()));
        } else {
            // dd($request->all());
            $vitalSign = new VitalSign;
            // $vitalSign->user_id  = $request->id;
            // $vitalSign->user_id  = $request->file_no;
            $vitalSign->save();
            return response()->json($vitalSign);
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
}
