@extends('admin.layouts.admin')

@section('style')
    <link href="{{ asset('plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Pharmacy Requisition Management
                        {{-- <a href="{{ route('sales.index') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i>
                    New</a> --}}
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pharmacy Requisition Management</li>

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content noprint">
        <!-- Default box -->
        <div class="box box-primary">

            <div class="box-body noprint">

                <div class="row">
                    <div class="col-12">
                        <div class="card card-info collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Doctor's Prescription for patient: {!! $customer !!} </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'sales.store', 'method' => 'POST', 'role' => 'form']) !!}
                                {{ csrf_field() }}

                                <table class="table table-sm table-responsive table-sm table-responsive table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Doctors consultation Report</td>
                                            <td>Doctor's Prescription Recommendation</td>
                                        </tr>
                                        <tr>
                                            <td>{!! $mycustomer->pateintDiagnosisReport !!}</td>
                                            <td>{!! $mycustomer->pharmacy !!}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}
                                    Previous Investigations </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($tests != ' ')
                                    <h3 class="card-title">Investigations </h3>

                                    <table
                                        class="table table-sm table-responsive table-sm table-responsive table-bordered table-striped DataTables">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Lab</th>
                                                <th>Test</th>
                                                <th>Result</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tests as $test)
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{ $test->lab->lab_name }}</td>
                                                    <td>{{ $test->lab_service->lab_service_name }}</td>
                                                    <td>
                                                        @if ($test->resultReport != '0' && $test->status_id != 0)
                                                            {!! $test->resultReport !!}
                                                        @elseif($test->status_id == 2)
                                                            <span class="badge badge-danger">Request Declined</span>
                                                        @else
                                                            <span class="badge badge-warning">Awaiting Results</span>
                                                        @endif
                                                    </td>
                                                    <td>Requested On: <small>{{ $test->created_at }}</small> <br>
                                                        <hr> Last Updated On: <small>{{ $test->updated_at }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card card-primary collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Patient Information</h3>
                                @if ($patient->user->old_records)
                                    <a href="{!! url('storage/image/user/old_records/' . $patient->user->old_records) !!}" target="_blank"><i class="fa fa-file"></i> Old
                                        Records</a>
                                @endif

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="form-group">
                                    <label for="fullname">Title/Fullname</label>
                                    <div class="input-group input-group-sm">
                                        @if (!empty($patient->title->name))
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $patient->title->name }}</span>
                                            </div>
                                        @endif
                                        <input type="text" id="fullname" class="form-control form-control-sm"
                                            value="{{ $dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <input type="text" id="gender" class="form-control form-control-sm"
                                        value="{{ $dependant->genderr->name ?? ($patient->genderr->name ?? 'N/A') }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" id="dob" class="form-control form-control-sm"
                                        value="{{ $dependant->dob ?? ($patient->dob ?? 'N/A') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email"> Email</label>
                                    <input type="text" id="email" class="form-control form-control-sm"
                                        value="{{ $patient->user->email ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="contact_address">Contact Address</label>
                                    <textarea id="contact_address" class="form-control form-control-sm" rows="3" readonly>{{ $patient->address ?? 'N/A' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number"> Phone Number</label>
                                    <input type="text" id="phone_number" class="form-control form-control-sm"
                                        value="{{ $patient->user->phone_number ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="blood_groop">Blood Group</label>
                                    <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                        value="{{ $dependant->blood_group_id ?? ($patient->blood_group_id ?? 'N/A') }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label for="blood_groop">State/Province</label>
                                    <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                        value="{{ $patient->lgaa->name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="blood_groop">LGA</label>
                                    <input type="text" id="blood_groop_id" class="form-control form-control-sm"
                                        value="{{ $patient->lgaa ? $patient->lgaa->getState() : 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number"> Genotype</label>
                                    <input type="text" id="phone_number" class="form-control form-control-sm"
                                        value="{{ $dependant->genotype ?? ($patient->genotype ?? 'N/A') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="hmo"> HMO/Insurance</label>
                                    <input type="text" id="hmo" class="form-control form-control-sm"
                                        value="{{ $patient->hmo->name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="hmo"> HMO/Insurance Number</label>
                                    <input type="text" id="hmo" class="form-control form-control-sm"
                                        value="{{ $dependant->hmo_no ?? ($patient->hmo_no ?? 'N/A') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-dark collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Vital Sign for {!! $customer !!}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="temperature"> Temperature</label>
                                    <input type="text" id="temperature" class="form-control form-control-sm"
                                        value="{{ $vitalSign->temperature ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="weight"> Weight</label>
                                    <input type="text" id="weight" class="form-control form-control-sm"
                                        value="{{ $vitalSign->weight ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="bloodPressure"> Blood Pressure</label>
                                    <input type="text" id="bloodPressure" class="form-control form-control-sm"
                                        value="{{ $vitalSign->bloodPressure ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="VitalSignReport" class="control-label">Vital Sign Report</label>
                                    <textarea id="VitalSignReport" name="VitalSignReport" cols="10" rows="2" class="form-control"
                                        placeholder="Enter Instruction" readonly>{{ $vitalSign->VitalSignReport ?? 'N/A' }}
                        </textarea>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div class="callout callout-info">
                    <div class="form-group">
                        {{-- <label for="Parent" class="col-md-8 control-label">Select Patient Type </label> --}}
                        <div hidden="1">
                            <div class="radio radio-primary radio-inline">
                                @if (Auth::user()->id = 1)
                                    <input type="radio" name="s1" id="s1" value="1" checked>
                                @else
                                    <input type="radio" name="s1" id="s1" value="1"
                                        style="display: none;">
                                @endif
                                <label for="s1"> Credit Patient</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" name="s1" id="s1_" value="2" disabled>
                                <label for="s1_">Regular Patient</label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="s1" id="s1__" value="3" disabled>
                                <label for="s1__">Casual Patient</label>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group" id="dropMain" style="display: none;"> -->
                    <div class="form-group">
                        <div class="form-group">
                            <label>Patient Name:</label>
                            <input type="text" name="customer" id="customer" class="form-control"
                                value="{{ $customer }}" readonly="1">
                            <input type="hidden" name='user_id' value="{{ $mycustomer->user_id }}">
                            <input type="hidden" name="med_rep_id" value="{{ $medical }}">
                        </div>
                        <div class="form-group" hidden="1">
                            <label>stores:</label>
                            <input type="text" name="stores" id="stores" class="form-control" value="2"
                                readonly="1">

                        </div>
                        <div class="form-group" hidden="1">
                            <label>medical:</label>
                            <input type="text" name="medical" id="medical" class="form-control"
                                value="{{ $medical }}" readonly="1">

                        </div>


                        {{-- <div>
                            <div class="form-group">
                                <label>Mode of Payment:</label>
                                {!! Form::select('payment_mode2', $payment_mode, null, ['id' => 'payment_mode', 'name' => 'payment_mode', 'class' => 'select2 show-tick form-control', 'data-live-search' => 'true']) !!}
                            </div>
                        </div> --}}
                        <div class="form-group" id="payment_mode_">
                            <label for="payment_mode"
                                class="col-md-4 col-form-label">{{ __('Mode of Payment: ') }}</label>
                            {{-- {!! Form::select('payment_mode', $payment_mode, null, ['id' => 'payment_mode', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value', 'required' => 'true']) !!} --}}
                            <select name="payment_mode" id="payment_mode" placeholder="Pick a Value"
                                class="form-control" required>
                                <option value="">--Select payment mode</option>
                                @foreach ($payment_mode as $key => $mode)
                                    <option value="{{ $key }}">{{ $mode }}</option>
                                @endforeach

                                @isset($patient_account)
                                    <option value="from_account">Patient Account
                                        (???{{ $patient_account->deposit - $patient_account->creadit }})</option>
                                @endisset
                            </select>
                            @isset($patient_account)
                                <input type="hidden" name="from_account_id" value="{{ $patient_account->id }}">
                            @endisset
                        </div>
                        <div class="form-group">
                            <label for="use_hmo" class="col-md-4 col-form-label">{{ __('Use Hmo') }}</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="use_hmo" name="use_hmo" class=""
                                    onclick="cal_tot(this)" value="{{ $hmo->discount }}" checked required />
                                {{ $hmo->discount }}% Discount - {{ $hmo->name }}
                                <input type="hidden" name="hmo" value="{{ $hmo->id }}">
                            </div>
                        </div>
                        <div class="form-group " id="dropMe" style="display: none">
                            <label for="amount"
                                class="col-md-4 col-form-label">{{ __('Payment Rreference Id(POS/Teller no) ') }}</label>

                            <div class="col-md-6">
                                <input id="payment_id" type="text"
                                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                    name="payment_id" value=" " required autofocus>

                                @if ($errors->has('payment_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payment_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!--   <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Category:</label>
                                                                            {!! Form::select('category', $category, null, [
                                                                                'id' => 'category_id',
                                                                                'name' => 'category_id',
                                                                                'placeholder' => 'Pick Category',
                                                                                'class' => 'form-control',
                                                                                'data-live-search' => 'true',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div> -->
                        <div class="form-group col-md-4">
                            <label>Product Name:</label>
                            {!! Form::select('products', $products, null, [
                                'id' => 'product',
                                'placeholder' => 'Please Select Product',
                                'class' => 'select2 show-tick form-control',
                                'style' => 'width: 100%;',
                                'data-toggle' => 'select2',
                                'data-placeholder' => 'Select or search product from the list...',
                                'data-allow-clear' => 'true',
                            ]) !!}
                        </div>

                    </div>
                    <div class="row">
                        <table class="table table-sm table-responsive table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th>Current Quantity </th>
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
                                        <input type="number" name="current_quantity" id="current_quantity"
                                            class="form-control" readonly="true" value="{{ old('current_quantity') }}"
                                            placeholder="Current Quantity" />
                                    </td>
                                    <td>
                                        <input type="text" name="price" id="price" placeholder="Price"
                                            class="form-control" readonly="1" value="{{ old('price') }}" />
                                    </td>
                                    <td>
                                        <input type="text" name="max_discount" id="max_discount"
                                            placeholder="Maximum Discount" class="form-control" readonly="1"
                                            value="{{ old('max_discount') }}" />
                                    </td>
                                    <td>
                                        <input type="number" name="quantity" id="quantity" class=" form-control"
                                            value="{{ old('quantity') ? old('quantity') : 0 }}"
                                            placeholder="Request Quantity" />
                                    </td>
                                    <td>
                                        <input type="number" name="dc" id="dc" class="form-control"
                                            value="{{ old('dc') ? old('dc') : 0 }}" readonly="true"
                                            placeholder="Discount" />
                                    </td>
                                    {{-- <td>
                                            <select name="stores" id="stores" class="form-control">
                                                <option value="">Pick a value...</option>
                                                <option value=""></option>
                                            </select>
                                        </td> --}}
                                    <input type="hidden" name="piece_sprice" id="pieces_price"
                                        placeholder=" pieces_price" class=" form-control" readonly="1"
                                        value="{{ old('pieces_price') ? old('pieces_price') : 0 }}" />
                                    <input type="hidden" name="pieces_max_discount" id="pieces_max_discount"
                                        placeholder=" max_discount" class=" form-control" readonly="1"
                                        value="{{ old('pieces_max_discount') ? old('pieces_max_discount') : 0 }}" />
                                    <input type="hidden" name="pieces_quantity" id="pieces_quantity"
                                        class=" form-control"
                                        value="{{ old('pieces_quantity') ? old('pieces_quantity') : 0 }}" />
                                    <input type="hidden" name="pdc" id="pdc" class=" form-control"
                                        value="{{ old('pdc') ? old('pdc') : 0 }}" />


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class=" form-group text-center">
                        <a href="{{ route('prices.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i>
                            Back</a>
                        <button type="button"
                            onclick='

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
                                                                                Swal.fire({
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
                                                                                {{-- alert("Please enter a valid number of " + $("#product option:selected").text() + " Quantity."); --}}
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

                                                                            if(parseInt($("#quantity").val(), 10) > parseInt($("#current_quantity").val(), 10) )
                                                                            {
                                                                                {{-- alert("Please Reduce the number of ." + $("#product option:selected").text() + " Quantity demand Not Available."); --}}
                                                                                Swal.fire({
                                                                                    icon: "error",
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
                                                                            '
                            class="btn btn-primary"><i class="fa fa-plus"></i>
                            Add
                            Item</button>

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
                                    <th>Amount {{ NAIRA_CODE }}</th>
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
                                                              "
                            class="btn btn-danger"><i class="fa fa-remove"></i>
                            Remove
                            item(s)
                            From
                            List</a>

                        <a onclick="
                                                                if( dtTable.rows().data().length < 1){
                                                                  // alert('Enter items to upload');
                                                                  $('.flash').html('<h4>Add items to upload to server.</h4>').fadeIn(300).delay(20).fadeOut(500);
                                                                  return false;
                                                                }else{
                                                                    postData();
                                                                }
                                                              "
                            class="btn btn-success pull-right"><i class="fa fa-arrow-up"></i>
                            Proccess
                            Item(s)</a>


                    </div>
                    {{-- <span class="text-danger" id="discount_text"></span> --}}
                </div>

    </section>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script>
        $('select[name="products"]').select2().on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '{{ url('/myform/ajaxprice') }}/' + id,
                        type: "GET",
                        dataType: "text",
                        success: function(response) {

                            console.log(response);
                            var data = jQuery.parseJSON(response);

                            data = data[0];
                            data1 = data[1];
                            {{-- var data = $.parseJSON(data);
                             alert(data); --}}
                            {{-- var res = JSON.parse(data); --}}
                            {{-- alert(data[0]);
                                alert(data[1]); --}}

                            {{-- console.log(data[0]);
                                console.log(data.storeStock[1]); --}}
                            $('select[name="slug"]').empty();
                            $('#current_quantity').val(data.stock.current_quantity);
                            $('#price').val(data.current_sale_price);
                            $('#max_discount').val(data.max_discount);
                            $('#pieces_price').val(data.pieces_price);
                            $('#pieces_max_discount').val(data.pieces_max_discount);
                            {{-- $('#stores').val(data.store_id); --}}

                            $.each(data, function(key, value) {
                                $('#stores').append('<option value="' + value + '">' +
                                    value + '</option>');
                                console.log(key, value);
                            });

                            $.each(data, function(key, value) {
                                $('select[name="slug"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                                console.log(key, value);
                            });
                        }

                    });



                } else {
                    $('#price').val("");
                }
            });
    </script>
    <script src="{{ asset('plugins/datatables/sum().js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>

    <script>
        function cal_tot(obj) {
            if ($('#use_hmo').is(':checked')) {
                discount = $(obj).val();
                discount = (parseFloat(discount) / 100) * parseFloat($('#total_amount').val());
                discount_text = parseFloat($('#total_amount').val()) - discount;
                $('#discount_text').text('You pay ???' + discount_text);
            } else {
                discount = $(obj).val();
                discount_text = "You pay ???" + $('#total_amount').val();
                $('#discount_text').text(discount_text);
            }
        }

        var subtotal = 0;
        var dtTable;
        var customer;
        var stores;
        $('.flash').hide();

        jQuery(function($) {
            $(document).ready(function() {
                customer = $('#customer');
                stores = $('#stores');
                payment_mode = $('select[name="payment_mode"]');
                {{-- console.log(customer.val()); --}}
                {{-- console.log(stores.val()); --}}

                dtTable = $('#property').DataTable({
                    "dom": 'Bfrtip',
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    buttons: ['pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'],
                    drawCallback: function() {

                        var sumTotal = $('#property').DataTable().column(8).data().sum();
                        $('#subtotal').html(sumTotal);

                    },
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "select": true,
                    "edit": true
                });

                $('#property tbody').on('click', 'tr', function() {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    } else {
                        dtTable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });

                {{-- $('#button').click( function () {
                            dtTable.row('.selected').remove().draw( false );
                        } ); --}}

            });
        });

        function postData() {

            var DataPayLoad = '';
            DataPayLoad = '[';
            for (i = 0; i < dtTable.rows().data().length - 1; i++) {
                DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i, 1).data() + '", "quantity":"' + dtTable.cell(i, 2)
                    .data() + '", "total_amount":"' + dtTable.cell(i, 8).data() + '", "price":"' + dtTable.cell(i, 4)
                    .data() + '"}, ';
                // DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i,1).data() + '", "quantity":"' + dtTable.cell(i,2).data() + '", "total_amount":"' + dtTable.cell(i,3).data() + '", "price":"' +  dtTable.cell(i,4).data() + '", "pieces_price":"' +  dtTable.cell(i,5).data() + '", "pieces_quantity":"' +  dtTable.cell(i,6).data() + '"}';
            }
            DataPayLoad += '{' + '"product":' + '"' + dtTable.cell(i, 1).data() + '", "quantity":"' + dtTable.cell(i, 2)
                .data() + '", "total_amount":"' + dtTable.cell(i, 8).data() + '", "price":"' + dtTable.cell(i, 4).data() +
                '", "pieces_price":"' + dtTable.cell(i, 5).data() + '", "pieces_quantity":"' + dtTable.cell(i, 6).data() +
                '"}';
            DataPayLoad += ']';

            {{-- console.log(DataPayLoad); --}}

            dataPL = {
                'trans': "{{ $trans }}",
                'customer': customer.val(),
                'stores': stores.val(),
                'medical': "{{ $medical }}",
                'payment_mode': payment_mode.val(),
                'payload': DataPayLoad
            };
            // var jsonString = JSON.stringify(dataPL);
            $.ajax({
                type: "post",
                url: "{{ route('sales.store') }}",
                data: dataPL,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('.flash').html(data).fadeIn(300).delay(200000).fadeOut(300);
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('.flash').html(errorThrown).fadeIn(300).delay(2000).fadeOut(300);
                }
            });
        }
    </script>

    {{-- <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            {{-- $.noConflict(); --}}

            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                // alert(category_id);
                if (category_id) {
                    $.ajax({
                        url: '{{ url('myCategoryAjax/ajax') }}/' + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('select[name="product"]').children('option:not(:first)').remove();
                            $.each(data, function(id, value) {
                                // $('select[name="products"]')
                                // .append($("<option></option>")
                                // .attr("value",id)
                                // .text(value));
                                $('select[name="product"]').append('<option value="' +
                                    id + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="product"]').children('option:not(:first)').remove();
                }

            });

            if (document.getElementById('s1').checked) {
                $("#dropMain").slideDown(500);
                $("#dropNo").slideUp(500);
                {{-- console.log("dropDown"); --}}
            }

            if (document.getElementById('s1_').checked) {
                $("#dropSub").slideDown(500);
                {{-- console.log("dropDown"); --}}
            }

            if (document.getElementById('s1__').value) {
                $("#dropNo").slideDown(500);
                {{-- console.log("dropDown"); --}}
            }

            $("#s1").click(function() {
                $("#dropMain").slideDown(500);
                $("#dropSub").slideUp(500);
                $("#dropNo").slideUp(500);
                customer = $('select[name="customer1"]');
                {{-- console.log(customer); --}}
                payment_mode = $('select[name="payment_mode1"]');
                stores = $('select[name="stores1"]');
                $("#s1_").prop("checked", false);
                $("#s1__").prop("checked", false);
                {{-- console.log(customer); --}}
                {{-- console.log(stores); --}}
            });

            $("#s1_").click(function() {
                $("#dropSub").slideDown(500);
                $("#dropMain").slideUp(500);
                $("#dropNo").slideUp(500);
                customer = $('select[name="customer2"]');
                {{-- console.log(customer); --}}
                payment_mode = $('select[name="payment_mode2"]');
                stores = $('select[name="stores2"]');
                $("#s1").prop("checked", false);
                $("#s1__").prop("checked", false);
                {{-- console.log(customer); --}}
                {{-- console.log(store); --}}
                {{-- console.log("dont drop"); --}}
            });

            $("#s1__").click(function() {
                $("#dropNo").slideDown(500);
                $("#dropSub").slideUp(500);
                $("#dropMain").slideUp(500);
                customer = $('#customer');
                payment_mode = $('select[name="payment_mode"]');
                stores = $('select[name="stores"]');
                $("#s1").prop("checked", false);
                $("#s1_").prop("checked", false);
                {{-- console.log(customer); --}}
                {{-- console.log(store); --}}
                // document.getElementById('password').disabled = true;
                {{-- console.log("dont drop"); --}}
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.noConflict();
            $('select[name="products"]').select2().on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '{{ url('/myform/ajaxprice') }}/' + id,
                        type: "GET",
                        dataType: "text",
                        success: function(response) {

                            console.log(response);
                            var data = jQuery.parseJSON(response);

                            data = data[0];
                            data1 = data[1];
                            {{-- var data = $.parseJSON(data);
                             alert(data); --}}
                            {{-- var res = JSON.parse(data); --}}
                            {{-- alert(data[0]);
                                alert(data[1]); --}}

                            {{-- console.log(data[0]);
                                console.log(data.storeStock[1]); --}}
                            $('select[name="slug"]').empty();
                            $('#current_quantity').val(data.stock.current_quantity);
                            $('#price').val(data.current_sale_price);
                            $('#max_discount').val(data.max_discount);
                            $('#pieces_price').val(data.pieces_price);
                            $('#pieces_max_discount').val(data.pieces_max_discount);
                            {{-- $('#stores').val(data.store_id); --}}

                            $.each(data, function(key, value) {
                                $('#stores').append('<option value="' + value + '">' +
                                    value + '</option>');
                                console.log(key, value);
                            });

                            $.each(data, function(key, value) {
                                $('select[name="slug"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                                console.log(key, value);
                            });
                        }

                    });



                } else {
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

            $("#s1").click(function() {
                $("#dropMain").slideDown(500);
                $("#dropSub").slideUp(500);
                $("#dropNo").slideUp(500);
                customer = $('select[name="customer1"]');
                console.log(customer);
                payment_mode = $('select[name="payment_mode1"]');
                stores = $('select[name="stores1"]');
                $("#s1_").prop("checked", false);
                $("#s1__").prop("checked", false);
                console.log(customer);
                console.log(stores);
            });

            $("#s1_").click(function() {
                $("#dropSub").slideDown(500);
                $("#dropMain").slideUp(500);
                $("#dropNo").slideUp(500);
                customer = $('select[name="customer2"]');
                console.log(customer);
                payment_mode = $('select[name="payment_mode2"]');
                stores = $('select[name="stores2"]');
                $("#s1").prop("checked", false);
                $("#s1__").prop("checked", false);
                console.log(customer);
                console.log(store);
                console.log("dont drop");
            });

            $("#s1__").click(function() {
                $("#dropNo").slideDown(500);
                $("#dropSub").slideUp(500);
                $("#dropMain").slideUp(500);
                customer = $('#customer');
                payment_mode = $('select[name="payment_mode"]');
                stores = $('select[name="stores"]');
                $("#s1").prop("checked", false);
                $("#s1_").prop("checked", false);
                console.log(customer);
                console.log(store);
                // document.getElementById('password').disabled = true;
                console.log("dont drop");
            });

            if ($('#use_hmo').is(':checked')) {
                discount = $('#use_hmo').val();
                discount = (parseFloat(discount) / 100) * parseFloat($(
                    '#total_amount').val());
                discount_text = parseFloat($('#total_amount').val()) - discount;
                $('#discount_text').text('You pay ???' + discount_text);
            } else {
                discount = $('#use_hmo').val();
                discount_text = "You pay ???" + $('#total_amount').val();
                $('#discount_text').text(discount_text);
            }

            $('select[name="payment_mode"]').on('change', function() {
                $('#dropMe').slideDown(300);
            });
        });
        $('.DataTables').DataTable();
    </script>
    {{-- <script src="{{ asset('js/app.js') }}" type="text/javascript"></script> --}}
@endsection
