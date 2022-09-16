<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Supplier;
use App\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listSuppliers()
    {
        // $list = GraduantsList::where('has_corrected_name', '=', 1)->where('signature', '=', 0)->where('caligrapher', '=', 0)->with(['programme', 'session'])->orderBy('reg_number')->get();
        $list = Supplier::orderBy('company_name', 'DESC')->get();

        // dd($list);
        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('visible', function ($list) {
                return (($list->visible == 0) ? "<span class='badge badge-default'>No</span>" : "<span class='badge badge-success'>Yes</span>");
            })

            ->addColumn('view_invoice',   '<a href="{{ route(\'suppliers.edit\', $id)}}" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>')
            ->addColumn('view_payment',   '<a href="{{ route(\'showListsupplierPayment\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> View</a>')
            ->addColumn('make_payment',   '<a href="{{ route(\'pay_supplier.show\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> View</a>')
            ->addColumn('create_invoice',   '<a href="{{ route(\'invoices.show\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> Create</a>')
            ->addColumn('view',   '<a href="{{ route(\'suppliers.show\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> View</a>')
            // ->addColumn('process',   '<button type="button" class="edit-modal btn btn-info btn-xs" data-toggle="modal" data-id="{{$id}}" data-caligrapher="{{$caligrapher}}" ><i class="fa fa-pencil"></i> Process</button>')
            // ->addColumn('process', '<button type="button" class="delete-modal btn btn-info btn-xs" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-pencil"></i> Process</button>')
            ->rawColumns(['view_invoice', 'view_payment', 'visible', 'make_payment', 'create_invoice', 'view'])
            ->make(true);
    }


    public function index()
    {
        // $data = Supplier::orderBy('company_name','DESC')->get();
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suppliers.create');
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
            'company_name'      => 'bail|required|unique:suppliers|max:200',
            'address'           => 'required|max:200',
            'phone'             => 'required|max:15',
            'last_payment'      => 'required',
            'last_payment_date' => 'required',
            'last_buy_date'     => 'required',
            'last_buy_amount'   => 'required',
            'credit'            => 'required',
            'deposit'           => 'required',
            'date_line'         => 'required',
        ];

        try {
            $v = Validator::make($request->all(), $rules);
            // dd($v);
            if ($v->fails()) {

                // alert()->error($v->messages()->all()[0])->toToast('top-right');
                return back()->with('errors', $v->messages()->all()[0])->withInput();

                // return redirect()->back()->withInput()->withErrors($v);
                //  return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                // alert()->question('We love cookies, whats about you?', '')->toToast('bottom-right')->showConfirmButton('Accept', '#3085d6')->persistent(false, true);

            } else {

                $mysupplier                     = new Supplier();
                $mysupplier->company_name       = $request->company_name;
                $mysupplier->address            = $request->address;
                $mysupplier->phone              = $request->phone;
                $mysupplier->created_by         = Auth::user()->id;
                $mysupplier->last_payment       = $request->last_payment;
                $mysupplier->last_payment_date  = $request->last_payment_date;
                $mysupplier->last_buy_amount    = $request->last_buy_amount;
                $mysupplier->credit             = $request->credit;
                $mysupplier->deposit            = $request->deposit;
                $mysupplier->date_line          = $request->date_line;
                $mysupplier->visible            = 1;

                if ($mysupplier->save()) {
                    $msg = 'Supplier name for ' . $request->company_name . ' was saved successfully.';
                    // flash($msg, 'success');
                    alert()->success($msg)->toToast('top-right');
                    return redirect(route('suppliers.index'))->withMessage($msg)->withMessageType('success')->with($msg);
                } else {
                    $msg = 'Something is went wrong. Please try again later, information not save.';
                    //flash($msg, 'danger');
                    return redirect()->back()->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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


            $supplier = Supplier::whereId($id)->first();

            return view('admin.suppliers.show', compact('supplier'));
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
        $data = Invoice::whereSupplier_id($id)->with('supplier')->get();
        $company_name = Supplier::whereId($id)->first();
        return view('admin.suppliers.suppliers_invoice', compact('data', 'company_name'));
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
        try {
            // $rules = [
            //             'company_name' => 'required|max:200',
            //             'address' => 'required|max:200',
            //             'phone' => 'required|max:24'
            //         ];

            //  $v = validator()->make($request->all(), $rules);

            //  if( $v->fails() )
            //  {
            //      $msg = 'Please cheak Your Inputs .';
            //      //flash($msg, 'danger');
            //      return redirect()->back()->withInput()->withErrors($v);

            //  } else {

            $mysupplier =  Supplier::whereId($id)->first();
            $mysupplier->company_name          = $request->company_name;
            $mysupplier->address               = $request->address;
            $mysupplier->phone                 = $request->phone;
            $mysupplier->last_payment          = $request->last_payment;
            $mysupplier->last_payment_date     = $request->last_payment_date;
            $mysupplier->last_buy_date         = $request->last_buy_date;
            $mysupplier->last_buy_amount       = $request->last_buy_amount;
            $mysupplier->credit                = $request->credit;
            $mysupplier->deposit               = $request->deposit;
            $mysupplier->date_line             = $request->date_line;
            $mysupplier->visible               = $request->visible;

            if ($mysupplier->update()) {
                $msg = 'Supplier ' . $request->company_name . ' was Updated successfully.';
                alert()->success($msg)->toToast('top-right');
                return redirect(route('suppliers.index'))->withMessage($msg)->withMessageType('success')->with($msg);
            } else {
                $msg = 'Something is went wrong. Please try again later, information not save.';
                alert()->error($msg)->toToast('top-right');
                return redirect()->back()->withInput();
            }
            // }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
