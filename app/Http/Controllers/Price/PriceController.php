<?php

namespace App\Http\Controllers\Price;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use FFI\Exception;
use App\ApplicationStatu;
use App\User;
use App\Invoice;
use App\Supplier;
use App\StockOrder;
use App\Stock;
use App\Product;
use App\Price;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

//use Carbon;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function __construct()
    {
        // $this->middleware('permission:treasures');
        // $this->middleware('permission:treasure-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:treasure-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:treasure-delete', ['only' => ['destroy']]);
        $this->middleware(['role:Super-Admin|Admin|Requisition', 'permission:prices|price-create|price-list|price-show|price-edit|price-delete']);
    }

    public function listPrices()
    {
       $pc = Price::where('visible', '>=', 0)->with('product')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('product', function($pc){
                return ($pc->product->product_name);
            })
->rawColumns(['product'])

            ->make(true);
    }

    public function index()
    {
        try {

            if(Auth::user()){

                   $products     = Product::whereVisible(1)->whereStock_assign(1)->wherePrice_assign(0)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
                   $application = ApplicationStatu::whereId(1)->first();
                   $invoice = 34568765;
                return view('admin.prices.create', compact('products','invoice','application'));
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
       $data = Price::where('visible', '>',0 )->with('product')->get();
                //if (Auth::user('id', '>',2)) {
                  return view('admin.prices.pricelist');
                // }else{return view('admin.prices.customer_price_list', compact('data'));
                // }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$now = Carbon::now();
         $now = date(0000-00-00 );

        try {
        $rules = [
                    'products' => 'required|max:100',
                    'price'    => 'required|max:11'
                ];

         $v = validator()->make($request->all(), $rules);

         if( $v->fails() )
         {
             $msg = 'Please cheak Your Inputs .';
             //flash($msg, 'danger');
             return redirect()->back()->withInput()->withErrors($v);

         } else {
             $cheak_half = Product::find($request->products);
             //dd($cheak_half);
             $myprice                 = new Price();
             $myprice->product_id         = $request->products;
             $myprice->initial_sale_date   = $now;
             $myprice->current_sale_date   = $now;
             $myprice->initial_sale_price   = $request->price;
             $myprice->current_sale_price  = $request->price;
             $myprice->pr_buy_price        = $request->buy_price;
             if($request->max_discount == ""){
              $myprice->max_discount        = 0;
             }else{ $myprice->max_discount        = $request->max_discount;
             }

             if($cheak_half->has_have == 1){
              $myprice->half_price         = $request->price / 2;

             }elseif($cheak_half->has_have == 0){
                $myprice->half_price = 0;
             }
             if($cheak_half->has_piece ==1){
              $myprice->pieces_price        = $request->pieces_price;
              $myprice->pieces_max_discount = $request->pieces_max_discount;
             }elseif($cheak_half->has_piece ==0){
              $myprice->pieces_price        = 0;
              $myprice->pieces_max_discount = 0;
             }

             $myprice->visible            = 1;
             if( $myprice->save() ) {
                $assing_stock = Product::find($request->products);
                 $assing_stock->price_assign =1;
                 $assing_stock->update();
                 $msg = 'price for ' . $cheak_half->product_name . ' was saved successfully.';
                // flash($msg, 'success');
                   return redirect(route('prices.index'))->withMessage($msg)->withMessageType('success')->with( $msg);
             } else {
                 $msg = 'Something is went wrong. Please try again later, information not save.';
                 //flash($msg, 'danger');
                 return redirect()->back()->withInput();
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
       try {

            if(Auth::user()){

                   $products     = Product::whereId($id)->first();
                   $application = ApplicationStatu::whereId(1)->first();
                return view('admin.prices.newprice', compact('products','application'));
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
       try {


         if(Auth::user()){
                  $application = ApplicationStatu::whereId(1)->first();
                 $data = Price::with('product')->whereProduct_id($id)->first();
                 if(empty($data)){
                     $msg = 'price is not set was saved successfully.';
                   return redirect(route('prices.index'))->withMessage($msg)->withMessageType('success')->with( $msg);
                 }else{
               // dd($data);
                  return view('admin.prices.edit', compact('data','application'));
                 }
            }else{
                 return view('home.index');
        }

       } catch (Exception $e) {
           return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
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
     {   //  dd($request);
        //$now = Carbon::now();
         $now = date(0000-00-00 );

        try {
        $rules = [
                    //'buy_price' => 'required|max:11',
                    //'price'    => 'required|max:11'
                ];

         $v = validator()->make($request->all(), $rules);

         if( $v->fails() )
         {
             $msg = 'Please cheak Your Inputs .';
             //flash($msg, 'danger');
             return redirect()->back()->withInput()->withErrors($v);

         } else {
             $cheak_half = Product::find($request->products);
          //  dd($request);
             $myprice                       =  Price::where('id', "=", $id)->first();

             $myprice->initial_sale_date    = $now;
             $myprice->current_sale_date    = $now;
             $myprice->initial_sale_price   = $request->price;
             $myprice->current_sale_price   = $request->price;
             $myprice->pr_buy_price         = $request->new_buy_price;
               if($request->max_discount == ""){
              $myprice->max_discount        = 0;
             }else{ $myprice->max_discount        = $request->max_discount;
             }

              $myprice->half_price         = 0;

              $myprice->pieces_price        =0;
              $myprice->pieces_max_discount = 0;


             $myprice->visible            = 1;
             if( $myprice->update() ) {

                 $msg = 'price was update successfully';
                // flash($msg, 'success');
                   return redirect(route('products.index'))->withMessage($msg)->withMessageType('success')->with( $msg);
             } else {
                 $msg = 'Something is went wrong. Please try again later, information not save.';
                 //flash($msg, 'danger');
                 return redirect()->back()->withInput();
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
    public function priceslist()
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
