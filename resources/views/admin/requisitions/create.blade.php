@extends('admin.layouts.admin')

@section('style')
<link href="{{ asset('plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Requisition Request Form</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Requisition Request Form</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card card-primary">
        <div class="card-header">{{ $customer->fullname }} Requisition Request Form</div>
        <div class="card-body">

            {!! Form::open(array('route' => 'requisitions.store', 'method'=>'POST', 'role'=>'form' )) !!}
            {{ csrf_field() }}

            <div class="form-group row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category:</label>
                        {!! Form::select('category', $category , null, ['id' => 'category_id', 'name' =>
                        'category_id','placeholder' => 'Pick Category', 'class' => 'form-control', 'data-live-search' =>
                        'true' ])
                        !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name:</label>
                        {{-- {!! Form::select('products', $products , null, ['id' => 'product', 'placeholder' =>
                        'Pick a Product', 'class' => 'form-control', 'data-allow-clear' =>
                        'true' ]) !!} --}}
                        <select id="product" name="product" class="form-control">
                            <option value="" selected>Pick a Product</option>
                        </select>
                    </div>
                </div>
            </div>






            <div class="table-responsive">
                <table class="table table-sm table-responsive table-bordered table-striped ">
                    <thead>
                        <tr>
                            <th>Price (&#8358;)</th>
                            <th>Max. Discount (&#8358;)</th>
                            <th>Requested Quantity </th>
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
                                <input type="text" name="price" id="price" placeholder="Price" class="form-control"
                                    readonly="1" value="{{ old('price')  }}" />
                            </td>
                            <td>
                                <input type="text" name="max_discount" id="max_discount" placeholder="Maximum. Discount"
                                    class=" form-control" readonly="1" value="{{ old('max_discount') }}" />
                            </td>
                            <td>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    value="{{ (old('quantity')) ? old('quantity') :0}}"
                                    placeholder="Requested Quantity" />
                            </td>
                            <td>
                                <input type="number" name="dc" id="dc" class="form-control"
                                    value="{{ (old('dc')) ? old('dc') :0}}" readonly="true" placeholder="Discount" />
                            </td>
                            <input type="hidden" name="piece_sprice" id="pieces_price" placeholder="pieces_price"
                                class="form-control" readonly="1"
                                value="{{ (old('pieces_price'))? old('pieces_price') :0  }}" />
                            <input type="hidden" name="pieces_max_discount" id="pieces_max_discount"
                                placeholder=" max_discount" class=" form-control" readonly="1"
                                value="{{ (old('pieces_max_discount'))? old('pieces_max_discount') :0  }}" />
                            <input type="hidden" name="pieces_quantity" id="pieces_quantity" class="form-control"
                                value="{{(old('pieces_quantity'))? old('pieces_quantity') :0    }}" />
                            <input type="hidden" name="pdc" id="pdc" class="form-control"
                                value="{{ (old('pdc'))? old('pdc') :0    }}" />


                        </tr>
                    </tbody>
                </table>
            </div>

            <div class=" form-group text-center">
                <a href="{{ route('prices.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> Back</a>
                <button type="button" onclick='
                        
                        if( $("#category_id option:selected").text() == "Pick Category")
                          {
                            $("#category_id option:selected").focus();
                            Swal.fire({
                                icon: "error",
                                text: "Product Category not Selected",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            return false;
                          }

                          if( $("#product option:selected").text() == "Pick a Product")
                          {
                            $("#product option:selected").focus();
                            Swal.fire({
                                icon: "error",
                                text: "Product was not selected!",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            return false;
                          }
                          if( $("#price").text() == "Please Select price")
                          {
                            $("#price option:selected").focus();
                            swal({
                                icon: "error",
                                text: "Please select a price",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            return false;
                          }

                          if( ! $.isNumeric($("#quantity").val()) || $("#quantity").val()==0 )
                          {
                          
                            Swal.fire({
                                icon: "error",
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
                            
                            Swal.fire({
                                icon: "error",
                                text: "Please enter a valid number of " + $("#product option:selected").text() + " Quantity.",
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
                            Swal.fire({
                                icon: "error",
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
                            Swal.fire({
                                icon: "error",
                                text: "Please enter a valid Amount " + $("#product option:selected").text() + " Discount.",
                                showConfirmButton: true,
                                timer: 30000
                            });
                            $("#dc").val(0)
                            $("#dc").focus();
                            return false;
                          }

                          $("#showProperty").slideDown(500);
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
                            <th>Discount </th>
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
                            <th>Total {{ NAIRA_CODE }}: <span id="subtotal"></span></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="flash alert alert-danger fadeOut"></div>

                <a onclick="

                Swal.fire({
                    title: 'Are you sure you want to remove the selected item?',
                    text: 'You wont be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!',
                }).then((result) => {
                    if (result.value) {
                        dtTable.row('.selected').remove().draw( false );
                        Swal.fire({
                            'Removed!',
                            'Your item has been removed from the list.',
                            'success'
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
              " class="btn btn-danger"><i class="fa fa-remove"></i> Remove item(s) From List</a>

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
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
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
<!-- <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}"></script> -->

<script>
    var subtotal = 0;
    var dtTable = {property : null};
    $('.flash').hide();

        jQuery(function($) {
            // $(document).ready(function() {
                
                dtTable =  $('#property').DataTable({
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
                    "edit":true,
                });

                $('#property tbody').on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }else {
                        // dtTable.$('tr.selected').removeClass('selected');
                        dtTable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });

                {{-- $('#button').click( function () {
                    dtTable.row('.selected').remove().draw( false );
                } ); --}}

            // });
        });

        function postData(){

            var DataPayLoad = '';
                DataPayLoad = '[';
                for (i = 0; i < dtTable.rows().data().length -1; i++){
                    DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,8).data() + '", "price":"' +  dtTable.cell(i,4).data() + '"}, ';
                    // DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,3).data() + '", "price":"' +  dtTable.cell(i,4).data() + '", "pieces_price":"' +  dtTable.cell(i,5).data() + '", "pieces_quantity":"' +  dtTable.cell(i,6).data() + '"}';
                }
                DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,8).data() + '", "price":"' +  dtTable.cell(i,4).data() + '", "pieces_price":"' +  dtTable.cell(i,5).data() + '", "pieces_quantity":"' +  dtTable.cell(i,6).data() + '"}';
                DataPayLoad  += ']';

                {{--  console.log(DataPayLoad);  --}}

                dataPL = {
                            'trans': "{{ $trans }}",
                            'payload': DataPayLoad
                        };
                // var jsonString = JSON.stringify(dataPL);
            $.ajax({
                    type: "post",
                    url: "{{ route ('requisitions.store') }}",
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

{{--  <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>  --}}

<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="category_id"]').on('change', function() {
            var category_id = $(this).val();
            // alert(category_id);
            if(category_id) {
                $.ajax({
                url: '{{ url("myCategoryAjax/ajax") }}/'+category_id,
                type: "GET",
                dataType: "json",
                success:function(data)
                {
                    $('select[name="product"]').children('option:not(:first)').remove();
                    $.each(data, function(id, value) {
                        // $('select[name="products"]')
                        // .append($("<option></option>")
                        // .attr("value",id)
                        // .text(value));
                        $('select[name="product"]').append('<option value="'+ id +'">'+ value +'</option>');
                    });
                }
            });
            
            }else{
                $('select[name="product"]').children('option:not(:first)').remove();
            }
        
        });

        $('select[name="product"]').on('change', function() {
            var id = $(this).val();
            if(id) {
                    $.ajax({
                        url: '{{ url("/myform/ajaxprice") }}/'+id,
                        type: "GET",
                        {{--  contentType: "application/json",  --}}
                        dataType: "text",
                        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        success:function(response)
                        {
                        console.log(response);
                        var data = jQuery.parseJSON(response);
                        // console.log(data);
                            $('select[name="slug"]').empty();
                            $('#price').val(data.current_sale_price);
                            $('#max_discount').val(data.max_discount);
                            $('#pieces_price').val(data.pieces_price);
                            $('#pieces_max_discount').val(data.pieces_max_discount);
                            $.each(data, function(key, value) {
                                $('select[name="slug"]').append('<option value="'+ value +'">'+ value +'</option>');
                                // console.log(key, value);
                            });
                        }
                    });
            }else{
                    $('#price').val("");
            }
        });
      });
</script>

{{--  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script> --}}
@endsection