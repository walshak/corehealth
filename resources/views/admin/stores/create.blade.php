@extends('admin.layouts.admin')

@section('main-content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Store Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Store Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Create Store</h3>
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
                
            {!! Form::open(['method' => 'POST', 'route'=> 'stores.store', 'class' => 'form-horizontal' ]) !!}
            {{ csrf_field() }}
        
              <div class="form-group">
                <label for="store_name" class="col-sm-2 control-label">Store Name </label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="store_name" name="store_name" value="{{ old('store_name') }}" required autofocus placeholder="Enter Store Name e.g (Musa Store, Store 1 etc)">
                </div>
              </div>
              <div class="form-group">
                <label for="location" class="col-sm-2 control-label">Location</label>

                <div class="col-sm-10">
                <textarea id="location" name="location" cols="30" rows="10" class="form-control" placeholder="Enter location">
                      {{ old('location') }}
                      </textarea>
                </div>
              </div>
              
                <div class="form-group">
                    <label class="col-sm-2 control-label">Is Store Active</label>
                    <div class="col-sm-10 checkbox checkbox-info checkbox-circle">
                        <label>
                            <input id="visible" type="checkbox" name="visible">
                            True
                        </label>
                    </div>    
                </div>
                     
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <div class="col-sm-offset-1 col-sm-6">
                              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                      <div class="form-group">
                          <div class="col-sm-6">
                              <a href="{{ route('stores.index') }}" class="pull-right btn btn-danger"><i class="fa fa-close"></i> Back </a>
                          </div>
                      </div>
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
