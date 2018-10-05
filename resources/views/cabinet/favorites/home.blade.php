@extends('layouts.app')

@section('content')
    @include('cabinet._nav')
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Updated</th>
            <th>Title</th>
            <th>Region</th>
            <th>Category</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($adverts as $advert)
            <>
                <td>{{ $advert->id }}</td>
                <td>{{ $advert->updated_at }}</td>
                <td><a href="{{ route('adverts.show', $advert) }}">{{ $advert->title }}</a></td>
                <td>
                    @if ($advert->region)
                        {{$advert->region->name}}
                    @endif
                <td>
                <td>{{ $advert->category->name }}</td>
                <td>
                    <div class="d-flex flex-row pull-right">
                            <form method="POST" action="{{ route('cabinet.favorites.remove', $advert) }}" data-confirm='Do you want to remove advert \"{{$advert->title}}\" from favorites?' class="mr-1">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-outline-danger"><span class="fa fa-remove"></span> Delete</button>
                            </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $adverts->links() }}

@endsection