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

// Home > admin > news
Breadcrumbs::for('admin.news', function ($trail) {
    $trail->parent('admin');
    $trail->push('Новости', route('admin.news.index'));
});


// Home > admin > news > create || edit
Breadcrumbs::for('admin.news.create', function ($trail, $news) {
    $trail->parent('admin.news');
    if ($news->id) {
        $trail->push("Редактирование новости {$news->id}", route('admin.news.edit', $news));
    } else {
        $trail->push('Создание новости', route('admin.news.create'));
    }
});

// Home > admin  > news > download
Breadcrumbs::for('admin.news.download', function ($trail) {
    $trail->parent('admin.news');
    $trail->push('Скачать новость', route('admin.news.download'));
});

// Home > admin  > categories
Breadcrumbs::for('admin.category', function ($trail) {
    $trail->parent('admin');
    $trail->push('Категории', route('admin.category.index'));
});

// Home > admin > category > create || edit
Breadcrumbs::for('admin.category.create', function ($trail, $news) {
    $trail->parent('admin.category');
    if ($news->id) {
        $trail->push("Редактирование категории {$news->id}", route('admin.category.edit', $news));
    } else {
        $trail->push('Создание новости', route('admin.category.create'));
    }
});