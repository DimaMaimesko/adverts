@extends('layouts.app')

@section('content')
    @include('admin._nav')

    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-3"></div>
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6">
                        {!! Form::open(['url' => route('admin.permissions.update',['permission' => $permission]),'method'=>'PUT','data-parsley-validate','autocomplete'=>'off']) !!}
                        <div class="form-group">
                            <label for="roleName">Name</label>
                            {!! Form::text('name',$permission->name,['class'=>'form-control','placeholder'=>'Name','required','id'=>'roleName']) !!}
                        </div>
                        <div class="alert alert-success">
                            <div class="panel-heading">
                                <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    <div class="alert alert-danger" role="alert">
                        <div class="panel panel-heading mr-2">
                            {{ Form::open(['url' => route('admin.permissions.destroy',['id' => $permission->id]),'method'=>'DELETE']) }}
                            <button type="submit" class="btn btn-danger text-uppercase del-field" data-confirm="Do you want to delete Permission {{$permission->name}}?">
                                <i class="glyphicon glyphicon-remove"></i> Delete
                            </button>
                            {{ Form::close() }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3"></div>
    </div>
@endsection