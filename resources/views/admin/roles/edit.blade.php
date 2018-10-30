@extends('layouts.app')
@section('content')
    @include('admin.roles._nav')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="col-md-3"></div>
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6">
                    <div class="bgc-white p-20 bd">
                        {!! Form::open(['url' => route('admin.roles.update',['role' => $role]),'method'=>'PUT','data-parsley-validate','autocomplete'=>'off']) !!}
                            <div class="form-group">
                                <label for="roleName">Name</label>
                                {!! Form::text('name',$role->name,['class'=>'form-control','placeholder'=>'Name','required','id'=>'roleName']) !!}
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
                                        {!! Form::checkbox('roles[]', $permission->name, $role->hasPermissionTo($permission->name) ? true : false) !!}
                                        <label for="roleName">{{$permission->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                {{ Form::open(['url' => route('admin.roles.destroy',['id' => $role->id]),'method'=>'DELETE']) }}
                                <button type="submit" class="btn btn-danger text-uppercase del-field" data-confirm="Do you want to delete Permission {{$permission->name}}?">
                                    <i class="glyphicon glyphicon-remove"></i> Delete
                                </button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("[data-confirm]").click(function() {
                return confirm($(this).attr('data-confirm'));
            });
        });
    </script>
@endsection
