@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    {!! Form::open(['url' => route('admin.categories.update',['category'=> $category]),'method'=>'PUT','autocomplete'=>'off']) !!}
    <br>
    <div class="form-group">
        <label>Category name</label>
        {!! Form::text('name',$category->name,['class'=>'form-control','placeholder'=>'Category name','required']) !!}
    </div>
    <div class="form-group">
        <label>Slug</label>
        {!! Form::text('slug',$category->slug,['class'=>'form-control','placeholder'=>'Slug','required']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateRole">Parent</label>
        {!! Form::select('parent_id',$parents, isset($category->parent->id) ? $category->parent->id : null,['class'=>'form-control','placeholder'=>'Parent Category','required']) !!}
    </div>

    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection