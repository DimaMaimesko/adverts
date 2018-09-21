@extends('layouts.app')
@section('content')
@include('admin._nav')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="row">
                    <div class="col-6 col-md-8 col-lg-10">
                        <h4 class="c-grey-900"></h4>
                    </div>
                    <div class="col-md-12 pull-right">
                        <p>
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-success text-uppercase pull-right">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Create new Role
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
                                <th>Users attached</th>
                                <th>Is active</th>
                                <th width="120px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->users_count }}</td>
                                    <td>@if($role->active == 1) <span class="label label-success">Active</span>
                                        @else <span class="label label-default">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.roles.edit',['role'=> $role]) }}"
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
            </div>
        </div>
    </div>
@endsection