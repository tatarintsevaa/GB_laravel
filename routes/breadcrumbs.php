<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home > news
Breadcrumbs::for('news', function ($trail) {
    $trail->parent('home');
    $trail->push('Новости', route('news.index'));
});

// Home > news > categories
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('news');
    $trail->push('Категории', route('news.category.index'));
});

// Home > news > category > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push($category, route('news.category.show', $category));
});

// Home > news > [one]
Breadcrumbs::for('one', function ($trail, $news) {
    $trail->parent('news');
    $trail->push($news->title, route('news.show', $news->id));
});

// Home > admin
Breadcrumbs::for('admin', function ($trail) {
    $trail->parent('home');
    $trail->push('Админка', route('admin.index'));
});

// Home > admin > create
Breadcrumbs::for('create', function ($trail) {
    $trail->parent('admin');
    $trail->push('Создание новости', route('admin.create'));
});

// Home > admin  > download
Breadcrumbs::for('download', function ($trail) {
    $trail->parent('admin');
    $trail->push('Скачать новость', route('admin.download'));
});
