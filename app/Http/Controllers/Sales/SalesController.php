<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Stock;
use App\Sale;
use App\Category;
use App\Product;
use App\Transaction;
use App\Customer;
use App\Dependant;
use App\Price;
use App\Store;
use App\Promotion;
use App\PromoSale;
use App\ModeOfPayment;
use App\StoreStoke;
use App\Requisition;
use App\RequisitionRequest;
use App\MedicalReport;
use App\Patient;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\PatientAccount;
use App\VitalSign;
use App\PatientLabService;

class SalesController extends Controller
{
    public function listShowTransactions($id)
    {

        // $list = GraduantsList::where('signature', '=', 0)->where('caligrapher', '=', 1)->with(['programme', 'session'])->orderBy('reg_number')->get();
        $list = Sale::with('product', 'transaction', 'store')->where('transaction_id', '=', $id)->get();

        //  dd($list);
        return Datatables::of($list)
            ->addIndexColumn()
            ->addColumn('productName', function ($list) {
                $productName = $list->product->product_name;
                return $productName;
            })

            ->addColumn('edit',   '<button type="button" class="edit-modal btn btn-primary btn-sm" data-toggle="modal" data-id="{{$id}}" ><i class="fa fa-pencil"></i> </button>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> </button>')
            ->rawColumns(['productName', 'edit', 'delete'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('permission:sales');
        // $this->middleware('permission:sale-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:sale-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:sale-delete', ['only' => ['destroy']]);
        // $this->middleware(['role_or_permission:Super-Admin|Admin|Sales|sales|sale-create|sale-list|sale-show|sale-edit|sale-delete']);
    }
    public function index()
    {
        $patients = Patient::with(['user'])
            ->where('visible', '1')
            ->orWhere('visible', '2')
            ->orWhere('visible', '3')
            ->orWhere('visible', '4')
            ->get();

        return view('admin.sales.index', compact('patients'));
    }

    public function newSale($id,$dependant_id = null)
    {
        try {
            $stock_cheak = Stock::where('current_quantity', ">", 0)->get();
            foreach ($stock_cheak as $stock) {
                $assing_stock = Product::find($stock->product_id);
                $assing_stock->stock_assign = 1;
                $assing_stock->current_quantity = $stock->current_quantity;
                $assing_stock->update();
            }


            if (Auth::user()) {

                $mycustomer = MedicalReport::find($id);
                $patient = Patient::where('user_id', '=', $mycustomer->user_id)->first();
                $dependant = Dependant::find($dependant_id) ?? null;
                $medical = $mycustomer->id;
                $cheak_trans = Transaction::where('transaction_no', "=", $mycustomer->transaction_no)->first();
                if($dependant_id == null){
                    $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id',null)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
                }else{
                    $vitalSign = VitalSign::where('user_id', '=', $patient->user_id)->where('dependant_id',$dependant_id)->where('status', '=', 2)->where('paymentVisibility', '=', 1)->first();
                }

                if (!empty($cheak_trans)) {
                    $msg = ' Record Exist';
                    Alert::warning('warning Title', $msg);
                    return redirect()->route('sales.index')->withMessage($msg)->withMessageType('warning');
                }

                if($dependant_id == null){
                    $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id',null)->get();
                    $customer       = userfullname($mycustomer->user->id);
                }else{
                    $tests = PatientLabService::where('patient_user_id', '=', $patient->user_id)->where('dependant_id',$dependant_id)->get();
                    $customer       = $dependant->fullname;
                }

                $payment_mode   = ModeOfPayment::whereVisible(1)->where("id", "<", 5)->orderBy('id', 'asc')->pluck('payment_mode', 'id');
                $products       = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
                $myproducts     = Product::whereVisible(1)->where("current_quantity", ">", 0)->whereStock_assign(1)->wherePrice_assign(1)->orderBy('product_name', 'asc')->get();
                $trans          = $mycustomer->transaction_no;
                $stores         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->pluck('store_name', 'id');
                // $storek         = Store::whereVisible(1)->where('id', "!=", 5)->orderBy('store_name', 'asc')->get();
                $storek         = Store::find(2);


                //$list           = RequisitionRequest::with('product', 'requisition')->where('requisition_id', '=', $id)->get();
                $category       = Category::where('status_id', '=', 2)->pluck('category_name', 'id')->all();
                $patient_account = PatientAccount::where('visible', 1)->where('user_id', $mycustomer->user->id)->first() ?? null;
                $hmo = Patient::with(['hmo'])->where('user_id', $mycustomer->user->id)->first()->hmo ?? 'Private';


                return view('admin.sales.new_sale', compact('category', 'products', 'myproducts', 'mycustomer', 'trans', 'payment_mode', 'mycustomer', 'stores', 'storek', 'customer', 'medical', 'patient_account', 'hmo', 'vitalSign', 'tests', 'patient','dependant'));


                // return view('admin.sales.index', compact('products','myproducts','customer','trans','payment_mode','mycustomer','stores','storek'));

            } else {

                return view('home.index');
            }
        } catch (Exception $e) {
            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transi = Requisition::where('visible', '=', 2)->where('status', '=', 0)->with('customer')->orderBy('id', 'DESC')->first();
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

        // validation of request
        if (empty($request->customer)) {
            //***Dont Removed the DD**\\
            dd('Customer Name is Empty');
            //***Dont Removed the DD**\\
        }

        if (empty($request->stores)) {
            //***Dont Removed the DD**\\
            dd('Select Store');
            //***Dont Removed the DD**\\
        }

        if (ctype_digit(strval($request->customer))) {

            $customer_details = Customer::find($request->customer);
            // dd($customer_details);
            $customer_name    = $customer_details->fullname;
            $customer_type_id = $customer_details->customer_type_id;
        } elseif (!ctype_digit(strval($request->customer))) {
            $customer_name = $request->customer;
            $customer_type_id = 4;
        }

        $rules = [
            // 'name'      => 'required',
            // 'namename'=> 'required',
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {
            $msg = 'Something is wrong with your input, Please Comfirm to continue';
            flash($msg, 'danger');
            return redirect()->back()->withInput()->withErrors($v);
        }

        $payLoad = json_decode($request->payload);
        // dd($payLoad);

        $Count = 0;
        $trans = $request->trans;

        $cheak_trans = Transaction::where('transaction_no', "=", $trans)->first();

        if (!empty($cheak_trans)) {
            // Please do not remove this DD, it will display error on page if we have double transaction
            dd('Transaction Number already exist in our record Refresh the page for new sales ');
        }

        $transaction   = new Transaction();
        $transaction->transaction_no    = $trans;
        $transaction->budget_year_id    = 1;
        $transaction->bank_transaction_payment_id    = $request->medical;
        $transaction->transaction_type  = "sales";
        $transaction->customer_name     = $customer_name;
        $transaction->total_amount      = 00;
        $transaction->deposit_b4        = 00;
        $transaction->credit_b4         = 00;
        $transaction->current_deposit   = 00;
        $transaction->current_credit    = 00;
        $transaction->customer_type_id  = 4; //$customer_type_id;
        $transaction->bank_name         = 00;
        $transaction->staff_id          = Auth::user()->id;
        $transaction->supply            = 1;
        if ($customer_type_id == 2 || $customer_type_id == 3) {

            $transaction->mode_of_payment_id    = 5;
            $transaction->bank_transaction_id   = $request->customer;
        } else {

            $transaction->bank_transaction_id   = 00;
            $transaction->mode_of_payment_id    = $request->payment_mode;
        }

        if ($request->use_hmo) {
            $transaction->hmo_id    = $request->hmo;
        } else {
            $transaction->hmo_id       = null;
        }

        $transaction->store_id = $request->stores;
        $transaction->tr_date = \Carbon\Carbon::now();
        $transaction->tr_year = \Carbon\Carbon::now();


        if ($transaction->save()) {

            $transaction_number = Transaction::whereTransaction_no($trans)->first()->id;
        }

        // dd($transaction_number);

        // $transaction_number = $transaction->id;
        for ($i = 0; $i <= count($payLoad) - 1; $i++) {

            $product_id  = Product::whereProduct_name($payLoad[$i]->product)->first()->id;

            $stock_cheak = Stock::where('product_id', "=", $product_id)->first();
            $price_list = Price::where('product_id', "=", $product_id)->first();

            if ($stock_cheak->current_quantity < $payLoad[$i]->quantity) {
            }
            /**
             * $gain to calculate each item gain  .
             * $total_gain Each gain Multiply by quantity
             *
             */
            $gain = ($payLoad[$i]->price) - ($price_list->pr_buy_price);
            $total_gain = $gain * $payLoad[$i]->quantity;

            if ($price_list->pr_buy_price > $payLoad[$i]->price) {

                $lost = $price_list->pr_buy_price - $payLoad[$i]->price;
                $total_lost = $lost * $payLoad[$i]->quantity;
            } else {

                $total_lost = 0;
            }

            $sales                       = new Sale();
            $sales->transaction_id       = $transaction_number;
            $sales->product_id           = $product_id;
            $sales->quantity_buy         = $payLoad[$i]->quantity;
            $sales->sale_price           = $payLoad[$i]->price;
            $sales->pieces_sales_price   = 1; //$payLoad[$i]->pieces_price;
            $sales->pieces_quantity      = 1; // $payLoad[$i]->pieces_quantity;
            $sales->total_amount         = ($payLoad[$i]->quantity * $payLoad[$i]->price); //(($payLoad[$i]->quantity * $payLoad[$i]->price)+($payLoad[$i]->pieces_price * $payLoad[$i]->pieces_quantity));
            //  lost
            $sales->lost                 = $total_lost;
            $sales->gain                 = $total_gain;
            $sales->store_id             = $request->stores;
            $sales->budget_year_id       = getBudgetYear();
            $sales->promo_qt             = 0;
            $sales->supply               = 1;
            $sales->user_id              = Auth::user()->id;

            if ($sales->save()) {

                $stock_cheak = Stock::where('product_id', "=", $product_id)->first();
                $stock  =  Stock::where('product_id', "=", $product_id)->first();

                $stock->quantity_sale       = $stock_cheak->quantity_sale + $payLoad[$i]->quantity;
                $stock->current_quantity    = $stock_cheak->current_quantity - $payLoad[$i]->quantity;
                $stock->update();

                // $produc = Product::find($product_id);
                $produc = Product::where('id', '=', $product_id)->first();
                $produc->current_quantity = $stock->current_quantity;
                $produc->update();
                //store record
                $store_stock = StoreStoke::where('product_id', '=', $product_id)->where('store_id', '=', $request->stores)->first();
                // dd($store_stock);
                if (empty($store_stock) || $store_stock == null) {
                    # code...
                    dd('The Item selected is not in that store');
                } else {
                    # code...
                    $store_stock->store_id         = $request->stores;
                    $store_stock->product_id       = $product_id;
                    $store_stock->initial_quantity = $store_stock->current_quantity;
                    $store_stock->quantity_sale    = $store_stock->quantity_sale + $payLoad[$i]->quantity;
                    $store_stock->current_quantity = $store_stock->current_quantity - $payLoad[$i]->quantity;
                    $store_stock->update();
                }



                // to cheak if there ispromotion on the product
                if ($produc->promotion == 1) {
                    //to get promotion parameters
                    $promotion = Promotion::where('product_id', '=', $product_id)->where('visible', '=', 1)->first();
                    //to calculate howmany customer buy
                    $to_buy =  $payLoad[$i]->quantity / $promotion->quantity_to_buy;
                    //to calculate howmany to give
                    $give  = $promotion->quantity_to_give * $to_buy;
                    // to save promotion transaction
                    $sale_promo = new PromoSale();
                    $sale_promo->product_id   = $product_id;
                    $sale_promo->promotion_id = $promotion->id;
                    $sale_promo->transaction_id = $transaction_number;
                    $sale_promo->quantity_buy = $payLoad[$i]->quantity;
                    $sale_promo->quantity_give = $give;
                    $sale_promo->total_amount = ($payLoad[$i]->quantity * $payLoad[$i]->price);

                    $sale_promo->visible = 1;

                    $sale_promo->save();
                    // update sales table for tansaction
                    $the_promor = Sale::where('transaction_id', '=', $transaction_number)->where('product_id', '=', $product_id)->first();

                    $the_promor->promo_qt =  $give;
                    $the_promor->update();
                    // updatepromotion tabele with current status
                    $promotion->current_qt = $promotion->current_qt - $give;
                    $promotion->give_qt =  $promotion->give_qt + $give;
                    $promotion->update();
                }

                $Count++;
            }
        }  // loop end brace

        // $update_transaction_no = Requisition::where('transaction_no',  '=', $trans)->first();
        // $update_transaction_no->id = $update_transaction_no->id;
        // $update_transaction_no->status = 1;
        // $update_transaction_no->update();
        $medical = MedicalReport::find($request->medical);
        $medical->pharmacy_status = 2;
        $medical->pharmacy_id = Auth::user()->id;
        $medical->update();
        if ($Count > 1) {

            $customer_update =  Customer::find($request->customer);
            $msg = 'Receipt Available';

            // For Admin debug purposes
            // return redirect(route('receipt.show',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);
            return redirect(route('sales.edit', $transaction_number))->withMessage($msg)->withMessageType('success')->with($msg);
            if (Auth::user()->is_admin == 2) {
                # code...
                return redirect(route('sales.edit', $transaction_number))->withMessage($msg)->withMessageType('success')->with($msg);
            }
        } elseif ($Count > 0 and $Count < 2) {

            $customer_update =  Customer::find($request->customer);
            $msg = 'Receipt Available';

            // For Admin Debug Purposes
            // return redirect(route('receipt.show',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);

            return redirect(route('sales.edit', $transaction_number))->withMessage($msg)->withMessageType('success')->with($msg);
            if (Auth::user()->is_admin == 2) {
                # code...
                return redirect(route('sales.edit', $transaction_number))->withMessage($msg)->withMessageType('success')->with($msg);
            }
            // return redirect(route('sales.edit',$transaction_number))->withMessage($msg)->withMessageType('success')->with( $msg);

        } else {
            return "Soemthing went wrong!";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTransactions($id)
    {

        $pc = Sale::with('product', 'transaction', 'store')->where('transaction_id', "=", $id)->get();

        // dd($pc);

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('productName', function ($pc) {

                $productName = $pc->product->product_name;

                return $productName;
            })
            // ->addColumn('update', function ($pc) {


            //     if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

            //         $url =  route('customers.edit', $pc->id);
            //         return '<a href="' . $url . '" class="btn btn-info btn-sm"><i class="fa fa-pencil"> </i> Update</a>';
            //     } else {

            //         return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-pencil text-primary"></i> Update</a>';
            //     }
            // })
            ->addColumn('delete', function ($pc) {


                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                    // $url =  route('customers.edit', $pc->id);
                    return '<a href="#" readonly="true" class="btn btn-danger btn-sm"><i class="fa fa-trash"> </i> Delete</a>';
                } else {

                    return '<a href="#" class="btn btn-danger btn-sm"> <i class="fa fa-trash text-primary"></i> Delete</a>';
                }
            })
            ->rawColumns(['productNAme', 'delete'])
            ->make(true);
    }

    public function show($id)
    {

        $transi = Transaction::find($id);
        // dd($transi);
        $tran = Sale::with('product', 'transaction', 'store')->where('transaction_id', "=", $id)->get();
        return view('admin.sales.show', compact('tran', 'transi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
    public function destroy($id)
    {

        $checkProduct = Transaction::where('id', "=", $id)->first();

        if ($checkProduct->supply == 1) {

            $getSales = Sale::where('transaction_id', "=", $id)->get();

            foreach ($getSales as  $getSale) {

                // get an item fromsales
                $sales = Sale::find($getSale->id);

                //*************STORE CONTROL***************//
                $store_stock = StoreStoke::where('product_id', '=',  $sales->product_id)->where('store_id', '=',   $sales->store_id)->first();

                $thestore                   = StoreStoke::find($store_stock->id);
                $thestore->store_id         = $sales->store_id;
                $thestore->product_id       = $sales->product_id;
                $thestore->initial_quantity = $store_stock->initial_quantity -  $sales->quantity_buy;
                $thestore->quantity_sale    = $store_stock->quantity_sale -  $sales->quantity_buy;
                $thestore->current_quantity = $store_stock->current_quantity +  $sales->quantity_buy;
                $thestore->update();


                $stock  =  Stock::where('product_id', "=", $sales->product_id)->first();
                $stock->quantity_sale      = $stock->quantity_sale -  $sales->quantity_buy;
                $stock->current_quantity   = $stock->current_quantity + $sales->quantity_buy;
                $stock->update();


                $sales->delete();

                $trans = Transaction::where('id', "=", $id)->first();

                $product = Product::find($sales->product_id);
                $product->current_quantity = $stock->current_quantity;
                $product->update();


                $trans->total_amount = $trans->total_amount - $sales->total_amount;
                $trans->update();
            }
            //dstroy tansaction
            $sales_cheak = Sale::where('transaction_id', "=", $id)->first();

            if (empty($sales_cheak)) {

                $transm = Transaction::find($id);

                // if ($transm->bank_transaction_id > 0) {
                //     $customer = Customer::find($transm->bank_transaction_id);
                //     if ($customer->customer_type_id == 2 || $customer->customer_type_id == 3 ) {
                //         # code...
                //     }

                // }
                if (!empty($transm)) {
                    $transm->delete();
                }
            }

            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } elseif ($checkProduct->suuply == 2) {

            return response()->json([
                'success' => 'Product already supplied!'
            ]);
        } else {

            return response()->json([
                'success' => 'Old Transction!'
            ]);
        }
    }



    public function myformprice($id)
    {

        // $data               = array();
        $data  = Price::whereProduct_id($id)->with('product', 'stock')->first();
        $data1 = StoreStoke::where('product_id', '=', $id)->where('current_quantity', '>', 1)->get();
        // return json_encode($price, $storeStock);
        return json_encode(array($data, $data1));
    }

    public function mysaleinvoice($trans)
    {

        $sale = Sale::whereTransaction_no($trans)->first();
        return view('admin.sales.invoice', compact('sale'));
    }
}
