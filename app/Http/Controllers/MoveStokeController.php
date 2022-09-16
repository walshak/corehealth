<?php

namespace App\Http\Controllers;

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
use Datatables;

class MoveStokeController extends Controller
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
          
        

        try { 

            $rules = [
                    'quantity'          => 'required|max:11',
                    'stores_' => 'required|max:11'
                ];

               $v = validator()->make($request->all(), $rules);

                 if( $v->fails() )
                 {
                     $msg = 'Please cheak Your Inputs .';
                     //flash($msg, 'danger');
                     return redirect()->back()->withInput()->withErrors($v);

                 } 
                 if ($request->quantity >  $request->current_quntity) {
                     $msg = 'Reduce Quantity' . $request->quantity . 'to Transfer.';
                        // flash($msg, 'success');
                           return redirect()->back()->withInput()->withMessage($msg)->withMessageType('warning')->with( $msg);
                 }
             
              $pcc = StoreStoke::where('store_id', '=', $request->stores_)->where('product_id','=',$request->product_id)->first();
             
         if (empty($pcc)) {
                 //dd($pcc);
             
                     $store                 = new StoreStoke();
                    
                     $store->store_id         = $request->stores_;
                     $store->product_id       = $request->product_id;
                     $store->initial_quantity = 0;
                     $store->quantity_sale    = 0;
                     $store->order_quantity   = 0;
                     $store->current_quantity = $request->quantity;
                     

                     if(  $store->save() ) {
                         $msg = ' items  was transfer successfully.';
                          $pc = StoreStoke::where('store_id', '=', $request->store_id)->where('product_id','=',$request->product_id)->with('store','product')->first();
                         $pc->initial_quantity    = $pc->current_quantity ;
                         $pc->current_quantity    = $pc->current_quantity - $request->quantity;
                         $pc->update() ;
                        // flash($msg, 'success');
                           return redirect(route('stores.index'))->withMessage($msg)->withMessageType('success')->with( $msg);  
                     } else {
                         $msg = 'Something is went wrong. Please try again later, information not save.';
                         //flash($msg, 'danger');
                         return redirect()->back()->withInput();
                     }
          }elseif (!empty($pcc)) {
                     //$pcc = StoreStoke::find($pc->id);
                     $pcc->order_quantity      = $request->quantity;
                     $pcc->initial_quantity    = $pcc->current_quantity ;
                     $pcc->current_quantity    = $pcc->current_quantity + $request->quantity;
                    

                     if(  $pcc->update() ) {
                        $pc = StoreStoke::where('store_id', '=', $request->store_id)->where('product_id','=',$request->product_id)->with('store','product')->first();
                         $pc->initial_quantity    = $pc->current_quantity ;
                         $pc->current_quantity    = $pc->current_quantity - $request->quantity;
                         $pc->update() ;
                         $msg = ' items  was transfer successfully.';
                        // flash($msg, 'success');
                           return redirect(route('stores.index'))->withMessage($msg)->withMessageType('success')->with( $msg);  
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
        $now = \Carbon\Carbon::now();
          
       
         $pc = StoreStoke::where('id', '=', $id)->with('store','product')->first();
       
         //$stores    = Store::where('id', '=!', $pc->store_id)->orderBy('store_name','asc')->pluck('store_name', 'id');
         $stores    = Store::whereVisible(1)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
         // dd($stores);

        return view('admin.move_stock.move_stock', compact('stores','pc','id','now'));
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
