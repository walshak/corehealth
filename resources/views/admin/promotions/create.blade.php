@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">
            
        <div class="content-header">
          
        </div>

        <div class="container">
     <div class="row justify-content-center">
        <div class="raw">
            <div class="card">
                <div class="card-header">{{ __('Product Promotion Setting') }}</div>

                <div class="card-body">
                   
                        @csrf 
                          {!! Form::open(array('route' => 'promotion.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
                         

                        <table  class="table table-sm table-responsive table-bordered table-striped ">

                          <thead>
                            <tr>
                              <th>Product </th>
                              <th>Promotion Name  </th>
                              <th>Total Quantity  </th>
                              <th>Quantity to Buy  </th>
                              <th>Quantity to Give</th>
                              <th>Start Date</th> 
                              <th>End Date</th>
                         
                              
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td>
                                    
                                        {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' => ' Select Product Product', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                                 
                                
                                </td>
                                <td>
                                     <input type="text" name="promotion_name"   id="promotion_name" placeholder="promotion_name" class=" form-control"  value="{{ old('promotion_name')  }}" />
                                </td>  
                                <td>
                                     <input type="number" name="promotion_total_quantity"   id="promotion_total_quantity" placeholder=" 0" class=" form-control"  value="{{ old('promotion_total_quantity')  }}" />
                                </td>
                                <td>
                                     <input type="number" name="quantity_to_buy"   id="quantity_to_buy" placeholder=" 0" class=" form-control"  value="{{ old('quantity_to_buy')  }}" />
                                </td>
                                <td>
                                     <input type="number" name="quantity_to_give"   id="quantity_to_give" placeholder=" quantity_to_give" class=" form-control" value="{{ (old('quantity_to_give')) ? old('quantity_to_give') :0  }}" />
                                </td>
                                
                                  <td>
                                        <input type="Date" name="start_date"   id="start_date" placeholder=" Pieces Price" class=" form-control"  value="{{ (old('start_date')) ? old('start_date') :0  }}" />
                                  </td> 
                                  <td> 
                                       <input type="Date" name="end_date"   id="end_date" placeholder=" Max discount" class=" form-control"  value="{{ (old('end_date')) ? old('end_date') :0  }}" />
                                  </td>
                             
                               
                            </tr>   
                          </tbody>
                     
                    </table>
                        
                        <div class="box-footer" align="center">
                                <a href="{{ route('promotion.index') }}" class="btn btn-success"> Back</a>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Submit</button>
                        </div>
                        <br>
                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
        </div>

    </div>
    
@endsection

