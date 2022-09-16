@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ ('Invoice Details for Supplier') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{ $supplier->company_name }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $supplier->company_name }}</h3>
            </div>
            {!! Form::open(array('route' => 'invoices.store', 'method'=>'POST', 'class' => 'form-horizontal' )) !!}
            <!-- /.card-header -->
            <div class="card-body">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="title">Invoice Number:</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="company_id" name="company_id"
                                    value="{!! $supplier->id !!}" readonly>

                                <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                    placeholder="Invoice Number" value="{!! old('invoice_no') !!}" required autofocus>
                                @error('invoice_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="title">Number of Products:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="number_of_products"
                                    name="number_of_products"
                                    placeholder="Number of Products on physical Supplier Invoice"
                                    value="{!! old('number_of_products') !!}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="title">Invoice Date:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                    value="{!! old('invoice_date') !!}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="title">Total Amount:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="total_amount" name="total_amount"
                                    placeholder="Total Amount" value="{!! old('total_amount') !!}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-sm table-responsive table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="2">{{ $supplier->company_name }}</th>
                                    {{-- <th></th>
                                    <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    {{-- <td></td> --}}
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    {{-- <td></td> --}}
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>


            </div>
            <div class="card-footer bg-transparent border-info">
                <div class="form-group row">
                    <div class="col-md-6"><a href="{{ route('invoices.index') }}" class="btn btn-success"> <i
                                class="fa fa-close"></i>
                            Back</a></div>
                    <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i
                                class="fa fa-send"></i>
                            Submit</button></div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</section>

@endsection

<script src="{{ asset('../resources/assets/js/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

    if (document.getElementById('s1').checked) {
        $("#dropMain").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    } 

    if (document.getElementById('s2').checked) {
        $("#dropSub").slideDown(500);
         // document.getElementById('password').disabled = false;
        console.log("dropDown");
    }


     $("#s1").click(function(){
        $("#reorder_alert").slideDown(500);
      
        // $("#dropNo").slideUp(500);
         // document.getElementById('password').disabled = false;
        console.log("drop2");
     });

});
 
 
</script>