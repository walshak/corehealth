<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Store;
use Validator;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;



class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('permission:stores');
        // $this->middleware('permission:store-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:store-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:store-delete', ['only' => ['destroy']]);
        $this->middleware(['role:Super-Admin|Admin', 'permission:stores|store-create|store-list|store-show|store-edit|store-delete']);
    }

    public function listStores()
    {
       $pc = Store::where('visible', '>=', 0)->orderBy('store_name','ASC')->get();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('visible', function($pc){
                return (($pc->visible == 0) ? "Inactive" : "Active");
            })
            ->editColumn('location', function ($pc) {
                return $pc->location;
            })
            ->addColumn('edit', function($pc){

                if (Auth::user()->hasPermissionTo('store-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url = route('stores.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit</a>';
                } else {

                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-pencil"></i> Edit</button>';
                    return $label;
                }

            })
            ->addColumn('view', function($pc){

                if (Auth::user()->hasPermissionTo('store-stocks-show') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url = route('stores-stokes.show', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View Product</a>';
                } else {

                    $label = '<button disabled class="btn btn-secondary btn-sm"> <i class="fa fa-eye"></i> View Product</button>';
                    return $label;
                }
            })
            ->rawColumns(['edit','view'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $data = Store::orderBy('store_name','DESC')->get();
        return view('admin.stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        // dd($request->all());
        try {
            $rules = [
                'store_name' => 'required|min:3|max:150',
                'location'   => 'required|min:3|max:150',
            ];

            if ($request->visible) {
                #  Making sure if password change was selected it's being validated
                $rules += [
                    'visible' => 'required',
                ];
            }

            $v = Validator::make($request->all(), $rules);

            if( $v->fails() ) {
                Alert::error('Error Title', 'One or more information is needed.');
                return redirect()->back()->withInput()->withErrors($v);
            } else {

                $store               = new Store();
                $store->store_name   = $request->store_name;
                $store->location     = $request->location;
                $store->visible      = ($request->visible) ? 1 : 0;

                if($store->save()) {
                    $msg = 'New Store  ' . $request->name . ' was created successfully.';
                    Alert::success('Success ', $msg);
                    return redirect()->route('stores.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        try {

             $store = Store::whereId($id)->first();
            return view('admin.stores.edit',compact('store'));

        }catch(Exception $e) {

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
    { // dd($request);
        try {

            $rules = [
                'store_name' => 'required|min:3|max:150',
                'location'   => 'required|min:3|max:150',
            ];

            if ($request->visible) {
                #  Making sure if password change was selected it's being validated
                $rules += [
                    'visible' => 'required',
                ];
            }

            $v = Validator::make($request->all(), $rules);

            if( $v->fails() ) {
                Alert::error('Error Title', 'One or more information is needed.');
                return redirect()->back()->withInput()->withErrors($v);
            } else {

                $store               = Store::findOrFail($id);
                $store->store_name   = $request->store_name;
                $store->location     = $request->location;
                $store->visible      = ($request->visible) ? 1 : 0;

                if($store->update()) {
                    $msg = 'Store  ' . $request->store_name . ' was Updated successfully.';
                    Alert::success('Success ', $msg);
                    return redirect()->route('stores.index');
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
    public function destroy($id)
    {
        //
    }

}

