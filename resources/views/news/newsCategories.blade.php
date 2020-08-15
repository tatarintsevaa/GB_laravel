@extends('layouts.index')
@section('content')
    <ul class="nav flex-column">
        @forelse($categories as $category)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('newsByCategories', ['name' => $category['slug']]) }}">
                {{ $category['name'] }}
            </a>
        </li>
        @empty
            Нет категорий новостей
        @endforelse
    </ul>
@endsection
