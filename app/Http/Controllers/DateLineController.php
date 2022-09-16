<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Customer;
use App\Transaction;
use App\CustomerType;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DateLineController extends Controller
{
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
        //
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
         $data = Customer::with('customer_type')->find($id);
       // dd($data);
        $customers     = CustomerType::whereVisible(1)->orderBy('type_name', 'asc')->pluck('type_name', 'id');
    
      return view('admin.customers.dateline',compact('data','customers')); 
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
         try {   
        $rules = [
                    'name'          => 'required|max:100',
                    'date_line'          => 'required|max:14'
                ];
           
         $v = validator()->make($request->all(), $rules);

         if( $v->fails() )
        // if(empty($request) )
         {  
             $msg = 'Please cheak Your Inputs .';
             //flash($msg, 'danger');
             return redirect()->back()->withInput()->withErrors($v);

         } else {
            
              //dd($request);
             $mycustomer                      =  Customer::where('id', "=", $id)->first();
          
             $mycustomer->date_line             = $request->date_line;
           
             if( $mycustomer->update() ) {
                 $msg = 'Customer ' . $request->name . ' Date Line was Updated successfully.';
                // flash($msg, 'success');
                   return redirect(route('customers.index'))->withMessage($msg)->withMessageType('success')->with( $msg);  
             } else {
                 $msg = 'Something is went wrong. Please try again later, information not save.';
                 //flash($msg, 'danger');
                 return redirect()->back()->withInput();
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
