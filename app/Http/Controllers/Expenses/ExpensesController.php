<?php

namespace App\Http\Controllers\Expenses;

use Illuminate\Http\Request;
use FFI\Exception;
use App\Http\Controllers\Controller;
use App\Expense;
use App\ModeOfPayment;
use App\DailyExpense;
use Illuminate\Support\Facades\Auth;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware(['role:super-admin', 'permission:publish articles|edit articles']);
        // $this->middleware(['role:Super-Admin|Admin|Expenses', 'permission:expenses-list|expenses-create']);
        $this->middleware(['role:Super-Admin|Admin|Expenses', 'permission:expenses|expenses-create|expenses-show|expenses-edit|expenses-delete']);
    }

    public function listExpenses()
    {

        $pc = DailyExpense::where('visible', '=', 1)
                        //   ->with(['user' => function ($q) {
                        //         $q->addSelect(['id', 'surname', 'firstname', 'othername']);
                        //     }])
                          ->with('expense')
                          ->orderBy('id', 'DSC')
                          ->get();


        return Datatables::of($pc)
            ->addIndexColumn()
            // ->editColumn('user_id', function ($pc) {
            //     $fullname = $pc->surname->name . ' ' . $pc->firstname;
            //     return $fullname;
            // })
            ->editColumn('visible', function ($pc) {
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })
            ->editColumn('expense_id', function ($pc) {
                return ($pc->expense->expenses_name);
            })
            ->addColumn('view', function ($pc) {

                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('expenses-edit')) {

                    $url =  route('expenses.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-success"> <i class="fa fa-pencil"></i> View</a>';

                }else{

                    return '<a href="#" class="btn btn-info"> <i class="fa fa-pencil"></i> Admin Only</a>';
                }
            })
            ->rawColumns(['view', 'expense', 'visible'])
            ->make(true);
    }

    public function index()
    {

    try {
            return view('admin.expenses.index');

        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

           // if(Auth::user()){

                $expenses       = Expense::whereVisible(1)->orderBy('expenses_name', 'asc')->pluck('expenses_name', 'id');
                $now            = \Carbon\Carbon::now();
                $beneficiary    = User::where('visible', '=', 2)->orderBy('id', 'asc')->get(['surname','firstname','othername','id'])->pluck('name', 'id');
                $payment_mode   = ModeOfPayment::whereVisible(1)->where("id","<",5)->orderBy('id', 'asc')->get();

                return view('admin.expenses.create', compact('expenses', 'now', 'payment_mode', 'beneficiary'));
            // }else{
            //      return view('home.index');
            // }
        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
        // validation of request
        $rules = [
                    // 'name'      => 'required',
                    // 'namename'=> 'required',
                ];

        $v = validator()->make($request->all(), $rules);

        if( $v->fails() )
        {
            $msg = 'Something is wrong with your input, Please Comfirm to continue';
            flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        }

               $payLoad = json_decode($request->payload);

        $Count = 0;

        for ($i = 0; $i <= count($payLoad)-1; $i++){

            $expense = Expense::where('expenses_name', "=", $payLoad[$i]->expenses)->first()->id;

            //$payment_mode = ModeOfPayment::where('payment_mode', "=", $payLoad[$i]->payment_mode)->first()->id;

            $expens                 = new DailyExpense();
            $expens->expense_id     = $expense;
            $expens->beneficiary    = $payLoad[$i]->beneficiary;
            $expens->amount         = $payLoad[$i]->total_amount;
            $expens->mode_payment   = 1;
            $expens->visible        = 1;
            $expens->user_id        = Auth::user()->id ;


            if($expens->save()) {

                $Count++;
            }


        }  // loop end brace

        if ($Count > 1) {
            return $Count . " item(s) have been successfully uploaded! ";
        } elseif ($Count > 0 And $Count < 2){
            return $Count . " item(s) have been successfully uploaded!";
        }else {
            return "Soemthing went wrong!";
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
