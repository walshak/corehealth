<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Supplier;
use App\CustomerType;
use App\Invoice;
use App\ModeOfPayment;
use App\SupplyAndPayment;
use Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class SupplyAndPaymentController extends Controller
{
    //(Request $request, $id)
    public function listsupplierPayment(Request $request, $id)
    {
        //dd($request->all());
        $pc = SupplyAndPayment::where('supplier_id', "=", $id)->with('supplier', 'mode_of_payment')->orderBy('id', 'desc')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('company', function ($pc) {

                return ($pc->supplier->company_name);
            })
            ->editColumn('mode', function ($pc) {

                return ($pc->mode_of_payment->payment_mode);
            })
            ->addColumn('view', function ($pc) {
                return '<a href="' . route('ryprintSupplierPayment', $pc->id) . '" class="btn btn-info"><i class="fa fa-eye"></i>view</a>';
            })
            ->rawColumns(['company', 'view', 'mode'])
            ->make(true);
    }

    public function showListsupplierPayment($id)
    {


        try {

            if (Auth::user()) {
                $supplier = Supplier::find($id);
                $suppliers = SupplyAndPayment::where('supplier_id', "=", $id)->get();
                $sum_payment = 0;
                $sum_supply = 0;

                foreach ($suppliers as $suppliert) {
                    $sum_payment += $suppliert->pay_amount;
                    $sum_supply  += $suppliert->supply_amount;
                }
                //dd($sum_payment);
                return view('admin.suppliers.show_payment', compact('supplier', 'sum_payment', 'sum_supply'));
            } else {
                return view('home.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }
    public function ryprintSupplierPayment($id)
    {


        try {

            if (Auth::user()) {

                SupplyAndPayment::where('supplier_id', "=", $id)->with('supplier', 'mode_of_payment')->orderBy('id', 'desc')->get();
                $trans = Supplier::find($request->id);
                $apps = appsettings();
                $tra = $request->trans;
                return view('admin.suppliers.pay_supplier', compact('trans', 'apps', 'tra'));
            } else {
                return view('home.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('me o');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //make_payment.blade.php
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = \Carbon\Carbon::now();

        $rules = [
            'total_amount' => 'required|max:11|min:3',
            'payment_mode' => 'required'
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            $msg = 'Please cheak Your Inputs .';
            //flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        } else {

            $new_supply_payment = new SupplyAndPayment();
            $new_supply_payment->transaction_id = $request->trans;
            $new_supply_payment->supplier_id    = $request->id;
            $new_supply_payment->supply_amount  = 00;
            $new_supply_payment->invoice_no     = 00;
            $new_supply_payment->pay_amount     = $request->total_amount;
            $new_supply_payment->mode_of_payment_id  = $request->payment_mode;
            $new_supply_payment->transaction_date = $now;
            $new_supply_payment->staff_id       = Auth::user()->id;
            $new_supply_payment->deposit_b4     = $request->current_deposit;
            $new_supply_payment->credit_b4      = $request->current_credit;
            $new_supply_payment->visible        = 1;

            if ($new_supply_payment->save()) {
                $supply_payment = Supplier::find($request->id);
                if ($supply_payment->deposit > 0  &&   $supply_payment->creadit == 0) {
                    $my_deposit =   $supply_payment->deposit + $request->total_amount;
                    $my_creadit = 0;
                } elseif ($supply_payment->deposit > 0) {
                    $my_deposit = $request->total_amount +   $supply_payment->deposit;
                    $my_creadit = 0;
                } elseif ($supply_payment->deposit == 0  &&   $supply_payment->creadit == 0) {
                    $my_deposit = $request->total_amount;
                    $my_creadit = 0;
                } elseif ($supply_payment->creadit > $request->total_amount) {
                    $my_deposit = 0;
                    $my_creadit =  $supply_payment->creadit - $request->total_amount;
                } elseif ($supply_payment->creadit == $request->total_amount) {
                    $my_deposit = 0;
                    $my_creadit = 0;
                } elseif ($supply_payment->creadit > 0  &&   $supply_payment->creadit < $request->total_amount) {
                    $my_deposit = $request->total_amount -   $supply_payment->creadit;
                    $my_creadit = 0;
                }
                $supply_payment = Supplier::find($request->id);
                $supply_payment->deposit     = $my_deposit;
                $supply_payment->credit     = $my_creadit;
                if ($request->current_credit > 0) {
                    $supply_payment->credit_b4   = $request->current_credit;
                } else {
                    $supply_payment->credit_b4   = 0;
                }

                if ($request->current_deposit > 0) {
                    $supply_payment->deposit_b4  = $request->current_deposit;
                } else {
                    $supply_payment->deposit_b4  = 0;
                }
                $supply_payment->tootal_deposite  =   $supply_payment->tootal_deposite + $request->total_amount;
                $supply_payment->last_payment  =  $request->total_amount;
                if ($supply_payment->update()) {
                    $trans = Supplier::find($request->id);
                    $apps = appsettings();
                    $tra = $request->trans;
                    return view('admin.suppliers.pay_supplier', compact('trans', 'apps', 'tra'));
                }
            } else {
                $msg = 'Something is went wrong. Please try again later, information not save.';
                //flash($msg, 'danger');
                return redirect()->back()->withInput();
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


        try {

            if (Auth::user()) {
                $trans = generateTransactionId();
                $supplier = Supplier::find($id);
                $payment_mode = ModeOfPayment::whereVisible(1)->where("id", "!=", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
                return view('admin.suppliers.make_payment', compact('supplier', 'trans', 'payment_mode'));
            } else {
                return view('home.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
