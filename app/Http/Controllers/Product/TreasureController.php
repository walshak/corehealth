<?php

namespace App\Http\Controllers\Product;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Price;
use App\Product;
use App\Stock;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class TreasureController extends Controller
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
        // $this->middleware('role:Super-Admin|Admin');
    }

    public function listProductsTreasure()
    {
       //$pc =Price::where("pr_buy_price", ">", 0)->with('product','stock')->get();
       $pc = Product::where("current_quantity",">",0)->whereStock_assign(1)->wherePrice_assign(1)->with('price')->orderBy('product_name','asc')->get();

        return Datatables::of($pc)
             ->addIndexColumn()
             ->editColumn('product_name', function($pc){
                return (ucfirst($pc->product_name));
            })
            ->editColumn('visible', function($pc){
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })
            ->editColumn('value', function($pc){
                return ( '₦'. number_format($pc->price->pr_buy_price));
            })
            ->editColumn('total_value', function($pc){
                return ( '₦'. number_format($pc->current_quantity * $pc->price->pr_buy_price));
            })

             ->editColumn('current_quantity', function($pc){
                return ($pc->current_quantity);
            })


             ->addColumn('store', function($pc){

                if (Auth::user()->hasPermissionTo('store-stocks-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
                    # code...
                    $url = route('stores-stokes.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>';

                } else {
                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-pencil"></i> View</button>';
                    return $label;
                }

            })

            ->rawColumns(['visible', 'value', 'total_value', 'product_name', 'current_quantity', 'store'])
            ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // alert()->success('SuccessAlert','Successfully Updated the record.');
       $data = Product::where("current_quantity",">",0)->whereStock_assign(1)->wherePrice_assign(1)->with('price')->orderBy('product_name','asc')->get();
          $i=0;
         foreach ($data as $datas) {
         	$tt = $datas->current_quantity * $datas->price->pr_buy_price;
         	 $i +=$tt;
         }

        return view('admin.product.treasure', compact('i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


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

