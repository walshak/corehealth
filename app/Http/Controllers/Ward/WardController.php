<?php

namespace App\Http\Controllers\Ward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ward;
use App\Bed;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Auth;
class WardController extends Controller
{

     public function listWards()

    {
       $pc = Ward::all();
        //dd($pc);
                return Datatables::of($pc)
                    ->addIndexColumn()

                    ->editColumn('visible', function($pc){
                     return (($pc->visible == 0)?"Inactive":"Active");
                    })
                    ->addColumn('edit', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('wards.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil nav-icon text-success"> </i> edit</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                        }
                    })
                    ->addColumn('viewBeds', function($pc){

                        $bed = Bed::where('ward_id', '=', $pc->id)->first();
                       if (!empty($bed)) {

                            $url =  route('beds.show', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-pencil nav-icon text-primary"> </i> View Beds</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i>Bet Not Available</a>';
                        }
                    })
                    ->addColumn('addBed', function($pc){
                       if ($pc->bed_assing == 0) {

                           return '<a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="' . $pc->ward_name. '" title="Create Bed"> <i class="fas fa-plus-circle"></i> Create Bed
                            </a> ';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i>Active</a>';
                        }
                    })
                    ->addColumn('price', function($pc){

                       if ($pc->bed_assing == 0) {
                              return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> No Bed Assing </a>';

                        } elseif ( $pc->price_assing ==0 AND $pc->bed_assing == 1 ) {

                             return '<a data-toggle="modal" id="smallButton" data-target="#smallModal"
                                data-attr="' . $pc->ward_name . '" title="show">
                                <i class="fas fa-plus-circle text-success  fa-lg"> </i>Create Bed Price
                            </a>';
                        }else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Active</a>';
                        }
                    })
        ->rawColumns(['visible','edit','addBed','viewBeds','price'])

        ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('admin.wards.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.wards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $cheek = Ward::where('ward_name', '=', $request->ward_name)->first();
      // dd($cheek);
        if(!empty($cheek)) {

                        $msg = 'The Ward with a Title  [' .$request->ward_name . '] was already exist in our record.';
                    Alert::warning('Warning Title', $msg);
                      return redirect()->back()->with( $msg)->withInput();
        }

        $rules = [
            'ward_name'          => 'required',
            'description'         => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {

                $ward                     = new Ward;
                // dd($ward);
                $ward->ward_name       = $request->ward_name;
                $ward->description        = $request->description;
                $ward->visible            = 1;
                $ward->price_assing       = 0;
                $ward->bed_assing       = 0;
                if( $ward->save() ) {
                        $msg = 'The ward [' . $request->ward_name . '] was successfully Saved.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('wards.index')->withMessage($msg)->withMessageType('success');


                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
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
    public function edit($id)
    {
         $ward = Ward::find($id);

          return view('admin.wards.edite', compact('ward'));
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

        $rules = [
            'ward_name'  => 'required',
            'description'  => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {

                $ward                     =  Ward::find($id);
                $ward->ward_name        = $request->ward_name;
                $ward->description        = $request->description;
                $ward->visible            = $request->visible;
                if( $ward->update() ) {
                     $msg = 'ward Updated Successfuly.';
                    Alert::warning('Success ', $msg);
                        return redirect(route('wards.index'))->with('toast_success', $msg);


                } else {
                    $msg = 'Something is went wrong. Please try again later, Product not Saved.';
                    //flash($msg, 'danger');
                    return redirect()->back()->with('error', $msg)->withInput();
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
