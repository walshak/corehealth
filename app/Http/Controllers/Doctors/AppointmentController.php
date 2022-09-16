<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Appointment;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listDoctorsAppointments()
    {

        $doctorsAppointment = Appointment::with(['user', 'doctor', 'status'])
            ->where('apStatus_id', '>', 0)
            ->orderBy('id', 'ASC')
            ->get();

        return Datatables::of($doctorsAppointment)
            ->addIndexColumn()
            ->editColumn('user_id', function ($doctorsAppointment) {
                $fullname = $doctorsAppointment->user->surname . " " . $doctorsAppointment->user->firstname . " " . $doctorsAppointment->user->othername;
                return $fullname;
            })
            ->addColumn('specialization_id', function ($doctorsAppointment) {
                $specialization = ($doctorsAppointment->specialization_id == 0) ? "No Specialization Set" : $doctorsAppointment->specialization->name;

                return "<span class='badge badge-pill badge-dark'>" . $specialization . "</span>";
            })
            ->addColumn('status_id', function ($doctorsAppointment) {
                $statusName = $doctorsAppointment->status->name;
                $status = (($doctorsAppointment->status_id == 1) ? "<span class='badge badge-pill badge-secondary'>" . $statusName . "</span>" : "<span class='badge badge-pill badge-success'>" . $statusName . "</span>");

                return $status;
            })
            ->addColumn('edit', function ($doctorsAppointment) {

                if (Auth::user()->hasPermissionTo('user-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url =  route('doctors.edit', $doctorsAppointment->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> </a>';
                } else {

                    $label = '<span class="label label-warning">Not Allow</span>';
                    return $label;
                }
            })
            ->addColumn('delete', function ($doctorsAppointment) {

                if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
                    $id = $doctorsAppointment->id;
                    return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="' . $id . '"><i class="fa fa-trash"></i></button>';
                } else {
                    $label = '<span class="label label-danger">Not Allow</span>';
                    return $label;
                }
            })
            ->rawColumns(['title_id', 'specialization_id', 'status_id', 'view', 'edit', 'delete', 'deleted'])
            ->make(true);
        // }
    }

    public function listMyAppointments($id)
    {

        $doctorsAppointment = Appointment::with(['user', 'doctor', 'status'])
            ->where('apStatus_id', '>', 0)
            ->where('user_id', $id)
            ->orderBy('id', 'ASC')
            ->get();

        return Datatables::of($doctorsAppointment)
            ->addIndexColumn()
            ->editColumn('user_id', function ($doctorsAppointment) {
                $fullname = $doctorsAppointment->user->surname . " " . $doctorsAppointment->user->firstname . " " . $doctorsAppointment->user->othername;
                return $fullname;
            })
            ->addColumn('specialization_id', function ($doctorsAppointment) {
                $specialization = ($doctorsAppointment->specialization_id == 0) ? "No Specialization Set" : $doctorsAppointment->specialization->name;

                return "<span class='badge badge-pill badge-dark'>" . $specialization . "</span>";
            })
            ->addColumn('status_id', function ($doctorsAppointment) {
                $statusName = $doctorsAppointment->status->name;
                $status = (($doctorsAppointment->status_id == 1) ? "<span class='badge badge-pill badge-secondary'>" . $statusName . "</span>" : "<span class='badge badge-pill badge-success'>" . $statusName . "</span>");

                return $status;
            })
            // ->addColumn('edit', function ($doctorsAppointment) {

            //     if (Auth::user()->hasPermissionTo('user-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin','Doctor'])) {
            //         $id = $doctorsAppointment->id;
            //         return '<button type="button" class="edit-modal btn btn-primary btn-sm" data-toggle="modal" data-id="' . $id . '"><i class="fa fa-pencil"></i></button>';
            //     } else {

            //         $label = '<span class="label label-warning">Not Allow</span>';
            //         return $label;
            //     }
            // })
            // ->addColumn('delete', function ($doctorsAppointment) {

            //     if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin','Doctor'])) {
            //         $id = $doctorsAppointment->id;
            //         return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="' . $id . '"><i class="fa fa-trash"></i></button>';
            //     } else {
            //         $label = '<span class="label label-danger">Not Allow</span>';
            //         return $label;
            //     }
            // })
            ->addColumn('edit',   '<button type="button" class="edit-modal btn btn-primary btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-pencil"></i> Edit</button>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> Delete</button>')
            ->rawColumns(['user_id', 'specialization_id', 'status_id', 'edit', 'delete'])
            ->make(true);
        // }
    }

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
        // dd($request->all());

        $rules = [
            'apStartDate'  => 'required',
            'apEndDate'   => 'required',
            'waitTime'   => 'required',
        ];

        if (!empty($request->apStatus_id)) {

            $rules += [
                'apStatus_id'  => 'required',
            ];
        }

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            // $checkDoctor = Appointment::where('user_id', '=', $request->user_id)
            //                      ->Orwhere('secondary_email', '=', $request->secondary_email)
            //                      ->Orwhere('secondary_phone_number', '=', $request->secondary_phone_number)->first();

            // if(!empty($checkDoctor)){

            //     $msg = "The user information you try to input already exist please check your input";
            //     return back()->with('toast_error', $msg)->withInput();

            // }

            $appDetails                = new Appointment;
            $appDetails->user_id   = $request->user_id;
            $appDetails->doctor_id   = $request->doctor_id;
            $appDetails->apStartDate   = $request->apStartDate;
            $appDetails->apEndDate     = $request->apEndDate;
            $appDetails->waitTime     = $request->waitTime;

            if ($request->apStatus_id) {

                $appDetails->apStatus_id       = ($request->apStatus_id == "on") ? 2 : 1;
            }

            if ($appDetails->save()) {
                return response()->json($appDetails);
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
        Appointment::find($id)->update([
            'apStatus_id' => 0
        ]);
        $msg = 'Callender Entry deleted.';
        Alert::success('Success ', $msg);
        return back();
    }
}
