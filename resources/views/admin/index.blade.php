@extends('layouts.index')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin') }}
        <h2 class="title">Админка</h2>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.news.create') }}">Создать новость</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.news.download') }}">Скачать новости</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.news.index') }}">Редактировать новости</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.category.index') }}">Создание / редактирование категорий</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.users.index') }}">Редактирование пользователей</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.parser') }}">Парсинг</a></li>
        </ul>
    </div>
@endsection

