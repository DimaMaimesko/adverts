@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')
    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{ route('admin.regions.create') }}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Create new Region
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
            <th>Parent_id</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($regions as $region)
            <tr>
                <td>{{ $region->id }}</td>
                <td><a href="{{ route('admin.regions.show', $region) }}">{{ $region->name }}</a></td>
                <td>{{ $region->slug }}</td>
                <td>{{ $region->parent_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $regions->appends(Request::except('page'))->links() }}
@endsection
