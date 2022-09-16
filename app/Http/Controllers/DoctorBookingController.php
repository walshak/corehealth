<?php

namespace App\Http\Controllers;

use App\DoctorBooking;
use App\Patient;
use App\Doctor;
use Illuminate\Http\Request;
use App\Appointment;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Response;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctorsAppointmentSpaces = Appointment::with(['user', 'doctor', 'status'])
            ->where('apStatus_id', '>', 0)
            ->orderBy('id', 'ASC')
            ->get();
        return view('admin.doctor_booking.index', compact(''));
    }

    public function listHmos()
    {

        $hmos = Hmo::orderBy('name', 'ASC')->get();

        return Datatables::of($hmos)
            ->addIndexColumn()
            ->addColumn('edit',   '<a href="{{ route(\'DoctorBooking.edit\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> Edit</a>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> Delete</button>')
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $doctor_id = $request->input('doc');
        $doctor = Doctor::find($doctor_id);
        $today = \Carbon\Carbon::now();
        $calender = Appointment::where('doctor_id', $doctor_id)->where('apStatus_id', '>', 0)->where('apEndDate', '>=', $today)->get();
        $patients = Patient::where('visible', 1)
            ->orWhere('visible', 2)
            ->orWhere('visible', 3)
            ->orWhere('visible', 4)
            ->with(['user'])
            ->get();
        return view('admin.doctor_booking.create', compact('doctor', 'calender', 'patients'));
    }

    public function listReturningPatientsPayment()
    {
        $pc = VitalSign::where('status', '=', '-1')->where('medical_report_id', '=', 0)->where('paymentVisibility', '=', 0)->get();

        // dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('fullname', function ($pc) {
                return (userfullname($pc->user_id));
            })
            ->addColumn('payment', function ($pc) {

                // if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                $url =  route('returningPatientFee', $pc->user_id);
                return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Pay </a>';
                // } else {

                //     return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Make Payment</a>';
                // }
            })
            ->rawColumns(['fullname', 'payment'])

            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =
            [
                'patient' => 'required',
                'calender' => 'required',
                'doc_id' => 'required'
            ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            Alert::error('Error Title', 'One or more information is needed.');
            return redirect()->back()->withInput()->withErrors($v);
        } else {
            $doctor = Doctor::find($request->doc_id);
            $booking              = new DoctorBooking;
            $booking->patient_id       = $request->patient;
            $booking->doctor_id       = $request->doc_id;
            $booking->booked_by    = Auth::id();
            $booking->fee                         = $doctor->consultation_fee;
            $booking->appointment_id              = $request->calender;
            $booking->time                        = $request->time;

            if ($booking->save()) {

                $msg = 'The booking was successfully Saved.';
                Alert::success('Success ', $msg);
                return redirect()->back()->withMessage($msg)->withMessageType('success');
            }
        }
    }

    public function calenderDoctor($id){
        $booking = Appointment::find($id);
        return response(json_encode($booking));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function show(Hmo $Hmo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function edit(Hmo $Hmo)
    {
        return view('admin.doctor_booking.edit')->with('hmo', $Hmo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hmo $Hmo)
    {
        $rules =
            [
                'name' => 'required',
                'desc' => 'nullable|min:3|max:500',
                'discount' => 'numeric|required'
            ];
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            Alert::error('Error Title', 'One or more information is needed.');
            return redirect()->back()->withInput()->withErrors($v);
        } else {

            $Hmo->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'discount' => $request->discount
            ]);
            $Hmo->syncPermissions($request->permission);

            $msg = 'The Hmo [' . $Hmo->name . '] was successfully updated.';
            Alert::success('Success ', $msg);
            return redirect()->route('DoctorBooking.index')->withMessage($msg)->withMessageType('success');
            // return response()->json($role);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hmo $Hmo)
    {
        $hmo = $Hmo->delete();
        return response()->json($hmo);
    }
}
