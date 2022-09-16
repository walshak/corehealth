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
    
    <section class="content">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stock Order</h3>
                <div class="box-tools pull-right">
                    {{-- <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fa fa-list"></i> View Citizens</a> --}}     
                </div>
            </div>
            <div class="box-body">
            {{-- <div class="col-sm-offset-2 col-sm-10"> --}}
                {!! Form::open(array('route' => 'stock-order.store', 'method'=>'POST', 'role'=>'form', 'enctype' => 'multipart/form-data' )) !!}
                    {{ csrf_field() }}

                    
                     <div class="callout callout-info">
                   <strong>Invoice Details.</strong> <br><br>
                  <ul>
                        
                        <li><strong>Company: </strong> {{ $invoice->supplier->company_name }}</li>
                        <li><strong>Invoice No: </strong> {{ $invoice->invoice_no }}</li>
                        <li><strong>Date: </strong>{{ $invoice->invoice_date }}</li>
                         <li><strong>Number of Products: </strong> {{ $invoice->number_of_products }}</li> 
                        <li><strong>Total Amount: </strong>₦{{ $invoice->total_amount}}</li>
                        
                       
                             
                  </ul>

               </div>
                    
                            <input type="hidden" name="invoice" id="invoice" readonly="true" class="form-control" value="{{ $invoice->invoice_no }}" />
                  
                <table id="products" class="table table-sm table-responsive table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>product_name</th>
                      <th>Store</th>
                      <th>order_quantity </th>
                      <th>total_amount</th>
                    </tr>
                    </thead>
                 
                      <tr>
                        <td>  
                          {!! Form::select('products ', $products , null, ['id' => 'product', 'placeholder' => 'Please Select Product', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </td>
                        <td>  
                          {!! Form::select('stores ', $stores , null, ['id' => 'stores', 'placeholder' => 'Please Select store', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </td>
                     
                        <td> 
                          
                             <input type="number" name="quantity"   id="quantity" placeholder=" Quantity" class=" form-control" value="{{ old('quantity')  }}" />
                        </td> 
                        <td> 
                              <input type="number" name="total_amount"  id="total_amount" placeholder=" Amount" class="form-control" value="{{ old('total_amount') }}" />
                        </td>   
                      
                      </tr>  
                </table>
                    
                    <div class=" form-group text-right">
                        <a href="{{ route('invoices.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> Back</a>
                        <button type="button" onclick='   

                          if( $("#invoice").text() == "Please Select invoice")
                          {
                            alert("Please select a invoice.");
                            $("#invoice option:selected").focus();
                            return false;
                          }

                          if( $("#product option:selected").text() == "Please Select Product")
                          {
                            alert("Please select a product.");
                            $("#product option:selected").focus();
                            return false;
                          }

                          if( $("#stores option:selected").text() == "Please Select store")
                          {
                            alert("Please select a stores.");
                            $("#stores option:selected").focus();
                            return false;
                          }


                          if( ! $.isNumeric($("#quantity").val())  )
                          {
                            alert("Please enter a valid number of ." + $("#product option:selected").text() + " Quantity.");
                            $("#quantity").focus();
                            return false;
                          }



                          if( ! $.isNumeric($("#total_amount").val())  )
                          {
                            alert("Please enter a valid total amount of ." + $("#product option:selected").text() + " order for this invoice.");
                            $("#quantity").focus();
                            return false;
                          }

                        sn = dtTable.rows().count(); dtTable.row.add([
                          sn+1,
            $("#product option:selected").text(),
            $("#stores option:selected").text(),
            parseInt($("#quantity").val()),
            $("#total_amount").val(),$("#invoice").val(),
            // $("#total_amount").val() * parseInt($("#quantity").val()) 
           



    ]).draw();

     $("#product").val("");
     $("#stores").val("");
     $("#quantity").val("");
     $("#total_amount").val("");
     
              
                     
' class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</button> 
 
                    </div>
                {!! Form::close() !!}
                <table id="property" class="table table-sm table-responsive table-bordered table-striped ">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Products</th>
                    <th>Stores</th>
                    <th>Qty </th>
                    <th>Total amount <br />(&#8358;)</th> 
                    <th>Invoice No</th>
                   
                  </tr>
                </thead>
                <tbody>
                     
                </tbody>
                {{-- <tfoot>
                <tr>
                    <th>S/N</th>
                    <th>Products</th>
                    <th>Qty </th>
                    <th>Total amount <br />(&#8358;)</th>
                   
                  </tr>
                </tfoot> --}}
              </table> 

              <div class="flash alert alert-danger fadeOut" ></div>

              <a onclick="dtTable.row('.selected').remove().draw();

                // dtTable.cells().each( function (index) {
                //   var cell = dtTable.cell(index);
                //   alert(cell.data());

                // });
                  for (i = 0; i < dtTable.rows().count(); i++){
                      dtTable.cell(i,0).data(i+1);
                  }
               

               " class="btn btn-danger"><i class="fa fa-remove"></i> Delete Selected item(s)</a>


               <a onclick="
               if( dtTable.rows().count() < 1){
                // alert('Enter items to upload');
                $('.flash').html('<h4>Add items to upload to server.</h4>').fadeIn(300).delay(2000).fadeOut(500);
                 return false;
               }else{
                  postData();
                

               }
              
                  
               

               " class="btn btn-success pull-right"><i class="fa fa-arrow-up"></i> Upload Items to Server</a>
              
          </div>
      </div>
            {{-- </div> --}}
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
 var dtTable;


 $('.flash').hide();

  (function($) {

      $(document).ready(function() {
          dtTable =  $('#property').DataTable( {
                  dom: 'Bfrtip',
                  buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
                  "paging": true,
                  "lengthChange": false,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                  "select":true
            });
      });

  }) ( jQuery );

function postData(){

 var DataPayLoad = '';
     ;
               
      DataPayLoad =  '[';
                  for (i = 0; i < dtTable.rows().count() -1; i++){
                     DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "stores":"' + dtTable.cell(i,2).data() + '","quantity":"' + dtTable.cell(i,3).data() + '", "total_amount":"' + dtTable.cell(i,4).data() + '", "invoice":"' +  dtTable.cell(i,5).data() + '"}, ';
                   }
                    DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "stores":"' + dtTable.cell(i,2).data() + '", "quantity":"' + dtTable.cell(i,3).data() + '", "total_amount":"' + dtTable.cell(i,4).data() + '", "invoice":"' +  dtTable.cell(i,5).data() + '"}]';

        dataPL = {'invoice_id': "{{$invoice->id}}", 'payload' : DataPayLoad };
       // var jsonString = JSON.stringify(dataPL);
     $.ajax({
          type: "post",
          url: "{{ route ('stock-order.store') }}",
          data:dataPL,
        
          headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          
          success: function(data){

            $('.flash').html(data).fadeIn(300).delay(200000).fadeOut(300);
          
          },
          
          error: function(xhr, textStatus, errorThrown){
            $('.flash').html(errorThrown).fadeIn(300).delay(2000).fadeOut(300);
          }

     });



}
    </script>




<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script> 
@endsection
