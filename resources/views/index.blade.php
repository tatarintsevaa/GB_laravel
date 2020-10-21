@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.index')

@section('title', 'Главная')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('home') }}
        <h3 class="title">Последние новости</h3>
        <!-- тут будем выводить свежие  новостей из базы -->
        <div class="row news-box">
            @empty($lastNews)
                <div class="col-12 justify-content-center">Новостей нет</div>
            @else
                <div class="col-md-8 mb-2">
                    <a href="{{ route('news.show', ['id' => $lastNews->id])  }}" class="last-news">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $lastNews->title }}</h5>
                                <p class="card-text">{!! Str::limit($lastNews->text, 200) !!}</p>
                            </div>
                            <img src="{{ $lastNews->image ?? 'https://via.placeholder.com/500x300' }}" class="card-img-bottom" alt="photo">
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    @forelse($lustNewsList as $item)
                        <h2>{{ $item->title }}</h2>
                        <p>{!! Str::limit($item->text, 150) !!}</p>
                        <p>
                            @if ($item->is_private)
                                <a class="btn btn-secondary disabled" href="{{ route('news.show', ['id' => $item->id]) }}"
                                   role="button" tabindex="-1" aria-disabled="true">
                                    Подробнее &raquo;
                                </a>
                            @else
                                <a class="btn btn-secondary" href="{{ route('news.show', ['id' => $item->id]) }}"
                                   role="button">
                                    Подробнее &raquo;
                                </a>
                            @endif
                        </p>
                    @empty
                        Новостей нет
                    @endforelse
                </div>
            @endempty
        </div>
    </div>
@endsection
