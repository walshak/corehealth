<?php

namespace App\Http\Controllers;

use App\Hmo;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Response;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class HmoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hmo.index');
    }

    public function listHmos()
    {

        $hmos = Hmo::orderBy('name', 'ASC')->get();

        return Datatables::of($hmos)
            ->addIndexColumn()
            ->addColumn('edit',   '<a href="{{ route(\'hmos.edit\', $id)}}" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> Edit</a>')
            ->addColumn('delete', '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="{{$id}}"><i class="fa fa-trash"></i> Delete</button>')
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hmo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =
            [
                'name' => 'required|unique:roles,name',
                'desc' => 'nullable|min:3|max:500',
                'discount' => 'numeric|required'
            ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            Alert::error('Error Title', 'One or more information is needed.');
            return redirect()->back()->withInput()->withErrors($v);
        } else {

            $hmo              = new Hmo;
            $hmo->name        = $request->name;
            $hmo->discount    = $request->discount;
            $hmo->desc        = $request->desc;

            if ($hmo->save()) {
                $hmo->syncPermissions($request->permission);
                // return response()->json($hmo);
                $msg = 'The Hmo [' . $hmo->name . '] was successfully Saved.';
                Alert::success('Success ', $msg);
                return redirect()->route('hmos.index')->withMessage($msg)->withMessageType('success');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function show(Hmo $Hmo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function edit(Hmo $Hmo)
    {
        return view('admin.hmo.edit')->with('hmo', $Hmo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hmo $Hmo)
    {
        $rules =
            [
                'name' => 'required',
                'desc' => 'nullable|min:3|max:500',
                'discount' => 'numeric|required'
            ];
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // return Response::json(array('errors' => $v->getMessageBag()->toArray()));
            Alert::error('Error Title', 'One or more information is needed.');
            return redirect()->back()->withInput()->withErrors($v);
        } else {

            $Hmo->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'discount' => $request->discount
            ]);
            $Hmo->syncPermissions($request->permission);

            $msg = 'The Hmo [' . $Hmo->name . '] was successfully updated.';
            Alert::success('Success ', $msg);
            return redirect()->route('hmos.index')->withMessage($msg)->withMessageType('success');
            // return response()->json($role);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hmo  $Hmo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hmo $Hmo)
    {
        $hmo = $Hmo->delete();
        return response()->json($hmo);
    }
}
