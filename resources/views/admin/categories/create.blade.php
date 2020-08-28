@extends('layouts.index')

@section('title', 'Создание новости')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin.category.create', $category) }}
        <h3 class="title">
            @if ($category->id) Редактирование категории {{ $category->id }} @else Добавить категорию @endif
        </h3>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST"
                  action="@if($category->id){{ route('admin.category.update', $category) }}@else{{route('admin.category.store')}}@endif">
                @csrf
                @if($category->id)
                    @method('PUT')
                @endif
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Название</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" autofocus
                               value="{{ $category->name ?? old('name')}}" placeholder="Введите название категории">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-md-4 col-form-label text-md-right">Slug</label>

                    <div class="col-md-6">
                        <input id="slug" type="text" class="form-control" name="slug" autofocus
                               value="{{ $category->slug ?? old('slug')}}" placeholder="Введите название категории на английском">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-dark">
                            @if($category->id) Сохранить @else Добавить @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
