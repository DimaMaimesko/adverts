@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    {!! Form::open(['url' => route('admin.regions.update',['region'=> $region]),'method'=>'PUT','data-parsley-validate','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label for="userCreateName">Region name</label>
        {!! Form::text('name',$region->name,['class'=>'form-control','placeholder'=>'Region name','required']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Slug</label>
        {!! Form::text('slug',$region->slug,['class'=>'form-control','placeholder'=>'Slug','required']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Parent id</label>
        {!! Form::text('parent_id',$region->parent_id,['class'=>'form-control','placeholder'=>'Parent id']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection