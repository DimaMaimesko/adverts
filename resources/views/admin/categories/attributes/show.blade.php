@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.categories.attributes.edit', [$category, $attribute]) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.categories.attributes.destroy', [$category, $attribute]) }}" data-confirm="Do you want to delete attribute {{$attribute->name}}?" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $attribute->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $attribute->name }}</td>
        </tr>
        <tr>
            <th>Type</th><td>{{ $attribute->type }}</td>
        </tr>
        <tr>
            <th>Required</th> <td>{{ $attribute->required ? 'Yes' : '' }}</td>
        </tr>
        <tr>
            <th>Variants</th> <td>{{implode("\n", $attribute->variants) }}</td>
        </tr>


        <tbody>
        </tbody>
    </table>
@endsection