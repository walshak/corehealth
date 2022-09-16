<?php

namespace App\Http\Controllers\Ledges;

use Illuminate\Http\Request;
use FFI\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\StockOrder;
use App\Sale;
use App\Product;
use App\StokeLedge;
use App\InitialStock ;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon;

class StockLedgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @retur \Illuminate\Http\Response
     */

    public function lisDayliStockLedge($id)
    {


        $today_ledger = StokeLedge::where('ledge_date', 'LIKE','%'.$id. '%')
                                    ->with(['product'])
                                    ->join('products', 'products.id', '=', 'stock_ledges.product_id')
                                    ->orderBy('products.product_name', 'ASC')
                                    ->get();


        return Datatables::of($today_ledger)
            ->addIndexColumn()
            ->editColumn('product', function($today_ledger){
                return ($today_ledger->product->product_name);
            })
            ->editColumn('user', function($today_ledger){
                return (userfullname($today_ledger->product->user_id));
            })
            ->addColumn('date', function($today_ledger){
                return \Carbon\Carbon::parse($today_ledger->ledge_date)->format('d-m-Y');
            })
            ->addColumn('view_incoming', function($today_ledger){
                return '<a href="' . route('viewIncoming', $today_ledger->id) .'" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> In</a>';
            })
            ->addColumn('view_outgoing', function($today_ledger){
                return '<a href="' . route('viewOutgoing', $today_ledger->id) .'" class="btn btn-warning btn-sm"><i class="fa fa-eye"> </i> Out</a>';
            })
            ->rawColumns(['product','view_incoming','view_outgoing','user', 'date'])
            ->make(true);
    }

    public function ListIncoming($id)
    {
        $today_ledger = StokeLedge::find($id);

        $stocks = StockOrder::where('product_id', '=', $today_ledger->product_id)
                            ->where('stock_date',  '=',  $today_ledger->ledge_date)
                            ->with('product')
                            ->get();

             return Datatables::of($stocks)
             ->addIndexColumn()
             ->editColumn('product', function($stocks){
                return ($stocks->product->product_name);
            })
            ->rawColumns(['product'])
            ->make(true);
    }

    public function viewIncoming($id)
    {
            
         try {
                                    
            if(Auth::user()){
                
                 $ledger = StokeLedge::find($id);
                 
                $date = $ledger->ledge_date;

           $stock = StockOrder::where('product_id', '=', $ledger->product_id)
            ->where('stock_date', '=',  $ledger->ledge_date)->with('product')->sum('order_quantity');

                return view('admin.stock_ledges.view_incoming', compact('id','date','stock'));
            }else{
                 return view('home.index');
             }
        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
        }
    }

    public function ListOutgoing($id)
    {
        $today_ledger = StokeLedge::find($id);

             $now = \Carbon\Carbon::now();
       $datte = explode(" ", $now);
            
        $pc = Sale::where('product_id', '=', $today_ledger->product_id)->where('sale_date','LIKE','%'.   $today_ledger->ledge_date. '%' )->with('transaction','product', 'store')->orderBy('id','DESC')->get();

         // dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', function($pc){
                return '<a href="' . route('receipt.show', $pc->transaction_id) .'" class="btn btn-info"><i class="fa fa-eye"></i>view</a>';
            })
             ->editColumn('product', function($pc){
                return ($pc->product->product_name);
            }) 
             ->editColumn('store', function($pc){
                return (($pc->store->store_name >= 0)?$pc->store->store_name:" ");
            }) 
             ->editColumn('trans', function($pc){
                return (($pc->transaction->transaction_no >= 0)?$pc->transaction->transaction_no:" ");
            })
             ->editColumn('customer', function($pc){
                return (($pc->transaction->customer_name >= 0)?$pc->transaction->customer_name:" ");
            })
          
            ->rawColumns(['view','product','store','trans','customer'])

            ->make(true);
    }

    public function viewOutgoing($id)
    {
            
         try {
                                    
            if(Auth::user()){
                
                 $ledge = StokeLedge::find($id);
                 $day = explode(" ", $ledge->ledge_date);
                
                 $sales = Sale::where('sale_date','LIKE','%'.  $day[0]. '%' )->where('product_id', '=', $ledge->product_id)->sum('total_amount');
                $date = $ledge->ledge_date;
         
                return view('admin.stock_ledges.view_outgoing', compact('id','date','sales'));
            }else{
                 return view('home.index');
             }
        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
        }
    }

    public function findLedge(Request $request)
    {
            if(Auth::user()){

                    if (empty($request->products) && empty($request->ledge_date)) {

                        $rules = [
                            'ledge_date'  => 'required',
                        ];
                    }

                    if(!empty($request->products) && !empty($request->ledge_date)){

                        $rules = [
                            'ledge_date'  => 'nullable|date',
                        ];
                    }

                    if (empty($request->products) && !empty($request->ledge_date)) {

                        $rules = [
                            'ledge_date'  => 'nullable|date',
                        ];
                    }

                    if (!empty($request->products) && empty($request->ledge_date)) {

                        
                        $rules = [
                            'ledge_date'  => 'nullable|date',
                        ];
                    }

                    $v = Validator::make($request->all(), $rules);

                    if ($v->fails()) {
                        // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
                        return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                    } else {

                        if (!empty($request->products) && !empty($request->ledge_date)) {
                            $param = $request->products . " " . $request->ledge_date;
                        }

                        if (empty($request->products) && !empty($request->ledge_date)) {
                            $param = 'AA' . " " . $request->ledge_date;
                        }

                        if (!empty($request->products) && empty($request->ledge_date)) {
                            $param = $request->products . " " . 'AA';
                        }

                        return view('admin.stock_ledges.show_product_ledge', compact('param'));

                    }

            }else{
                 return view('home.index');
             }
        
    }

    public function ListFindLedge($id){

        $param = explode(" ", $id);

        if ( $param[0] != 'AA' &&  $param[1] != 'AA')  {

            // $today_ledger = StokeLedge::where('ledge_date', '=', $param[1])
            //                           ->where('product_id','=', $param[0])
            //                           ->with('product')->get();
            
            $today_ledger = StokeLedge::where('ledge_date', '=', $param[1])
                                      ->where('product_id','=', $param[0])
                                      ->with(['product'])
                                      ->join('products', 'products.id', '=', 'stock_ledges.product_id')
                                      ->orderBy('products.product_name', 'ASC')
                                      ->get();
        }

        if ( $param[0] == 'AA' &&  $param[1] != 'AA') {
            // $today_ledger = StokeLedge::where('ledge_date', '=', $param[1])->with('product')->get();
            $today_ledger = StokeLedge::where('ledge_date', '=', $param[1])
                                    ->with(['product'])
                                    ->join('products', 'products.id', '=', 'stock_ledges.product_id')
                                    ->orderBy('products.product_name', 'ASC')
                                    ->get();
        }

        if( $param[0] != 'AA' &&  $param[1] == 'AA') {
            // $today_ledger = StokeLedge::where('product_id','=',$param[0])->with('product')->get();
            $today_ledger = StokeLedge::where('product_id', '=', $param[0])
                                    ->with(['product'])
                                    ->join('products', 'products.id', '=', 'stock_ledges.product_id')
                                    ->orderBy('products.product_name', 'ASC')
                                    ->get();
        }

        return Datatables::of($today_ledger)
            ->addIndexColumn()
            ->editColumn('product', function($today_ledger){
                return ($today_ledger->product->product_name);
            })
            ->editColumn('user', function($today_ledger){
                return (userfullname($today_ledger->product->user_id));
            })
            ->addColumn('view_incoming', function($today_ledger){
                return '<a href="' . route('viewIncoming', $today_ledger->id) .'" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> In</a>';
            })
            ->addColumn('view_outgoing', function($today_ledger){
                return '<a href="' . route('viewOutgoing', $today_ledger->id) .'" class="btn btn-info btn-sm"><i class="fa fa-minus"> </i> Out</a>';
            })
            ->rawColumns(['product','view_incoming','view_outgoing','user'])
            ->make(true);
    }

    public function index()
    {
        
        try {
                                    
            if(Auth::user()){
                   
                $products     = Product::whereVisible(1)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');  
                return view('admin.stock_ledges.index',compact('products'));
            }else{
                 return view('home.index');
             }
        } catch(Exception $e) {
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
            if(Auth::user()){
                return view('admin.stock_ledges.create');
            }else{
                return view('home.index');
            }

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
        $rules = [
            'ledge_date'  => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $carbonDate     = \Carbon\Carbon::now();
            $todayFormat    = explode(" ", $carbonDate);
            $today          = $todayFormat[0];
            $date           = $request->ledge_date;

            if ($today != $date) {
                # code...
                Alert::error('Error', "The date you selected is not today's date, please select today's date to create the ledger.");
                return redirect()->route('stock-ledge.create');
            }

            
            $checkdate = StokeLedge::where('ledge_date',  '=', $date)->first();

            if (!empty($checkdate)) {

                $msg = 'The ledger for this date has been created';
                return redirect(route('stock-ledge.show', $date))->with('toast_warning', $msg);

            }

            $products = Product::orderBy('product_name', 'ASC')->get();

            foreach ($products as $product) {

                // new stock for the day
                $stocks = StockOrder::where('product_id', '=', $product->id)
                    ->where('created_at',  'LIKE', '%' . $date . '%')
                    ->sum('order_quantity');

                // dd($stocks);

                // sale stock for the day
                $sale  =  Sale::where('product_id', '=', $product->id)
                    ->where('created_at', 'LIKE', '%' .  $date . '%')
                    ->sum('quantity_buy');

                // dd($sale);

                $initial_stock = InitialStock::where('product_id', '=', $product->id)->first();

                $ledge = new StokeLedge;
                $ledge->product_id = $product->id;
                $ledge->ledge_date = $date;
                $ledge->in_coming = $stocks;
                $ledge->out_goin = $sale;
                $ledge->Balance = $product->current_quantity;
                $ledge->initial_balance = ((!empty($initial_stock) ? $initial_stock->quantity : 0));
                $ledge->user_id = $product->user_id;
                $ledge->visible = 1;
                $ledge->save();

                if (empty($initial_stock)) {

                    // $initial_quantity = 0;
                    $initial_qt = new InitialStock;
                    $initial_qt->product_id = $product->id;
                    $initial_qt->quantity = $product->current_quantity;
                    $initial_qt->visible = 1;
                    $initial_qt->save();
                }else{
                        $change_initial_qt = InitialStock::find($initial_stock->id);
                    
                        $change_initial_qt->id = $initial_stock->id;
                        $change_initial_qt->quantity = $product->current_quantity;
                        $change_initial_qt->save();
                }
            }
            
              // $msg = "Ledger Successfully Created...";
           // return redirect(route('stock-ledge.show', $date))->with('toast_sucess', $msg);
            $id = $date;
           return redirect(route('stock-ledge.show', $id));

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
                                    
            if(Auth::user()){
                // $date = $id;   
                  
                return view('admin.stock_ledges.show', compact('id'));
            }else{
                 return view('home.index');
             }
        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
