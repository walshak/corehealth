<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Sale;
use App\Product;
use App\Stock;use App\Price;
use App\Promotion;
use App\PromoSale;
use Auth;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PromotionController extends Controller
{  
     public function listPromotionSales(Request $request, $id)
    {
        $pc = PromoSale::where('promotion_id','=',$id)->with('promotion','product','transaction')->orderBy('id','ASC')->get();

        return Datatables::of($pc)
             ->addIndexColumn()
            
             ->editColumn('product', function($pc){
                return ($pc->product->product_name);
                //return ($pc->id);
            })
            ->editColumn('transaction', function($pc){
                return ($pc->transaction->transaction_no);
                //return ($pc->id);
            })

            
           ->addColumn('trans', function($pc){
                return '<a href="' . route('transactions.show', $pc->transaction->id) .'" class="btn btn-info"><i class="fa fa-eye"></i> View</a>';
            }) 
           
            ->rawColumns(['product','trans','transaction'])
            ->make(true);  
    }
     public function listPromotion()
    {
        $pc = Promotion::with('product')->orderBy('id','DSC')->get();

        return Datatables::of($pc)
             ->addIndexColumn()
            ->editColumn('visible', function($pc){
                return (($pc->visible == 0)?"Inactive":"Active");
            }) 
            
             ->editColumn('product', function($pc){
                return ($pc->product->product_name);
                //return ($pc->id);
            })
            
            ->addColumn('edit', function($pc){
                return '<a href="' . route('promotion.edit', $pc->id) .'" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>';
            })
             //promo-sales
        
           ->addColumn('trans', function($pc){
                return '<a href="' . route('promotion.show', $pc->id) .'" class="btn btn-info"><i class="fa fa-eye"></i> View</a>';
            }) 
           
            ->rawColumns(['edit','product','visible','trans'])
            ->make(true);  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
       try {
                                    
            if(Auth::user()){
                   //$pc = Promotion::with('product')->orderBy('id','ASC')->get();
                   //dd($pc);
                return view('admin.promotions.index');
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
                   
                   $products = Product::whereVisible(1)->where('current_quantity','>',0)->where('price_assign','=',1)->wherePromotion(0)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
                   $application = ApplicationStatu::whereId(1)->first();
                   $invoice = 34568765;
                return view('admin.promotions.create', compact('products','invoice','application'));
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
     
     // dd($request->all());

       // $now = Carbon::now();
        $now = date(0000-00-00 );
        
        try {  
        $rules = [
                    'products' => 'required',
                    'promotion_name'    => 'required|max:200|unique:promotions',
                    'promotion_total_quantity' => 'required|max:11',
                    'quantity_to_buy'    => 'required|max:4',
                    'quantity_to_give' => 'required|max:3',
                    'start_date'    => 'required|max:11',
                    'end_date' => 'required|max:11',
                ];

         $v = validator()->make($request->all(), $rules);

         if( $v->fails() )
         {
             $msg = 'Please cheak Your Inputs .';
             //flash($msg, 'danger');
             return redirect()->back()->withInput()->withErrors($v);
              $request->products ;
      
         } else{
              $promor = new Promotion();
              
              $promor->product_id                = $request->products;
              $promor->promotion_name          = $request->promotion_name; 
              $promor->promotion_total_quantity= $request->promotion_total_quantity; 
              $promor->quantity_to_buy         = $request->quantity_to_buy;
              $promor->quantity_to_give        =  $request->quantity_to_give ;
              $promor->start_date              = $request->start_date;
              $promor->end_date                = $request->end_date;
              $promor->current_qt              = $request->promotion_total_quantity;        
              $promor->give_qt                 =0; 
              $promor->visible                 =1;


             if( $promor->save() ) {
                 // dd($request->products);
                 $product = Product::whereId($request->products)->first();
                
                 $product->promotion =1;
                 $product->update();
                 $msg = 'promotion for ' . $product->product_name . ' was saved successfully.';
                // flash($msg, 'success');
                   return redirect(route('promotion.index'))->withMessage($msg)->withMessageType('success')->with( $msg);  
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
    public function show(Request $Request, $id)
    {
        try {
                                    
            if(Auth::user()){
                   $promotion = Promotion::find($id);
                //$pc = PromoSale::where('promotion_id','=',$id)->with('promotion','product','transaction')->orderBy('id','ASC')->get();
              //dd($promotion);
                return view('admin.promotions.listPromotionSales', compact('promotion','id'));
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
                   $promotion = Promotion::whereId($id)->with('product')->first();
                 $products = Product::whereVisible(1)->whereCurrent_quantity(">",0)->wherePrice_assign(1)->wherePromotion(0)->orderBy('product_name', 'asc')->pluck('product_name', 'id');
                 //dd($promotion);
                return view('admin.promotions.edit', compact('promotion','id','products'));
            }else{
                 return view('home.index');
             }
        } catch(Exception $e) {
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
    {
        //dd($request);
        try {
                                    
            if(Auth::user()){
                   $promor = Promotion::whereId($id)->first();
                   if ($promor->promotion_total_quantity > $request->promotion_total_quantity) {
                   $cqt =  $promor->promotion_total_quantity - $request->promotion_total_quantity; 
                   $promor->current_qt = $promor->current_qt - $cqt;

                  }elseif ($request->promotion_total_quantity > $promor->promotion_total_quantity ) {
                   $cqt = $request->promotion_total_quantity - $promor->promotion_total_quantity; 
                       $promor->current_qt = $promor->current_qt + $cqt;
                  } else {
                      $promor->current_qt = $request->promotion_total_quantity;
                  }
                  
                  $promor->promotion_name          = $request->promotion_name; 
                  $promor->promotion_total_quantity= $request->promotion_total_quantity; 
                  $promor->quantity_to_buy         = $request->quantity_to_buy;
                  $promor->quantity_to_give        =  $request->quantity_to_give ;
                  $promor->start_date              = $request->start_date;
                  $promor->end_date                = $request->end_date;
                  $promor->visible                = $request->visible;
                  
                  if ($promor->save()) {
                        $product = Product::whereId($promor->product_id)->first();
                
                              $product->promotion = $request->visible;
                              $product->update();
                      return view('admin.promotions.index');
                  }else{

                  }
                         
                  //$promor->give_qt                 =0;
                
            }else{
                 return view('home.index');
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
    public function destroy($id)
    {
        //
    }
}
