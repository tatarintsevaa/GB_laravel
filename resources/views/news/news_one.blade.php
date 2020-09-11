@extends('layouts.index')

@section('title')
    @parent{{ $news->title  }}
@endsection

@section('content')
    @if ($news)
        <div class="container">
            {{ Breadcrumbs::render('one', $news) }}
            @if (!$news->is_private && Auth::check())
                <h1 class="title">
                    {{ $news->title }}
                </h1>
                <img src="{{ $news->image ?? 'https://via.placeholder.com/300x150' }}"
                     class="img-fluid" alt="image">
                <p>{{ $news->text }}</p>
            @else
                <div class="alert alert-info" role="alert">
                    Новость приватная. Зарегистрируйтесь для просмоотра
                </div>
            @endif
        </div>
    @else
        <div class="container">Такой новости нет</div>
    @endif
@endsection
