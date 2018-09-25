@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.regions.edit', $region) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.regions.destroy', $region) }}" data-confirm="Do you want to delete region {{$region->name}}?" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $region->id }}</td>
            </tr>
            <tr>
                <th>Name</th><td>{{ $region->name }}</td>
            </tr>
            <tr>
                <th>Slug</th><td>{{ $region->slug }}</td>
            </tr>
            <tr>
                <th>Parent id</th><td>{{ $region->parent_id }} {{$region->parent ? '('.$region->parent->name.')' : ""}}</td>
            </tr>
        </tbody>
    </table>

    <div class="col-6 col-md-4 col-lg-2">
        <p>
            <a href="{{ route('admin.subregion',['parent_id' => $region->id]) }}" class="btn btn-success">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Create new sub-region in {{ $region->name }}
            </a>
        </p>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Sorting</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($children as $child)
            <tr>
                <td>{{ $child->id }}</td>
                <td><a href="{{ route('admin.regions.show', $child) }}">{{ $child->name }}</a></td>
                <td>{{ $child->slug }}</td>
                <td>
                    <div class="d-flex flex-row">
                        <form method="POST" action="{{ route('admin.regions.first', $child) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.up', $child) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.down', $child) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.last', $child) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>

    </script>
@endsection