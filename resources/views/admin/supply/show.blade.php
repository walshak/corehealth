
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
	              <div class="box-header with-border">
				   	<h3 class="text-success">list of Product
				   </h3>

				   <div class="panel-body">
				 
					
                    {!! Form::open(array('route' => 'supply.store', 'method'=>'POST', 'role'=>'form')) !!}
                        {{ csrf_field() }}

						 <table id="property" class="table table-sm table-responsive table-bordered table-striped">

							<thead>
								<tr class="text-success">
									<th>S/N</th>
									<th><input type="checkbox" class="checkbox-inline" id="selectall"/></th>
									<th>Course </th>
									<th>Code </th>
									<th>Unit</th>
									<th>Type</th>
									<th>Requisite</th>
									<th>Semester</th>
								
								</tr>
							</thead>
							<tbody>
								<?php
								  $sn = 1;
                                  $totalload =0;
								?>
								
								
							</tbody>
						
						</table>
					
						<div class="row">
			                <div class="col-md-6">
			                    <div class="form-group">
			                        <div class="col-sm-12">
			                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
			                        </div>
			                    </div>
			                </div>
					 {!! Form::close() !!} 
					</div>
				</div>
			</div>
		</div>
	</div>


@section('scripts')

<!-- jQuery -->

{{-- <script src="{{ asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script> --}}
{{-- <script src="{{ asset('plugins/jQuery/jquery.min.js') }}" ></script> --}}
<!-- Bootstrap 4 -->
<!-- DataTables -->
<script src="{{ asset('/plugins/dataT/datatables.js') }}" defer></script>

<SCRIPT language="javascript">
   $(function(){

		  $('.checkbox-inline').attr('checked', true);
	
    });
</SCRIPT>   
@endsection
