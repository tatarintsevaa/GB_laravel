@extends('layouts.index')

@section('content')

    <div class="row news-box">
        @forelse($news as $item)
            <div class="col-md-4">
                <h2>{{ $item['title'] }}</h2>
                <p>{{ $item['text'] }}</p>
                <p><a class="btn btn-secondary" href="{{ route('newsOne', ['id' => $item['id']]) }}" role="button">View details &raquo;</a></p>
            </div>
        @empty
            <p>Новостей нет</p>
        @endforelse
    </div>

@endsection
