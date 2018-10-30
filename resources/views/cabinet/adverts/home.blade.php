@extends('layouts.app')

@section('content')
    @include('cabinet.adverts._nav')
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Status</th>
            <th>Updated at</th>
            <th>Published at</th>
            <th>Expires at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($adverts as $advert)
            <tr>
                <td>{{ $advert->id }}</td>
                <td><a href="{{ route('cabinet.adverts.edit', $advert->id) }}">{{ $advert->title }}</a></td>
                <td>{{ $advert->content }}</td>
                <td>
                    @if ($advert->isDraft())
                        <span class="badge badge-secondary">Draft</span>
                    @endif
                    @if ($advert->isOnModeration())
                        <span class="badge badge-warning">On Moderation</span>
                    @endif
                    @if ($advert->isActive())
                        <span class="badge badge-success">Active</span>
                    @endif
                    @if ($advert->isClosed())
                        <span class="badge badge-dark">Closed</span>
                    @endif
                <td>{{ $advert->updated_at  }}</td>
                <td>{{ $advert->published_at  }}</td>
                <td>{{ $advert->expires_at  }}</td>
                <td>
                    <div class="d-flex flex-row pull-right">
                        @if (!$advert->isOnModeration())

                            <form method="POST" action="{{ route('cabinet.adverts.tomoderation', $advert) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning">To moderation</button>
                            </form>
                        @endif
                            <form method="POST" action="{{ route('cabinet.adverts.delete', $advert) }}" data-confirm="Do you want to delete advert {{$advert->title}}?" class="mr-1">
                                <input type="hidden" name="_method" value="delete" />
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $adverts->links() }}

@endsection