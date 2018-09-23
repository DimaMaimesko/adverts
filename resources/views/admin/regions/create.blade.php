@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    {!! Form::open(['url' => route('admin.regions.store'),'method'=>'POST','data-parsley-validate','autocomplete'=>'off']) !!}
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
        <label>Parent id</label>
        {!! Form::text('parent_id',isset($parent_id) ? $parent_id : old('parent_id'),['class'=>'form-control','placeholder'=>'Parent id']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection