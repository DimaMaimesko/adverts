@extends('layouts.app')

@section('content')

    @if ($advert->isDraft())
        <div class="alert alert-danger">
            It is a draft.
        </div>
        @if ($advert->reject_reason)
            <div class="alert alert-danger">
                {{ $advert->reject_reason }}
            </div>
        @endif
    @endif

    @can ('moderate-advert')

        <div class="d-flex flex-row mb-3">
            <form method="POST" action="{{ route('admin.adverts.reject', $advert) }}" class="mr-1">
                @csrf
                <button class="btn btn-danger">Reject</button>
                <input id="reject" type="text" class="form-control{{ $errors->has('reject_reason') ? ' is-invalid' : '' }} mr-2" name="reject_reason" value="{{$advert->reject_reason ? $advert->reject_reason : ""}}" required>
            </form>
            <form method="POST" action="{{ route('admin.adverts.moderate', $advert) }}" class="mr-1">
                @csrf
                <button class="btn btn-success">Moderate</button>
            </form>
            {{----}}
            {{--<a href="{{ route('admin.adverts.adverts.edit', $advert) }}" class="btn btn-primary mr-1">Edit</a>--}}
            {{--<a href="{{ route('admin.adverts.adverts.photos', $advert) }}" class="btn btn-primary mr-1">Photos</a>--}}



            {{--@if ($advert->isOnModeration() || $advert->isActive())--}}
                {{--<a href="{{ route('admin.adverts.adverts.reject', $advert) }}" class="btn btn-danger mr-1">Reject</a>--}}
            {{--@endif--}}

            {{--<form method="POST" action="{{ route('admin.adverts.adverts.destroy', $advert) }}" class="mr-1">--}}
                {{--@csrf--}}
                {{--@method('DELETE')--}}
                {{--<button class="btn btn-danger">Delete</button>--}}
            {{--</form>--}}
        </div>
    @endcan

    {{--@can ('manage-own-advert', $advert)--}}
            {{--<div class="d-flex flex-row mb-3">--}}
                {{--<a href="{{ route('cabinet.adverts.edit', $advert) }}" class="btn btn-primary mr-1">Edit</a>--}}
                {{--<a href="{{ route('cabinet.adverts.photos', $advert) }}" class="btn btn-primary mr-1">Photos</a>--}}

                {{--@if ($advert->isDraft())--}}
                    {{--<form method="POST" action="{{ route('cabinet.adverts.send', $advert) }}" class="mr-1">--}}
                        {{--@csrf--}}
                        {{--<button class="btn btn-success">Publish</button>--}}
                    {{--</form>--}}
                {{--@endif--}}
                {{--@if ($advert->isActive())--}}
                    {{--<form method="POST" action="{{ route('cabinet.adverts.close', $advert) }}" class="mr-1">--}}
                        {{--@csrf--}}
                        {{--<button class="btn btn-success">Close</button>--}}
                    {{--</form>--}}
                {{--@endif--}}

                {{--<form method="POST" action="{{ route('cabinet.adverts.destroy', $advert) }}" class="mr-1">--}}
                    {{--@csrf--}}
                    {{--@method('DELETE')--}}
                    {{--<button class="btn btn-danger">Delete</button>--}}
                {{--</form>--}}
            {{--</div>--}}
    {{--@endcan--}}

    <div class="row">
        <div class="col-md-9">

            <p class="float-right" style="font-size: 36px;">{{ $advert->price }}</p>
            <h1 style="margin-bottom: 10px">{{ $advert->title  }}</h1>
            <p>
                @if ($advert->expires_at)
                    Date: {{ $advert->published_at }} &nbsp;
                @endif
                @if ($advert->expires_at)
                    Expires: {{ $advert->expires_at }}
                @endif
            </p>

            <div style="margin-bottom: 20px">
                <div class="row">
                    <div class="col-10">
                        <div style="height: 400px; background: #f6f6f6; border: 1px solid #ddd"></div>
                    </div>
                    <div class="col-2">
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                    </div>
                </div>
            </div>

            <p>{!! nl2br(e($advert->content)) !!}</p>

            <p>Address: {{ $advert->address }}</p>


            <hr/>


        </div>

    </div>
@include('cabinet.adverts.photos.index')
@endsection
