@extends('admin.layouts.admin')

@section('main-content')
    <div id="content-wrapper">

        <div class="content-header">

        </div>

        <div class="container">
     <div class="row justify-content-center">
        <div class="raw">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                         <div class="noprint" align="center">

                                        {!! Form::open(['method' => 'DELETE','route' => ['sales.destroy', $transi->id],'style'=>'display:inline']) !!}
                                                        {!! Form::submit('Destroy Transaction', ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete']) !!}
                                                        <!-- <i class="fa fa-trash"></i> -->
                                          {!! Form::close() !!}
                          </div>

                                <br>
                        <table  class="table table-sm table-responsive table-bordered table-striped ">

                          <thead>
                            <tr>
                              <th>Delete</th>
                              <th>Product Name</th>
                              <th>Quantity</th>
                              <th> Sale Price  (&#8358;)</th>
                              <th> Total Amount (&#8358;)</th>
                              <th>Update</th>


                            </tr>
                          </thead>
                          <tbody>
                             <?php $si = 0; ?>
                              @foreach($tran as $trans)

                            <tr>

                                <td>
                                   {!! Form::open(['method' => 'DELETE','route' => ['removed-edit-sales.destroy', $trans->id],'style'=>'display:inline']) !!}
                                                        {!! Form::submit('DELETE', ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete']) !!}

                                    {!! Form::close() !!}
                                </td>

                                  <form class="form-horizontal" name="{{$si++}}" id="{{$si++}}" method="POST" action="{{ route('removed-edit-sales.update', $trans->id) }}">
                                      {{-- {!! Form::model($user, ['method' => 'PATCH', 'route'=> ['users.update', $user->id], 'enctype' => 'multipart/form-data']) !!} --}}
                                     {{ csrf_field() }}
                                     <input name="_method" type="hidden" value="PUT">

                                <td>
                                     <input type="text" name="product"   id="product"  class=" form-control"  value="{{ (old('product_name')) ? old('product_name') : $trans->product->product_name}}" />
                                </td>
                                <td>
                                     <input type="text" name="quantity_buy"   id="quantity_buy" placeholder="quantity_buy" class=" form-control"  value="{{ (old('quantity_buy')) ? old('quantity_buy') : $trans->quantity_buy }}" />
                                </td>
                                 <td>
                                     <input type="text" name="sale_price"   id="sale_price" placeholder="sale_price" class=" form-control"  value="{{ (old('sale_price')) ? old('sale_price') : $trans->sale_price }}" />
                                </td>
                                <td>
                                     <input type="text" name="total_amount"   id="total_amount" placeholder=" total_amount" class=" form-control"  value="{{ (old('total_amount')) ? old('total_amount') : $trans->total_amount }}" />
                                </td>

                                  <td>

                                <button type="submit" class="btn btn-success"> <i class="fa fa-pencil"></i> Edit</button>
                                  </td>

                              {!! Form::close() !!}
                            </tr>
                            @endforeach
                          </tbody>

                    </table>

                        <div class="box-footer" align="center">

                        </div>
                        <br>

                </div>
            </div>
        </div>
    </div>
        </div>

    </div>

@endsection

