    @if(count($advert->photos) > 0)
        <?php
        $i = 0;
        ?>
        <div id="albums">
            <div class="container">
                    @foreach($advert->photos as $item)
                        <?php $i++; ?>
                        @if ($i == 1)
                            <div class="row">
                        @endif
                            <div class="col-md-4">
                                    <div class="img-thumbnail m-md-2">
                                        <a href="{{asset($item->photo)}}">
                                            <img src="{{asset($item->photo)}}" alt="Photo" style="width:100%">
                                            <div class="caption">
                                                <p>{{($item->title)}}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        @if ($i == 3)
                            </div>
                            <?php $i = 0; ?>
                        @endif
                    @endforeach
            </div>
        </div>
    @else
        <p>No Albums To Display</p>
    @endif