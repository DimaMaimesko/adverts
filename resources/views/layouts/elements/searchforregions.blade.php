<div class="search-bar py-1 my-1">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="{{route('admin.regions.search')}}" method="GET">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group py-1 my-1">
                                    <input type="text" class="form-control" name="text" value="{{ request('text') }}" placeholder="Search for region ...">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group py-1 my-1">
                                    <button class="btn btn-light border" type="submit"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="col-md-3 d-flex flex-row">
                <p>Powered by</p>
                <img src="{{asset('storage/logo-algolia.png')}}" alt="Algolia Logo" height="20" width="70">
            </div>
        </div>
    </div>
</div>
@if ($counted > 0)
    <div class="alert alert-info">
        <strong>{{$counted}}</strong> matches found.
    </div>
@endif