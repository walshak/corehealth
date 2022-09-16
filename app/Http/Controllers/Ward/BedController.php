<?php

namespace App\Http\Controllers\Ward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ward;
use App\Bed;
use App\PaymentType;
use App\PaymentItem;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Auth;
class BedController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ListWardBets($id)
    {
         $pc =  Bed::where('ward_id', '=', $id)->get();
        //dd($pc);
                return Datatables::of($pc)
                    ->addIndexColumn()

                    ->editColumn('visible', function($pc){
                    return (($pc->visible == 0)?"InActive":"Active");
                    })

                    ->editColumn('status', function($pc){
                     return (($pc->status == 0)?"Available":"Addmision ON");
                    })

                    ->addColumn('edit', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('wards.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-success btn-sm"><i class="fa fa-pencil nav-icon text-warning"> </i> edit</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i> edit</a>';
                        }
                    })
                    ->addColumn('delete', function($pc){

                       if (Auth::user()->hasRole(['Super-Admin', 'Admin']) || Auth::user()->hasPermissionTo('customer-edit')) {

                            $url =  route('wards.edit', $pc->id);
                            return '<a href="' . $url . '" class="btn btn-danger btn-sm"><i class="fa fa-pencil nav-icon text-primary"> </i> Delete</a>';
                        } else {

                            return '<a href="#" class="btn btn-info btn-sm"> <i class="fa fa-circle-o text-primary"></i>View Bed</a>';
                        }
                    })

        ->rawColumns(['visible','edit','status','delete'])

        ->make(true);
    }
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
      //dd($request);


       $cheek = Ward::where('ward_name', '=', $request->ward_id)->first();
      // // dd($cheek);
        if( $request->p_bed_no == 0 AND  $request->pr_bed_no == 0 ) {

                        $msg = 'No Bed Number   ';
                    Alert::warning('Warning Title', $msg);
                      return redirect()->route('wards.index')->withMessage($msg)->withMessageType('warning');
        }

        $rules = [
            'ward_id'          => 'required',
        ];



        try {


            $v = validator()->make($request->all(), $rules);

            if($v->fails()){
                // Alert::error('Error Title', 'One or more information is needed.');
                // return redirect()->back()->withInput()->withErrors($v);
                // return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
                return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();

            } else {
                   $p_bed_no = $request->p_bed_no + 1;
                   $pr_bed_no = $request->pr_bed_no + 1;
                  if ($request->p_bed_no > 0) {
                       for ($i=1; $i < $p_bed_no; $i++) {


                        $bed                     = new Bed;
                        $bed->ward_id            = $cheek->id;
                        $bed->bed_name           = $request->ward_id .' '. 'Public Bed'.$i;
                        $bed->describtion        = $request->ward_id .' '. 'Public Bed'.$i;
                        $bed->bed_type           = 1;
                        $bed->status             = 0;
                        $bed->visible            = 1;

                        $bed->save();
                      }
                   }
                  if ($request->pr_bed_no > 0) {
                       for ($k=1; $k < $pr_bed_no; $k++) {


                        $pr_bed                     = new Bed;
                        $pr_bed->ward_id            = $cheek->id;
                        $pr_bed->bed_name           = $request->ward_id .' '. 'Private Bed'.$k;
                        $pr_bed->describtion        = $request->ward_id .' '. 'Private Bed'.$k;
                        $pr_bed->bed_type           = 2;
                        $pr_bed->status             = 0;
                        $pr_bed->visible            = 1;

                         $pr_bed->save();
                      }
                   }

                        $ward = Ward::find($cheek->id);
                      $ward->bed_assing = 1;
                      $ward->save();
                        $msg = 'The beds  for [' . $request->ward_id . '] was successfully Created.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('beds.show',$cheek->id)->withMessage($msg)->withMessageType('success');



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
         $beds = Bed::where('ward_id', '=', $id)->first();
         return view('admin.beds.ward_beds',compact('id','beds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }
    public function bedPrice(Request $request)

   {


        $rules = [
            'item_name'          => 'required',
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
                      $cheek = PaymentType::where('payment_type_name', '=', $request->payment_type_name)->first();
                     if (!empty($cheek)) {

                            $msg = 'The payment_type_name already  Exist';
                            return redirect()->back()->with('toast_warning', $msg)->withInput();

                     }
                    if ($request->public_amount > 0) {
                        $item                     = new PaymentItem;
                        $item->payment_type_id    = $request->payment_type_id;
                        $item->item_name          = $request->item_name .''. 'Public Bed';
                        $item->description        = $request->description;
                        $item->amount             = $request->public_amount;
                        $item->visible            = 1;
                        $item->save();
                    }
                     if ($request->private_amount > 0) {
                        $pr_item                     = new PaymentItem;
                        $pr_item->payment_type_id    = $request->payment_type_id;
                        $pr_item->item_name          = $request->item_name .''. 'Private Bed';
                        $pr_item->description        = $request->description;
                        $pr_item->amount             = $request->public_amount;
                        $pr_item->visible            = 1;
                        $pr_item->save();
                    }
                      $ward = Ward::where('ward_name', '=', $request->item_name)->first();
                      $ward->price_assing = 1;
                      $ward->save();

                        $msg = 'The beds  Price was successfully Created.';
                        Alert::success('Success ', $msg);
                        return redirect()->route('wards.index')->withMessage($msg)->withMessageType('success');



            }
        } catch(Exception $e) {

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
