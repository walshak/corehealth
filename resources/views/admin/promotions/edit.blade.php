@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">
            
        <div class="content-header">
          
        </div>

        <div class="container">
     <div class="row justify-content-center">
        <div class="raw">
            <div class="card">
                <div class="card-header">{{ $promotion->product->product_name.__('Product Promotion Setting') }}</div>

                <div class="card-body">
                   
                       
                           <form class="form-horizontal" method="POST" action="{{ route('promotion.update', $id) }}">
                                {{ csrf_field() }}
                                    
                                    <input name="_method" type="hidden" value="PUT">

                         

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
                              <th>Opend</th>
                         
                              
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                               {{--  <td>
                                    
                                        {!! Form::select('products', $products , null, ['id' => 'product_name', 'placeholder' => $promotion->$product->product_name, 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                                 
                                
                                </td> --}}
                                <td>
                                    {{-- 
                                       {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' => $promotion->product->product_name, 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!} --}}
                                       {{$promotion->product->product_name}}
                                 
                                
                                </td>
                                <td>
                                     <input type="text" name="promotion_name"   id="promotion_name" placeholder="promotion_name" class=" form-control"  value="{{ $promotion->promotion_name }}
                                     " />

                                    {{--  {{ (old('promotion_name')) ? old('promotion_name') :$promotion->promotion_name }}" --}}
                                </td>  
                                <td>
                                     <input type="number" name="promotion_total_quantity"   id="promotion_total_quantity" placeholder=" 0" class=" form-control"  value="{{ $promotion->promotion_total_quantity  }}" />
                                </td>
                                <td>
                                     <input type="number" name="quantity_to_buy"   id="quantity_to_buy" placeholder=" 0" class=" form-control"  value="{{ $promotion->quantity_to_buy }}" />
                                </td>
                                <td>
                                     <input type="number" name="quantity_to_give"   id="quantity_to_give" placeholder=" quantity_to_give" class=" form-control" value="{{ $promotion->quantity_to_give }}" />
                                </td>
                                
                                  <td>
                                        <input type="text" name="start_date"   id="start_date" placeholder=" {{ $promotion->end_date }}" class=" form-control"  value="{{ $promotion->start_date }}" />
                                  </td> 
                                  <td> 
                                       <input type="text" name="end_date"   id="end_date" placeholder=" {{ $promotion->end_date }}" class=" form-control"  value="{{ $promotion->end_date }}" />
                                  </td>
                                  <td>

                                     
                                            <select id="visible" name="visible" class="form-control selectpicker" data-style="btn-white" data-live-search="true">
                                                <option value="">--Select--</option>
                                                <option value="0" {{ ($promotion->visible == 0) ? "selected='selected'" : '' }}>No</option>
                                                <option value="1" {{ ($promotion->visible == 1) ? "selected='selected'" : '' }}>Yes</option>
                                            
                                            </select>
                                        <!-- </div> -->
                                  
                                  </td>
                             
                               
                            </tr>   
                          </tbody>
                     
                    </table>
                        
                        <div class="box-footer" align="center">
                                <a href="{{ route('products.index') }}" class="btn btn-success"> Back</a>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Submit</button>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>

    </div>
    
@endsection

