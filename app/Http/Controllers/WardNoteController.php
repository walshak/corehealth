<?php

namespace App\Http\Controllers;

use Auth;
use App\Dependant;
use App\Patient;
use App\WardNote;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class WardNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ward_notes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $patient_id = $request->get('patient_id');
        if(null != $request->get('dependant_id')){
            $dependant_id = $request->get('dependant_id');
            $patient = Patient::find($patient_id);
            $dependant = Dependant::find($dependant_id);
        }else{
            $dependant_id = $dependant = null;
            $patient = Patient::find($patient_id);
        }

        return view('admin.ward_notes.create',compact('patient','dependant'));
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
            'title'  => 'required',
            'patient_id'  => 'required',
            'note'   => 'nullable',
        ];

        if ($request->hasFile('filename')) {
            #  Making sure the file being validated
            $rules += [
                'filename' => 'max:100024|mimes:jpeg,docx,png,gif,pdf,jpg',
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
                $path_o = storage_path('/app/public/image/user/ward_notes/');
                $file_o = $request->file('filename');
                $extension_o = strtolower($file_o->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name_o = str_replace(" ", "-", strtolower($file_o->getClientOriginalName()));
                $name_o = str_replace("_", "-", $name_o);
                $filename_o = time() . '-' . $name_o;
                //dd($filename_o);

                if (Storage::disk('ward_notes')->exists($filename_o)) {
                    // delete image before uploading
                    Storage::disk('ward_notes')->delete($filename_o);

                    Storage::disk('ward_notes')->put($filename_o,$file_o->get());
                } else {
                    Storage::disk('ward_notes')->put($filename_o,$file_o->get());
                }
            }
            $note = new WardNote;
            if($request->filename){
                $note->filename    = ($filename_o) ? $filename_o : null;
            }else{
                $note->filename    = null;
            }

            $note->title = $request->title;
            $note->note = $request->note;
            $note->patient_id = $request->patient_id;
            $note->user_id = Auth::id();
            if(!empty($request->dependant_id)){
                $note->dependant_id = $request->dependant_id;
            }else{
                $note->dependant_id = null;
            }

            if($note->save()){
                $msg = 'Note saved sucessfully';
                Alert::success('Success ', $msg);
                return redirect()->route('ward_note.index');
            }else{
                $msg = 'Something is went wrong. Please try again later.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WardNote  $wardNote
     * @return \Illuminate\Http\Response
     */
    public function show(WardNote $wardNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WardNote  $wardNote
     * @return \Illuminate\Http\Response
     */
    public function edit(WardNote $wardNote)
    {

        $patient_id = $wardNote->patient_id;
        if(null != $wardNote->dependant_id){
            $dependant_id = $wardNote->dependant_id;
            $patient = Patient::find($patient_id);
            $dependant = Dependant::find($dependant_id);
        }else{
            $dependant_id = $dependant = null;
            $patient = Patient::find($patient_id);
        }

        return view('admin.ward_notes.edit',compact('patient','dependant','wardNote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WardNote  $wardNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WardNote $wardNote)
    {
        $rules = [
            'title'  => 'required',
            'note'   => 'nullable',
        ];

        if ($request->hasFile('filename')) {
            #  Making sure the file being validated
            $rules += [
                'filename' => 'max:100024|mimes:jpeg,docx,png,gif,pdf,jpg',
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
                $path_o = storage_path('/app/public/image/user/ward_notes/');
                $file_o = $request->file('filename');
                $extension_o = strtolower($file_o->getClientOriginalExtension());

                // format of file is "timestamp-file-name.extension"
                $name_o = str_replace(" ", "-", strtolower($file_o->getClientOriginalName()));
                $name_o = str_replace("_", "-", $name_o);
                $filename_o = time() . '-' . $name_o;
                //dd($filename_o);

                if (Storage::disk('ward_notes')->exists($filename_o)) {
                    // delete image before uploading
                    Storage::disk('ward_notes')->delete($filename_o);

                    Storage::disk('ward_notes')->put($filename_o,$file_o->get());
                } else {
                    Storage::disk('ward_notes')->put($filename_o,$file_o->get());
                }
            }
            $note = $wardNote;
            if($request->filename){
                $note->filename    = ($filename_o) ? $filename_o : null;
            }else{
                $note->filename    = null;
            }

            $note->title = $request->title;
            $note->note = $request->note;

            if($note->update()){
                $msg = 'Note Updated sucessfully';
                Alert::success('Success ', $msg);
                return redirect()->route('ward_note.index');
            }else{
                $msg = 'Something is went wrong. Please try again later.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WardNote  $wardNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(WardNote $wardNote)
    {
        //
    }

    public function listWardNotes(Request $request){
        $patient_id = $request->get('patient_id') ?? null;
        $dependant_id = $request->get('dependant_id') ?? null;
        if(null == $patient_id && null == $dependant_id){
            $note = WardNote::where('status',1)->orderBy('created_at','DESC')->get();
        }elseif(null != $patient_id && null == $dependant_id){
            $note = WardNote::where('status',1)->orderBy('created_at','DESC')
                ->where('patient_id',$patient_id)->where('dependant_id',null)->get();
        }elseif(null != $patient_id && null != $dependant_id){
            $note = WardNote::where('status',1)->orderBy('created_at','DESC')
                ->where('patient_id',$patient_id)->where('dependant_id',$dependant_id)->get();
        }
        return Datatables::of($note)
            ->addIndexColumn()
            ->addColumn('edit',   function($note){
                if($note->user_id == Auth::id() || Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')){
                    $url = route('ward_note.edit', $note->id);
                    return '<a href="'.$url.'" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> Edit</a>';
                }else{
                    return '<a href="#" class="btn btn-info btn-sm" ><i class="fa fa-circle"></i> Edit</a>';
                }
            })
            ->addColumn('delete',   function($note){
                if($note->user_id == Auth::id() || Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')){
                    return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="'.$note->id.'"><i class="fa fa-trash"></i> Delete</button>';
                }else{
                    return '<a href="#" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Delete</a>';
                }
            })
            ->editColumn('user_id', function($note){
                $posted_by = userfullname($note->user_id);
                return $posted_by;
            })
            ->editColumn('title', function($note){
                if ($note->filename != null){
                    $url = url('storage/image/user/ward_notes/' . $note->filename);
                    return '<span>'.$note->title.'</span><br><a href="'.$url.'" target="_blank"><i class="fa fa-file"></i> Attached File </a>';
                }else{
                    return "<span>$note->title</span><br><span class='badge badge-warning'>No file attached</span>";
                }
            })
            ->editColumn('patient_id', function($note){
                if (null == $note->dependant_id) {
                    $p = Patient::find($note->patient_id);
                    return userfullname($p->user_id);
                } else {
                    $p = Patient::find($note->patient_id);
                    $d = Dependant::find($note->dependant_id);
                    return $d->fullname .' ('.userfullname($p->user_id).')';
                }
            })
            ->editColumn('created_at', function ($note) {
                return date('h:i a D M j, Y', strtotime($note->created_at));
            })
            ->rawColumns(['title','edit', 'delete'])
            ->make(true);
    }
}
