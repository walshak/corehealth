@extends('admin.layouts.admin')

@section('main-content')
<!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
       
    </section>

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif  --}}  
    
    <section class="content noprint">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Search Transaction</h3>
                <div class="box-tools pull-right">
                    {{-- <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fa fa-list"></i> View Citizens</a> --}}     
                </div>
            </div>
            <div class="box-body noprint">
            {{-- <div class="col-sm-offset-2 col-sm-10"> --}}
                {!! Form::open(array('route' => 'transactions.store', 'method'=>'POST', 'role'=>'form' )) !!}
                    {{ csrf_field() }}

                    
                     <div class="callout callout-info">
             
                    <div class="form-group">
                       <label for="Parent" class="col-md-8 control-label">Select Search Type</label>
                          <div>
                               <div class="radio radio-primary radio-inline">
                               
                                  <input type="radio" name="s1" id="s1" value="1">
                               <input type="radio" name="s1" id="s1" value="1" style="display: none;">
                                
                                  <label for="s1">Day </label>
                              </div>
                              <div class="radio radio-success radio-inline">
                                  <input type="radio" name="s1" id="s1_" value="2">
                                  <label for="s1_">Dates</label>
                              </div>
                              <div class="radio radio-danger radio-inline">
                                  <input type="radio" name="s1" id="s1__" value="3">
                                  <label for="s1__">Transaction No</label>
                              </div>
                          </div>
                    </div>
                  <div id="dropMain" style="display: none;">

                          <div class="form-group">
                              <label for="select" class="control-label">Day :</label>
                               <div class="form-control-material">
                                  <input type="date" name="toDay"   id="toDay"  />
                                </div>
                          </div>
                      
                 </div>
                  
                  <div class="form-group" id="dropSub" style="display: none;">
                        <div class="form-group">
                              <label for="select" class="control-label">From Date :</label>
                               <div class="form-control-material">
                                  <input type="date" name="start_date"   id="start_date"  />
                                </div>
                          </div>
                           <div class="form-group">
                              <label for="select" class="control-label">To Date :</label>
                               <div class="form-control-material">
                                  <input type="date" name="end_date"   id="end_date"  />
                                </div>
                          </div>

                  </div>
                  <div class="form-group" id="dropNo" style="display: none;">
                        <label for="transaction" class="control-label">Transaction No  </label>
                        <div class="form-control-material">
                           <input type="text" name="transaction_no" id="transaction_no" placeholder=" Enter Transaction No" class=" form-control" value="{{ old('transaction_no') }}" />
                        </div>
                        
                  </div>
               </div>
                    
                                   
                                      
                     <div class="box-footer" align="center">
                                <a href="{{ route('sales.index') }}" class="btn btn-success"> Back</a>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Submit</button>
                     </div>
                        <br>
 
                    </div>
                {!! Form::close() !!}


            {{-- </div> --}}
            </div>
        </div>

</div>
                 

              
    </section>
@endsection

@section('scripts')
    {{-- @parent --}}
 <script src="{{ asset('../resources/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('../resources/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('../resources/assets/plugins/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('../resources/assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('../resources/assets/plugins/select2/select2.js') }}"></script>

    <!-- DataTables -->
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('../resources/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>





<script src="{{ asset('js/app.js') }}" type="text/javascript"></script> 
<script type="text/javascript">
$(document).ready(function(){

   

    if (document.getElementById('s1').checked) {
        $("#dropMain").slideDown(500);

         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    } 

    if (document.getElementById('s1_').checked) {
        $("#dropSub").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    }

    if (document.getElementById('s1__').checked) {
        $("#dropNo").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    }  

     $("#s1").click(function(){
        $("#dropMain").slideDown(500);
        $("#dropSub").slideUp(500);
        $("#dropNo").slideUp(500);

          $('#start_date').val("");
          $('#end_date').val("");
          $('#transaction_no').val("");
     });

     $("#s1_").click(function(){
        $("#dropSub").slideDown(500);
        $("#dropMain").slideUp(500);
        $("#dropNo").slideUp(500);

          $('#toDay').val("");
          $('#transaction_no').val("");
     });

     $("#s1__").click(function(){
        $("#dropNo").slideDown(500);
        $("#dropSub").slideUp(500);
        $("#dropMain").slideUp(500);
          $('#toDay').val("");
          $('#start_date').val("");
          $('#end_date').val("");
     });
});
 
 
</script>
@endsection
