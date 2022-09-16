<?php

namespace App\Http\Controllers\Transactions;

use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Sale;
use App\DailyExpense;
use Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('permission:transactions');
        // $this->middleware('permission:transaction-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:transaction-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);
        // $this->middleware(['role_or_permission:Super-Admin|Admin|transactions|transaction-create|transaction-list|transaction-show|transaction-edit|transaction-delete']);
    }

    public function listTransactions()
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);

        if (Auth::user()->hasRole(['Super-Admin'])) {

            $pc = Transaction::with('mode_of_payment')->with('hmo')->orderBy('tr_date', 'DESC')->get();
        } elseif (Auth::user()->hasRole(['Admin', 'Sales-Admin'])) {

            $pc = Transaction::with('mode_of_payment')->with('hmo')->orderBy('tr_date', 'DESC')->get();
        } else {
            # code...
            $pc = Transaction::Where('staff_id', '=', Auth::user()->id)->with('mode_of_payment')->with('hmo')->orderBy('tr_date', 'DESC')->get();
        }

        //dd($pc);


        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', function ($pc) {

                if (Auth::user()->hasPermissionTo('transaction-show') || Auth::user()->hasRole(['Super-Admin', 'Admin', 'Transaction'])) {
                    # code...
                    $url = route('transactions.show', $pc->transaction_no);
                    return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>';
                    //return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i> view</a>';
                } else {
                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-pencil"></i> View</button>';
                    return $label;
                }
            })
            ->editColumn('mode', function ($pc) {
                return (($pc->mode_of_payment->payment_mode >= 0) ? $pc->mode_of_payment->payment_mode : " ");
            })
            ->editColumn('transaction_type', function ($pc) {
                if(is_numeric($pc->transaction_type)){
                    $ty = DB::select("SELECT * FROM `payment_items` WHERE `id` = :type",array('type'=>$pc->transaction_type))[0]->item_name;
                    return $ty;
                }else{
                    return $pc->transaction_type;
                }
            })
            ->editColumn('hmo_id', function ($pc) {
                return $pc->hmo->name ?? 'N/A';
            })
            ->editColumn('mode_of_payment_id', function ($pc) {
                return $pc->mode_of_payment->payment_mode;
            })
            ->rawColumns(['view', 'mode', 'store_id'])
            ->make(true);
    }

    public function listTodaySalesProduct(request $request, $id)
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);
        $pc = Sale::where('sale_date', 'LIKE', '%' .  $datte[0] . '%')->with('transaction', 'product', 'store')->orderBy('id', 'DESC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', '<a href="{{ route(\'transactions.edit\', $id)}}" class="btn btn-success" ><i class="fa fa-street-view"></i> View</a>')
            ->editColumn('product', function ($pc) {
                return ($pc->product->product_name);
            })
            ->editColumn('store', function ($pc) {
                return (($pc->store->store_name >= 0) ? $pc->store->store_name : " ");
            })
            ->editColumn('trans', function ($pc) {
                return (($pc->transaction->transaction_no >= 0) ? $pc->transaction->transaction_no : " ");
            })
            ->editColumn('customer', function ($pc) {
                return (($pc->transaction->customer_name >= 0) ? $pc->transaction->customer_name : " ");
            })
            ->rawColumns(['view', 'product', 'store', 'trans', 'customer'])
            ->make(true);
    }

    public function daylistTransactions(Request $request)
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);
        $pc = Transaction::with(['users', 'mode_of_payment'])->where('id', '>', 0)->orderBy('id', 'DESC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('staff_id', function ($pc) {
                $staff_id = $pc->users->surname . ' ' . $pc->users->firstname;
                return $staff_id;
            })
            ->editColumn('date', function ($pc) {
                $date = explode(" ", $pc->tr_date);
                $dateMain = $date[0];

                return $dateMain;
            })
            ->editColumn('transType', function ($pc) {
                $transType = ucwords($pc->transaction_type);
                return $transType;
            })
            ->editColumn('budgetYear', function ($pc) {
                $budgetYear = getBudgetYearName($pc->budget_year_id);

                return $budgetYear;
            })
            ->editColumn('paymentMode', function ($pc) {
                $paymentMode = ucwords($pc->mode_of_payment->payment_mode);
                return $paymentMode;
            })
            ->addColumn('view', function ($pc) {
                // return '<a href="' . route('transactions.show', $pc->id) . '" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i> view</a>';
                return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i> view</a>';
            })
            ->rawColumns(['staff_id', 'date', 'transType', 'view', 'paymentMode', 'budgetYear'])
            ->make(true);
    }
    public function listTerminustSupply()
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);

        $pc = Sale::where('user_id', '=', Auth::user()->id)->with('transaction', 'product', 'store')->orderBy('id', 'DESC')->get();

        // dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', function ($pc) {
                $url =  route("transactions.show", $pc->transaction->transaction_no);
                return '<a href="' . $url . '" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>';
            })
            ->editColumn('product', function ($pc) {
                return ($pc->product->product_name);
            })
            ->editColumn('store', function ($pc) {
                return (($pc->store->store_name >= 0) ? $pc->store->store_name : " ");
            })
            ->editColumn('trans', function ($pc) {
                return (($pc->transaction->transaction_no >= 0) ? $pc->transaction->transaction_no : " ");
            })
            ->editColumn('customer', function ($pc) {
                return (($pc->transaction->customer_name >= 0) ? $pc->transaction->customer_name : " ");
            })
            ->rawColumns(['view', 'product', 'store', 'trans', 'customer'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);
        // dd($datte);
        $data = Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->with('mode_of_payment')->with('store')->orderBy('id', 'DESC')->get();

        //1***********saless
        $sales = Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->where('transaction_type', '=', 'sales')->sum('total_amount');

        //2****************Cash
        $sumCash  = Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->where('mode_of_payment_id', '=', 1)->where('transaction_type', '!=', 'Borrow')->sum('total_amount');

        //3*********************bank
        $sumbank  = Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->where('mode_of_payment_id', '=', 2)->orWhere('mode_of_payment_id', '=', 3)->orWhere('mode_of_payment_id', '=', 4)->sum('total_amount');

        //4*********************payment to credit Account
        $sumpayment  =  Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->where('transaction_type', '=', 'Payment to Account')->sum('total_amount');

        //4*********************payment to credit Account
        $sumBorrow  =  Transaction::where('tr_date', 'LIKE', '%' .  $datte[0] . '%')->where('transaction_type', '=', 'Borrow')->sum('total_amount');

        //5*********************daily_expenses
        $sumexpense  =  DailyExpense::where('created_at', 'LIKE', '%' .  $datte[0] . '%')->sum('amount');

        //5*********************daily_expenses
        $sumgain  =  Sale::where('created_at', 'LIKE', '%' .  $datte[0] . '%')->sum('gain');

        // dd($sumgain);

        $sumexpenseCashpaymend  =  DailyExpense::where('created_at', 'LIKE', '%' .  $datte[0] . '%')->where('mode_payment', '=', 1)->sum('amount');

        $cash_at_hand = (($sumCash - $sumexpenseCashpaymend) - $sumBorrow);
        $sum = 0;
        //dd($data1);
        foreach ($data as $datas) {
            $sum += $datas->total_amount;
        }
        // dd($sumgain);
        return view('admin.transactions.today_sales', compact('now', 'sum', 'sales', 'sumCash', 'sumbank', 'sumpayment', 'sumexpense', 'cash_at_hand', 'sumBorrow', 'sumgain'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.transactions.index');
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
        return view('admin.transactions.transactions');
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
            $trans = Transaction::whereId($id)->first() ?? Transaction::where('transaction_no',$id)->first();
            //dd($trans);

            if ($trans->transaction_type == 'sales') {
                $msg = 'Receipt Available';
                return redirect(route('receipt.show', $trans->id))->withMessage($msg)->withMessageType('success')->with($msg);
            } elseif ($trans->transaction_type == 'Payment to Account') {
                $apps = appsettings();
                return view('admin.customers.customerPayment', compact('trans', 'apps'));

            }elseif($trans->transaction_type == 'Registration Fee'){

                return redirect()->route('hospital-receipts.show',$trans->transaction_no);

            } else {
                $apps = appsettings();
                return view('admin.customers.customerBorrow', compact('trans','apps'));
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

        try {

            $now = \Carbon\Carbon::now();
            $datte = explode(" ", $now);
            $data = Sale::where('sale_date', 'LIKE', '%' .  $datte[0] . '%')->with('transaction', 'product', 'store')->orderBy('id', 'DESC')->get();
            return view('admin.transactions.today_sales_product', compact('now', 'id'));
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

        $sales = Transaction::where('id', "=", $id)->delete();
        return redirect()->route('sales');
    }
    public function terminustSupply()
    {
        return view('admin.transactions.terminust_supply');
    }
}
