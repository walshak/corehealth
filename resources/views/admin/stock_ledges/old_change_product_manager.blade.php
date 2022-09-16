

          
            <div class="card border-info mb-3">
               
                 <form class="form-horizontal" method="POST" action="{{ route('products-managers.update', $product->id) }}">
                                {{ csrf_field() }}
                                    
                        <input name="_method" type="hidden" value="PUT">  
                        <input type="hidden" name="product_id" value="{{$product->id}}">    
                    <div class="card-header bg-transparent border-info">{{ __('Change  Product Manager') }}</div>
                      <h4 text align="center"> Present Manager {!! $present_manager !!} </h4>
                    <div class="card-body">

                        <div class="form-group row">
                                    <label for="select" class="col-sm-2 col-form-label">Product Managers</label>
                                    <div class="col-sm-10">
                                        <select id="user" name="user" class="form-control">
                                             <option value=""> --Select--</option> @foreach($users as $user)
                                                   <option value="{{$user->id}}">{{$user->firstname.' '.$user->lastname.' '.$user->othername}} </option> 
                                                   @endforeach
                                                </select>
                                            
                                        </select>
                                    </div>
                                </div>
                    </div>
                    <div class="card-footer bg-transparent border-info">
                        <div class="form-group row">
                          <div class="col-md-6">
                              <button onclick="goBack()">Go Back </button>
                           </div>
                            <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i> Submit</button></div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>



<script>
  function goBack() {
    window.history.go(-1);
  }
</script>

