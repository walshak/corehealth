@extends('admin.layouts.admin')


@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ $invoice->supplier->company_name }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">{{ $invoice->supplier->company_name }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">

  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ $invoice->supplier->company_name }}</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <!-- <div class="pull-right">
            <button type="button" class="add-modal btn btn-primary" data-toggle="modal">New Role</button>
          </div> -->
        {!! Form::model($invoice, ['method' => 'PATCH', 'route'=> ['invoices.update', $invoice->id], 'class' =>
        'form-horizontal', 'role' => 'form']) !!}
        {{ csrf_field() }}

        <div class="form-group">
          <label class="control-label col-sm-4" for="title">Invoice Number:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="invoice_no" name="invoice_no"
              value="{!! (!empty($invoice->invoice_no)) ? $invoice->invoice_no : old('invoice_no') !!}" required
              autofocus>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-4" for="title">Number of Products:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="number_of_products" name="number_of_products"
              value="{!! (!empty($invoice->number_of_products)) ? $invoice->number_of_products : old('number_of_products') !!}"
              required autofocus>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="title">Invoice Date:</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="invoice_date" name="invoice_date"
              value="{!! (!empty($invoice->invoice_date)) ? $invoice->invoice_date : old('invoice_date') !!}" required
              autofocus>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-4" for="title">Total Amount:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="total_amount" name="total_amount"
              value="{!! (!empty(formatMoney($invoice->total_amount))) ? formatMoney($invoice->total_amount) : old('total_amount') !!}"
              required autofocus>
          </div>
        </div>

        <div class="form-group">
          <label for="visible" class="col-sm-4 control-label">Reset</label>

          <div class="col-sm-8">
            <select class="form-control" id="visible" name="visible">
              <option value="0">--Select--</option>
              @foreach($options as $option)
              @if($option->id == $invoice->visible)
              <option selected value="{{ $option->id }}">No</option>
              @else
              <option value="{{ $option->id }}">Yes</option>
              @endif

              @endforeach
            </select>
            <p class="errorVisible text-center alert alert-danger hidden"></p>
          </div>
        </div>
      </div>

      <div class="card-footer bg-transparent border-info">
        <div class="form-group row">
          <div class="col-md-6"><a href="{{ route('invoices.index') }}" class="btn btn-success"> <i
                class="fa fa-close"></i>
              Back</a></div>
          <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i>
              Submit</button></div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>

  </div>

</section>

@endsection