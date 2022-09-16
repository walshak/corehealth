<?php

namespace App\Http\Controllers\Doctors;

use App\Clinic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Doctor;
use App\User;
use App\Title;
use App\Status;
use App\State;
use App\Lga;
use App\Specialization;
use App\Gender;
use App\StatusCategory;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware(['role:super-admin', 'permission:publish articles|edit articles']);
        // $this->middleware(['role:Super-Admin|Admin|Users', 'permission:users|user-create|user-list|user-show|user-edit|user-delete']);
    }

    public function listDoctors()
    {

        $doctors = Doctor::with(['title', 'user', 'specialization', 'status'])
                      ->where('status_id', '>', 0)
                      ->orderBy('id', 'ASC')
                      ->get();

        return Datatables::of($doctors)
            ->addIndexColumn()
            ->addColumn('title_id', function ($doctors) {
                $title = $doctors->title->name;
                return "<span class='badge badge-pill badge-dark'>".$title."</span>";
            })
            ->editColumn('user_id', function ($doctors) {
                $fullname = $doctors->user->surname." ".$doctors->user->firstname." ".$doctors->user->othername;
                return $fullname;
            })
            ->addColumn('specialization_id', function ($doctors) {
                $specialization = ($doctors->specialization_id == 0) ? "No Specialization Set" : $doctors->specialization->name;

                return "<span class='badge badge-pill badge-dark'>".$specialization."</span>";
            })
            ->addColumn('clinic_id', function ($doctors) {
                $clinic = ($doctors->clinic_id == 0) ? "No clinic Set" : $doctors->clinic->clinic_name;
                return "<span class='badge badge-pill badge-dark'>".$clinic."</span>";
            })
            ->addColumn('status_id', function($doctors){
                $statusName = $doctors->status->name;
                $status = (($doctors->status_id == 1) ? "<span class='badge badge-pill badge-secondary'>". $statusName."</span>" : "<span class='badge badge-pill badge-success'>". $statusName."</span>");

                return $status;
            })
            ->addColumn('deleted', function($doctors){

                $status = (($doctors->deleted == 1) ? "<span class='badge badge-pill badge-secondary'>Deleted</span>" : "<span class='badge badge-pill badge-primary'>Active</span>");

                return $status;
            })
            ->addColumn('view', function ($doctors) {


                if (Auth::id() == $doctors->user_id || Auth::user()->hasRole(['Super-Admin', 'Admin','Doctor'])) {

                    if ($doctors->is_admin == 20) {

                        $url =  route('doctors.show', $doctors->id);
                        return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-eye"></i> Calender</a>';
                    } else {

                        $label = '<span class="badge badge-sm badge-warning">Not Allowed</span>';
                        return $label;
                    }
                } else {

                    $label = '<span class="label label-warning">Not Allowed</span>';
                    return $label;
                }
            })
            ->addColumn('book', function ($doctors) {

                if ($doctors->is_admin == 20 || $doctors->specialization_id != 0) {

                    $url =  route('DoctorBooking.create', "doc=$doctors->id");
                    return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-eye"></i> Book</a>';
                } else {

                    $label = '<span class="badge badge-sm badge-warning">Not Allow</span>';
                    return $label;
                }
            })
            ->addColumn('edit', function ($doctors) {

                if (Auth::id() == $doctors->user_id || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url =  route('doctors.edit', $doctors->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> </a>';
                } else {

                    $label = '<span class="label label-warning">Not Allow</span>';
                    return $label;
                }
            })
            ->addColumn('delete', function ($doctors) {

                if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
                    $id = $doctors->id;
                    return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="' . $id . '"><i class="fa fa-trash"></i></button>';
                } else {
                    $label = '<span class="label label-danger">Not Allow</span>';
                    return $label;
                }
            })
            ->rawColumns(['title_id', 'specialization_id','clinic_id', 'status_id', 'view', 'edit', 'delete', 'deleted','book'])
            ->make(true);
        // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = Title::whereStatusId(1)->get();
        $statuses = Status::whereVisible(1)->get();

        return view('admin.doctors.index', compact('titles', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('visible', '=', 2)->orderBy('id', 'asc')->get(['surname','firstname','othername','id'])->pluck('name', 'id');
        $statuses = Status::pluck('name', 'id')->all();
        $statusCategories = StatusCategory::whereIn('id', [19, 20, 21, 22, 23])->pluck('name', 'id')->all();
        $titles = Title::whereStatusId(1)->pluck('name', 'id')->all();
        $specializations = Specialization::whereStatusId(1)->pluck('name', 'id')->all();
        $genders = Gender::whereStatusId(1)->pluck('name', 'id')->all();
        $states = State::whereStatusId(1)->pluck('name', 'id')->all();
        $lgas = Lga::whereStatusId(1)->pluck('name', 'id')->all();
        $clinics = Clinic::pluck('clinic_name', 'id')->all();

        return view('admin.doctors.create', compact('users', 'statuses', 'titles', 'specializations', 'genders', 'states', 'lgas', 'statusCategories','clinics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $rules = [
            'title_id'  => 'required',
            'is_admin'   => 'required',
            'user_id'   => 'bail|required',
            'gender_id'  => 'required',
            'state_id'   => 'required',
            'secondary_email'   => 'required|email',
            'secondary_phone_number'   => 'required',
            'contact_address'   => 'required',
            'date_of_birth'   => 'required',
            'home_address'   => 'required',

        ];

        if($request->is_admin == 20){

            $rules += [
                'specialization_id'  => 'required',
                'consultation_fee'   => 'required',
                'clinic_id'          => 'required'
            ];
        }

        if (!empty($request->state_id)) {

            $rules += [
                'lga_id'  => 'required|integer',
            ];
        }

        if ($request->status_id) {

            $rules += [
                'status_id'  => 'required',
            ];
        }

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $checkDoctor = Doctor::where('user_id', '=', $request->user_id)
                                 ->Orwhere('secondary_email', '=', $request->secondary_email)
                                 ->Orwhere('secondary_phone_number', '=', $request->secondary_phone_number)->first();

            if(!empty($checkDoctor)){

                $msg = "The user information you try to input already exist please check your input";
                return back()->with('toast_error', $msg)->withInput();

            }

            $doctor            = new Doctor;
            $doctor->title_id           = $request->title_id;
            $doctor->is_admin           = $request->is_admin;
            $doctor->user_id            = $request->user_id;

            $doctor->gender_id          = $request->gender_id;
            $doctor->state_id           = $request->state_id;

            if($request->is_admin == 20){

                $doctor->specialization_id  = $request->specialization_id;
                $doctor->consultation_fee   = $request->consultation_fee;
                $doctor->clinic_id          = $request->clinic_id;

            }else{

                $doctor->specialization_id  = 0;
                $doctor->consultation_fee   = "0.00";
            }

            if ($request->state_id) {

                $doctor->lga_id         = $request->lga_id;
            }

            $doctor->secondary_email          = $request->secondary_email;
            $doctor->secondary_phone_number          = $request->secondary_phone_number;
            $doctor->contact_address          = $request->contact_address;
            $doctor->date_of_birth          = $request->date_of_birth;

            $doctor->home_address          = $request->home_address;

            if ($request->status_id) {

                $doctor->status_id       = ($request->status_id == "on") ? 2 : 1;
            }

            $doctor->deleted       = 0;

            if ($doctor->save()) {
                $msg = 'Doctor Information Saved.';
                Alert::success('Success ', $msg);
                return redirect()->route('doctors.index');
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
        $doctor = Doctor::whereId($id)->with(['title', 'user', 'specialization', 'status'])->first();
        $users = User::where('visible', '=', 2)->orderBy('id', 'asc')->get(['surname','firstname','othername','id'])->pluck('name', 'id');
        $statuses = Status::pluck('name', 'id')->all();
        $titles = Title::whereStatusId(1)->pluck('name', 'id')->all();
        $specializations = Specialization::whereStatusId(1)->pluck('name', 'id')->all();
        $genders = Gender::whereStatusId(1)->pluck('name', 'id')->all();
        $states = State::whereStatusId(1)->pluck('name', 'id')->all();
        $lgas = Lga::whereStatusId(1)->pluck('name', 'id')->all();
        $clinics = Clinic::pluck('clinic_name', 'id')->all();

        return view('admin.doctors.show', compact('doctor', 'users', 'statuses', 'titles', 'specializations', 'genders', 'states', 'lgas','clinics'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $statusCategories = StatusCategory::whereIn('id', [19, 20, 21, 22, 23])->pluck('name', 'id')->all();
        $doctor = Doctor::whereId($id)->first();
        $users = User::where('visible', '=', 2)->orderBy('id', 'asc')->get(['surname','firstname','othername','id'])->pluck('name', 'id');
        $statuses = Status::pluck('name', 'id')->all();
        $titles = Title::whereStatusId(1)->pluck('name', 'id')->all();
        $specializations = Specialization::whereStatusId(1)->pluck('name', 'id')->all();
        $genders = Gender::whereStatusId(1)->pluck('name', 'id')->all();
        $states = State::whereStatusId(1)->pluck('name', 'id')->all();
        $lgas = Lga::whereStatusId(1)->pluck('name', 'id')->all();
        $clinics = Clinic::pluck('clinic_name', 'id')->all();

        return view('admin.doctors.edit', compact('doctor', 'users', 'statuses', 'titles', 'specializations', 'genders', 'states', 'lgas', 'statusCategories','clinics'));
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
        // dd($request->all());
        $rules = [
            'title_id'  => 'required',
            'is_admin'   => 'required',
            'user_id'   => 'bail|required',
            'gender_id'  => 'required',
            'state_id'   => 'required',
            'secondary_email'   => 'required|email',
            'secondary_phone_number'   => 'required',
            'contact_address'   => 'required',
            'date_of_birth'   => 'required',
            'home_address'   => 'required',
        ];


        if($request->is_admin == 20){

            $rules += [
                'specialization_id'  => 'required',
                'consultation_fee'   => 'required',
                'clinic_id'      => 'required'
            ];
        }

        if (!empty($request->state_id)) {

            $rules += [
                'lga_id'  => 'required|integer',
            ];
        }

        if ($request->status_id) {

            $rules += [
                'status_id'  => 'required',
            ];
        }

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return back()->with('errors', $v->messages()->all()[0])->withInput();
        } else {

            $doctor            = Doctor::findOrFail($id);

            $doctor->title_id           = $request->title_id;
            $doctor->user_id            = $request->user_id;
            $doctor->specialization_id  = $request->specialization_id;
            $doctor->clinic_id          = $request->clinic_id;
            $doctor->gender_id          = $request->gender_id;
            $doctor->state_id           = $request->state_id;

            if ($request->state_id) {

                $doctor->lga_id         = $request->lga_id;
            }

            $doctor->secondary_email          = $request->secondary_email;
            $doctor->secondary_phone_number          = $request->secondary_phone_number;
            $doctor->contact_address          = $request->contact_address;
            $doctor->date_of_birth          = $request->date_of_birth;
            $doctor->consultation_fee          = $request->consultation_fee;
            $doctor->home_address          = $request->home_address;

            if ($request->status_id) {
                $doctor->status_id       = ($request->status_id == "on") ? 2 : 1;
            }else{
                $doctor->status_id       = ($request->status_id) ? $request->status_id : 1;
            }

            if ($request->deleted) {
                $doctor->deleted       = ($request->deleted == "on") ? 1 : 0;
            }else{
                $doctor->deleted       = ($request->deleted) ? $request->deleted : 0;
            }
            // $doctor->deleted       = ($request->deleted) ? $request->deleted : 0;

            if ($doctor->save()) {
                $msg = 'Doctor Information Updated.';
                Alert::success('Success ', $msg);
                return redirect()->route('doctors.index');
            }
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
        $doctor = Doctor::findOrFail($id);
        $doctor->status_id = 1;
        $doctor->deleted = 1;
        $doctor->save();

        return response()->json($doctor);
    }
}
