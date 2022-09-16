<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use App\ApplicationStatu;
use App\User;
use App\Status;
use App\Product;
use App\Category;
use App\StoreStoke;
use App\Stock;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCategories()
    {

        $productCat = Category::where('status_id', '>', 0)->orderBy('id', 'ASC')->get();


        return Datatables::of($productCat)
            ->addIndexColumn()
            ->addColumn('category_code', function ($productCat) {
                $category_code = '<span class="badge badge-pill badge-dark">' . $productCat->category_code . '</sapn>';
                return $category_code;
            })
            ->addColumn('status_id', function ($productCat) {

                $active = '<span class="badge badge-pill badge-success">Active</sapn>';
                $inactive = '<span class="badge badge-pill badge-dark">Inactive</sapn>';
                return (($productCat->status_id == 1) ? $inactive : $active);
            })
            ->addColumn('view', function ($productCat) {

                if (Auth::user()->hasPermissionTo('user-show') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url =  route('categories.show', $productCat->id);
                    return '<a href="' . $url . '" class="btn btn-success btn-sm" ><i class="fa fa-street-view"></i> View</a>';
                } else {

                    $label = '<span class="label label-warning">Not Allowed</span>';
                    return $label;
                }
            })
            ->addColumn('edit', function ($productCat) {

                if (Auth::user()->hasPermissionTo('user-edit') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {

                    $url =  route('categories.edit', $productCat->id);
                    return '<a href="' . $url . '" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i> Edit</a>';
                } else {

                    $label = '<span class="label label-warning">Not Allow</span>';
                    return $label;
                }
            })
            // ->addColumn('delete', function ($productCat) {

            //     if (Auth::user()->hasPermissionTo('user-delete') || Auth::user()->hasRole(['Super-Admin', 'Admin'])) {
            //         $id = $productCat->id;
            //         return '<button type="button" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-id="' . $id . '" data-target="#deleteModal"><i class="fa fa-trash"></i> Delete</button>';
            //     } else {
            //         $label = '<span class="label label-danger">Not Allow</span>';
            //         return $label;
            //     }
            // })
            ->rawColumns(['category_code', 'status_id', 'view', 'edit'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'category_name'        => 'required',
            'category_code'        => 'required',
            'category_description' => 'required'
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {

            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $category                       = new Category();
            $category->category_name        = $request->category_name;
            $category->category_code        = $request->category_code;
            $category->category_description = $request->category_description;
            $category->status_id              = 2;

            if ($category->save()) {
                $msg = 'The Category ' . $request->category_name . ' was saved successfully.';
                return redirect(route('categories.index'))->with('toast_success', $msg);
            } else {

                $msg = 'Something is went wrong. But it seems it is not your input contact the system administrator';
                return redirect()->back()->with('toast_error', $msg)->withInput();
            }
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
        // $productCat = Category::whereId($id)->with(['products'])->first();
        // $options  = Status::whereVisible(1)->pluck('name', 'id')->all();

        $reqCat = Category::where('id', '=', $id)
            ->with(['products'])->get();
        // dd($reqCat[0]->products);
        return view('admin.category.show', compact('reqCat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $productCat = Category::whereId($id)->first();
        $options  = Status::whereVisible(1)->pluck('name', 'id')->all();

        return view('admin.category.edit', compact('productCat', 'options'));
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
        $rules = [
            'category_name'        => 'required',
            'category_code'        => 'required',
            'category_description' => 'required',
            'status_id'            => 'required'
        ];

        $v = validator()->make($request->all(), $rules);

        if ($v->fails()) {

            return redirect()->back()->with('toast_error', $v->messages()->all()[0])->withInput();
        } else {

            $category                       = Category::find($id);
            $category->category_name        = $request->category_name;
            $category->category_code        = $request->category_code;
            $category->category_description = $request->category_description;
            $category->status_id            = $request->status_id;

            if ($category->save()) {
                $msg = 'The Category ' . $request->category_name . ' was updated successfully.';
                return redirect(route('categories.index'))->with('toast_success', $msg);
            } else {

                $msg = 'Something is went wrong. But it seems it is not your input contact the system administrator';
                return redirect()->back()->with('toast_error', $msg)->withInput();
            }
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
        $productCat = Category::findOrFail($id);
        $productCat->delete();

        return response()->json($productCat);
    }
}
