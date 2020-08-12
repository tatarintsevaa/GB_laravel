@extends('layouts.index')

@section('content')
    <div class="container">
        <h3 class="title">Новости</h3>
        <!-- тут будем выводить топ 6 новостей из базы -->
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

    </div>
@endsection

