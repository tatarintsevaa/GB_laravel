@extends('layouts.index')

@section('title', 'Категории')

@section('content')
    <div class="container">
        <ul class="nav flex-column">
            @forelse($categories as $category)
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('news.category.show', ['name' => $category['slug']]) }}">
                        {{ $category['name'] }}
                    </a>
                </li>
            @empty
                Нет категорий новостей
            @endforelse
        </ul>
    </div>
@endsection

