@extends('layouts.app')

@section('content')
    @include('cabinet.adverts.create._nav')

    <p>Choose category:</p>

    @include('cabinet.adverts.create._categories', ['categories' => $categories])

@endsection