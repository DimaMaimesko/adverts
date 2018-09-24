@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')
    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Create new Category
                </a>
            </p>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Parent_id (name)</th>
            <th>Depth</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>
                    @for ($i = 0; $i <= $category->depth; $i++) &mdash; @endfor
                    <a href="{{ route('admin.categories.show', $category) }}">{{ $category->name }}</a>
                </td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_id }} {{$category->parent ? '('.$category->parent->name.')' : ""}}</td>
                <td>{{ $category->depth }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
