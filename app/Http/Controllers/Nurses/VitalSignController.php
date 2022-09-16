<?php

namespace App\Http\Controllers\Nurses;

use App\VitalSign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\User;
use App\Nurse;
use App\Gender;
use App\Transaction;
use App\PaymentType;
use App\PaymentItem;
use App\Patient;
use App\ModeOfPayment;
use App\Clinic;
use App\Dependant;
use App\StatusCategory;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

class VitalSignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listVitalSigns()
    {
        $vitalSignList = VitalSign::with(['user'])
        ->where('status', '=', 0)
        ->where('updated_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())
        ->orderBy('created_at', 'DESC')
        ->get();

        //dd($vitalSignList);

        return Datatables::of($vitalSignList)
        ->addIndexColumn()
        ->addColumn('file_no', function ($vitalSignList) {
            $file_no = $vitalSignList->file_no;
            return "<span class='badge badge-pill badge-dark'>".$file_no."</span>";
        })

        ->editColumn('user_id', function ($vitalSignList) {
            //if the vital belongs to a dependat rather than a principal
            if (null != $vitalSignList->dependant_id) {
                $dependant = Dependant::find($vitalSignList->dependant_id);
                $fullname = $dependant->fullname;
            } else {
                $fullname = $fullname = $vitalSignList->user->surname." ".$vitalSignList->user->firstname." ".$vitalSignList->user->othername;
            }

            return $fullname;
        })
        ->editColumn('updated_at', function ($vitalSignList) {
            return date('h:i a D M j, Y',strtotime($vitalSignList->updated_at));
        })
        ->addColumn('status', function($vitalSignList){
            $statusName = "Vital Sign Not Taken";
            $status = (($vitalSignList->status_id == 0) ? "<span class='badge badge-pill badge-secondary'>". $statusName."</span>" : "<span class='badge badge-pill badge-success'>Vitals Taken</span>");

            return $status;
        })

        ->addColumn('clinic', function($vitalSignList){
            if (null != $vitalSignList->dependant_id) {
                $dependant = Dependant::with('clinic')->find($vitalSignList->dependant_id);
                //dd($dependant);
                return $dependant->clinic->clinic_name;
            } else {
               $patient = Patient::with('clinic')->where('user_id',$vitalSignList->user_id)->first();
                return ($patient->clinic->clinic_name);
            }
        })

        // ->addColumn('view', function ($vitalSignList) {

        //     if (Auth::user()->hasPermissionTo('user-show') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

        //         $url =  route('vitalSign.show', $vitalSignList->id);
        //         return '<a href="' . $url . '" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>';

        //     } else {

        //         $label = '<span class="badge badge-sm badge-warning">Not Allowed</span>';
        //         return $label;
        //     }
        // })

        // ->addColumn('edit', function ($vitalSignList) {

        //     if (Auth::user()->hasPermissionTo('user-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

        //         $url =  route('vitalSign.edit', $vitalSignList->id);
        //         return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> </a>';
        //     } else {

        //         $label = '<span class="label label-warning">Not Allow</span>';
        //         return $label;
        //     }
        // })
        // ->addColumn('delete', function ($vitalSignList) {

        //     if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
        //         $id = $vitalSignList->id;
        //         return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="' . $id . '"><i class="fa fa-trash"></i></button>';
        //     } else {
        //         $label = '<span class="label label-danger">Not Allow</span>';
        //         return $label;
        //     }
        // })
        ->addColumn('process',   '<a href="{{ route(\'vitalSign.show\', $id)}}" class="btn btn-success" ><i class="fa fa-street-view"></i> View</a>')
        ->rawColumns(['file_no', 'status', 'process','updated_at'])
        ->make(true);




// }
    }

    public function updateUser(Request $request)
    {
        // dd($request->all());
        VitalSign::find($request->pk)->update([$request->name => $request->value]);
        return response()->json(['success' => 'done']);
    }

    public function saveWhoProcessed(Request $request)
    {
        // dd($request->all());
        $res = VitalSign::find($request->id);
        $res->nurse_id            = Auth::user()->id;
        $res->dateProccessed    = \Carbon\Carbon::now();
        // dd($res);

        if ($res->save()) {
            return response()->json($res);
        }

        return response()->json($res);
    }

    public function saveVitalSignStatus(Request $request)
    {
        // dd($request->all());
        $resAck = VitalSign::find($request->id);
        $resAck->status = ($resAck->paymentVisibility == 1) ? 2 : 1;

        if ($resAck->save()) {

            // $getPatient = Patient::where('');

            // $transaction                        = new Transaction();
            // $transaction->transaction_no        = $request->trans;
            // $transaction->budget_year_id        = 1;
            // $transaction->bank_transaction_payment_id = $resAck->user_id;
            // $transaction->transaction_type      = $request->payment_items;
            // $transaction->customer_name         = userfullname($resAck->user_id);
            // $transaction->total_amount          = $request->total_amount;
            // $transaction->deposit_b4            = 00;
            // $transaction->credit_b4             = 00;
            // $transaction->current_deposit       = 00;
            // $transaction->current_credit        = 00;
            // $transaction->customer_type_id      = 2; //$customer_type_id;
            // $transaction->bank_name             = 00;
            // $transaction->staff_id              = Auth::user()->id;
            // $transaction->supply                = 1;
            // $transaction->bank_transaction_id   = 00;
            // $transaction->mode_of_payment_id    = $request->payment_mode;

            // $transaction->store_id = 0;
            // $transaction->tr_date = \Carbon\Carbon::now();
            // $transaction->tr_year = \Carbon\Carbon::now();

            // if($transaction->save()){

            //     $patient            = Patient::where('user_id', '=', $resAck->user_id)->first();
            //     $patient->clinic_id = $request->clinic_name;
            //     $patient->visible   = 1;
            //     $patient->save();

            //      return response()->json($resAck);
            // }

            return response()->json($resAck);

        }
    }

    public function index()
    {
        return view('admin.vitalSign.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VitalSign  $vitalSign
     * @return \Illuminate\Http\Response
     */
    public function show(VitalSign $vitalSign)
    {

        $getPatientVitalSign = VitalSign::where('id', '=', $vitalSign->id)->with(['user'])->first();
        $dependant = Dependant::find($getPatientVitalSign->dependant_id) ?? null;
        $trans = generateTransactionId();
        $payment_mode = ModeOfPayment::whereVisible(1)->where("id","!=",5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
        $payment_items = PaymentItem::whereVisible(1)->where('payment_type_id', '=', 6)->orderBy('item_name', 'asc')->pluck('item_name', 'id');
        $clinic = Clinic::where('visible', '=', 1)->orderBy('id', 'asc')->pluck('clinic_name', 'id');

        return view('admin.vitalSign.show', compact('getPatientVitalSign','trans','payment_mode','clinic','payment_items','dependant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VitalSign  $vitalSign
     * @return \Illuminate\Http\Response
     */
    public function edit(VitalSign $vitalSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VitalSign  $vitalSign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VitalSign $vitalSign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VitalSign  $vitalSign
     * @return \Illuminate\Http\Response
     */
    public function destroy(VitalSign $vitalSign)
    {
        //
    }
}
