<?php

namespace App\Http\Controllers\Patient;

use Auth;
use App\Hmo;
use App\User;
use App\Ward;
use App\State;
use App\Clinic;
use App\Doctor;
use App\Patient;
use App\VitalSign;
use App\LabService;
use App\NextOfKing;
use App\DoctorBooking;
use App\MedicalReport;
use App\PatientAssignBed;
use App\PatientLabService;
use App\Bed;
use App\Product;
use App\PatientAccount;
use App\Dependant;
use App\ApplicationStatu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newPatients()
    {
        return view('admin.patients.new_patients');
    }

    public function listNewPatients()
    {
        $pc = User::where('is_admin', '=', '19')->where('visible', '=', 0)->orderBy('created_at', 'DESC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->id));
            })
            ->addColumn('payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('newRegistrationFee', $pc->id);
                return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Pay </a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Make Payment</a>';
                // }
            })
            ->rawColumns(['fullname', 'payment'])

            ->make(true);
    }

    public function NewRegistrationRequestList()
    {
        $pc = Patient::where('visible', '=', 1)->orWhere('visible', '=', 99)->with('user', 'clinic')->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user->id));
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->addColumn('register', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('newRegistrationForm', $pc->user_id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Register</a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Register</a>';
                // }
            })
            ->rawColumns(['fullname', 'register', 'phone_number'])

            ->make(true);
    }
    public function ConsultationRequestList()
    {
        $doc_id = Auth::id();
        $doc_clinic = Doctor::where('user_id', $doc_id)->first()->clinic_id;
        //dd($doc_clinic);
        $pc = Patient::where('visible', '=', 2)->where('clinic_id', $doc_clinic)
        ->where('updated_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())
        ->with('user', 'clinic')->orderBy('updated_at', 'DESC')->get();
        //dd($pc);//check why user 863 does not exst but his patient profile does not patient id = 9599
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user->id));
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('clinic', function ($pc) {
                return ($pc->clinic->clinic_name);
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->addColumn('attend', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('consultation', $pc->id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Attend</a>';
                // }
            })

            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'price'])

            ->make(true);
    }

    public function ConsultationRequestListDependants()
    {
        $doc_id = Auth::id();
        $doc_clinic = Doctor::where('user_id', $doc_id)->first()->clinic_id;
        $pc = Dependant::where('visible', '=', 2)->where('clinic_id', $doc_clinic)
        ->where('updated_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())
        ->with('patient', 'clinic')->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                $patient = Patient::find($pc->patient_id);
                return $pc->fullname.' ('.userfullname($patient->user_id).')';
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('clinic', function ($pc) {
                return ($pc->clinic->clinic_name);
            })
            ->editColumn('file_no', function ($pc) {
                return ($pc->patient->file_no);
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->addColumn('attend', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('consultation', [$pc->patient_id, $pc->id]);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Attend</a>';
                // }
            })

            ->rawColumns(['fullname', 'attend', 'clinic', 'gender', 'price'])

            ->make(true);
    }

    public function ConsultationBookingList()
    {
        $today = \Carbon\Carbon::now();
        $pc = DoctorBooking::where('status', '=', 1)
            ->where('paid', 1)
            ->where('created_at', '>', 'now() - interval 30 DAY')
            ->where('doctor_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->with('patient', 'doctor')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->patient->user_id));
            })
            ->editColumn('gender', function ($pc) {
                return (($pc->gender == 1) ? "Male" : "Female");
            })
            ->editColumn('clinic', function ($pc) {
                return ($pc->patient->clinic->clinic_name);
            })
            ->editColumn('updated_at', function ($pc) {
                return date('h:i a D M j, Y', strtotime($pc->updated_at));
            })
            ->editColumn('file_no', function ($pc) {
                return ($pc->patient->file_no);
            })
            ->addColumn('hmo', function ($pc) {
                $patient_hmo = Patient::where('id', $pc->patient_id)->first()->hmo_id;
                $hmo_name = Hmo::where('id', $patient_hmo)->first()->name ?? 'N/A';
                return $hmo_name;
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->patient->user->phone_number);
            })
            ->addColumn('attend', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('consultation', $pc->patient->id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Attend</a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Attend</a>';
                // }
            })
            ->addColumn('state', function ($pc) {
                $today = \Carbon\Carbon::now();
                if ($today >= $pc->time) {
                    return "<span class = 'badge badge-success'>Due</span>";
                } else {
                    return "<span class = 'badge badge-primary'>Approaching</span>";
                }
            })

            ->rawColumns(['fullname', 'attend', 'phone_number', 'clinic', 'gender', 'price', 'state'])

            ->make(true);
    }


    public function index()
    {
        return view('admin.patients.patient_list');
    }

    public function patientsList()
    {
        $pc = Patient::with('user', 'clinic')->orderBy('created_at', 'DESC')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user->id));
            })
            ->editColumn('phone_number', function ($pc) {
                return ($pc->user->phone_number);
            })
            ->addColumn('add', function ($pc) {
                $url =  route('dependants.create') . '?id=' . $pc->user_id;
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
            })
            ->addColumn('edit', function ($pc) {
                $url =  route('patient.edit',$pc->user_id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-edit nav-icon text-success"> </i> Edit</a>';
            })
            ->addColumn('note', function ($pc) {
                if(Auth::user()->hasRole(['Doctor'])){
                    $url =  route('ward_note.create',['patient_id'=>$pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
                }elseif(Auth::user()->hasRole(['Nurse'])){
                    $url =  route('nursing-note.create',['patient_id'=>$pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
                }elseif(Auth::user()->hasRole(['Admin','Super Admin'])){
                    $url =  route('ward_note.create',['patient_id'=>$pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a><br>';
                    $url =  route('nursing-note.create',['patient_id'=>$pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add(Nurse)</a>';
                }else{
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> Add</a>';
                }
            })
            ->addColumn('services', function ($pc) {
                if(Auth::user()->hasRole(['Super-Admin','Admin','Accounts','Receptionist'])){
                    $url =  route('patient.services_rendered',['patient_id'=>$pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Print</a>';
                }else{
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> Print</a>';
                }
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
            ->editColumn('created_at', function ($note) {
                return date('h:i a D M j, Y', strtotime($note->created_at));
            })
            ->addColumn('hmo', function ($pc) {
                $hmo = Hmo::find($pc->hmo_id);
                return $hmo->name;
            })
            ->rawColumns(['fullname', 'add', 'phone_number', 'hmo','edit','acc_bal','note','services'])

            ->make(true);
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
        $check = Patient::find($request->id);
        if (empty($check)) {
            $msg = 'Record not found';
            Alert::warning('Error Title', $msg);
            return redirect()->route('newRegistrationFormRequestList');
        }

        // dd($request->all());
        $rules = [
            'gender'  => 'bail|required',
            'hieght'  => 'nullable',
            'weight'   => 'nullable',
            'address'     => 'nullable',
            'disability'   => 'nullable',
            'account_type'  => 'nullable',
            'next_of_king_id'  => 'required',
            'next_of_king_phone'   => 'required',
            'next_of_king_address'   => 'nullable',
            'hmo' => 'required',
            'dob' => 'required'

        ];

        if ($request->hasFile('filename')) {
            #  Making sure if password change was selected it's being validated
            $rules += [
                'filename' => 'max:1024|mimes:jpeg,bmp,png,gif,svg,jpg',
            ];
        }
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            // Alert::error('Error Title', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            if ($request->hasFile('filename')) {
                $path = storage_path('/app/public/image/user/');
                $file = $request->file('filename');
                $extension = strtolower($file->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name = str_replace(" ", "-", strtolower($file->getClientOriginalName()));
                $name = str_replace("_", "-", $name);
                $filename = time() . '-' . $name;

                if (Storage::disk('user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($path . $filename);

                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                } else {
                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                }

                $thumbnail_path = storage_path('/app/public/image/user/thumbnail/');
                // save thumbnail for user images
                if (Storage::disk('thumbnail_user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($thumbnail_path . $filename);

                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                } else {
                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                }
            }

            $patient_detail  = Patient::find($request->id);
            $patient_detail->gender         = $request->gender;
            $patient_detail->blood_group_id = $request->blood_group_id;
            $patient_detail->genotype       = $request->genotype;
            $patient_detail->hieght         = $request->hieght;
            $patient_detail->disability     = $request->disability;
            $patient_detail->weight         = $request->weight;
            $patient_detail->account_type_id   = $request->account_type ?? null;
            $patient_detail->address        = $request->address;
            $patient_detail->nationality    = $request->nationality;
            $patient_detail->lga            = $request->lga_id;
            $patient_detail->dob            = $request->dob;
            $patient_detail->last_visiting_date = $request->last_visiting_date;
            $patient_detail->hmo_id         = $request->hmo;
            $patient_detail->hmo_no         = $request->hmo_no ?? null;
            //if the patient paid for file and consultation, else they wont be sent to the doctor
            if($patient_detail->visible == 1){
                $patient_detail->visible        = 2;
            }elseif($patient_detail->visible == 99){
                $patient_detail->visible        = 4;
            }

            if ($patient_detail->update()) {

                $king = new NextOfKing;
                $king->user_id   = $patient_detail->user_id;
                $king->full_name = $request->next_of_king_id;
                $king->phone     = $request->next_of_king_phone;
                $king->address   = $request->next_of_king_address;
                $king->visible   = 1;

                if ($king->save()) {
                    //if the user paid only for file, dot create a vital
                    if($patient_detail->visible == 2){
                        $vitalSign = new VitalSign;
                        $vitalSign->user_id  = $patient_detail->user_id;
                        $vitalSign->receptionist_id  = Auth::user()->id;
                        $vitalSign->nurse_id  = 0;
                        $vitalSign->medical_report_id  = 0;
                        $vitalSign->file_no  = $patient_detail->file_no;
                        $vitalSign->temperature  = 0;
                        $vitalSign->weight  = 0;
                        $vitalSign->bloodPressure  = 0;
                        $vitalSign->vitalSignReport  = "";
                        $vitalSign->status  = 0;
                        $vitalSign->paymentVisibility = 1;
                        $vitalSign->dateProccessed  = "";


                        if ($vitalSign->save()) {
                            // Send User an email with set password link
                            $msg = 'Record Saved';
                            Alert::success('Success ', $msg);
                            return redirect()->route('newRegistrationFormRequestList');
                        }
                    }else{
                        // Send User an email with set password link
                        $msg = 'Record Saved';
                        Alert::success('Success ', $msg);
                        return redirect()->route('newRegistrationFormRequestList');
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_detail = User::find($id);
        $fullname = userfullname($user_detail->id);
        $patient = Patient::where('user_id',$id)->first();
        $states = State::where('status_id', '=', 1)->pluck('name', 'id')->all();
        $hmos = Hmo::all();
        $next_of_kin = NextOfKing::where('user_id',$patient->user_id)->first();

        return view('admin.patients.edit', compact('user_detail', 'fullname', 'patient', 'states', 'hmos','next_of_kin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $check = Patient::find($request->id);
        $rules = [
            'gender'  => 'bail|required',
            'hieght'  => 'nullable',
            'weight'   => 'nullable',
            'address'     => 'nullable',
            'disability'   => 'nullable',
            'account_type'  => 'nullable',
            'next_of_king_id'  => 'required',
            'next_of_king_phone'   => 'required',
            'next_of_king_address'   => 'nullable',
            'hmo' => 'required',
            'dob' => 'required',
            'file_no' => 'required|unique:patients,file_no,'.$patient->id

        ];

        if ($request->hasFile('filename')) {
            #  Making sure if password change was selected it's being validated
            $rules += [
                'filename' => 'max:1024|mimes:jpeg,bmp,png,gif,svg,jpg',
            ];
        }
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            // Alert::error('Error Title', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            if ($request->hasFile('filename')) {
                $path = storage_path('/app/public/image/user/');
                $file = $request->file('filename');
                $extension = strtolower($file->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name = str_replace(" ", "-", strtolower($file->getClientOriginalName()));
                $name = str_replace("_", "-", $name);
                $filename = time() . '-' . $name;

                if (Storage::disk('user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($path . $filename);

                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                } else {
                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                }

                $thumbnail_path = storage_path('/app/public/image/user/thumbnail/');
                // save thumbnail for user images
                if (Storage::disk('thumbnail_user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($thumbnail_path . $filename);

                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                } else {
                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                }
            }

            $patient_detail  = Patient::find($request->id);
            $patient_detail->gender         = $request->gender;
            $patient_detail->blood_group_id = $request->blood_group_id;
            $patient_detail->genotype       = $request->genotype;
            $patient_detail->hieght         = $request->hieght;
            $patient_detail->disability     = $request->disability;
            $patient_detail->weight         = $request->weight;
            $patient_detail->account_type_id   = $request->account_type ?? null;
            $patient_detail->address        = $request->address;
            $patient_detail->nationality    = $request->nationality;
            $patient_detail->lga            = $request->lga_id;
            $patient_detail->dob            = $request->dob;
            $patient_detail->last_visiting_date = $request->last_visiting_date;
            $patient_detail->hmo_id         = $request->hmo;
            $patient_detail->hmo_no         = $request->hmo_no ?? null;
            $patient_detail->visible        = 2;
            $patient_detail->file_no        = $request->file_no;


            if ($patient_detail->update()) {
                if(isset($request->next_of_kin_ID)){
                    $king = NextOfKing::find($request->next_of_kin_ID);
                    $king->user_id   = $patient_detail->user_id;
                    $king->full_name = $request->next_of_king_id;
                    $king->phone     = $request->next_of_king_phone;
                    $king->address   = $request->next_of_king_address;
                    $king->visible   = 1;
                    if ($king->update()) {
                        // Send User an email with set password link
                        $msg = 'Record Saved';
                        Alert::success('Success ', $msg);
                        return redirect()->route('patient.index');
                    }
                }else{
                    $king = new NextOfKing;
                    $king->user_id   = $patient_detail->user_id;
                    $king->full_name = $request->next_of_king_id;
                    $king->phone     = $request->next_of_king_phone;
                    $king->address   = $request->next_of_king_address;
                    $king->visible   = 1;
                    if ($king->save()) {
                        // Send User an email with set password link
                        $msg = 'Record Saved';
                        Alert::success('Success ', $msg);
                        return redirect()->route('patient.index');
                    }
                }

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    public function newRegistrationFormRequestList()
    {
        return view('admin.patients.new_registration_request_list');
    }

    public function newRegistrationForm($id)
    {
        $user_detail = User::find($id);
        $fullname = userfullname($user_detail->id);
        $patient = Patient::where('user_id', '=', $id)->first();
        $states = State::where('status_id', '=', 1)->pluck('name', 'id')->all();
        $hmos = Hmo::all();

        return view('admin.patients.registration_form', compact('user_detail', 'fullname', 'patient', 'states', 'hmos'));
    }

    public function CurrentConsultationRequestlist()
    {
        return view('admin.patients.consultation_request_list');
    }

    public function BookedPatients()
    {
        return view('admin.patients.booked');
    }

    public function BedRequests()
    {
        return view('admin.beds.bed_requests');;
    }

    public function listBedRequests()
    {
        $pc = MedicalReport::where('discharge', 0)
            ->where('admission_status', 1)
            ->where('admission', 1)
            ->where('bed_assigned', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('doctor', function ($pc) {
                $doc = Doctor::find($pc->doctor_id);
                return (userfullname($doc->user_id));
            })
            ->addColumn('patient', function ($pc) {
                $patient = Patient::where('user_id', $pc->user_id)->first();
                return (userfullname($patient->user_id)) . " ($patient->file_no)";
            })
            ->addColumn('process', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin', 'Receptionist']) || Auth::user()->hasPermissionTo('customer-edit')) {
                    $url =  route('assignBed', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Assign Bed </a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Not Allowed</a>';
                }
            })
            ->rawColumns(['doctor', 'process', 'patient'])

            ->make(true);
    }

    public function assignBed($medicalReport_id)
    {
        $rep = MedicalReport::with(['user', 'doctor'])->find($medicalReport_id);
        $wards          = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
        return view('admin.beds.assign_bed', compact('rep', 'medicalReport_id', 'wards'));
    }

    public function assignBedStore(Request $request)
    {
        $rules = [
            'ward_id' => 'required',
            'bed_id' => 'required',
            'medicalReport_id' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {

            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $report = MedicalReport::find($request->medicalReport_id);

            $report->ward_id  = $request->ward_id;
            $report->bed_id   = $request->bed_id;
            $report->bed_assigned = 1;
            if ($report->update()) {
                $assignBed = new PatientAssignBed;
                $assignBed->patient_user_id = $report->user_id;
                $assignBed->medical_report_id = $report->id;
                $assignBed->ward_id = $request->ward_id;
                $assignBed->bed_id = $request->bed_id;
                $assignBed->bedCharges = 0;
                $assignBed->numberDays = 1;
                $assignBed->disChargeDate = "";
                $assignBed->amountPaid = 0;
                $assignBed->payment_status = 0;
                $assignBed->partPayment = 0;
                $assignBed->discountPayment = 0;

                if ($assignBed->save()) {
                    $bed = Bed::find($request->bed_id);
                    $bed->status = 1;
                    if ($bed->save()) {
                        $msg = ' Bed Assigned.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('BedRequests')->withMessage($msg)->withMessageType('success');
                    } else {
                        $msg = 'Something is went wrong. Please try again later.';
                        return redirect()->back()->with('error', $msg)->withInput();
                    }
                } else {
                    $msg = 'Something is went wrong. Please try again later.';
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            } else {
                $msg = 'Something is went wrong. Please try again later.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        }
    }

    


    public function Consultation($id, $dependant_id = null)
    {
        if (null != $dependant_id) {
            $dependant      = Dependant::find($dependant_id);
            $patient        = Patient::where('id', '=', $id)->first();
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_id')->orderBy('lab_service_name')->get();
            $wards          = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $clinics        = Clinic::where('visible', 1)->get();
            $vitalSign      = VitalSign::where('user_id', '=', $patient->user_id)
                ->where('status', 2)
                ->where('paymentVisibility', '=', 1)
                ->where('dependant_id', $dependant_id)
                ->orderBy('id', 'DESC')
                ->first();
            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', $dependant_id)->where('status_id', 1)->get();
            $products       = Product::with(['price'])->whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();

            return view('admin.patients.consultation_file', compact('patient', 'lab_services', 'wards', 'vitalSign', 'clinics', 'tests', 'dependant'));
        } else {
            $dependant = null;
            $patient        = Patient::where('id', '=', $id)->first();
            $lab_services   = LabService::where('visible', '=', 1)->orderBy('lab_id')->orderBy('lab_service_name')->get();
            $wards          = Ward::where('visible', '=', 1)->pluck('ward_name', 'id')->all();
            $clinics        = Clinic::where('visible', 1)->get();
            $vitalSign      = VitalSign::where('user_id', '=', $patient->user_id)
                ->where('status', 2)
                ->where('paymentVisibility', '=', 1)
                ->where('dependant_id', null)
                ->orderBy('id', 'DESC')
                ->first();


            $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id', null)->where('status_id', 1)
                ->orderBy('created_at', 'DESC')->get();
                $products       = Product::with(['price'])->whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();

            return view('admin.patients.consultation_file', compact('patient', 'lab_services', 'wards', 'vitalSign', 'clinics', 'tests', 'dependant','products'));
        }
    }

    public function returningPatients()
    {
        return view('admin.patients.returningPatients.index');
    }

    public function returningPatientsBooking()
    {
        return view('admin.patients.returningPatients.returningPatientsBookingFee');
    }

    public function listReturningPatientsPayment()
    {
        $pc = VitalSign::where('status', '=', '-1')->where('medical_report_id', '=', 0)->where('paymentVisibility', '=', 0)->orderBy('created_at', 'DESC')->get();


        //dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                //if the vital belongs to a dependat rather than a principal
                if (null != $pc->dependant_id) {
                    $dependant = Dependant::find($pc->dependant_id);
                    return $dependant->fullname;
                } else {
                    return (userfullname($pc->user_id));
                }
            })
            ->addColumn('payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                if (null == $pc->dependant_id) {
                    $url =  route('returningPatientFee', $pc->user_id);
                    return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Pay </a>';
                } else {
                    $url =  route('returningPatientFee', [$pc->user_id, $pc->dependant_id]);
                    return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Pay </a>';
                }
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Make Payment</a>';
                // }
            })
            ->rawColumns(['fullname', 'payment'])

            ->make(true);
    }

    public function listReturningPatientsBookingPayment()
    {
        $pc = DoctorBooking::where('status', '=', '1')->where('paid', '=', 0)->orderBy('created_at', 'DESC')->get();

        // dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('doctor', function ($pc) {
                $doc = Doctor::find($pc->doctor_id);
                return (userfullname($doc->user_id));
            })
            ->addColumn('patient', function ($pc) {
                $patient = Patient::find($pc->patient_id);
                return (userfullname($patient->user_id)) . " ($patient->file_no)";
            })
            ->addColumn('payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                $patient = Patient::find($pc->patient_id);
                $url =  route('returningPatientBookingFee', $pc->id);
                return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Pay </a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Make Payment</a>';
                // }
            })
            ->rawColumns(['doctor', 'payment', 'patient'])

            ->make(true);
    }



    public function services_rendered(Request  $request)
    {
        $rules = [
            'patient_id' => 'required',
        ];

        if ($request->has('dependant_id')) {
            $rules += [
                'dependant_id' => 'required',
            ];
        }
        if ($request->has('start_from')) {
            $rules += [
                'start_from' => 'required',
            ];
        }
        if ($request->has('stop_at')) {
            $rules += [
                'stop_at' => 'required',
            ];
        }
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {

            return back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {
            $patient_id = $request->get('patient_id');
            $patient = Patient::find($patient_id);
            if(null != $request->get('dependant_id') && !empty($request->get('dependant_id'))){
                $dependant_id = $request->get('dependant_id');
                $dependant = Dependant::find($dependant_id);
            }else{
                $dependant = null;
            }
            if(null == $request->get('start_from') && null == $request->get('stop_at')){
                return view('admin.patients.services_rendered',compact('patient','dependant'));
            }else{
                $start_from = $request->get('start_from');
                $stop_at = $request->get('stop_at');
                if(null != $dependant){
                    $consultation = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)->where('dependant_id',$dependant->id)
                        ->whereBetween('updated_at',[$start_from,$stop_at])->get();
                    $prescription = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)
                        ->where('dependant_id',$dependant->id)->where('pharmacy_status',1)
                        ->whereBetween('updated_at',[$start_from,$stop_at])->get();

                    $nursing = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)
                    ->where('dependant_id',$dependant->id)->where('nurseContent_status',1)
                    ->whereBetween('updated_at',[$start_from,$stop_at])->get();

                    $lab = PatientLabService::with(['lab_service', 'lab','medical_report'])
                            ->where('payment_status', '=', 1)->where('sampeTaken', '=', 1)->where('status_id', '=', 1)
                            ->where('patient_user_id',$patient->user_id)->where('dependant_id',$dependant->id)
                            ->whereBetween('updated_at',[$start_from,$stop_at])->get();
                }else{
                    $consultation = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)->where('dependant_id',null)
                        ->whereBetween('updated_at',[$start_from,$stop_at])->get();
                    $prescription = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)
                        ->where('dependant_id',null)->where('pharmacy_status',1)
                        ->whereBetween('updated_at',[$start_from,$stop_at])->get();

                    $nursing = MedicalReport::with('doctor')->where('user_id',$patient->user_id)->where('visible','>',0)
                    ->where('dependant_id',null)->where('nurseContent_status',1)
                    ->whereBetween('updated_at',[$start_from,$stop_at])->get();

                    $lab = PatientLabService::with(['lab_service', 'lab','medical_report'])
                            ->where('payment_status', '=', 1)->where('sampeTaken', '=', 1)->where('status_id', '=', 1)
                            ->where('patient_user_id',$patient->user_id)->where('dependant_id',null)
                            ->whereBetween('updated_at',[$start_from,$stop_at])->get();
                }
                return view('admin.patients.services_rendered',compact('patient','dependant','consultation','prescription','nursing','lab'));
            }
        }
    }

    public function pendingConsultationRequestlist()
    {
        return view('admin.patients.returningPatients.index');
    }
}
