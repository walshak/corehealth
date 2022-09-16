<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FFI\Exception;
use App\ApplicationStatu;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\PaymentType;

use Auth;

class PaymentTypeController extends Controller
{  
     public function listPaymentTypes()
  
    {
       $pc = PaymentType::all();
        
                return Datatables::of($pc)
                    ->addIndexColumn()
                    
                    ->editColumn('visible', function($pc){
                     return (($pc->visible == 0)?"Inactive":"Active");
                    })
                    ->addColumn('edit', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('payment-type.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil nav-icon text-success"> </i> edit</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                        }
                    })
                    ->addColumn('addPaymentItem', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('payment-item.show', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add Items</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Add Items</a>';
                        }
                    })
                    ->addColumn('viewPaymentItem', function($pc){

                            $url =  route('showPaymentTypeItem', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-eye nav-icon text-warning"> </i> View Items </a>';
                        
                    })
        ->rawColumns(['visible','edit','addPaymentItem','viewPaymentItem'])

        ->make(true);
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payments.payment_types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.payments.create_payment_type');
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
            'payment_type_name'          => 'required',
            'description'         => 'required',
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

                            $msg = 'The payment_type_name already  Exist';
                            return redirect()->back()->with('toast_warning', $msg)->withInput();

                     }
                    
                    $type                     = new PaymentType;
                    // dd($type);
                    $type->payment_type_name  = $request->payment_type_name;
                    $type->description        = $request->description;
                    $type->visible            = 1;
                     $msg = 'type Saved.';
                if( $type->save() ) {
                        return redirect(route('payment-type.index'))->with('toast_success', $msg);
                   

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $payment_type = PaymentType::find($id);
        return view('admin.payments.edite_payment_type', compact('payment_type'));
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
            'payment_type_name'    => 'required',
            'description'         => 'required',
        ];

        

        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {
                     
                    
                    $type                     = PaymentType::find($id);
                    // dd($type);
                    $type->payment_type_name  = $request->payment_type_name;
                    $type->description        = $request->description;
                    $type->visible            = 1;
                     
                if( $type->update() ) {
                    $msg = 'type Saved.';
                        return redirect(route('payment-type.index'))->with('toast_success', $msg);
                   

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
}
