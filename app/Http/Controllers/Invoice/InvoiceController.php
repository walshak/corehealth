<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use FFI\Exception;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Invoice;
use App\Supplier;
use App\Product;
use App\StockOrder;
use App\Status;
use Auth;
// use Illuminate\Auth;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listInvoices()
    {
        $invoice = Invoice::with('supplier')->orderBy('invoice_date', 'ASC')->get();

        // dd($invoice);
        return Datatables::of($invoice)
            ->addIndexColumn()
            ->editColumn('supplier_id', function ($invoice) {
                $supplier_name = $invoice->supplier->company_name;
                return $supplier_name;
            })
            ->addColumn('total_amount', function ($invoice) {
                return formatMoney($invoice->total_amount);
            })
            ->addColumn('visible', function ($invoice) {
                $urlOne = route('stock-order.show', $invoice->id);
                $urlTwo = route('stocks.show', $invoice->id);
                $one = '<a class="btn btn-primary btn-xs" title="edit" href="' . $urlOne . '"><i class="fa fa-pencil text-warning"></i> Enter</a>';
                $two = '<a class="btn btn-default btn-xs" title="edit" href="' . $urlTwo . '"><i class="fa fa-eye text-warning"></i> View</a>';

                // $url =  route('users.show', $user->id);
                // return '<a href="' . $url . '" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>';

                return (($invoice->visible == 1) ? $one : $two);
            })
            ->addColumn('show',   '<a href="{{ route(\'invoices.show\', $id)}}" class="btn btn-success btn-xs" ><i class="fa fa-eye"></i> Show</a>')
            ->addColumn('edit',   '<a href="{{ route(\'invoices.edit\', $id)}}" class="btn btn-info btn-xs" ><i class="fa fa-pencil"></i> Edit</a>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> Delete</button>')
            ->rawColumns(['total_amount', 'visible', 'show', 'edit', 'delete'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Invoice::with('supplier')->orderBy('visible','ASC')->get();

        return view('admin.invoices.index');
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
            'company_id'         => 'required',
            'invoice_no'         => 'required|max:100|unique:invoices',
            'number_of_products' => 'required|max:3',
            'invoice_date'       => 'required|max:11',
            'total_amount'       => 'required|max:11',
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            alert()->error($v->messages()->all()[0])->toToast('top-right');
            return redirect()->back()->withInput()->withErrors($v);
        } else {
            // dd($request);
            $myinvoice                    = new Invoice();
            $myinvoice->invoice_no        = $request->invoice_no;
            $myinvoice->number_of_products = $request->number_of_products;
            $myinvoice->invoice_date      = $request->invoice_date;
            $myinvoice->total_amount      = $request->total_amount;
            $myinvoice->supplier_id       = $request->company_id;
            $myinvoice->created_by         = Auth::user()->id;


            $myinvoice->visible            = 1;
            if ($myinvoice->save()) {
                $msg = 'invoice name for ' . $request->invoice_name . ' was saved successfully.';
                // flash($msg, 'success');
                return redirect(route('invoices.index'))->withMessage($msg)->withMessageType('success')->with($msg);
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
        $supplier = Supplier::whereId($id)->first();
        return view('admin.invoices.create', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $options = Status::whereVisible(1)->get();
            $invoice = Invoice::whereId($id)->with('supplier')->first();

            return view('admin.invoices.edit', compact('invoice', 'options'));
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }
    public function print_invoice($id)
    {
        try {


            $invoice = Invoice::whereId($id)->with('supplier')->first();
            $other_lists = StockOrder::where('invoice_id', '=', $id)->with('product')->get();
            $user = User::find($invoice->created_by);
            //dd($user);
            //dd($invoice);
            //dd($other_lists);
            return view('admin.invoices.print_invoice', compact('invoice', 'other_lists', 'user'));
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
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
            $rules = [
                'company_id'         => 'required|max:11',
                'invoice_no'         => 'required|max:100|unique:invoices',
                'number_of_products' => 'required|max:3',
                'invoice_date'       => 'required|max:11',
                'total_amount'       => 'required|max:11',
            ];

            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                $msg = 'Please cheak Your Inputs .';
                //flash($msg, 'danger');
                return redirect()->back()->withInput()->withErrors($v);
            } else {
                // dd($request);
                $myinvoice                    =  Invoice::whereId($id)->first();
                $myinvoice->invoice_no        = $request->invoice_no;
                $myinvoice->number_of_products = $request->number_of_products;
                $myinvoice->invoice_date      = $request->invoice_date;
                $myinvoice->total_amount      = $request->total_amount;


                $myinvoice->visible            = $request->visible;
                if ($myinvoice->save()) {
                    $msg = 'invoice name for ' . $request->invoice_name . ' was saved successfully.';
                    // flash($msg, 'success');
                    return redirect(route('invoices.index'))->withMessage($msg)->withMessageType('success')->with($msg);
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
