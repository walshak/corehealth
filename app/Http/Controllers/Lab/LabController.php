<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lab;
use App\LabService;
use App\ApplicationStatu;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Patient;
use App\Clinic;
use Auth;

class LabController extends Controller
{
    public function listLabs()
  
    {
       $pc = Lab::all();
        //dd($pc);
                return Datatables::of($pc)
                    ->addIndexColumn()
                    
                    ->editColumn('visible', function($pc){
                     return (($pc->visible == 0)?"Inactive":"Active");
                    })
                    ->addColumn('edit', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('labs.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil nav-icon "> </i> edit</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                        }
                    })
                    ->addColumn('services', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('showLabServices', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-eye nav-icon text-warning"> </i> View</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-warning"></i> View</a>';
                        }
                    })
                     ->addColumn('addServices', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('lab-services.show', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-plus nav-icon text-primary"> </i> Add</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Add</a>';
                        }
                    })
                     ->addColumn('staffs', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('lab-managers.show', $pc->id);
                            $url1 =  route('ShowLabStaffs', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-plus nav-icon text-primary"> </i> Add</a>'. "-". '<a href="' . $url1 . '" class="btn btn-success btn-sm"><i class="fa fa-eye nav-icon text-primary"> </i> View</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> Add</a>';
                        }
                    })
        ->rawColumns(['visible','edit','services','addServices','staffs'])

        ->make(true);
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.labs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.labs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //dd($request);

        $rules = [
            'lab_name'          => 'required',
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

                $lab                     = new Lab;
                // dd($lab);
                $lab->lab_name       = $request->lab_name;
                $lab->description        = $request->description;
                $lab->visible            = 1;
                 $msg = 'lab Saved.';
                if( $lab->save() ) {
                        return redirect(route('labs.index'))->with('toast_success', $msg);
                   

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
        $lab = Lab::find($id);

          return view('admin.labs.edite', compact('lab'));
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
            'lab_name'  => 'required',
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

                $lab                     =  Lab::find($id);
                $lab->lab_name           = $request->lab_name;
                $lab->description        = $request->description;
                $lab->visible            = $request->visible;
                if( $lab->update() ) {
                     $msg = 'lab Updated Successfuly.';
                        return redirect(route('labs.index'))->with('toast_success', $msg);
                   

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
