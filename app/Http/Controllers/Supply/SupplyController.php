<?php

namespace App\Http\Controllers\Supply;

use Illuminate\Http\Request;
use FFI\Exception;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Sale;
use App\Product;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listUnsupplyTransactions()
    {

        $now = \Carbon\Carbon::now();
        $datte = explode(" ", $now);

         $pc = Transaction::where('transaction_type', '=', 'sales')->where('supply', '=', 1)->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('view', function($pc){
                return '<a href="' . route('transactions.show', $pc->id) .'" class="btn btn-info"><i class="fa fa-eye"></i>view</a>';
            })
            ->editColumn('supply', function($pc){

                if ($pc->supply == 1) {

                  $url = route('supply.show', $pc->id);
                   return '<a class="btn btn-warning " href="'.$url .'"><i class="fa fa-pencil"></i> Approve </a>';

                } else {

                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-i-cursor"></i> Supply</button>';
                    return $label;
                }
            })
            ->editColumn('mode', function($pc){
                return (($pc->mode_of_payment->payment_mode >= 0)?$pc->mode_of_payment->payment_mode:" ");
            })
            ->editColumn('store', function($pc){
                return (($pc->store->store_name >= 0)?$pc->store->store_name:" ");
            })
            ->rawColumns(['view','mode','store','supply'])
            ->make(true);
    }

    public function TotalUnsupplyStock(){

       try {
              $now = \Carbon\Carbon::now();
            return view('admin.supply.UnsupplyStock', compact('now'));

        } catch(Exception $e) {
            return redirect()->back()->withMessage("An error occurred ".$e->getMessage());
        }
    }

    public function ListTotalUnsupplyStock(){

        $pc = Sale::where('supply','=', 1 )->with('transaction','product', 'store','user')->orderBy('id','DESC')->get();
        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('product', function($pc){
                return ($pc->product->product_name);
            })
            ->editColumn('store', function($pc){
                return (($pc->store->store_name >= 0)?$pc->store->store_name:" ");
            })
            ->editColumn('trans', function($pc){
                return ($pc->transaction->transaction_no );
            })
            ->editColumn('customer', function($pc){
                return ($pc->transaction->customer_name );
            })
            ->editColumn('user', function($pc){
                return (userfullname($pc->user_id) );
            })
            ->editColumn('date', function($pc){

                $date  =  explode(" ", $pc->sale_date);
                $dateOne   = $date[0];
                $dateTwo   = $date[1];
                return $dateOne;
            })
            ->rawColumns(['product','store','trans','customer','user', 'date'])
            ->make(true);
    }

    public function index()
    {
        try {
            return view('admin.supply.index');
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
        //
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
                $aprove = Transaction::find($id);
                $aprove->supply = 2;
                $aproveSales = Sale::where('transaction_id', '=', $id)->get();

            foreach ($aproveSales as $approveSale) {

                $aprove_supply = Sale::find($approveSale->id);
                $aprove_supply->supply = 2;
                $aprove_supply->update();
            }
                $aprove->update();

            Alert::success('Success', 'You have successfuly aproved the supply of' .'$aprove->');
            return view('admin.supply.index');

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
