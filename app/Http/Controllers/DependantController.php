<?php

namespace App\Http\Controllers;

use App\Dependant;
use Auth;
use App\Hmo;
use App\User;
use App\Patient;
use App\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DependantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.patients.dependants.index');
    }


    public function listDependants()
    {
        return view('admin.patients.dependants.patient_list');
    }

    public function dependantsList()
    {
        $pc = Dependant::with('patient')->get();
        //dd($pc);
        return Datatables::of($pc)
            ->addIndexColumn()
            ->addColumn('edit', function ($pc) {
                $url =  route('dependants.edit', $pc->id);
                return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Edit</a>';
            })
            ->addColumn('delete', function ($pc) {
                if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {
                    $url = route('dependants.destroy', $pc->id);
                    return "<form method='post' action='$url'><button class = 'btn btn-danger btn-sm'> <i class='fa fa-trash'> </i> Delete</button><form>";
                } else {
                    $url = route('dependants.destroy', $pc->id);
                    return "<button class = 'btn btn-danger btn-sm' disabled> <i class='fa fa-trash'> </i> Delete</button>";
                }
            })
            ->addColumn('file_no', function ($pc) {
                return $pc->patient->file_no;
            })
            ->addColumn('principal', function ($pc) {
                return userfullname($pc->patient->user_id);
            })
            ->addColumn('hmo', function ($pc) {
                $hmo = Hmo::find($pc->patient->hmo_id);
                return $hmo->name;
            })
            ->addColumn('services', function ($pc) {
                if(Auth::user()->hasRole(['Super-Admin','Admin','Accounts','Receptionist'])){
                    $url =  route('patient.services_rendered',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Print</a>';
                }else{
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> Print</a>';
                }
            })
            ->addColumn('note', function ($pc) {
                if(Auth::user()->hasRole(['Super-Admin','Admin','Doctor','Nurse'])){
                    $url =  route('ward_note.create',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
                }else{
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> Add</a>';
                }

                if(Auth::user()->hasRole(['Doctor'])){
                    $url =  route('ward_note.create',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
                }elseif(Auth::user()->hasRole(['Nurse'])){
                    $url =  route('nursing-note.create',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a>';
                }elseif(Auth::user()->hasRole(['Admin','Super Admin'])){
                    $url =  route('ward_note.create',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add</a><br>';
                    $url =  route('nursing-note.create',['patient_id'=>$pc->patient_id,'dependant_id'=> $pc->id]);
                    return '<a href="' . $url . '" class="btn btn-primary btn-sm"><i class="fa fa-plus nav-icon text-success"> </i> Add(Nurse)</a>';
                }else{
                    return '<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-circle nav-icon text-success"> </i> Add</a>';
                }
            })
            ->rawColumns(['fullname', 'edit', 'hmo', 'delete','note','services'])

            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_detail = User::find($request->id);
        $fullname = userfullname($user_detail->id);
        $patient = Patient::where('user_id', '=', $request->id)->first();
        //dd($patient);
        $states = State::where('status_id', '=', 1)->pluck('name', 'id')->all();
        $hmos = Hmo::find($patient->hmo_id);
        // dd($hmos);

        return view('admin.patients.dependants.create', compact('user_detail', 'fullname', 'patient', 'states', 'hmos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'gender'  => 'bail|required',
            'dob' => 'required',
            'fullname' => 'required'

        ];

        if ($request->hasFile('filename')) {
            #  Making sure if password change was selected it's being validated
            $rules += [
                'filename' => 'max:1024|mimes:jpeg,bmp,png,gif,svg,jpg',
            ];
        }
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            // Alert::error('Error Title', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            if ($request->hasFile('filename')) {
                $path = storage_path('/app/public/image/user/');
                $file = $request->file('filename');
                $extension = strtolower($file->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name = str_replace(" ", "-", strtolower($file->getClientOriginalName()));
                $name = str_replace("_", "-", $name);
                $filename = time() . '-' . $name;

                if (Storage::disk('user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($path . $filename);

                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                } else {
                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                }

                $thumbnail_path = storage_path('/app/public/image/user/thumbnail/');
                // save thumbnail for user images
                if (Storage::disk('thumbnail_user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($thumbnail_path . $filename);

                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                } else {
                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                }
            }

            $dependant_detail  = new Dependant;
            $dependant_detail->patient_id     = $request->patient_id;
            $dependant_detail->fullname     = $request->fullname;
            $dependant_detail->gender         = $request->gender;
            $dependant_detail->blood_group_id = $request->blood_group_id;
            $dependant_detail->genotype       = $request->genotype;
            // $dependant_detail->hieght         = $request->hieght;
            $dependant_detail->disability     = $request->disability;
            // $dependant_detail->weight         = $request->weight;
            $dependant_detail->dob            = $request->dob;
            $dependant_detail->hmo_id         = $request->hmo;
            $dependant_detail->hmo_no         = $request->hmo_no;
            $dependant_detail->visible        = 2;


            if ($dependant_detail->save()) {
                $msg = 'Record Saved';
                Alert::success('Success ', $msg);
                return redirect()->back();
            }
        }
    }

    public function getMyDependants($user_id){
        $user = User::find($user_id);
        $patient = Patient::where('user_id',$user->id)->first();
        // dd($patient);
        $dependants = Dependant::where('patient_id',$patient->id)->get();
        return response(json_encode($dependants));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function show(Dependant $dependant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function edit(Dependant $dependant)
    {
        $dependant = $dependant;
        $user_detail = User::find($dependant->patient->user_id);
        $fullname = userfullname($user_detail->id);
        $patient = Patient::where('user_id', '=', $dependant->patient->user_id)->first();
        //dd($patient);
        $states = State::where('status_id', '=', 1)->pluck('name', 'id')->all();
        $hmos = Hmo::find($patient->hmo_id);
        // dd($hmos);

        return view('admin.patients.dependants.edit', compact('user_detail', 'fullname', 'patient', 'states', 'hmos','dependant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependant $dependant)
    {
        $rules = [
            'gender'  => 'bail|required',
            'dob' => 'required',
            'fullname' => 'required'

        ];

        if ($request->hasFile('filename')) {
            #  Making sure if password change was selected it's being validated
            $rules += [
                'filename' => 'max:1024|mimes:jpeg,bmp,png,gif,svg,jpg',
            ];
        }
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            // Alert::error('Error Title', 'One or more information is needed.');
            // return redirect()->back()->withInput()->withErrors($v);
            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            if ($request->hasFile('filename')) {
                $path = storage_path('/app/public/image/user/');
                $file = $request->file('filename');
                $extension = strtolower($file->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name = str_replace(" ", "-", strtolower($file->getClientOriginalName()));
                $name = str_replace("_", "-", $name);
                $filename = time() . '-' . $name;

                if (Storage::disk('user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($path . $filename);

                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                } else {
                    Image::make($file)
                        ->resize(215, 215)
                        ->save($path . $filename);
                }

                $thumbnail_path = storage_path('/app/public/image/user/thumbnail/');
                // save thumbnail for user images
                if (Storage::disk('thumbnail_user_images')->exists($filename)) {
                    // delete image before uploading
                    File::delete($thumbnail_path . $filename);

                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                } else {
                    Image::make($file)
                        ->resize(106, 106)
                        ->save($thumbnail_path . $filename);
                }
            }

            $dependant_detail                 = $dependant;
            $dependant_detail->patient_id     = $request->patient_id;
            $dependant_detail->fullname       = $request->fullname;
            $dependant_detail->gender         = $request->gender;
            $dependant_detail->blood_group_id = $request->blood_group_id;
            $dependant_detail->genotype       = $request->genotype;
            // $dependant_detail->hieght         = $request->hieght;
            $dependant_detail->disability     = $request->disability;
            // $dependant_detail->weight         = $request->weight;
            $dependant_detail->dob            = $request->dob;
            $dependant_detail->hmo_id         = $request->hmo;
            $dependant_detail->hmo_no         = $request->hmo_no;
            $dependant_detail->visible        = 2;


            if ($dependant_detail->Update()) {
                $msg = 'Record Updated';
                Alert::success('Success ', $msg);
                return redirect()->route('dependants.index');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependant $dependant)
    {
        //
    }
}
