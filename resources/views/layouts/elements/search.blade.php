<div class="search-bar pt-2">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="text" value="{{ request('text') }}" placeholder="Search for...">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button class="btn btn-light border" type="submit"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>