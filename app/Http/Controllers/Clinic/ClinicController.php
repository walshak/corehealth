<?php

namespace App\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FFI\Exception;
use App\ApplicationStatu;
use App\User;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Patient;
use App\Clinic;
use Auth;
class ClinicController extends Controller
{
    public function listClinics()
    {
       $pc = Clinic::all();

        return Datatables::of($pc)
            ->addIndexColumn()
            ->editColumn('visible', function($pc){
                return (($pc->visible == 0)?"Inactive":"Active");
            })
            ->addColumn('edit', function($pc){
                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                    $url =  route('clinics.edit', $pc->id);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-pencil nav-icon text-success"> </i> edit</a>';
                } else {

                    return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                }
            })
            ->rawColumns(['visible','edit'])
            ->make(true);
    }

    public function index()
    {
       return view('admin.clinics.index');
    }

    public function create()
    {
        return view('admin.clinics.create');
    }

    public function getNoteTemplate($id){
        $tem = Clinic::find($id);
        $tem = $tem->clinic_note_format;
        return response(json_encode(['template'=>$tem]));
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
            'clinic_name'          => 'required',
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

                $clinic                     = new Clinic;
                // dd($clinic);
                $clinic->clinic_name       = $request->clinic_name;
                $clinic->description        = $request->description;
                $clinic->visible            = 1;
                 $msg = 'Clinic Saved.';
                if( $clinic->save() ) {
                        return redirect(route('clinics.index'))->with('toast_success', $msg);


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
        $clinic = Clinic::find($id);
        return view('admin.clinics.edite', compact('clinic'));
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
            'clinic_name'  => 'required',
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

                $clinic                     =  Clinic::find($id);
                $clinic->clinic_name        = $request->clinic_name;
                $clinic->description        = $request->description;
                $clinic->visible            = $request->visible;

                if( $clinic->update() ) {
                     $msg = 'Clinic Updated Successfuly.';
                        return redirect(route('clinics.index'))->with('toast_success', $msg);
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
