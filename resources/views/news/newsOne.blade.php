@extends('layouts.index')

@section('content')
    @if ($news)
        <div class="container">
            <h1 class="title">
                {{ $news['title'] }}
            </h1>
            <p>{{ $news['text'] }}</p>
        </div>
    @else
        <div>Такой новости нет</div>
    @endif
@endsection
