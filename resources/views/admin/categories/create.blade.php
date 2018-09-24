@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    {!! Form::open(['url' => route('admin.categories.store'),'method'=>'POST','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label>Region name</label>
        {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Region name','required']) !!}
    </div>
    <div class="form-group">
        <label>Slug</label>
        {!! Form::text('slug',old('slug'),['class'=>'form-control','placeholder'=>'Slug','required']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateRole">Parent</label>
        {!! Form::select('parent_id',$parents, null,['class'=>'form-control','placeholder'=>'Parent Category','required']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection