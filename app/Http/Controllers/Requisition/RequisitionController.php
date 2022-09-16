<?php

namespace App\Http\Controllers\Requisition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Stock;
use App\Sale;
use App\Category;
use App\Product;
use App\Transaction;
use App\Customer;
use App\Dependant;
use App\Price;
use App\Store;
use App\Promotion;
use App\PromoSale;
use App\ModeOfPayment;
use App\StoreStoke;
use App\Requisition;
use App\RequisitionRequest;
use App\MedicalReport;
use App\Patient;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class RequisitionController extends Controller
{
    public function listDepartmentRequest($id)
    {

        $list = RequisitionRequest::with('product', 'requisition')->where('requisition_id', '=', $id)->get();
        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('productName', function ($list) {
                $productName = $list->product->product_name;
                return $productName;
            })
            ->addColumn('edit', '<button type="button" class="edit-modal btn btn-primary btn-sm" data-toggle="modal" data-id="{{$id}}" ><i class="fa fa-pencil"></i> </button>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> </button>')
            ->rawColumns(['productName', 'edit', 'delete'])
            ->make(true);
    }

    public function createSaleRequest(Request $request)
    {
        $rules = [
            'patient_id'  => 'required',
            'service_description'  => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {
                if ($request->patient_id != 'not-apply') {
                    $report                            = new MedicalReport;
                    $report->user_id                   = $request->patient_id;
                    $report->doctor_id                 = Auth::user()->id;
                    $report->pharmacy_id               = 0;
                    $report->nurse_id                  = 0;
                    $report->transaction_no            = generateTransactionId();
                    $report->pateintDiagnosisReport    = $request->service_description;
                    $report->nurseContent_status       = 0;
                    $report->nurseContent              = "";
                    $report->pharmacy_status           = 1;
                    $report->pharmacy                  = 'By Pharmacy: ' . $request->service_description;
                    $report->visible                   = 1;
                } else {
                    $report                            = new MedicalReport;
                    $report->user_id                   = 44;
                    $report->doctor_id                 = Auth::user()->id;
                    $report->pharmacy_id               = 0;
                    $report->nurse_id                  = 0;
                    $report->transaction_no            = generateTransactionId();
                    $report->pateintDiagnosisReport    = $request->service_description;
                    $report->nurseContent_status       = 0;
                    $report->nurseContent              = "";
                    $report->pharmacy_status           = 1;
                    $report->pharmacy                  = 'By Pharmacy: ' . $request->service_description;
                    $report->visible              = 1;
                }

                if ($report->save()) {
                    $msg = 'Pharmacy Request created Successfuly...';
                    return redirect()->back()->with('toast_success', $msg);
                } else {
                    $msg = 'Something is went wrong. Please try again later, Request not Saved.';
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    public function listRequest()
    {

        $list = MedicalReport::where('pharmacy_status', '=', 1)->orderBy('created_at', 'DESC')->get();
        //dd($list);
        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('patient', function ($list) {
                if(null == $list->dependant_id){
                    $fullname =  userfullname($list->user_id);
                }else{
                    $dependant = Dependant::find($list->dependant_id);
                    $fullname = $dependant->fullname;
                }
                return $fullname;
            })
            // ->addColumn('account', function ($list) {
            //     if($list->user->id != 44){
            //         $patient = Patient::where('user_id', '=', $list->user->id)->first();
            //         // dd($patient);
            //         if(null != $patient->account_type_id){
            //             $account = $patient->account_type->account_type_name;
            //             //dd($account);
            //             return $account;
            //         }else{
            //             return "N/A";
            //         }
            //     }else{
            //         return "N/A";
            //     }
            // })

            ->addColumn('process', function ($list) {

                // if (Auth::user()->hasPermissionTo('sales') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                if ($list->dependant_id == null) {
                    $url = route('newSale', $list->id);
                    return '<a href="' . $url . '" class="btn btn-secondary btn-sm"><i class="fa fa-i-cursor"></i> Process</a>';
                } else {
                    $url = route('newSale', [$list->id,$list->dependant_id]);
                    return '<a href="' . $url . '" class="btn btn-secondary btn-sm"><i class="fa fa-i-cursor"></i> Process</a>';
                }
                // } else {

                //     $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-i-cursor"></i> Process</button>';
                //     return $label;
                // }


            })
            ->rawColumns(['patient', 'process', 'account'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->customer_id;
        $transi = Requisition::where('customer_id', '=', $id)->where('status', '=', 0)->first();
        //dd($transi);
        if (!empty($transi)) {
            $customer = Customer::find($transi->customer_id);
            return view('admin.requisitions.index', compact('transi', 'customer'));
        } else {
            return redirect(route('home'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_cheak = Stock::where('current_quantity', ">", 0)->get();
        foreach ($stock_cheak as $stock) {
            $assing_stock = Product::find($stock->product_id);
            $assing_stock->stock_assign = 1;
            $assing_stock->current_quantity = $stock->current_quantity;
            $assing_stock->update();
        }


        if (Auth::user()) {

            $id = Auth::user()->customer_id;
            $transi = Requisition::where('customer_id', '=', $id)->where('status', '=', 0)->first();

            if (!empty($transi)) {
                $customer = Customer::find($transi->customer_id);
                return view('admin.requisitions.index', compact('transi', 'customer'));
            }

            $customer       = Customer::find(Auth::user()->customer_id);

            $products       = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
            $myproducts     = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();
            $trans          = generateTransactionId();
            $stores         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
            $storek         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->get();
            $mycustomer     = Customer::find(Auth::user()->customer_id);
            $category       = Category::where('status_id', '=', 2)->pluck('category_name', 'id')->all();

            return view('admin.requisitions.create', compact('products', 'myproducts', 'customer', 'trans', 'customer', 'stores', 'storek', 'category'));
        } else {

            return view('home.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);


        $cheak_transaction_no = Requisition::where('transaction_no',  '=', $request->trans)->first();
        if (!empty($cheak_transaction_no)) {
            //***Dont Removed the DD**\\
            dd('transaction_no   already exist in our record go back and  refresh for new transaction_no ');
            //***Dont Removed the DD**\\
        }
        $payLoad = json_decode($request->payload);

        // dd($payLoad);

        $requisitions = new Requisition();

        $requisitions->customer_id     = Auth::User()->customer_id;
        $requisitions->transaction_no  = $request->trans;
        $requisitions->request_user_id = Auth::User()->id;
        $requisitions->total_amount    = 0;
        $requisitions->approve_user_id = 0;
        $requisitions->status          = 0;
        $requisitions->request_date    = $datte[0];
        $requisitions->aprove_date     = 0;
        $requisitions->visible         = 1;

        if ($requisitions->save()) {
            $requisition_id = Requisition::where('transaction_no',  '=', $request->trans)->first();

            $Count = 0;
            for ($i = 0; $i <= count($payLoad) - 1; $i++) {
                $product_id  = Product::whereProduct_name($payLoad[$i]->product)->first()->id;
                $new_request                 = new RequisitionRequest();
                $new_request->product_id     = $product_id;
                $new_request->requisition_id = $requisition_id->id;
                $new_request->price          = $payLoad[$i]->price;
                $new_request->total_amount   = $payLoad[$i]->total_amount;
                $new_request->quantity       = $payLoad[$i]->quantity;
                $new_request->status         = 0;
                $new_request->visible        = 1;
                $new_request->save();

                $Count++;
            }  // loop end brace
            $sum = RequisitionRequest::where('requisition_id', '=', $requisition_id->id)->sum('total_amount');
            //dd($sum );
            $total_amount = Requisition::find($requisition_id->id);
            $total_amount->id           = $requisition_id->id;
            $total_amount->total_amount = $sum;
            $total_amount->update();

            $urlIndex = route('requisitions.index');
            $urlEdit = route('requisitions.show', $requisition_id->id);

            $btnIndex = '<a href="' . $urlIndex . '" class="btn btn-secondary btn-sm"><i class="fa fa-i-cursor"></i> View Request</a>';
            $btnEdit = '<a href="' . $urlEdit . '" class="btn btn-dark btn-sm"><i class="fa fa-i-cursor"></i> Edit Request</a>';

            if ($Count > 1) {
                return $Count . " item(s) uploaded successfully! " . " " . $btnIndex . " | " . $btnEdit;
                return view('admin.sales.invoice_buton', compact('trans'));
            } elseif ($Count > 0 and $Count < 2) {
                return $Count . " item(s) uploaded successfully! " . " " . $btnIndex . " | " . $btnEdit;
            } else {
                return "Soemthing went wrong!";
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
        $transi = Requisition::where('id', '=', $id)->with('customer')->first();

        if (empty($transi)) {

            $msg = "No item found create new request";
            return redirect(route('requisitions.index'))->with('toast_success', $msg);
        }

        return view('admin.requisitions.show', compact('transi'));
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
        $now = \Carbon\Carbon::now();

        $approve = Requisition::find($id);
        $approve->id = $id;
        $approve->aprove_date = $now;
        $approve->approve_user_id = Auth::user()->id;
        $approve->visible = 2;
        $approve->update();
        $msg = 'Request Successfully Approved.';

        return redirect(route('requisitions.index', $id))->with('toast_success', $msg);
    }

    public function editRequest($id, $qt)
    {

        if ($qt < 1) {
            $msg = 'Enter Valid  Quantity for the item.';
            return redirect(route('requisitions.show', $id))->with('toast_success', $msg);
        }

        $new_request               = RequisitionRequest::find($id);
        $new_request->id           = $id;


        $new_request->total_amount = $qt * $new_request->price;
        $new_request->quantity     = $qt;
        $new_request->update();

        if ($new_request->update()) {

            $getSumFromRequisitionRequest = RequisitionRequest::find($id)->sum('total_amount');

            $requisition =  Requisition::find($new_request->requisition_id);
            $requisition->total_amount = $getSumFromRequisitionRequest;
            $requisition->save();
        }

        return redirect(route('requisitions.show', $id))->with('toast_success');
    }

    public function destroyRequest($id)
    {

        $recs = RequisitionRequest::where('requisition_id', '=', $id)->get();
        foreach ($recs as $rec) {
            $rec->delete();
        }
        $requis              = Requisition::find($id);
        $requis->delete();
        return redirect(route('requisitions.create', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $new_request              =  RequisitionRequest::find($id);

        $dbAmount = $new_request->total_amount;

        $requisition =  Requisition::find($new_request->requisition_id);
        $requisition->id = $requisition->id;
        $requisition->total_amount = $requisition->total_amount - $dbAmount;
        $requisition->update();
        $new_request->delete();

        $check = RequisitionRequest::where('requisition_id', '=', $requisition->id)->first();

        if (empty($check)) {
            $requisition->delete();

            $msg = "No Item Found create new request";
            return redirect(route('requisitions.create'))->with('toast_success', $msg);
        }

        return redirect(route('requisitions.show', $id))->with('toast_success');
    }

    public function requisitionReceipt($id)
    {
        $reqRequest = RequisitionRequest::where('requisition_id', '=', $id)
            ->with([
                'product',
                'requisition' => function ($query) {
                    $query->with(['customer']);
                }
            ])->get();

        return view('admin.requisitions.receipt', compact('reqRequest'));
    }
    public function myformpriceAdd($id, $k)
    {

        //dd();
        $product = RequisitionRequest::where('requisition_id', '=', $k)->where('product_id', '=', $id)->first();
        if (!empty($product)) {
            $msg = 'Record Found';
            //return redirect(back())->with('toast_warning', $msg);
            // return json_encode($msg);
            return response()->json(['msg' => $msg]);
            //exit();

        } else {
            $data  = Price::whereProduct_id($id)->with('product', 'stock')->first();


            return json_encode($data);
        }
    }


    public function addItems()
    {

        $id = Auth::user()->customer_id;
        $transi = Requisition::where('customer_id', '=', $id)->where('status', '=', 0)->first();

        //dd($transi);
        if (!empty($transi)) {
            $customer = Customer::find($transi->customer_id);
            $list           = RequisitionRequest::with('product')->where('requisition_id', '=', $transi->id)->get();
            $category       = Category::where('status_id', '=', 2)->pluck('category_name', 'id')->all();
            $products       = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
            $myproducts     = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();
            $trans          = $transi->transaction_no;
            $stores         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
            $storek         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->get();


            return view('admin.requisitions.add_items', compact('myproducts', 'products', 'transi', 'customer', 'category', 'trans', 'stores', 'storek', 'list'));
        } else {
            return redirect(route('home'));
        }
    }
    public function saveAddItems(Request $request)
    {
        //dd($request);
        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);
        $payLoad = json_decode($request->payload);

        $requisition_id = Requisition::where('transaction_no',  '=', $request->trans)->first();
        if (!empty($requisition_id)) {



            $Count = 0;
            for ($i = 0; $i <= count($payLoad) - 1; $i++) {
                $product_id  = Product::whereProduct_name($payLoad[$i]->product)->first()->id;
                $new_request                 = new RequisitionRequest();
                $new_request->product_id     = $product_id;
                $new_request->requisition_id = $requisition_id->id;
                $new_request->price          = $payLoad[$i]->price;
                $new_request->total_amount   = $payLoad[$i]->total_amount;
                $new_request->quantity       = $payLoad[$i]->quantity;
                $new_request->status         = 0;
                $new_request->visible        = 1;
                $new_request->save();

                $Count++;
            }  // loop end brace
            $sum = RequisitionRequest::where('requisition_id', '=', $requisition_id->id)->sum('total_amount');
            //dd($sum );
            $total_amount = Requisition::find($requisition_id->id);
            $total_amount->id           = $requisition_id->id;
            $total_amount->total_amount = $sum;
            $total_amount->update();

            $urlIndex = route('requisitions.index');
            $urlEdit = route('requisitions.show', $requisition_id->id);

            $btnIndex = '<a href="' . $urlIndex . '" class="btn btn-secondary btn-sm"><i class="fa fa-i-cursor"></i> View Request</a>';
            $btnEdit = '<a href="' . $urlEdit . '" class="btn btn-dark btn-sm"><i class="fa fa-i-cursor"></i> Edit Request</a>';

            if ($Count > 1) {
                return $Count . " item(s) uploaded successfully! " . " " . $btnIndex . " | " . $btnEdit;
                return view('admin.sales.invoice_buton', compact('trans'));
            } elseif ($Count > 0 and $Count < 2) {
                return $Count . " item(s) uploaded successfully! " . " " . $btnIndex . " | " . $btnEdit;
            } else {
                return "Soemthing went wrong!";
            }
        }
    }
}
