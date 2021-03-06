@extends('layouts.app')

@section('content')
    @include('admin.pages._nav')

    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                   name="title"
                   value="{{ $page->title }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="menu_title" class="col-form-label">Title</label>
            <input id="menu_title" class="form-control{{ $errors->has('menu_title') ? ' is-invalid' : '' }}"
                   name="menu_title"
                   value="{{  $page->menu_title }}">
            @if ($errors->has('menu_title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('menu_title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug" class="col-form-label">Slug</label>
            <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                   name="slug"
                   value="{{ $page->slug }}" required>
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="userCreateRole">Parent</label>
            {!! Form::select('parent_id',$parents, null,['class'=>'form-control','placeholder'=>'Parent Category']) !!}
        </div>

        <div class="form-group">
            <label for="content" class="col-form-label">Content</label>
            <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}   summernote"
                      name="content" rows="10" required>
                     {{  $page->content }}
            </textarea>
            @if ($errors->has('content'))
                <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                      name="description" rows="3">
                {{ $page->description }}
            </textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection