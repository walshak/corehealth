<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Customer;
use App\CustomerBudget;
use App\Transaction;
use App\CustomerType;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function __construct()
    {
        // $this->middleware('permission:customers');
        // $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        // $this->middleware(['role:Super-Admin|Admin|Customer', 'permission:customers|customer-create|customer-show|customer-edit|customer-delete']);
    }

    public function listCustomers()
    {
        $pc = Customer::where('visible', '>=', 0)->with('customer_type')->orderBy('fullname', 'ASC')->get();
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('creadit', function ($pc) {
                return (($pc->creadit) > 0) ? "<span>&#8358;</span>" . number_format($pc->creadit, 2, '.', ', ') : "<span>&#8358;</span>" . number_format($pc->creadit, 2, '.', ',');
            })
            ->editColumn('deposit', function ($pc) {

                return (($pc->deposit) == 0) ? "No Deposit" : $pc->deposit;
            })
            ->addColumn('trans', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-show')) {

                    $url =  route('customers.show', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-dark btn-sm"><i class="fa fa-list text-warning"> </i> View</a>';
                } else {

                    return '<a href="#" class="btn btn-dark btn-sm"> <i class="fa fa-circle-o text-primary"></i> View</a>';
                }
            })
            ->addColumn('payment', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('customer-payment.show', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-secondary btn-sm"><i class="fa fa-plus"> </i> Enter</a>';
                } else {

                    return '<a href="#" class="btn btn-secondary btn-sm"> <i class="fa fa-circle-o"></i> Enter</a>';
                }
            })
            ->addColumn('borrow', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('borrows.show', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-secondary btn-sm"><i class="fa fa-circle-o"> </i> Borrow</a>';
                } else {

                    return '<a href="#" class="btn btn-secondary btn-sm"> <i class="fa fa-circle-o "></i> Borrow</a>';
                }
            })
            ->addColumn('dateline', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('create-dateline-edit')) {

                    $url =  route('dateline.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-circle-o"> Set</i></a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-pencil"> Set</i></a>';
                }
            })
            ->addColumn('view', function ($pc) {


                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    $url =  route('customers.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm"><i class="fa fa-pencil"> </i></a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-pencil"></i></a>';
                }
            })
            ->rawColumns(['creadit', 'trans', 'payment', 'borrow', 'view', 'dateline'])
            ->make(true);
    }

    public function index()
    {
        //   $data = Customer::where('visible', '>=', 0)->with('customer_type')->orderBy('fullname','ASC')->get();
        //dd($data);
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            if (Auth::user()) {

                $customers     = CustomerType::whereVisible(1)->orderBy('type_name', 'asc')->pluck('type_name', 'id');
                return view('admin.customers.create', compact('customers'));
            } else {
                return view('home.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
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
        // dd($request->all());
        try {

            $rules = [
                'name'          => 'required',
                'code'          => 'required',
                'customers_'          => 'required',
                'phone'          => 'required|max:14',
                'address'          => 'required|max:200',
                'credit_limit'          => 'required'
            ];

            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {

                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {

                $mycustomer                      = new Customer();
                $mycustomer->fullname            = $request->name;
                $mycustomer->code                = $request->code;
                $mycustomer->phone               = $request->phone;
                $mycustomer->address             = $request->address;
                $mycustomer->customer_type_id    = $request->customers_;
                $mycustomer->credit_limit        = $request->credit_limit;
                $mycustomer->visible            = 1;

                if ($mycustomer->save()) {
                    $msg = 'The Client ' . $request->name . ' was saved successfully.';
                    return redirect(route('customers.index'))->with('toast_success', $msg);
                } else {

                    $msg = 'Something is went wrong. But it seems it is not your input contact the system administrator';
                    return redirect()->back()->with('toast_error', $msg)->withInput();
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.q22
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //(Request $request, $id)
    public function listcustomerTransaction(Request $request, $id)
    {
        //dd($request->all());
        $pc = Transaction::where('bank_transaction_id', "=", $id)->orderBy('id', 'desc')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', function ($pc) {
                return '<a href="' . route('transactions.show', $pc->id) . '" class="btn btn-info"><i class="fa fa-eye"></i>view</a>';
            })
            ->editColumn('budgetYear', function ($pc) {
                $budgetYear = getBudgetYearName($pc->budget_year_id);

                return $budgetYear;
            })
            ->rawColumns(['view', 'budgetYear'])
            ->make(true);
    }


    public function show($id)
    {


        try {

            //$data_buy = Transaction::where('bank_transaction_id', "=", $id)->where('transaction_type', "=",'Payment to Account')->sum('total_amount');
            // dd($data_buy);
            $customers     = Customer::find($id)->fullname;

            return view('admin.customers.customerTransaction', compact('customers', 'id'));
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    public function listcustomerDateline()
    {
        $now   = \Carbon\Carbon::now();
        $firstDay = '2010-02-01';

        $nowr      =  \Carbon\Carbon::now()->addDays(2);
        $lastDay_  =  explode(" ", $nowr);
        $lastDay   = $lastDay_[0];

        $now1      =  \Carbon\Carbon::now()->addDays(1);
        $lastDay_1  =  explode(" ", $now1);
        $lastDay1   = $lastDay_1[0];



        try {
            $data = Customer::where('creadit', ">", 0)->whereBetween('date_line',  [$firstDay, $lastDay])->orderBy('date_line', 'desc')->get();
            $credit = Customer::where('creadit', ">", 0)->sum('creadit');
            //dd($credit);


            return view('admin.customers.view_dateline', compact('data', 'lastDay', 'lastDay1', 'credit', 'now'));
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
        $data = Customer::with('customer_type')->find($id);
        // dd($data);
        $customers     = CustomerType::whereVisible(1)->orderBy('type_name', 'asc')->pluck('type_name', 'id');

        return view('admin.customers.edite', compact('data', 'customers'));
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
                'name'          => 'required|max:100',
                'code'          => 'required',
                'phone'          => 'required|max:14',
                'address'          => 'required|max:200'
            ];

            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                $msg = 'Please check Your Inputs .';
                //flash($msg, 'danger');
                return redirect()->back()->withInput()->withErrors($v);
            } else {

                //dd($request);
                $mycustomer                      =  Customer::where('id', "=", $id)->first();
                $mycustomer->fullname            = $request->name;
                $mycustomer->code                = $request->code;
                $mycustomer->phone               = $request->phone;
                $mycustomer->address             = $request->address;
                if (empty($request->customers_)) {
                    $mycustomer->customer_type_id   = $mycustomer->customer_type_id;
                } else {
                    $mycustomer->customer_type_id    = $request->customers_;
                }

                $mycustomer->credit_limit        = $request->credit_limit;
                $mycustomer->visible            = $request->visible;
                if ($mycustomer->update()) {
                    $msg = 'Client ' . $request->name . ' was updated successfully.';
                    // flash($msg, 'success');
                    return redirect(route('customers.index'))->withMessage($msg)->withMessageType('success')->with($msg);
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
