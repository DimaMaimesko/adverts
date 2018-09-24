@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm="Do you want to delete category {{$category->name}}?" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $category->id }}</td>
            </tr>
            <tr>
                <th>Name</th><td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>Slug</th><td>{{ $category->slug }}</td>
            </tr>
            <tr>
                <th>Parent id</th><td>{{ $category->parent_id }} {{$category->parent ? '('.$category->parent->name.')' : ""}}</td>
            </tr>
        </tbody>
    </table>


@endsection

@section('scripts')
    <script>

    </script>
@endsection