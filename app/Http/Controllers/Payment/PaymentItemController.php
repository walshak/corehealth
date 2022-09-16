<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\LabService;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\PaymentType;
use App\PaymentItem;
use Auth;

class PaymentItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.payments.payment_items_list');

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
         

        $rules = [
            'item_name'          => 'required',
            'description'         => 'required',
            'amount'         => 'required',
        ];

        

        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {
                      $cheek = PaymentType::where('payment_type_name', '=', $request->payment_type_name)->first();
                     if (!empty($cheek)) {

                            $msg = 'The payment type name already exist';
                            return redirect()->back()->with('toast_warning', $msg)->withInput();

                     }
                    
                    $item                     = new PaymentItem;
                    
                    $item->payment_type_id    = $request->payment_type_id;
                    $item->item_name          = $request->item_name;
                    $item->description        = $request->description;
                    $item->amount             = $request->amount;
                    $item->visible            = 1;
                     
                if( $item->save() ) {
                    
                     if ($request->payment_type_id = 3) {
                        $lbs = LabService::where('lab_service_name', '=',$request->item_name)->first();
                        $lbs->price_assing = 1;
                        $lbs->update();

                     }
                        $msg = 'item successfully save';
                        return redirect(route('showPaymentTypeItem',$request->payment_type_id))->with('toast_success', $msg);
                   

                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch(Exception $e) {

                return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
       $payment_type = PaymentType::find($id);

        return view('admin.payments.create_payment_items', compact('payment_type'));
    }
    public function showPaymentTypeItem($id)
    {
       $payment_type = PaymentType::find($id);

        return view('admin.payments.show_payment_type_items', compact('payment_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $payment_item = PaymentItem::find($id);
        return view('admin.payments.edite_payment_items', compact('payment_item'));
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
         

        $rules = [
            'item_name'          => 'required',
            'description'         => 'required',
            'amount'         => 'required',
        ];

        

        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {
                     
                    
                    $item                     = PaymentItem::find($id);
                    
                    $item->item_name          = $request->item_name;
                    $item->description        = $request->description;
                    $item->amount             = $request->amount;
                    $item->visible            = 1;
                    
                if( $item->update() ) {
                         $msg = 'item Saved.';
                        return redirect(route('showPaymentTypeItem', $item->payment_type_id))->with('toast_success', $msg);
                   

                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
                }
            }
        } catch(Exception $e) {

                return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
     public function listPaymentTypeItems($id)
  
    {
       $pc = PaymentItem::where('payment_type_id', '=',$id)->with('paymentType')->get();
        
                return Datatables::of($pc)
                    ->addIndexColumn()
                    
                    ->editColumn('visible', function($pc){
                     return (($pc->visible == 0)?"Inactive":"Active");
                    })
                    ->editColumn('payment_type', function($pc){
                     return ($pc->paymentType->payment_type_name);
                    })
                    ->addColumn('edit', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('payment-item.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil nav-icon text-success"> </i> edit</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                        }
                    })
                   
        ->rawColumns(['visible','edit','payment_type'])

        ->make(true);
    }
      public function PaymentItemsList()
  
    {
       $pc = PaymentItem::all();
        
                return Datatables::of($pc)
                    ->addIndexColumn()
                    
                    ->editColumn('visible', function($pc){
                     return (($pc->visible == 0)?"Inactive":"Active");
                    })
                    ->editColumn('payment_type', function($pc){
                     return ($pc->paymentType->payment_type_name);
                    })
                   
        ->rawColumns(['visible','
            '])

        ->make(true);
    } 
}
