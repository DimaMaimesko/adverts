@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    {!! Form::open(['url' => route('admin.users.store'),'method'=>'POST','data-parsley-validate','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label for="userCreateName">Username</label>
        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Username','required','id'=>'userCreateName']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Email address</label>
        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email','required','id'=>'userCreateEmail']) !!}
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="userCreatePassword">Password</label>
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password','required','id'=>'userCreatePassword']) !!}
    </div>
    @if(auth()->user()->hasPermissionTo('set roles'))
        <div class="form-group">
            <label for="userCreateRole">Role</label>
            {!! Form::select('role',$roles, null,['class'=>'form-control','placeholder'=>'Role','required','id'=>'userCreateRole']) !!}
        </div>
    @endif

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection