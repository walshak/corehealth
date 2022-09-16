<?php

namespace App\Http\Controllers;

use App\NursingNote;
use App\Patient;
use App\Dependant;
use App\NursingNoteType;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class NursingNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patient_id = $request->input('patient_id');
        $patient = Patient::find($patient_id);
        $depndant_id = $request->input('dependant_id') ?? null;
        $depndant = ($depndant_id) ? Dependant::find($depndant_id) : null;

        if($depndant){
            $observation_note = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',1)
                ->first() ?? null;
            $observation_note_template = NursingNoteType::find(1);

            $treatment_sheet = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',2)
                ->first() ?? null;
            $treatment_sheet_template = NursingNoteType::find(2);

            $io_chart = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',3)
                ->first() ?? null;

            $treatment_sheet_template = NursingNoteType::find(3);

            $labour_record = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',4)
                ->first() ?? null;

            $labour_record_template = NursingNoteType::find(4);
        }else{
            $observation_note = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',1)
                ->first() ?? null;

            $observation_note_template = NursingNoteType::find(1);

            $treatment_sheet = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',2)
                ->first() ?? null;

            $treatment_sheet_template = NursingNoteType::find(2);

            $io_chart = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',3)
                ->first() ?? null;

            $io_chart_template = NursingNoteType::find(3);

            $labour_record = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',4)
                ->first() ?? null;

            $labour_record_template = NursingNoteType::find(4);
        }
        return view('admin.nursing_notes.index',compact('patient','depndant','observation_note','treatment_sheet','io_chart','labour_record',
            'observation_note_template','treatment_sheet_template','io_chart_template','labour_record_template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->patient_id);
        $rules = [
            'patient_id'  => 'required',
            'note_type'  => 'required',
            'the_text' => 'required'
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if ($v->fails()) {
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
            } else {
                $note = new NursingNote;

                $note->patient_id = $request->patient_id;
                $note->nursing_note_type_id = $request->note_type;
                $note->created_by = Auth::id();
                (!empty($request->dependant_id)) ? $note->dependant_id = $request->dependant_id : $note->dependant_id = null;
                $note->note = $request->the_text;

                if($note->save()){
                    return redirect()->back()->withMessage("Done");
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->withMessage("An error occurred " . $e->getMessage());
        }
    }

    public function new_note(Request $request){
        $patient_id = $request->input('patient_id');
        $depndant_id = $request->input('dependant_id') ?? null;
        $type = $request->note_type;

        if($depndant_id){
            if($type == 1){
                $observation_note = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',1)
                ->first() ?? null;

                if($observation_note){
                    if($observation_note->update(['completed'=>true,'note' => $this->remove_editable($observation_note->note)])){
                        return back();
                    }
                }
            }elseif($type == 2){
                $treatment_sheet = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',2)
                ->first() ?? null;

                if($treatment_sheet){
                    if($treatment_sheet->update(['completed'=>true, 'note' => $this->remove_editable($treatment_sheet->note)])){
                        return back();
                    }
                }
            }elseif($type == 3){
                $io_chart = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',3)
                ->first() ?? null;

                if($io_chart){
                    if($io_chart->update(['completed'=>true, 'note' => $this->remove_editable($io_chart->note)])){
                        return back();
                    }
                }
            }else{
                $labour_record = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',$depndant_id)
                ->where('completed',false)
                ->where('nursing_note_type_id',4)
                ->first() ?? null;

                if($labour_record){
                    if($labour_record->update(['completed'=>true, 'note' => $this->remove_editable($labour_record->note)])){
                        return back();
                    }
                }
            }
        }else{
            if($type == 1){
                $observation_note = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',1)
                ->first() ?? null;

                if($observation_note){
                    if($observation_note->update(['completed'=>true, 'note' => $this->remove_editable($observation_note->note)])){
                        return back();
                    }
                }
            }elseif($type == 2){
                $treatment_sheet = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',2)
                ->first() ?? null;

                if($treatment_sheet){
                    if($treatment_sheet->update(['completed'=>true, 'note' => $this->remove_editable($treatment_sheet->note)])){
                        return back();
                    }
                }
            }elseif($type == 3){
                $io_chart = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',3)
                ->first() ?? null;

                if($io_chart){
                    if($io_chart->update(['completed'=>true, 'note' => $this->remove_editable($io_chart->note)])){
                        return back();
                    }
                }
            }else{
                $labour_record = NursingNote::with(['patient','created_by','type'])
                ->where('patient_id',$patient_id)
                ->where('dependant_id',null)
                ->where('completed',false)
                ->where('nursing_note_type_id',4)
                ->first() ?? null;

                if($labour_record){
                    if($labour_record->update(['completed'=>true, 'note' => $this->remove_editable($labour_record->note)])){
                        return back();
                    }
                }
            }
        }

    }

    public function remove_editable($the_string){
        //make all contenteditable section uneditable, so that they wont be editable when they show up in medical history
        $the_string = str_replace('contenteditable="true"', 'contenteditable="false"', $the_string);
        $the_string = str_replace("contenteditable='true'", "contenteditable='false'", $the_string);
        $the_string = str_replace('contenteditable = "true"', 'contenteditable="false"', $the_string);
        $the_string = str_replace("contenteditable ='true'", "contenteditable='false'", $the_string);
        $the_string = str_replace('contenteditable= "true"', 'contenteditable="false"', $the_string);
        //remove all black borders
        $the_string = str_replace(' black', ' gray', $the_string);
        return $the_string;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NursingNote  $nursingNote
     * @return \Illuminate\Http\Response
     */
    public function show(NursingNote $nursingNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NursingNote  $nursingNote
     * @return \Illuminate\Http\Response
     */
    public function edit(NursingNote $nursingNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NursingNote  $nursingNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NursingNote $nursingNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NursingNote  $nursingNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(NursingNote $nursingNote)
    {
        //
    }
}
