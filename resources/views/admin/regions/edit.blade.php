@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    {!! Form::open(['url' => route('admin.users.update',['user'=> $user]),'method'=>'PUT','data-parsley-validate','autocomplete'=>'off']) !!}
    <div class="form-group">
        <label for="userCreateName">Username</label>
        {!! Form::text('name',$user->name,['class'=>'form-control','placeholder'=>'Username','required','id'=>'userCreateName']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Email address</label>
        {!! Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'Email','required','id'=>'userCreateEmail']) !!}
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    @if(auth()->user()->hasPermissionTo('set roles'))
        <div class="form-group">
            <label for="userCreateRole">Role</label>
            {!! Form::select('roles[]',$roles, $user->roles()->pluck('id'),['class'=>'form-control','placeholder'=>'Role','required','id'=>'userCreateRole']) !!}
        </div>
    @endif
    <div class="form-group">
        <label for="userCreatePassword">Password</label>
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password','id'=>'userCreatePassword']) !!}

    </div>
    {{--<div class="checkbox">--}}
        {{--{{ Form::hidden('status', 0) }}--}}
        {{--<label> Status:--}}
            {{--<input type="checkbox" data-toggle="toggle" data-on="active" data-off="wait"  @if($user->status) checked="checked" @endif name="status" type="checkbox" value="1">--}}
        {{--</label>--}}
    {{--</div>--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection