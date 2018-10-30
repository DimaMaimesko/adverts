@extends('layouts.app')

@section('content')
    @include('cabinet.adverts.create._nav')
    <h5>Chosen category: {{$category->name}}</h5>
    <h5>Chosen region: {{$region ? $region->getAddress() : ""}}</h5>
    @if ($region)
        <p>
            <a href="{{ route('cabinet.adverts.create.advert', [$category, $region]) }}" class="btn btn-success">Add Advert for {{ $region->name }}</a>
        </p>
    @else
        <p>
            <a href="{{ route('cabinet.adverts.create.advert', [$category]) }}" class="btn btn-success">Add Advert for all regions</a>
        </p>
    @endif
    @if ($region)
        @if (count($region->children) > 0)
        <p>Or choose nested region:</p>
        @endif
    @endif
    <ul>
        @foreach ($regions as $current)
            <li>
                <a href="{{ route('cabinet.adverts.create.region', [$category, $current]) }}">{{ $current->name }}</a>
            </li>
        @endforeach
    </ul>
@endsection