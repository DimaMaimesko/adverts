@extends('layouts.app')

@section('content')
    @include('cabinet._nav')


    @foreach ($dialog->messages()->orderBy('created_at')->get() as $message)
        <div class="card mb-3">
            <div class="card-header {{$message->user_id === Auth::id() ? "text-left" : "text-right"}}">
                {{ $message->created_at }} by {{ $message->user->name }}
            </div>
            <div class="card-body {{$message->user_id === Auth::id() ? "text-left" : "text-right"}}">
                {!! nl2br(e($message->message)) !!}
            </div>
        </div>
    @endforeach

        <form method="POST" action="{{ route('cabinet.messages.reply', $dialog) }}">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="message" rows="3" required></textarea>
            </div>
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">Reply</button>
            </div>
        </form>
@endsection