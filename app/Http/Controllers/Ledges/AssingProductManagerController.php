<?php

namespace App\Http\Controllers\Ledges;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Sale;
use App\Product;
use App\Stock;
use Yajra\DataTables\DataTables;
use App\StatusCategory;
use RealRashid\SweetAlert\Facades\Alert;

class AssingProductManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listProductsManager()
    {
        // $statusCat = StatusCategory::where('name', '=', 'Default Product Manager')->first();

        $pc = Product::where('id', '>', 0)->with('stock', 'user')->orderBy('product_name','ASC')->get();
       //$pc = Product::where('id', '>=', 0)->orderBy('product_name','DESC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()

            ->editColumn('visible', function($pc){
                return (($pc->user_id == 7) ? "No Manager" : "Active");
            })
            ->editColumn('current_quantity', function($pc){
                return ($pc->stock->current_quantity);
            })
            ->addColumn('edit', function($pc){

                if ($pc->user_id ==7 ) {

                    $url = route('products-managers.show', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Assign</a>';

                } else {

                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-plus"></i> Assign</button>';
                    return $label;
                }


            })
             ->editColumn('user', function($pc){
                return ($pc->user->lastname .' '.$pc->user->firstname.' '.$pc->user->othername);
            })
            ->addColumn('adjust', function($pc){

                if ($pc->user_id == 7) {
                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-i-cursor"></i> edit</button>';
                 return $label;


                } else {

                    $url = route('products-managers.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-i-cursor"></i> Edit</a>';

              }

            })




            ->rawColumns(['edit','adjust','user'])
            ->make(true);
    }
    public function index()
    {
        //$data = Product::where('id','>',0)->with('stock')->orderBy('product_name','DESC')->get();

        return view('admin.stock_ledges.view_prodoct_managers');
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
        // dd($request->all());
        if (empty($request->user_id)) {
             $msg = 'plese select Manager.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
        }
       //dd($request);
       $product = Product::Where('id', '=', $request->product_id)->first();
        // dd($product);
       $product->id = $request->product_id;
       $product->user_id = $request->user_id;
       $product->update();
       $msg = 'success';
          return redirect(route('products-managers.index'))->with('toast_success', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        // Am querying the Status Category Table and specifically getting the Product Manager by Assigning his
        // name to get the value so as to use it on the User table query...
        $userStatus = StatusCategory::where('name', '=', 'Product Manager')->where('visible', '=', 1)->first();

        $users = User::with(['statuscategory' => function ($q) {
                                $q->addSelect(['id', 'name']);
                            }])->where('visible', '=', 2)
                                ->where('is_admin', '=', $userStatus->id)
                                ->orderBy('id', 'ASC')
                                ->get(['surname', 'firstname', 'othername', 'id'])
                                ->pluck('name', 'id');

        return view('admin.stock_ledges.assing_product_manager', compact('product', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product = Product::find($id);
        //dd($product);
        $present_manager =  userfullname($product->user_id);
        $userStatus = StatusCategory::where('name', '=', 'Product Manager')->where('visible', '=', 1)->first();
        $users = User::with(['statuscategory' => function ($q) {
                            $q->addSelect(['id', 'name']);
                        }])->where('visible', '=', 2)
                        ->where('is_admin', '=', $userStatus->id)
                        ->orderBy('id', 'ASC')
                        ->get(['surname', 'firstname', 'othername', 'id'])
                        ->pluck('name', 'id');

        // dd($users);

        return view('admin.stock_ledges.change_product_manager', compact('product', 'users', 'present_manager'));
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
        // dd($request->all());
        if (empty($request->user_id)) {
             $msg = 'plese select Manager.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
        }
       //dd($request);
       $product = Product::find($request->product_id);
        // dd($product);
       $product->id = $request->product_id;
       $product->user_id = $request->user_id;
    //    $product->update();
       if ($product->update()) {
            # code...
            $msg =  alert("Success");
            return redirect(route('products-managers.index'))->with('toast_success', $msg);
       }else{
           $msg = alert("Error");
            return redirect(route('products-managers.index'))->with('toast_error', $msg);
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
