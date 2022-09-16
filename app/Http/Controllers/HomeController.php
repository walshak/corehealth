<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Customer;
use App\Transaction;
use App\CustomerType;
use App\DailyExpense;
use App\Promotion;
use App\Product;
use App\Requisition;
use App\MedicalReport;
use App\PatientLabService;
use App\Patient;
use App\VitalSign;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRequestRequisition()
    {

        $list = Requisition::where('customer_id', '=', Auth::user()->customer_id)
            ->where('visible', '=', 2)
            ->where('status', '=', 1)
            ->with('customer')
            ->get();
        //dd($list);
        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('customer_id', function ($list) {
                $fullname = $list->customer->fullname;
                return $fullname;
            })
            ->addColumn('account', function ($list) {
                if ($list->customer->deposit > 0) {
                    $account = 'Balance' . " " . formatMoney($list->customer->deposit);
                } elseif ($list->customer->creadit > 0) {
                    $account =  'Credit' . " " . formatMoney($list->customer->creadit);
                } else {
                    $account = 0;
                }

                return $account;
            })

            ->addColumn('process', function ($list) {

                // if (Auth::user()->hasPermissionTo('sales') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                $url = route('newSale', $list->id);
                return '<a href="' . $url . '" class="btn btn-secondary btn-sm"><i class="fa fa-i-cursor"></i> Process</a>';
                // } else {

                //     $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-i-cursor"></i> Process</button>';
                //     return $label;
                // }


            })
            ->rawColumns(['client', 'process', 'account'])
            ->make(true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(['Super-Admin', 'Admin'])) {

            $user = User::where('id', '=', Auth::user()->id)->first();
            $admitted = MedicalReport::where('admission_status', '=', 1)->count();
            $discharge = MedicalReport::where('admission_status', '=', 2)->count();
            $labPatients = PatientLabService::where('payment_status', '=', 1)
                ->where('resultReport', '=', '')
                ->where('resultReport_by', '=', 0)
                ->count();
            $newPatient = User::where('visible', '=', 0)->count();
            $products = Product::with('storeStock')->where('visible', 1)->get();
            return view('admin.home', compact('products','user', 'admitted', 'discharge', 'labPatients', 'newPatient'));
        } elseif (Auth::user()->hasAnyRole(['Head', 'Secretary'])) {
            $requisition = Requisition::where('customer_id', '=', Auth::user()->customer_id)->first();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $admitted = MedicalReport::where('admission_status', '=', 1)->count();
            $discharge = MedicalReport::where('admission_status', '=', 2)->count();
            $labPatients = PatientLabService::where('payment_status', '=', 1)
                ->where('resultReport', '=', '')
                ->where('resultReport_by', '=', 0)
                ->count();
            $newPatient = User::where('visible', '=', 0)->count();
            return view('admin.homeDepartment', compact('requisition','user', 'admitted', 'discharge', 'labPatients', 'newPatient'));
        } elseif (Auth::user()->hasAnyRole(['Receptionist'])) {
            // $requisition = Requisition::where('customer_id', '=', Auth::user()->customer_id)->first();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $admitted = MedicalReport::where('admission_status', '=', 1)->count();
            $discharge = MedicalReport::where('admission_status', '=', 2)->count();
            $labPatients = PatientLabService::where('payment_status', '=', 1)
                ->where('resultReport', '=', '')
                ->where('resultReport_by', '=', 0)
                ->count();
            $newPatient = User::where('visible', '=', 0)->count();
            return view('admin.homeDepartment', compact('user', 'admitted', 'discharge', 'labPatients', 'newPatient'));
        }

        $requisition = Requisition::where('customer_id', '=', Auth::user()->customer_id)->first();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $admitted = MedicalReport::where('admission_status', '=', 1)->count();
            $discharge = MedicalReport::where('admission_status', '=', 2)->count();
            $labPatients = PatientLabService::where('payment_status', '=', 1)
                ->where('resultReport', '=', '')
                ->where('resultReport_by', '=', 0)
                ->count();
            $newPatient = User::where('visible', '=', 0)->count();
            return view('admin.homeDepartment', compact('requisition','user', 'admitted', 'discharge', 'labPatients', 'newPatient'));

        return view('admin.home', compact('user', 'admitted', 'discharge', 'labPatients', 'newPatient'));
    }
}
