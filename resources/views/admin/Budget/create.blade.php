@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Budget year Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Budget year Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Create Budget year</h3>
        </div>

        <div class="card-body">
            <div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        
                    </div>
                @endif
                @include('partials.notification')
            </div>
                
            {!! Form::open(['method' => 'POST', 'route'=> 'budget-year.store', 'class' => 'form-horizontal' ]) !!}
            {{ csrf_field() }}
        
              <div class="card-body">
                

              <div class="form-group row">
                <label for="budget_year" class="col-md-2 col-form-label text-md-right">Year </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="budget_year" name="budget_year" value="{{ old('budget_year') }}" required 
                    autofocus placeholder="Enter Budget Year e.g (2001/2002)">
                  </div>
              </div>

              <div class="form-group row">
                <label for="budget_year" class="col-md-2 col-form-label text-md-right">Total Amount </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required 
                    autofocus placeholder="Enter Total Amount">
                  </div>
              </div>

              <div class="form-group row">
                <label for="opening_date" class="col-md-2 col-form-label text-md-right">{{ __(' Opening Date ') }}</label>
              
                <div class="col-md-10">
                  <input type="date" id="opening_date" name="opening_date" class="form-control" placeholder="Click to Show Date"
                    value="{{ old('opening_date') }}" required autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="closing_date" class="col-md-2 col-form-label text-md-right">{{ __('Closing Date ') }}</label>
              
                <div class="col-md-10">
                  <input type="date" id="closing_date" name="closing_date" class="form-control" placeholder="Click to Show Date"
                    value="{{ old('closing_date') }}" required autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="closing_date" class="col-md-2 col-form-label text-md-right"></label>
              
                <div class="col-md-10">
                  <div class="form-check checkbox-success checkbox-circle">
                    <input id="visible" type="checkbox" name="visible" class="form-check-input">
                    {{-- Activate Budget --}}
                    <label for="active">Is Active</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                
              </div>
            </div>

            <div class="card-footer bg-transparent border-info">
              <div class="form-group row">
                <div class="col-md-6"><a href="{{ route('budget-year.index') }}" class="btn btn-success"> <i class="fa fa-close"></i>
                    Back</a></div>
                <div class="col-md-6 "><button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-send"></i>
                    Submit</button></div>
              </div>
            </div>

            {!! Form::close() !!}

        </div>
      </div>
      
    </div>

</section>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<!-- <script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}"></script> -->
<!-- <script src="{{ asset('/plugins/datatables/dataTables.bootstrap4.js') }}"></script> -->
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

<script>
  //  CKEDITOR.replace('content');
</script>

<script>
    $(document).ready(function() {
      $.noConflict();
      CKEDITOR.replace('location');
    });
   
</script>

@endsection
