<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Stock;
use App\Sale;
use App\StoreStoke;
use App\Product;
use App\Transaction;
use App\Customer;
use App\Price;
use App\Store;
use App\ModeOfPayment;
use Auth;
use DB;

class RemovedEditSalesProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
      // dd($request); //
    }
    public function EditQuantity($id, $qt)
    {  
        $data = $id." " .$qt;

       $sales = Sale::find($id);
       if ($sales->quantity_buy < $qt || $sales->quantity_buy == $qt) {
           $msg = 'you cannot incrise the Quantity .';
           return redirect(route('transactions.show' , $id))->with('toast_success', $msg);
                    
       }
        $set_qt = $sales->quantity_buy - $qt;
        $sales->quantity_buy = $qt; 
             
        $curent_value  =  $qt * $sales->sale_price;  
        $minust_value  = $sales->total_amount - $curent_value ;
        $stock  =  Stock::where('product_id', '=', $sales->product_id)->first();
        //  dd($stock);
        $stock->id                 = $stock->id;
        $stock->quantity_sale      = $stock->quantity_sale -  $set_qt ;
        $stock->current_quantity   = $stock->current_quantity + $set_qt ;
        $stock->update();

        $produc = Product::find($sales->product_id);
        $produc->current_quantity = $produc->current_quantity + $set_qt ;
        $produc->update();

        $store_stock = StoreStoke::where('store_id', '=', $sales->store_id)->where('product_id', '=', $sales->product_id)->first();
        $store_stock->product_id         = $sales->product_id;
        $store_stock->current_quantity   = $store_stock->current_quantity + $set_qt;
        $store_stock->quantity_sale   = $store_stock->quantity_sale - $set_qt;
        $store_stock->update();
       ///////////////////////////////
        $trans = Transaction::where('id', '=', $sales->transaction_id)->first();
        $trans->id = $sales->transaction_id;
        $trans->total_amount = $trans->total_amount - $minust_value;

        if ($trans->current_deposit == 0 &&   $trans->current_credit == 0 ) {
            $trans->current_deposit  = $minust_value;
            $trans->current_credit   = 0;
        }
        if ($trans->current_deposit > 0 &&   $trans->current_credit == 0 ) {
            $trans->current_deposit  = $trans->current_deposit + $minust_value;
                $trans->current_credit   = 0;
        } 
        if ( $trans->current_credit > 0 &&   $trans->current_deposit == 0 ) {
            // $trans->current_deposit  = $trans->current_deposit + $sales->total_amount;
            //     $trans->current_credit   = 0;
            if ( $trans->current_credit > $minust_value) {
               $trans->current_credit =  $trans->current_credit -  $minust_value;
               $trans->current_deposit = 0;
            } elseif ( $trans->current_credit <  $minust_value) {
                 
               $trans->current_deposit = $minust_value -  $trans->current_credit;
               $trans->current_credit =  0;
            }
            
        }
        //****************customer***********************
        if ($trans->customer_type_id == 2 || $trans->customer_type_id == 3) {

            $customer = Customer::find($trans->bank_transaction_id);

            if ($customer->deposit     ==  0 && $customer->creadit == 0) {
                $customer->deposit =  $minust_value;
                $customer->creadit = 0;
            }
            if ($customer->deposit     > 0 && $customer->creadit == 0) {
                $customer->deposit    =  $customer->deposit +  $minust_value;
                $customer->creadit    =  0;
            }

            if ($customer->creadit  > 0 && $customer->deposit == 0) {
                if ($customer->creadit  >  $minust_value) {
                    $customer->creadit    =  $customer->creadit -  $minust_value;
                    $customer->deposit    = 0;
                } elseif ($customer->creadit  <  $minust_value) {
                    $customer->deposit =  $minust_value - $customer->creadit;
                    $customer->creadit = 0;
                }
            }
            $customer->update();
        }

         $trans->update();
         $sales->id = $sales->id; 
         $sales->quantity_buy = $qt; 
         $sales->total_amount = $qt * $sales->sale_price ;
         $sales->update();
     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // dd($id);

        $sales = Sale::find($id);
        $cheekValue = $sales->transaction_id;
        $stock  =  Stock::where('product_id', '=', $sales->product_id)->first();
        //  dd($stock);
        $stock->id                 = $stock->id;
        $stock->quantity_sale      = $stock->quantity_sale -  $sales->quantity_buy;
        $stock->current_quantity   = $stock->current_quantity + $sales->quantity_buy;
        $stock->update();

        $produc = Product::find($sales->product_id);
        $produc->current_quantity = $stock->current_quantity;
        $produc->update();

        $store_stock = StoreStoke::where('store_id', '=', $sales->store_id)->where('product_id', '=', $sales->product_id)->first();
        $store_stock->product_id         = $sales->product_id;
        $store_stock->initial_quantity   = $store_stock->initial_quantity + $sales->quantity_buy;
        $store_stock->current_quantity   = $store_stock->current_quantity + $sales->quantity_buy;
        $store_stock->quantity_sale   = $store_stock->quantity_sale - $sales->quantity_buy;
        $store_stock->update();

        $trans = Transaction::where('id', '=', $sales->transaction_id)->first();
        $trans->id = $sales->transaction_id;
        $trans->total_amount = $trans->total_amount - $sales->total_amount;

        if ($trans->current_deposit == 0 &&   $trans->current_credit == 0 ) {
            $trans->current_deposit  = $sales->total_amount;
                $trans->current_credit   = 0;
        }
        if ($trans->current_deposit > 0 &&   $trans->current_credit == 0 ) {
            $trans->current_deposit  = $trans->current_deposit + $sales->total_amount;
                $trans->current_credit   = 0;
        } 
        if ( $trans->current_credit > 0 &&   $trans->current_deposit == 0 ) {
            // $trans->current_deposit  = $trans->current_deposit + $sales->total_amount;
            //     $trans->current_credit   = 0;
            if ( $trans->current_credit >  $sales->total_amount) {
               $trans->current_credit =  $trans->current_credit -  $sales->total_amount;
               $trans->current_deposit = 0;
            } elseif ( $trans->current_credit <  $sales->total_amount) {
                 
               $trans->current_deposit = $sales->total_amount -  $trans->current_credit;
               $trans->current_credit =  0;
            }
            
        }
        //****************customer***********************
        if ($trans->customer_type_id == 2 || $trans->customer_type_id == 3) {

            $customer = Customer::find($trans->bank_transaction_id);

            if ($customer->deposit     ==  0 && $customer->creadit == 0) {
                $customer->deposit =   $trans->total_amount;
                $customer->creadit = 0;
            }
            if ($customer->deposit     > 0 && $customer->creadit == 0) {
                $customer->deposit    =  $customer->deposit +  $trans->total_amount;
                $customer->creadit    =  0;
            }

            if ($customer->creadit  > 0 && $customer->deposit == 0) {
                if ($customer->creadit  >  $trans->total_amount) {
                    $customer->creadit    =  $customer->creadit -  $trans->total_amount;
                    $customer->deposit    = 0;
                } elseif ($customer->creadit  <  $trans->total_amount) {
                    $customer->deposit =   $trans->total_amount - $customer->creadit;
                    $customer->creadit = 0;
                }
            }
            $customer->update();
        }

        $trans->update();
        $sales->delete();

        $cheek = Sale::where('transaction_id', '=', $cheekValue)->first();

        // if(empty($cheek)){
        //     $trans->delete();
        // }



    }


}
