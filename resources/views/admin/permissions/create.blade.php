@extends('layouts.app')
@section('content')
    @include('admin.permissions._nav')

    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-3"></div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                    {!! Form::open(['url' => route('admin.permissions.store'),'method'=>'POST','data-parsley-validate','autocomplete'=>'off']) !!}
                    <div class="form-group">
                        <label for="roleName">Name</label>
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name','required','id'=>'roleName']) !!}
                    </div>
                    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-3"></div>
            </div>
    </div>

@endsection