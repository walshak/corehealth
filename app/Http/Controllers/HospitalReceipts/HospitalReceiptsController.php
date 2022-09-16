<?php

namespace App\Http\Controllers\HospitalReceipts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModeOfPayment;
use App\Lab;
use App\LabService;
use App\ApplicationStatu;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Patient;
use App\PaymentItem;
use App\Clinic;
use App\MedicalReport;
use App\NurseService;
use App\Transaction;
use App\PatientLabService;
use App\PatientAccount;

use Auth;

class HospitalReceiptsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tran = Transaction::where('transaction_no', '=', $id)->first();
        //dd($tran);
        $apps = appsettings();
        //$patient = Patient::where('user_id', '=', $tran->bank_transaction_id)->first() ?? null;


        if ($tran->transaction_type == 'Patient Account') {

            $file = $patient->file_no ?? 'N/A';
            return view('admin.hospital_receipts.patient_deposite_receipt', compact('tran', 'apps', 'file'));
        }
        if ($tran->transaction_type == "Doctor/Nurse Services ") {
            $pc = NurseService::where('transaction_id', '=', $tran->id)->first();

            if ($pc->patient_user_id != null && $pc->patient_user_id != 44) {
                $file = showFileNumber($pc->patient_user_id);
            } else {
                $file = "N/A";
            }
            return view('admin.hospital_receipts.doctor_nurse_receipt', compact('tran', 'apps', 'file', 'pc'));
        }
        if ($tran->transaction_type == "Lab Services") {
            $pc = PatientLabService::where('transaction_id', '=', $tran->id)->first();
            //dd($pc);
            $services = PatientLabService::where('transaction_id', '=', $tran->id)->get();

            if ($pc->patient_user_id != null && $pc->patient_user_id != 44) {
                $file = showFileNumber($pc->patient_user_id);
            } else {
                $file = "N/A";
            }
            return view('admin.hospital_receipts.patient_lab_services_receipt', compact('tran', 'apps', 'file', 'pc', 'services'));
        }

        if ($tran->transaction_type == "Registration Fee") {
            $pc = MedicalReport::where('transaction_no', '=', $id)->first();

            if ($pc->patient_user_id != null && $pc->patient_user_id != 44) {
                $file = showFileNumber($pc->patient_user_id);
            } else {
                $file = "N/A";
            }
            return view('admin.hospital_receipts.consultation_receipt', compact('tran', 'apps', 'file', 'pc'));
        }

        if ($tran->transaction_type == "18") {
            $pc = MedicalReport::where('transaction_no', '=', $id)->first();

            if ($pc->patient_user_id != null && $pc->patient_user_id != 44) {
                $file = showFileNumber($pc->patient_user_id);
            } else {
                $file = "N/A";
            }
            return view('admin.hospital_receipts.consultation_receipt', compact('tran', 'apps', 'file', 'pc'));
        }
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
}
