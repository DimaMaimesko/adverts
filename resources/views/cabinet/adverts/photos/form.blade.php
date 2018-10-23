

    <form method="POST" action="{{route('cabinet.adverts.upload', $advert)}}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="photos" class="col-form-label">Choose Photo</label>
            <input id="photos"
                   type="file"
                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                   name="picture[]"
                   multiple required>
                   {{--name="files[]" multiple required>--}}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
