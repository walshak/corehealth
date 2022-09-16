<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lab;
use App\User;
use App\LabManager;
use Auth;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
class LabManagersController extends Controller
{

     public function listLabStaffs()
    {
       $pc = LabManager::where('id', '>', 0)->get();

                return Datatables::of($pc)
                    ->addIndexColumn()

                    ->editColumn('visible', function($pc){
                     return (($pc->status == 0)?"Inactive":"Active");
                    })


                    ->addColumn('fullname', function($pc){
                        return ( userfullname($pc->user->id));
                    })
                    ->editColumn('phone_number', function($pc){
                     return ($pc->user->phone_number);
                    })
                    ->editColumn('email', function($pc){
                     return ($pc->user->email);
                    })
                     ->addColumn('action', function($pc){
                        $url =  route('lab-managers.edit', $pc->id);
                       if ($pc->status == 1) {


                            return '<a href="' . $url . '" class="btn btn-warning btn-sm"><i class="fa fa-eye nav-icon text-success"> </i>Deactivate</a>';
                        } else {

                             return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-eye nav-icon text-warning"> </i> Activate</a>';
                        }
                    })
                     ->addColumn('remove', function($pc){
                        $url = $pc->id;


                              return '<button id="deleteRecord" class="btn btn-danger btn-sm deleteRecord" data-id="' . $url . '" > <i class="fa fa-trash"></i> Remove Staff </button>';


                    })
                     // ->addColumn('remove', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> </button>')



        ->rawColumns(['visible', 'fullname','email','phone_number', 'action','remove'])

        ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     $labm =LabManager::where('lab_id', '=', $request->lab_id)->where('user_id', '=', $request->user_id)->first();
       if (!empty($labm)) {
           $msg = 'Staff alredy Exists in this Lab.';
                        Alert::warning('Warning Title', $msg);
                        return redirect()->route('ShowLabStaffs',$labm->lab_id)->withMessage($msg)->withMessageType('warning');
       }

        $rules = [
            'user_id'          => 'required',
            'lab_id'          => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {

                $lab                     = new LabManager;
                // dd($lab);
                $lab->user_id            = $request->user_id;
                $lab->lab_id              = $request->lab_id;
                $lab->status            = 1;

                if( $lab->save() ) {
                          $msg = 'lab Manager Assing.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('ShowLabStaffs',$request->lab_id)->withMessage($msg)->withMessageType('success');


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
        $lab = Lab::find($id);
        $users = User::where('visible','>',0)->whereIsAdmin(16)->get();
        return view('admin.lab_managers.create', compact('lab','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $labm =LabManager::find($id);
       if ( $labm->status == 1) {
           $labm->status = 0;
           $labm->update();

           $msg = 'Staff Deactivate successfuly.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('ShowLabStaffs',$labm->lab_id)->withMessage($msg)->withMessageType('success');
       }else{
        $labm->status = 1;
        $labm->update();
         $msg = 'Staff Activate successfuly.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('ShowLabStaffs',$labm->lab_id)->withMessage($msg)->withMessageType('success');
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
       $labm = LabManager::where('id', "=", $id)->delete();

        $msg = 'Staff Has Removed  successfuly.';
        Alert::success('Success ', $msg);
        return redirect()->route('ShowLabStaffs',$labm->lab_id)->withMessage($msg)->withMessageType('success');
    }
     public function ShowLabStaffs($id)
    {   $lab = Lab::find($id);
        return view('admin.lab_managers.show_Lab_staffs', compact('lab'));
    }
}
