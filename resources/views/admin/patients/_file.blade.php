@extends('admin.layouts.admin')

@section('styles')
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="{{ asset('../node_modules/mdbootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('../node_modules/mdbootstrap/css/mdb.min.css') }}">
<link rel="stylesheet" href="{{ asset('../node_modules/mdbootstrap/css/style.css') }}"> --}}
@endsection

@section('main-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Patient Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Patient Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Patient Information</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body">
            {!! Form::open(array('route' => 'medical-report.store', 'method'=>'POST', 'role'=>'form', 'enctype' => 'multipart/form-data' )) !!}
                    {{ csrf_field() }}
                     <input type="hidden" name="id" value="{{$patient->user_id}}">
            <div class="form-group">
                <label for="fullname">Title/Fullname</label>
                <div class="input-group input-group-sm">
                    @if(!empty( $patient->title->name))
                    <div class="input-group-append">
                        <span class="input-group-text">{{ $patient->title->name }}</span>
                      </div>
                    @endif
                    <input type="text" id="fullname" class="form-control form-control-sm" value="{{ $patient->user->surname." ".$patient->user->firstname." ".$patient->user->othername }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="gender">gender</label>
                <input type="text" id="gender" class="form-control form-control-sm" value="{{ $patient->gender }}" readonly>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="text" id="dob" class="form-control form-control-sm" value="{{ $patient->dob }}" readonly>
            </div>
            <div class="form-group">
                <label for="email"> Email</label>
                <input type="text" id="email" class="form-control form-control-sm" value="{{ $patient->user->email }}" readonly>
            </div>
            <div class="form-group">
              <label for="contact_address">Contact Address</label>
              <textarea id="contact_address" class="form-control form-control-sm" rows="2" readonly>{{ $patient->address }}</textarea>
            </div>
            <div class="form-group">
                <label for="phone_number"> Phone Number</label>
                <input type="text" id="phone_number" class="form-control form-control-sm" value="{{ $patient->user->phone_number }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="blood_groop">Blood Group</label>
                <input type="text" id="blood_groop_id" class="form-control form-control-sm" value="{{ $patient->blood_group_id }}" readonly>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">{{$patient->clinic->clinic_name}}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
         
            <div class="form-group">
              <label for="inputEstimatedDuration">Doctor Diagonisation  and Proscription Report</label>
                      <textarea id="content" name="content" cols="10" rows="20" class="form-control" placeholder="Enter Content">
                      {{ old('content') }}
                      </textarea>
          
             
            </div>
          </div>
           <div class="form-group">
              <label for="admission" class="col-sm-4 control-label">Admission</label>
                <div class="col-sm-10">
                        <select class="form-control"  name ="gender">
                            <option value=''>--Select --</option>
                            <option value='1'>Yes</option>
                            <option value='2'>NO</option>
                        </select>
                </div>
              </div>
             <div class="form-group">
                <label for="Ward" class="col-sm-4 control-label">Ward</label>
                  <div class="col-sm-10">
                   <div class="form-group">
                     {!! Form::select('wards', $wards, null, array('id' => 'word_id', 'ward_name' => 'ward_id', 'class' => 'form-control', 'placeholder' => 'Select Ward')) !!}
                   </div>
                  </div>
                   
              </div>
               <div class="form-group">
                <label for="Bed" class="col-sm-4 control-label">Bed</label>
                  <div class="col-sm-10">
                     <div class="form-group">
                      <select id="bed_id" name="bed_id" class="form-control">
                          <option value="">--Select Bed-</option>
                      </select>
                     </div>
                   </div>
                   
                </div>
          <!-- /.card-body -->
        </div>
     </div>   <!-- /.card -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Lab Sarvices</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body p-0">
                      <div class="form-group ">
                            <div class="col-sm-offset-3 col-sm-9">
                                    <label for="permission">Lab <span >services</span></label>
                                
                                    <div class="row">
                                        <!-- <div class="form-group"> -->
                                            @foreach($lab_services as $value)
                                                <div class="col-md-3">
                                                    <!-- <div class="checkbox">  -->
                                                        <label class="control-label" for="{{ $value->id }}">
                                                            {{ Form::checkbox('service[]', $value->id) }}
                                                            {{ $value->lab_service_name }}
                                                        </label>
                                                
                                                        
                                                    <!-- </div> -->
                                                </div>
                                            @endforeach
                                        <!-- </div> -->
                                    </div>
                            </div>
                        </div>
                   
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a href="#" class="btn btn-secondary">Cancel</a>
        <input type="submit" value="submit" class="btn btn-success float-right">
      </div>
    </div>
      <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-6">
                    <a href="{{ route('CurrentConsultationRequestlist') }}" class="pull-right btn btn-danger"><i class="fa fa-close"></i> Back </a>
                </div>
            </div>
        </div>
    </div>
                {!! Form::close() !!}
  </section>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>

{{-- <script type="text/javascript" src="{{ asset('../node_modules/mdbootstrap/js/popper.min.js') }}"></script> --}}

<!-- Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.maskMoney.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('../node_modules/mdbootstrap/js/mdb.min.js') }}"></script> --}}

<script>
    // CKEDITOR.replace('content_edit');
    // CKEDITOR.replace('contact_address');
    CKEDITOR.replace('home_address');
    $('#date_of_birth').datepicker({});
    $("#consultation_fee");
    $("#secondary_phone_number").inputmask('9999-999-9999');
</script>
<script>
    $(document).ready(function () {
      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    $(document).ready(function() {
      $.noConflict();
      CKEDITOR.replace('content');
      $(".select2").select2();
    });

</script>
<script type="text/javascript">

    $(document).ready(function(){
      // $.noConflict();
          
          $('select[name="ward_id"]').on('change', function() {
              var wardID = $(this).val();
              // alert(wardID);
              if(wardID) {
                  $.ajax({
                      headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                      url: '{{ url("/mywardAjax/ajax") }}/'+wardID,
                      type: "GET",
                      dataType: "json",
                      success:function(data)
                      {
                        console.log(data);
                        $('select[name="bed_id"]').empty();

                        $.each(data, function(key, value) {
                            $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                      }

                  });

              }else{
                  
                  $('select[name="bed_id"]').empty();
              }

          });


    });

</script>

@endsection

