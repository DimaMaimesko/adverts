@extends('layouts.app')
@section('content')
    @include('admin.roles._nav')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="col-md-3"></div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="bgc-white p-20 bd">
                        <div class="mT-30">
                            {!! Form::open(['url' => route('admin.roles.store'),'method'=>'POST','data-parsley-validate','autocomplete'=>'off']) !!}
                            <div class="form-group">
                                <label for="roleName">Name</label>
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name','required','id'=>'roleName']) !!}
                            </div>
                            {{--<div class="checkbox">--}}
                                {{--{{ Form::hidden('active', 0) }}--}}
                                {{--<label>--}}
                                    {{--<input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Inactive"  checked="checked" name="active" type="checkbox" value="1">--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                @foreach($permissions as $permission)
                                    <div>
                                        {!! Form::checkbox('roles[]',$permission->name, false,['class'=>'icheckbox_flat-green checked']) !!}
                                        <label for="roleName">{{$permission->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
@endsection