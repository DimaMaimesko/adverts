@extends('layouts.app')
@section('content')
    @include('admin.permissions._nav')
    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Create new Permission
                </a>
            </p>
        </div>
    </div>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th width="150px"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.edit',['permission'=> $permission]) }}"
                               class="btn btn-sm btn-primary text-uppercase pull-right">
                                <span class="glyphicon glyphicon-pencil"></span>
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="bg-warning">
                            <h3 class="text-center">
                                Nothing found
                            </h3>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>



@endsection
