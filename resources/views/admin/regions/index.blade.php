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
    @include('layouts.elements.searchforregions')
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Parent_id (name)</th>
            <th>Sorting</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($regions as $region)
            <tr>
                <td>{{ $region->id }}</td>
                <td><a href="{{ route('admin.regions.show', $region) }}">{{ $region->name }}</a></td>
                <td>{{ $region->slug }}</td>
                <td>{{ $region->parent_id }} {{$region->parent ? '('.$region->parent->name.')' : ""}}</td>
                <td>
                    <div class="d-flex flex-row">
                        <form method="POST" action="{{ route('admin.regions.first', $region) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.up', $region) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.down', $region) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.regions.last', $region) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $regions->appends(Request::except('page'))->links() }}
@endsection
