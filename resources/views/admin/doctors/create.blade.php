@extends('admin.layouts.admin')

@section('style')
<link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Staff Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Staff Management</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Staff Management</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
                <form class="form-horizontal" role="form" id="editMyForm" enctype="multipart/form-data" action="{{ route('doctors.store') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="title_id">Title</label>
                        <div class="col-sm-10">
                            {!! Form::select('titles', $titles , null, ['id' => 'title_id', 'name' => 'title_id', 'placeholder' => 'Pick a Title', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="is_admin" class="col-sm-4 control-label">Status Category</label>

                        <div class="col-sm-10">
                        {!! Form::select('statusCategories', $statusCategories, null, array('id' => 'is_admin', 'name' => 'is_admin', 'class' => 'form-control select2', 'required' => 'true', 'placeholder' => 'Pick a value')) !!}
                        </div>
                    </div>
                    <div id="nameHidden" style="display: none;">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="user_id">Name</label>
                            <div class="col-sm-10">
                                {{-- {!! Form::select('users', $users , null, ['id' => 'user_id', 'name' => 'user_id', 'placeholder' => 'Pick a Doctor', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!} --}}
                                <select id="user_id" name="user_id" class="form-control" placeholder="Pick a value">
                                    <option value="">Pick a User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="specialization_id">Specialization</label>
                        <div class="col-sm-10">
                            {!! Form::select('specializations', $specializations , null, ['id' => 'specialization_id', 'name' => 'specialization_id','placeholder' => 'Pick a Specialization', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="specialization_id">Clinic</label>
                        <div class="col-sm-10">
                            {!! Form::select('clinics', $clinics , null, ['id' => 'clinic_id', 'name' => 'clinic_id','placeholder' => 'Pick a Clinic', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="gender_id">Gender</label>
                        <div class="col-sm-10">
                            {!! Form::select('genders', $genders , null, ['id' => 'gender_id', 'name' => 'gender_id','placeholder' => 'Pick a Gender', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="state_id" class="col-sm-4 control-label">States</label>

                        <div class="col-sm-10">
                            {!! Form::select('states', $states, null, array('id' => 'state_id', 'name' => 'state_id', 'class'
                            =>
                            'form-control', 'placeholder' => 'Pick a value')) !!}
                        </div>
                    </div>

                    <div id="lgaHidden" style="display: none;">
                        <div class="form-group">
                            <label for="lga_id" class="col-sm-4 control-label">LGA</label>
                            <div class="col-sm-10">
                            {{-- {!! Form::select('states', $states, null, array('id' => 'state_id', 'name' => 'state_id', 'class' => 'form-control', 'required' => 'true', 'placeholder' => 'Pick a value')) !!} --}}
                            <select id="lga_id" name="lga_id" class="form-control" placeholder="Pick a value">
                                <option value="">Pick a value</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="secondary_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="secondary_email" name="secondary_email" value="{!! old('secondary_email') !!}" autofocus placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="secondary_phone_number">Phone Number:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="secondary_phone_number" name="secondary_phone_number" value="{!! old('secondary_phone_number') !!}" placeholder="Phone Number" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_address" class="col-sm-5 control-label">Contact Address</label>
                        <div class="col-sm-10">
                        <textarea id="contact_address" name="contact_address" cols="30" rows="10"  class="form-control textarea" placeholder="Contact Address" style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                        {!! old('contact_address') !!}
                        </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="date_of_birth">Date of Birth:</label>
                        <div class="col-sm-10">
                            <div class="input-group date mb-3">
                                <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="{!! old('date_of_birth') !!}" placeholder="Date of Birth" autofocus>
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="consultation_fee">Consultation Fee:</label>
                        <div class="col-sm-10">
                            <div class="input-group date mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ NAIRA_CODE }}</span>
                                  </div>
                                <input type="text" class="form-control" id="consultation_fee" name="consultation_fee" value="{!! old('consultation_fee') !!}" placeholder="Consultation Fee" data-thousands="," data-decimal="."  autofocus>
                                <div class="input-group-append">
                                  <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="home_address" class="col-sm-5 control-label">Home Address</label>
                        <div class="col-sm-10">
                        <textarea id="home_address" name="home_address" cols="30" rows="10" class="form-control textarea" placeholder="Contact Address"
                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                        {!! old('home_address') !!}
                        </textarea>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="form-check checkbox-success checkbox-circle">
                            <input id="status_id" type="checkbox" name="status_id">
                            <label for="status_id">Is Active</label>
                        </div>
                    </div>
                    <hr>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-left">
                                    <a href="{{ route('doctors.index') }}" class="pull-right btn btn-danger"><i class="fa fa-close"></i> Back </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

        </div>
      </div>

    </div>

</section>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
{{-- <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script> --}}

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.maskMoney.js') }}"></script>

<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    // CKEDITOR.replace('content_edit');
    // CKEDITOR.replace('contact_address');
    // CKEDITOR.replace('home_address');
    $('#date_of_birth').datepicker({});
    $("#consultation_fee");
    $("#secondary_phone_number").inputmask('9999-999-9999');
    $('#contact_address').summernote();
    $('#home_address').summernote();
    // $('.textarea').summernote();
</script>
<script type="text/javascript">
    $(function(){
        // $.noConflict(); getUsersByStatusCategory
        $('select[name="state_id"]').on('change', function() {
            var stateID = $(this).val();
            $("#lgaHidden").slideDown(500);
            // alert(stateID);
            if(stateID) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    url: '{{ url("/mystateAjax/ajax") }}/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data)
                    {
                    console.log(data);
                    $('select[name="lga_id"]').children('option:not(:first)').remove();

                    $.each(data, function(key, value) {
                        $('select[name="lga_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                    }

                });

            }else{
                $('select[name="lga_id"]').children('option:not(:first)').remove();
            }
        });

        $('select[name="is_admin"]').on('change', function() {
            var isAdmin = $(this).val();

            $("#nameHidden").slideDown(500);
            // alert(isAdmin);
            if(isAdmin) {
                if(isAdmin != 20){
                    // alert(isAdmin)
                    $("#consultation_fee").attr('disabled','disabled');
                    $("#specialization_id").attr('disabled','disabled');
                }else{

                    $("#consultation_fee").removeAttr('disabled');
                    $("#specialization_id").removeAttr('disabled');

                }

                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    url: '{{ url("/getUsersByStatusCategory") }}/'+isAdmin,
                    type: "GET",
                    dataType: "json",
                    success:function(data)
                    {
                        console.log(data);
                        $('select[name="user_id"]').children('option:not(:first)').remove();

                        $.each(data, function(key, value) {
                            $('select[name="user_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }

                });

            }else{
                $('select[name="user_id"]').children('option:not(:first)').remove();
            }
        });
    });

  </script>

@endsection

