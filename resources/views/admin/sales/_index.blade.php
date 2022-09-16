@extends('admin.layouts.admin')

@section('style')
    <link href="{{ asset('plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')
<!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales Management <a href="{{ route('sales.index') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i> New Sales</a></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Management</li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content noprint">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-body noprint">

                {!! Form::open(array('route' => 'sales.store', 'method'=>'POST', 'role'=>'form' )) !!}
                    {{ csrf_field() }}
                    <div class="callout callout-info">
                        <div class="form-group">
                          <label for="Parent" class="col-md-8 control-label">Select Customer Type </label >
                          <div>
                              <div class="radio radio-primary radio-inline">
                                @if(Auth::user()->id =1 )
                                <input type="radio" name="s1" id="s1" value="1">
                                @else <input type="radio" name="s1" id="s1" value="1" style="display: none;">
                                @endif
                                <label for="s1">Credit Customer</label>
                              </div>
                              <div class="radio radio-success radio-inline">
                                  <input type="radio" name="s1" id="s1_" value="2">
                                  <label for="s1_">Cash Regular Customer</label>
                              </div>
                              <div class="radio radio-danger radio-inline">
                                  <input type="radio" name="s1" id="s1__" value="3" checked>
                                  <label for="s1__">Casual Cash Customer</label>
                              </div>
                          </div>
                        </div>
                        <div class="form-group" id="dropMain" style="display: none;">
                            <div class="form-group">
                                <label>Customer Name:</label>
                                {!! Form::select('customer1', $mycustomer , null, ['id' => 'fullname', 'placeholder' => 'Please Select customer', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                            </div>

                            <div class="form-group">
                                <label for="select" class="control-label">Select Store</label>
                                <div class="">
                                    <select id="stores1" name="stores1" class="form-control selectpicker" data-style="btn-white" data-live-search="true">
                                        @foreach($storek as $storec)
                                        <option value="{{$storec->id}}">{{$storec->store_name}} </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="dropSub" style="display: none;">
                              <div class="form-group">
                                  <label>Customer Name:</label>
                                  {!! Form::select('customer2', $customer , null, ['id' => 'fullname', 'placeholder' => 'Please Select customer', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                            </div>
                            <div class="form-group">
                                  <label>Mode of Payment:</label>
                                  {!! Form::select('payment_mode2', $payment_mode , null, ['id' => 'payment_mode', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                            </div>

                            <div class="form-control-material">
                                  <div class="form-group">
                                                  <label for="select" class="control-label">Select Store</label>
                                                  <div class="">
                                                      <select id="stores2" name="stores2" class="form-control selectpicker" data-style="btn-white" data-live-search="true">
                                                        @foreach($storek as $storec)
                                                          <option value="{{$storec->id}}">{{$storec->store_name}} </option>
                                                        @endforeach

                                                      </select>
                                                  </div>
                                  </div>
                              </div>

                        </div>
                        <div class="form-group" id="dropNo" style="display: none;">
                              <label for="customer" class="control-label">Customer Name  </label>
                              <div class="form-control-material">
                                <input type="text" name="customer"   id="customer" placeholder=" Enter Customer Name" class=" form-control" value="{{ old('customer') }}" />
                              </div>

                              <div class="form-control-material">
                                    <div class="form-group">
                                        <label for="select" class="control-label">Select Store</label>
                                        <div class="">
                                            <select id="stores" name="stores" class="form-control selectpicker" data-style="btn-white" data-live-search="true">
                                            @foreach($storek as $storec)
                                                <option value="{{$storec->id}}">{{$storec->store_name}} </option>
                                            @endforeach

                                            </select>
                                        </div>
                                    </div>
                              </div>

                              <div class="form-group">
                                  <label>Mode of Payment: </label>
                                  {!! Form::select('payment_mode', $payment_mode , null, ['id' => 'payment_mode', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Product Name:</label>
                        {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' => 'Please Select Product', 'class' => 'select2 show-tick form-control', 'style' => 'width: 100%;', 'data-toggle' => 'select2', 'data-placeholder' => 'Select or search product from the list...', 'data-allow-clear' => 'true' ]) !!}
                    </div>
                    <div class="raw">
                        <table  class="table table-sm table-responsive table-bordered table-striped ">
                            <thead>
                              <tr>
                                <th>Current Quantity </th>
                                <th>Price  (&#8358;)</th>
                                <th>Mxd (&#8358;)</th>
                                <th>Quantity to Buy </th>
                                <th>Discount</th>
                                <!-- <th>Stores</th>
                                <th>pieces price (&#8358;)</th>
                                <th>pieces Mxd (&#8358;)</th>
                                <th>pieces Qt</th>
                                <th>PDC</th> -->
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" name="current_quantity"   id="current_quantity" class=" form-control" readonly="true" value="{{ old('current_quantity') }}" />
                                    </td>
                                    <td>
                                        <input type="text" name="price"   id="price" placeholder=" price" class=" form-control" readonly="1" value="{{ old('price')  }}" />
                                    </td>
                                    <td>
                                        <input type="text" name="max_discount"   id="max_discount" placeholder=" max_discount" class=" form-control" readonly="1" value="{{ old('max_discount')  }}" />
                                    </td>
                                    <td>
                                        <input type="number" name="quantity" id="quantity" class=" form-control" value="{{ (old('quantity')) ? old('quantity') :0}}" />
                                    </td>
                                    <td>
                                        <input type="number" name="dc" id="dc" class=" form-control" value="{{ (old('dc')) ? old('dc') :0}}" />
                                    </td>
                                     {{-- <td>
                                        <select name="stores" id="stores" class="form-control">
                                             <option value="">Pick a value...</option>
                                             <option value=""></option>
                                        </select>
                                    </td> --}}
                                        <input type="hidden" name="piece_sprice"   id="pieces_price" placeholder=" pieces_price" class=" form-control" readonly="1" value="{{ (old('pieces_price'))? old('pieces_price') :0  }}" />
                                        <input type="hidden" name="pieces_max_discount"   id="pieces_max_discount" placeholder=" max_discount" class=" form-control" readonly="1" value="{{ (old('pieces_max_discount'))? old('pieces_max_discount') :0  }}" />
                                        <input type="hidden" name="pieces_quantity"   id="pieces_quantity"  class=" form-control" value="{{(old('pieces_quantity'))? old('pieces_quantity') :0    }}" />
                                        <input type="hidden" name="pdc"   id="pdc"  class=" form-control" value="{{ (old('pdc'))? old('pdc') :0    }}" />


                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" form-group text-center">
                        <a href="{{ route('prices.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> Back</a>
                        <button type="button" onclick='

                          if( $("#price").text() == "Please Select price")
                          {
                            $("#price option:selected").focus();
                            swal({
                                type: "error",
                                text: "Please select a price",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            return false;
                          }

                          if( $("#product option:selected").text() == "Please Select Product")
                          {
                            {{-- alert("Please select a product."); --}}
                            $("#product option:selected").focus();
                            swal({
                                type: "error",
                                text: "Please select product",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            return false;
                          }


                          if( ! $.isNumeric($("#quantity").val()) || $("#quantity").val()==0 )
                          {
                            {{-- alert("Please enter a valid number of " + $("#product option:selected").text() + " Quantity."); --}}
                            swal({
                                type: "success",
                                text: "Please enter a valid number of " + $("#product option:selected").text() + " Quantity.",
                                showConfirmButton: true,
                                timer: 30000
                            });

                            $("#quantity").val(0)
                            $("#quantity").focus();
                            return false;
                          }

                          if( ! $.isNumeric($("#quantity").val()) || $("#quantity").val()<1 )
                          {
                            {{-- alert("Please enter a valid number of " + $("#product option:selected").text() + " Quantity."); --}}
                            swal({
                                type: "error",
                                text: "Please enter a valid number of " + $("#product option:selected").text() + " Quantity.",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            $("#quantity").val(0)
                            $("#quantity").focus();
                            return false;
                          }

                          if(parseInt($("#quantity").val(), 10) > parseInt($("#current_quantity").val(), 10) )
                          {
                            {{-- alert("Please Reduce the number of ." + $("#product option:selected").text() + " Quantity demand Not Available."); --}}
                            swal({
                                type: "error",
                                text: "Please reduce the number of " + $("#product option:selected").text() + " quantity demanded not available in stock.",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            $("#quantity").val(0)
                            $("#quantity").focus();
                            return false;
                          }

                          if( ! $.isNumeric($("#dc").val()) && $("#dc").val() > $("#max_discount").val() )
                          {
                            {{-- alert("Please enter a valid discount Amount of ." + $("#product option:selected").text() ); --}}
                            swal({
                                type: "error",
                                text: "Please enter a valid discount Amount of " + $("#product option:selected").text(),
                                showConfirmButton: true,
                                timer: 30000
                            });
                            $("#dc").val(0)
                            $("#dc").focus();
                            return false;
                          }

                          if( ! $.isNumeric($("#max_discount").val()) || $("#dc").val()<0 )
                          {
                            {{-- alert("Please enter a valid Amount ." + $("#product option:selected").text() + " Discount."); --}}
                            swal({
                                type: "error",
                                text: "Please enter a valid Amount " + $("#product option:selected").text() + " Discount.",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            $("#dc").val(0)
                            $("#dc").focus();
                            return false;
                          }

                          $("#showProperty").slideDown(500);
                          {{-- sn = dtTable.rows().count(); --}}
                          sn = dtTable.rows().data().length;

                          dtTable.row.add([
                                sn+1,
                                $("#product option:selected").text(),
                                quantity = parseInt($("#quantity").val()),
                                $("#dc").val(),
                                price = parseInt($("#price").val()) - parseInt($("#dc").val()),
                                pieces = ( parseInt($("#pieces_price").val()) - parseInt($("#pdc").val())) * parseInt($("#pieces_quantity").val()),
                                piecesqt = parseInt($("#pieces_quantity").val()),$("#pdc").val(),
                                total = (( $("#price").val() - parseInt($("#dc").val())) * parseInt($("#quantity").val()) + pieces),
                                subtotal +=  ( parseInt($("#price").val()) - parseInt($("#dc").val())) * parseInt($("#quantity").val())
                          ]).draw();
                          console.log();
                          $("#product").val("");
                          $("#current_quantity").val("");
                          $("#product").focus();
                          $("#quantity").val(0);
                          $("#max_discount").val("");
                          $("#price").val("");
                          $("#dc").val(0);
                          $("#subtotal").html(subtotal);
                          console.log(subtotal);
                        ' class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</button>

                    </div>
                {!! Form::close() !!}

                <div style="height: 80px;"></div>
                <div id="showProperty" style="display: none;">

                <table id="property" class="table table-sm table-responsive table-bordered table-striped ">
                  <thead>
                      <tr>
                          <th>S/N</th>
                          <th>Products</th>
                          <th>Quantity </th>
                          <th>Dc </th>
                          <th>Price {{ NAIRA_CODE }}</th>
                          <th>-- </th>
                          <th>-- {{ NAIRA_CODE }}</th>
                          <th>-- </th>
                          <th>Total Amount {{ NAIRA_CODE }}</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="8"></th>
                      <th>Sub Total {{ NAIRA_CODE }}: <span id="subtotal"></span></th>
                    </tr>
                  </tfoot>
                </table>
                <div class="flash alert alert-danger fadeOut" ></div>

              <a onclick="
                {{-- dtTable.row('.selected').remove().draw(); --}}
                {{-- var removeRow = dtTable.row('.selected').cell(); --}}
                {{-- var selectedRow = dtTable.row('.selected').remove().draw(); --}}
                //subtotal -=  removeRow[4];
                {{-- subtotal -=  removeRow[total]; --}}
                {{-- $('#subtotal').html(subtotal); --}}
                {{-- console.log(subtotal); --}}
                {{-- selectedRow; --}}

                Swal.fire({
                    title: 'Are you sure you want to remove the selected item?',
                    text: 'You wont be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        dtTable.row('.selected').remove().draw( false );
                        Swal.fire({
                            'Removed!',
                            'Your item has been removed from the list.',
                            'success',
                        });
                    }
                });

                dtTable.cells().each( function (index) {
                  var cell = dtTable.cell(index);
                  alert(cell.data());

                });

                for (i = 0; i < dtTable.rows().data().length; i++){
                  dtTable.cell(i,0).data(i+1);

                }
              " class="btn btn-danger"><i class="fa fa-remove"></i> Delete Selected item(s)</a>

              <a onclick="
                if( dtTable.rows().data().length < 1){
                  // alert('Enter items to upload');
                  $('.flash').html('<h4>Add items to upload to server.</h4>').fadeIn(300).delay(20).fadeOut(500);
                  return false;
                }else{
                    postData();
                }
              " class="btn btn-success pull-right"><i class="fa fa-arrow-up"></i> Proccess Item(s)</a>


            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}" ></script>

    <!-- Bootstrap 3.3.6 -->
     {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('../resources/assets/plugins/datatables2/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/sum().js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/jQuery/sweetalert.min.js') }}" ></script> --}}
    <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}" ></script>
    <script>
        var subtotal = 0;
        var dtTable;
        var customer;
        var stores;
        $('.flash').hide();
            (function($) {
                $(document).ready(function() {
                    customer = $('#customer');
                    stores = $('#stores');
                    payment_mode = $('select[name="payment_mode"]');
                    console.log(customer.val());
                    console.log(stores.val());
                    dtTable =  $('#property').DataTable( {
                        "dom": 'Bfrtip',
                        "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                        ],
                        buttons: [ 'pageLength','copy', 'excel', 'pdf', 'print', 'colvis' ],
                        drawCallback: function () {

                            var sumTotal = $('#property').DataTable().column(8).data().sum();
                            $('#subtotal').html(sumTotal);

                        },
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "select":true,
                        "edit":true
                    });

                    $('#property tbody').on( 'click', 'tr', function () {
                        if ( $(this).hasClass('selected') ) {
                            $(this).removeClass('selected');
                        }else {
                            dtTable.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                        }
                    });

                    {{-- $('#button').click( function () {
                        dtTable.row('.selected').remove().draw( false );
                    } ); --}}

                });

            }) ( jQuery );

        function postData(){

            var DataPayLoad = '';
                DataPayLoad = '[';
                for (i = 0; i < dtTable.rows().data().length -1; i++){
                    DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,8).data() + '", "price":"' +  dtTable.cell(i,4).data() + '"}, ';
                    // DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,3).data() + '", "price":"' +  dtTable.cell(i,4).data() + '", "pieces_price":"' +  dtTable.cell(i,5).data() + '", "pieces_quantity":"' +  dtTable.cell(i,6).data() + '"}';
                }
                DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,8).data() + '", "price":"' +  dtTable.cell(i,4).data() + '", "pieces_price":"' +  dtTable.cell(i,5).data() + '", "pieces_quantity":"' +  dtTable.cell(i,6).data() + '"}';
                DataPayLoad  += ']';

                console.log(DataPayLoad);

                dataPL = {'trans': "{{$trans}}",
                          'customer': customer.val(),
                          'stores': stores.val(),
                          'payment_mode': payment_mode.val(),
                          'payload': DataPayLoad };
                // var jsonString = JSON.stringify(dataPL);
            $.ajax({
                    type: "post",
                    url: "{{ route ('sales.store') }}",
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

    <script type="text/javascript">
      $(document).ready(function(){
        $.noConflict();
          $('select[name="products"]').on('change', function() {
            var id = $(this).val();
                  if(id) {
                      $.ajax({
                          url: '{{ url("/myform/ajaxprice") }}/'+id,
                          type: "GET",
                          dataType: "text",
                          success:function(response)
                          {

                            console.log(response);
                            var data = jQuery.parseJSON(response);

                                data = data[0];
                                data1 = data[1];
                            {{--  var data = $.parseJSON(data);
                             alert(data);  --}}
                            {{--  var res = JSON.parse(data);  --}}
                                {{--  alert(data[0]);
                                alert(data[1]);  --}}

                                {{--  console.log(data[0]);
                                console.log(data.storeStock[1]);  --}}
                                $('select[name="slug"]').empty();
                                $('#current_quantity').val(data.stock.current_quantity);
                                $('#price').val(data.current_sale_price);
                                $('#max_discount').val(data.max_discount);
                                $('#pieces_price').val(data.pieces_price);
                                $('#pieces_max_discount').val(data.pieces_max_discount);
                                {{--  $('#stores').val(data.store_id);  --}}

                                $.each(data, function(key, value) {
                                    $('#stores').append('<option value="'+ value +'">'+ value +'</option>');
                                    console.log(key, value);
                                });

                              $.each(data, function(key, value) {
                                  $('select[name="slug"]').append('<option value="'+ value +'">'+ value +'</option>');
                                  console.log(key, value);
                              });
                          }

                      });



                  }else{
                      $('#price').val("");
                  }
          });

          if (document.getElementById('s1').checked) {
              $("#dropMain").slideDown(500);
              console.log("dropDown");
          }

          if (document.getElementById('s1_').checked) {
              $("#dropSub").slideDown(500);
              console.log("dropDown");
          }

          if (document.getElementById('s1__').value) {
              $("#dropNo").slideDown(500);
              console.log("dropDown");
          }

          $("#s1").click(function(){
              $("#dropMain").slideDown(500);
              $("#dropSub").slideUp(500);
              $("#dropNo").slideUp(500);
              customer = $('select[name="customer1"]');
              console.log(customer);
              payment_mode = $('select[name="payment_mode1"]');
              stores       = $('select[name="stores1"]');
              $("#s1_"). prop("checked", false);
              $("#s1__"). prop("checked", false);
              console.log(customer);
              console.log(stores);
          });

          $("#s1_").click(function(){
              $("#dropSub").slideDown(500);
              $("#dropMain").slideUp(500);
              $("#dropNo").slideUp(500);
              customer = $('select[name="customer2"]');
              console.log(customer);
              payment_mode = $('select[name="payment_mode2"]');
              stores = $('select[name="stores2"]');
              $("#s1"). prop("checked", false);
              $("#s1__"). prop("checked", false);
              console.log(customer);
              console.log(store);
              console.log("dont drop");
          });

          $("#s1__").click(function(){
              $("#dropNo").slideDown(500);
              $("#dropSub").slideUp(500);
              $("#dropMain").slideUp(500);
              customer = $('#customer');
              payment_mode = $('select[name="payment_mode"]');
              stores= $('select[name="stores"]');
              $("#s1"). prop("checked", false);
              $("#s1_"). prop("checked", false);
              console.log(customer);
              console.log(store);
              // document.getElementById('password').disabled = true;
              console.log("dont drop");
          });

          {{-- $(".select2").select2(); --}}
      });
    </script>
@endsection
