@extends('layouts.app')

@section('content')
    @include('cabinet.weather._nav')

    <form method="POST" action="{{ route('weather.get') }}">
        @csrf
        <div class="form-group">
            <label for="address" class="col-form-label">Address</label>
            <input type="text" id="address" class="form-control" name="address" required value="{{ old('address') }}">
            @if ($errors->has('content'))
                <span class="invalid-feedback"><strong>{{ $errors->first('address') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Get Weather</button>
        </div>
    </form>

    @if (isset($weather) && isset($address))
        <h3>Address: {{$address->formatted_address}}</h3>
        <h3>Temperature: {{$weather->currently->temperature}}</h3>
    @endif
@endsection