<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Stock;
use App\Sale;
use App\Product;
use App\Transaction;
use App\Customer;
use App\Price;
use App\Store;
use App\Promotion;
use App\PromoSale;
use App\ModeOfPayment;
use App\StoreStoke;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class SalesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $stock_cheak = Stock::where('current_quantity', ">", 0)->get();

        foreach ($stock_cheak as $stock) {
            $assing_stock = Product::find($stock->product_id);
            $assing_stock->stock_assign =1;
            $assing_stock->current_quantity = $stock->current_quantity;
            $assing_stock->update();
        }

        if(Auth::user()){

            $customer       = Customer::whereVisible(1)->where('customer_type_id',"=",1)->orderBy('fullname', 'asc')->pluck('fullname', 'id');
            $mycustomer     = Customer::where('customer_type_id',"=",2)->orWhere('customer_type_id',"=",3)->orderBy('fullname', 'asc')->pluck('fullname', 'id');
            $payment_mode   = ModeOfPayment::whereVisible(1)->where("id","!=",5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
            $products       = Product::whereVisible(1)->where("current_quantity",">",0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
            $myproducts     = Product::whereVisible(1)->where("current_quantity",">",0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name','asc')->get();
            $trans          = generateTransactionId();
            $stores         = Store::whereVisible(1)->where('id',"!=",5)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
            $storek         = Store::whereVisible(1)->where('id',"!=",5)->orderBy('store_name', 'asc')->get();

            return view('admin.sales.index', compact('products','myproducts','customer','trans','payment_mode','mycustomer','stores','storek'));
        }else{
            return view('home.index');
        }

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
        dd($request->all());

        $rules = [
            'store_name'  => 'required',
            'location'    => 'required',
        ];





        // validation of request
        if (empty($request->customer)) {
            //***Dont Removed the DD**\\
            // Alert::error('Error', 'Customer Name cannot be empty!');
            dd('Customer Name is Empty, Please Enter the Name to Continue');
            //***Dont Removed the DD**\\
        }

        if (empty($request->stores)) {
            //***Dont Removed the DD**\\
            dd('You Must Select Store, To Continue');
            //***Dont Removed the DD**\\
        }

        if (ctype_digit(strval($request->customer))) {

            $customer_details = Customer::find($request->customer);
            dd($customer_details);
            $customer_name    = $customer_details->fullname;
            $customer_type_id = $customer_details->customer_type_id;


        }elseif (!ctype_digit(strval($request->customer))) {

            $customer_name =$request->customer;
            $customer_type_id = 4;
        }

        $v = validator()->make($request->all(), $rules);

        if( $v->fails()){

            $msg = 'Something is wrong with your input, please comfirm to continue';
            flash($msg, 'danger');

            return redirect()->back()->withInput()->withErrors($v);
        }

            $payLoad = json_decode($request->payload);
            //
            // dd($payLoad);
            $Count   = 0;
            $trans   = $request->trans;

            $cheak_trans = Transaction::where('transaction_no', "=", $trans)->first();

        if(!empty($cheak_trans)){

            //***Dont Removed the DD**\\
                dd('A transaction already exist in our record refresh the page for a new transaction or sale to occur');
            //***Dont Removed the DD**\\
        }

        $transaction                    = new Transaction();
        $transaction->transaction_no    = $trans;
        $transaction->transaction_type  = "sales";
        $transaction->customer_name     = $customer_name;
        $transaction->total_amount      = 00;
        $transaction->deposit_b4        = 00;
        $transaction->credit_b4         = 00;
        $transaction->current_deposit   = 00;
        $transaction->current_credit    = 00;
        $transaction->customer_type_id  = $customer_type_id;
        $transaction->bank_name         = 00;

        if($customer_type_id == 2 || $customer_type_id == 3){

            $transaction->mode_of_payment_id  = 5;
            $transaction->bank_transaction_id = $request->customer;

        }else{

            $transaction->bank_transaction_id   = 00;
            $transaction->mode_of_payment_id    = $request->payment_mode;
        }

            $transaction->store_id  = $request->stores;
            $transaction->tr_date   = \Carbon\Carbon::now();
            $transaction->tr_year   = \Carbon\Carbon::now();

        if ($transaction->save()){

            $transaction_number = Transaction::whereTransaction_no($trans)->first()->id;
        }


        for ($i = 0; $i <= count($payLoad)-1; $i++){

            $product_id  = Product::whereProduct_name($payLoad[$i]->product)->first()->id;
            $stock_cheak = Stock::where('product_id',"=", $product_id)->first();
            $price_list = Price::where('product_id',"=", $product_id)->first();

            if($stock_cheak->current_quantity < $payLoad[$i]->quantity) { }

            /**
             * $gain to calculate each item gain.
             * $total_gain Each gain Multiply by quantity
             */

            $gain       = ($payLoad[$i]->price) - ($price_list->pr_buy_price);
            $total_gain = $gain * $payLoad[$i]->quantity;

            if($price_list->pr_buy_price > $payLoad[$i]->price){

                $lost       = $price_list->pr_buy_price - $payLoad[$i]->price;
                $total_lost = $lost * $payLoad[$i]->quantity;

            }else{

                $total_lost = 0;

            }

            // price current_sale_price
            $price = Price::where("product_id", "=", $product_id)->first();
            $priceWithDiscount = $price->current_sale_price -  $price->max_discount;

            if ($payLoad[$i]->price < $priceWithDiscount ) {
             	$pricetag = $price->current_sale_price;

            }elseif ($payLoad[$i]->price > $price->current_sale_price ){

                $pricetag = $price->current_sale_price;

            } else {

                $pricetag = $payLoad[$i]->price;
            }

            $sales                       = new Sale();
            $sales->transaction_id       = $transaction_number;
            $sales->product_id           = $product_id;
            $sales->quantity_buy         = $payLoad[$i]->quantity;
            $sales->sale_price           = $pricetag;
            $sales->pieces_sales_price   = 1; //$payLoad[$i]->pieces_price;
            $sales->pieces_quantity      = 1; // $payLoad[$i]->pieces_quantity;
            $sales->total_amount         = ($payLoad[$i]->quantity * $pricetag); //(($payLoad[$i]->quantity * $payLoad[$i]->price)+($payLoad[$i]->pieces_price * $payLoad[$i]->pieces_quantity));
            //  lost
            $sales->lost           = $total_lost;
            $sales->gain           = $total_gain;
            $sales->store_id       = $request->stores;
            $sales->promo_qt       = 0;
            $sales->user_id        = Auth::user()->id;

            if($sales->save()) {

                    $stock_cheak                = Stock::where('product_id',"=", $product_id)->first();
                    $stock                      = Stock::where('product_id',"=", $product_id)->first();

                    $stock->quantity_sale       = $stock_cheak->quantity_sale + $payLoad[$i]->quantity;
                    $stock->current_quantity    = $stock_cheak->current_quantity - $payLoad[$i]->quantity;
                    $stock->update();

                    $produc                     = Product::find($product_id);
                    $produc->current_quantity   = $stock->current_quantity;
                    $produc->update();

                    //*************STORE CONTROL***************//
                    $store_stock = StoreStoke::where('product_id','=', $product_id)->where('store_id','=', $request->stores)->first();
                    $store_stock->store_id         = $request->stores;
                    $store_stock->product_id       = $product_id;
                    $store_stock->initial_quantity = $store_stock->current_quantity;
                    $store_stock->quantity_sale    = $store_stock->quantity_sale + $payLoad[$i]->quantity;
                    $store_stock->current_quantity = $store_stock->current_quantity - $payLoad[$i]->quantity;
                    $store_stock->update();



                    // to cheak if there is promo on the product
                    if($produc->promotion == 1){

                        //to get promotion parameters
                        $promotion = Promotion::where('product_id','=',$product_id)->where('visible','=',1)->first();
                        // to calculate howmany customer buy

                        $to_buy =  $payLoad[$i]->quantity / $promotion->quantity_to_buy;

                        // to calculate howmany to give
                        $give   = $promotion->quantity_to_give * $to_buy;

                        // to save promotion transaction
                        $sale_promo                 = new PromoSale();
                        $sale_promo->product_id     = $product_id;
                        $sale_promo->promotion_id   = $promotion->id;
                        $sale_promo->transaction_id = $transaction_number;
                        $sale_promo->quantity_buy   = $payLoad[$i]->quantity;
                        $sale_promo->quantity_give  = $give;
                        $sale_promo->total_amount   = ($payLoad[$i]->quantity * $payLoad[$i]->price);
                        $sale_promo->visible        = 1;
                        $sale_promo->save();

                        // update sales table for tansaction
                        $the_promor                 = Sale::where('transaction_id', '=', $transaction_number)->where('product_id', '=',$product_id)->first();
                        $the_promor->promo_qt       = $give ;
                        $the_promor->update();

                        // updatepromotion tabele with current status
                        $promotion->current_qt      = $promotion->current_qt - $give;
                        $promotion->give_qt         = $promotion->give_qt + $give;
                        $promotion->update();
                    }

                $Count++;
            }


        }  // loop end brace



        if ($Count > 1) {

            $mytrans = Transaction::where('transaction_no',"=", $trans)->first();
            $trasum = Sale::where('transaction_id',"=", $mytrans->id)->sum('total_amount');

            $mytrans->total_amount     = $trasum;
            $mytrans->update();
            $customer_update =  Customer::find($request->customer);


            $msg = 'Receipt Available';
               // return redirect(route('receipt.show',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);
            return redirect(route('sales.edit', $transaction_number))->withMessage($msg)->withMessageType('success')->with($msg);

        }elseif ($Count > 0 && $Count < 2){

            $mytrans                = Transaction::where('transaction_no',"=", $trans)->first();
            $trasum                 = Sale::where('transaction_id',"=", $mytrans->id)->first();
            $mytrans->total_amount  =  $trasum->total_amount;
            $mytrans->update();

            $customer_update =  Customer::find($request->customer);
            $msg = 'Receipt Available';
               // return redirect(route('receipt.show',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);
            return redirect(route('sales.edit',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);

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

     public function listShowTransactions()
    {

        // $list = GraduantsList::where('signature', '=', 0)->where('caligrapher', '=', 1)->with(['programme', 'session'])->orderBy('reg_number')->get();
        $list = Sale::with('product', 'transaction', 'store')->where('transaction_id', '=', 5878)->get();

        //  dd($list);
        return Datatables::of($list)
            ->addIndexColumn()
            // ->editColumn('programme', function ($list) {
            //     $programme_name = $list->programme->name;
            //     return $programme_name;
            // })
            // ->editColumn('session', function ($list) {
            //     $session_name = $list->session->name;
            //     return $session_name;
            // })
            // ->addColumn('has_candidate_checked', function ($list) {
            //     return (($list->has_candidate_checked == 0) ? "<span class='label label-danger'>No</span>" : "<span class='label label-primary'>Yes</span>");
            // })
            // ->addColumn('acknowledgement', function ($list) {
            //     return (($list->acknowledgement == 0) ? "<span class='label label-danger'>No</span>" : "<span class='label label-primary'>Yes</span>");
            // })
            // ->addColumn('visible', function ($list) {
            //     return (($list->visible == 0) ? "<span class='label label-default'>Not Active</span>" : "<span class='label label-success'>Active</span>");
            // })
            // ->addColumn('signature', function ($list) {
            //     return (($list->signature == 0) ? "<span class='label label-danger'>No</span>" : "<span class='label label-primary'>Yes</span>");
            // })
            // ->addColumn('caligrapher', function ($list) {
            //     return (($list->caligrapher == 0) ? "<span class='label label-danger'>No</span>" : "<span class='label label-primary'>Yes</span>");
            // })
            // ->addColumn('view',   '<a href="{{ route(\'users.show\', $id)}}" class="btn btn-success" ><i class="fa fa-street-view"></i> View</a>')
            // ->addColumn('edit',   '<a href="{{ route(\'admission.edit\', $id)}}" class="btn btn-info" ><i class="fa fa-pencil"></i> Edit</a>')
            ->addColumn('edit',   '<button type="button" class="edit-modal btn btn-info btn-xs" data-toggle="modal" data-id="{{$id}}" data-signature="{{$signature}}" ><i class="fa fa-pencil"></i> Process</button>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-info btn-xs" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-pencil"></i> Process</button>')
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    public function show($id)
    {
        $transi = Transaction::find($id);
        // $tran   = Sale::with('product', 'transaction', 'store')->where('transaction_id', "=", $id)->get();

        // return view('admin.sales.show', compact('transi', 'tran'));
        return view('admin.sales.show', compact('transi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

       $trans = Transaction::find($id);
       return view('admin.sales.invoice_buton', compact('trans'));
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
    public function destroy($id){

        // $trans = Sale::where('transaction_id',"=", $id)->get();
        $sales = Sale::find($id);

        // $stock_cheak = Stock::where('product_id',"=",  $sales->product_id)->first();
        $stock  =  Stock::where('product_id',"=",$sales->product_id)->first();

        $stock->quantity_sale      = $stock->quantity_sale -  $sales->quantity_buy;
        $stock->current_quantity   = $stock->current_quantity + $sales->quantity_buy;
        $stock->update();

        $sales->delete();
        $trans = Transaction::where('id',"=", $id)->first();

        $produc = Product::find($sales->product_id);
        $produc->current_quantity = $stock->current_quantity;
        $produc->update();


        $trans->total_amount = $trans->total_amount - $sales->total_amount;
        $trans->update();

        return redirect()->route('sales.show',$sales->transaction_id);
    }

    public function myformprice($id){
        # code...
        // $price = Price::where("product_id", "=", $id)->with('product', 'stock')->first();
        $price = Price::where("product_id", "=", $id)->with('product', 'stock')->first();
        // dd($price);
        return json_encode($price);
    }

    public function mysaleinvoice($trans){

        $sale = Sale::whereTransaction_no($trans)->first();
        return view('admin.sales.invoice', compact('sale'));
    }

    public function myStockStoreAjax($id){

        $store_stocks = StoreStoke::where("store_id", "=", $id)
                                    ->with(['product' => function ($query) {
                                            $query->addSelect(['id', 'product_name']);
                                        }])
                                    ->get();
                                        // dd($store_stocks);
        return json_encode($store_stocks);
    }
}
