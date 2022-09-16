@extends('admin.layouts.admin')

@section('main-content')


@section('main-content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Client Credit DateLine</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Client Credit DateLine</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <!-- Default box -->
    <div class="card card-secondary">
        <div class="card-header with-border">
            <h3 class="card-title">Set Client Credit DateLine </h3>
            <div class="card-tools pull-right">
                {{-- <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fa fa-list"></i> View
                Citizens</a> --}}
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="col-sm-offset-2 col-sm-10"> --}}
            <form class="form-horizontal" method="POST" action="{{ route('dateline.update', $data->id) }}">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">

                <div class="form-group">
                    <label for="name" class="control-label"> Client FullName </label>
                    <div class="form-control-material">
                        <input type="text" name="name" id="name" placeholder=" Client FullName " class="form-control"
                            value="{{ (old('name')) ? old('name') : $data->fullname }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="control-label"> Client Type </label>
                    <div class="form-control-material">
                        <input type="text" name="customers" id="customers" placeholder=" customers "
                            class="form-control"
                            value="{{ (old('name')) ? old('name') : $data->customer_type->type_name }}" readonly="1" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label"> Phone </label>
                    <div class="form-control-material">
                        <input type="text" name="phone" id="phone" placeholder=" Phone " class="form-control"
                            value="{{ (old('name')) ? old('name') : $data->phone }}" readonly="1" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_line" class="control-label"> Date Line : Year Month Day</label>
                    <div class="form-control-material">
                        <input date="number" name="date_line" id="date_line" placeholder=" Dateline: YYYY-MM-DD"
                            class="form-control" value="{{ (old('name')) ? old('name') : $data->date_line }}" />
                    </div>


                    <br>

                    <div class="card-footer" align="center">
                        <a href="{{ route('customers.index') }}" class="btn btn-success"> Back</a>
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Update</button>
                    </div>
                    {!! Form::close() !!}

                </div>
        </div>
        {{-- </div> --}}
    </div>
    </div>
</section>
@endsection