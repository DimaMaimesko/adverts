

<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.profile.home') }}">Profile</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.adverts.home') }}">Adverts</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.favorites.home') }}">Favorites</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.adverts.create.category') }}">Create Advert</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.tickets.index') }}">Tickets</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.messages.index') }}">Messages  <span class="badge badge-danger">{{isset($counter) ? $counter : null }}</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('weather.index') }}">Weather</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.banners.index') }}">Banners</a></li>


</ul>

