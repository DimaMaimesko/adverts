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

    {{--@can ('manage-adverts')--}}
        {{--<div class="d-flex flex-row mb-3">--}}
            {{--<a href="{{ route('admin.adverts.adverts.edit', $advert) }}" class="btn btn-primary mr-1">Edit</a>--}}
            {{--<a href="{{ route('admin.adverts.adverts.photos', $advert) }}" class="btn btn-primary mr-1">Photos</a>--}}

            {{--@if ($advert->isOnModeration())--}}
                {{--<form method="POST" action="{{ route('admin.adverts.adverts.moderate', $advert) }}" class="mr-1">--}}
                    {{--@csrf--}}
                    {{--<button class="btn btn-success">Moderate</button>--}}
                {{--</form>--}}
            {{--@endif--}}

            {{--@if ($advert->isOnModeration() || $advert->isActive())--}}
                {{--<a href="{{ route('admin.adverts.adverts.reject', $advert) }}" class="btn btn-danger mr-1">Reject</a>--}}
            {{--@endif--}}

            {{--<form method="POST" action="{{ route('admin.adverts.adverts.destroy', $advert) }}" class="mr-1">--}}
                {{--@csrf--}}
                {{--@method('DELETE')--}}
                {{--<button class="btn btn-danger">Delete</button>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--@endcan--}}

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

            <div class="alert alert-info">
                @{{ count }} people are looking this advert right now.
                <ul>
                    <li v-for="viewer in viewers">
                        Id: @{{ viewer.id }}: @{{ viewer.name }},  @{{ viewer.email }}
                    </li>
                </ul>
            </div>

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

            <table class="table table-bordered">
                <tbody>
                @foreach ($advert->category->allAttributes() as $attribute)
                    <tr>
                        <th>{{ $attribute->name }}</th>
                        <td>{{ $advert->getValue($attribute->id) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p>Address: {{ $advert->address }}</p>

            <div style="margin: 20px 0; border: 1px solid #ddd">
                <div id="map" style="width: 100%; height: 250px"></div>
            </div>

            <p style="margin-bottom: 20px">Seller: {{ $advert->user->name }}</p>

            <div class="d-flex flex-row mb-3">
                {{--<span class="btn btn-success mr-1"><span class="fa fa-envelope"></span> Send Message</span>--}}
                {{--<span class="btn btn-primary phone-button mr-1" data-source="{{ route('adverts.phone', $advert) }}"><span class="fa fa-phone"></span> <span class="number">Show Phone Number</span></span>--}}
                @if ($user && $user->hasInFavorites($advert->id))
                    <form method="POST" action="{{ route('cabinet.favorites.remove', $advert) }}" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary"><span class="fa fa-star"></span> Remove from Favorites</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('cabinet.favorites.add', $advert) }}" class="mr-1">
                        @csrf
                        <button class="btn btn-info"><span class="fa fa-star"></span> Add to Favorites</button>
                    </form>
                @endif
                {{--<form method="GET" action="{{ route('cabinet.messages.showForm', $advert) }}" class="mr-1">--}}
                    {{--@csrf--}}
                    {{--<button class="btn btn-secondary"><span class="fa fa-subway"></span> Send Message To Owner</button>--}}
                {{--</form>--}}

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Send Message To Owner
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Send message to {{$advert->user->name}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('cabinet.messages.send', $advert) }}" class="mr-1">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message" class="col-form-label">Message: </label>
                                        <textarea id="message" class="form-control" name="message" rows="5" placeholder="Message about {{"\"".$advert->title."\""}}" required></textarea>
                                    </div>
                                    <button class="btn btn-secondary"><span class="fa fa-subway"></span> Send </button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>


                        </div>
                    </div>
                </div>

            </div>

            <hr/>

            {{--<div class="h3">Similar adverts</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="card">--}}
                        {{--<img class="card-img-top" src="https://images.pexels.com/photos/297933/pexels-photo-297933.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb" alt=""/>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="card-title h4 mt-0" style="margin: 10px 0"><a href="#">The First Thing</a></div>--}}
                            {{--<p class="card-text" style="color: #666">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="card">--}}
                        {{--<img class="card-img-top" src="https://images.pexels.com/photos/297933/pexels-photo-297933.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb" alt=""/>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="card-title h4 mt-0" style="margin: 10px 0"><a href="#">The First Thing</a></div>--}}
                            {{--<p class="card-text" style="color: #666">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-4">--}}
                    {{--<div class="card">--}}
                        {{--<img class="card-img-top" src="https://images.pexels.com/photos/297933/pexels-photo-297933.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb" alt=""/>--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="card-title h4 mt-0" style="margin: 10px 0"><a href="#">The First Thing</a></div>--}}
                            {{--<p class="card-text" style="color: #666">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>
        <div class="col-md-3">
            <div style="height: 400px; background: #f6f6f6; border: 1px solid #ddd; margin-bottom: 20px"></div>
            <div style="height: 400px; background: #f6f6f6; border: 1px solid #ddd; margin-bottom: 20px"></div>
        </div>
    </div>
    @include('cabinet.adverts.photos.index')
@endsection

{{--@section('scripts')--}}
    {{--<script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>--}}

    {{--<script type='text/javascript'>--}}
        {{--ymaps.ready(init);--}}
        {{--function init(){--}}
            {{--var geocoder = new ymaps.geocode(--}}
                {{--'{{ $advert->address }}',--}}
                {{--{ results: 1 }--}}
            {{--);--}}
            {{--geocoder.then(--}}
                {{--function (res) {--}}
                    {{--var coord = res.geoObjects.get(0).geometry.getCoordinates();--}}
                    {{--var map = new ymaps.Map('map', {--}}
                        {{--center: coord,--}}
                        {{--zoom: 7,--}}
                        {{--behaviors: ['default', 'scrollZoom'],--}}
                        {{--controls: ['mapTools']--}}
                    {{--});--}}
                    {{--map.geoObjects.add(res.geoObjects.get(0));--}}
                    {{--map.zoomRange.get(coord).then(function(range){--}}
                        {{--map.setCenter(coord, range[1] - 1)--}}
                    {{--});--}}
                    {{--map.controls.add('mapTools')--}}
                        {{--.add('zoomControl')--}}
                        {{--.add('typeSelector');--}}
                {{--}--}}
            {{--);--}}
        {{--}--}}
    {{--</script>--}}
{{--@endsection--}}
@section('scripts')
    <script>
        let app = new Vue({
            el: '#app',
            data: {
                viewers: [],
                count: 0
            },
            mounted(){
                this.listen();
                console.log(('advert.' + '{{$advert->id}}'));
            },
            methods: {
                listen() {
                    Echo.join('advert.' + '{{$advert->id}}')
                        .here((users) => {
                            this.count = users.length;
                            this.viewers = users;
                        })
                        .joining((user) => {
                            this.count++;
                            this.viewers.push(user);
                        })
                        .leaving((user) => {
                            this.count--;
                            _.pullAllBy(this.viewers, [user]);
                        })
                    // .listen()
                }
            }
        })
    </script>


@endsection