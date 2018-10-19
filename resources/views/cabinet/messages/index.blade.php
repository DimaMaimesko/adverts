@extends('layouts.app')

@section('content')
    @include('cabinet._nav')



    <table class="table table-striped">
        <thead>
        <tr>
            <th>Advert Title</th>
            <th>Client Name</th>
            <th>New messages</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($dialogs as $dialog)

            <tr>
                <td>{{ $dialog->advert->title }}</td>
                <td>{{ $dialog->client->name }}</td>
                {{--<td><a href="{{ route('admin.tickets.show', $ticket) }}" target="_blank">{{ $ticket->subject }}</a></td>--}}

                <td>
                    @if($dialog->owner_id == Auth::id())
                        @if ($dialog->user_new_messages > 0)
                            <span class="badge badge-danger">{{$dialog->user_new_messages}}</span>
                        @else
                            <span class="badge badge-secondary">{{$dialog->user_new_messages}}</span>
                        @endif
                    @elseif($dialog->client_id == Auth::id())
                        @if($dialog->client_new_messages > 0)
                             <span class="badge badge-danger">{{$dialog->client_new_messages}}</span>
                        @else
                             <span class="badge badge-secondary">{{$dialog->client_new_messages}}</span>
                        @endif
                    @endif
                </td>
                <td><form method="GET" action="{{ route('cabinet.messages.show', $dialog) }}"  class="mr-1">
                        <button class="btn btn-sm btn-outline-success">Show</button>
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

   {{ $dialogs->links() }}
@endsection