<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Invoice;
use App\Supplier;
use App\StockOrder;
use App\Stock;
use App\Product;
use App\Store;
use App\StoreStoke;
use Auth;


class StockOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      // dd($request);
         $now = \Carbon\Carbon::now();
         $datte = explode(" ", $now);
        // validation of request
        $cheak_trans = Invoice::where('id',"=",$request->invoice_id)->first();

        if($cheak_trans->visible == 2)
        {  
             //***Dont Removed the DD**\\
           dd('Invoice Items  already exist in our record go back for new invoice ');
              //***Dont Removed the DD**\\
        }
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
               //dd($payLoad);
        $Count = 0;

        for ($i = 0; $i <= count($payLoad)-1; $i++){
            //dd($payLoad[$i]->product);
            $product_id  = Product::whereProduct_name($payLoad[$i]->product)->first()->id;
            $store_id  = Store::whereStore_name($payLoad[$i]->stores)->first()->id;
            $stock_order                 = new StockOrder();
            $stock_order->invoice_id     = $request->invoice_id;
            $stock_order->product_id    = $product_id;
            $stock_order->store_id       = $store_id;
            $stock_order->order_quantity = $payLoad[$i]->quantity; 
            $stock_order->total_amount   = $payLoad[$i]->total_amount; 

                   
            if($stock_order->save()) {
                $invoice_status = Invoice::find($request->invoice_id);
                $invoice_status->visible = 2;
                $invoice_status->update();

                $stock_cheak = Stock::where('product_id',"=", $product_id)->first();
                if(empty($stock_cheak)) {
                   $stock                     = new Stock();
                   $stock->product_id        = $product_id;
                   $stock->initial_quantity   = 0;
                   $stock->order_quantity     = $payLoad[$i]->quantity;
                   $stock->current_quantity   = $payLoad[$i]->quantity; 
                   $stock->quantity_sale      = 0;
                   $stock->stock_date         = $datte[0];
                   $stock->save();
                   $assing_stock = Product::find($product_id);
                   $assing_stock->stock_assign =1;
                   $assing_stock->update();

                }else { $stock_cheak = Stock::where('product_id',"=", $product_id)->first();
                       $stock  =  Stock::where('product_id',"=", $product_id)->first();
                       $stock->product_id         = $product_id;
                       $stock->initial_quantity   = $stock_cheak->current_quantity;
                       $stock->order_quantity     = $payLoad[$i]->quantity;
                       $stock->current_quantity   = $stock_cheak->current_quantity
                       + $payLoad[$i]->quantity; 
                       $stock->update();

                }
                   $store_stock_cheak = StoreStoke::where('product_id',"=", $product_id)->where('store_id',"=", $store_id )->first();
                if(empty($store_stock_cheak)) {
                   $store_stock                     = new StoreStoke();
                    
                   $store_stock->store_id           = $store_id;
                   $store_stock->product_id         = $product_id;
                   $store_stock->initial_quantity   = 0;
                   $store_stock->order_quantity     = $payLoad[$i]->quantity;
                   $store_stock->current_quantity   = $payLoad[$i]->quantity; 
                   $store_stock->quantity_sale      = 0; 
                   $store_stock->save();

                }else { $store_stock_cheak = StoreStoke::where('product_id',"=", $product_id)->first();
                       $store_stock  =  StoreStoke::where('product_id',"=", $product_id)->first();
                       $store_stock->product_id         = $product_id;
                       $store_stock->initial_quantity   = $store_stock_cheak->current_quantity;
                       $store_stock->order_quantity     = $payLoad[$i]->quantity;
                       $store_stock->current_quantity   = $store_stock_cheak->current_quantity
                       + $payLoad[$i]->quantity; 
                       $store_stock->update();
 
                }
                 
                $Count++;
            }

                  
        }  // loop end brace
        
        if ($Count > 1) {
            return $Count . " item(s) have been successfully uploaded! ";
        }elseif ($Count > 0 And $Count < 2){
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
        try {
                                    
            if(Auth::user()){
                    $invoice = Invoice::whereId($id)->with('supplier')->first();
                   
                   $products     = Product::whereVisible(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
                    $stores     = Store::whereVisible(1)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
                return view('admin.stock_orders.create', compact('products','invoice','stores'));
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
