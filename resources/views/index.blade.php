@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.index')

@section('title', 'Главная')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('home') }}
        <h3 class="title">Список ТОП новостей</h3>
        <!-- тут будем выводить свежие  новостей из базы -->
        <div class="row news-box">
            <div class="col-md-8">
                <div class="card bg-white text-dark">
                    <img src="{{ $lastNews->image ?? 'https://via.placeholder.com/500x300' }}"
                         class="card-img" alt="image">
                    <div class="card-img-overlay">
                        <h5 class="card-title">{{ $lastNews->title }}</h5>
                        <p class="card-text">{{ Str::limit($lastNews->text, 100) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @forelse($lastListNews as $item)
                    <h2>{{ $item->title }}</h2>
                    <p>{{ Str::limit($lastNews->text, 150) }}</p>
                    <p>
                        @if ($item->isPrivate)
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
        </div>

    </div>
@endsection
