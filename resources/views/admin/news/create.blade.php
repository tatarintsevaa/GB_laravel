@extends('layouts.index')

@section('title', 'Создание новости')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin.news.create', $news) }}
        <h3 class="title">
            @if ($news->id) Редактирование новости {{ $news->id }} @else Добавить новость @endif
        </h3>
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST"
                  action="@if($news->id){{ route('admin.news.update', $news) }}@else{{route('admin.news.store')}}@endif">
                @csrf
                @if($news->id)
                    @method('PUT')
                @endif
                <div class="form-group row">
                    <label for="FormControlSelectTitle" class="col-md-4 col-form-label text-md-right">
                        Выбор категории
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="FormControlSelectTitle" name="category_id">
                            @foreach($categories as $category)
                                <option
                                    @if ($category->id == old('category_id') || $news->category_id == $category->id) selected
                                    @endif
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">Заголовок</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control" name="title" autofocus
                               value="{{ $news->title ?? old('title')}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="text" class="col-md-4 col-form-label text-md-right">Текст</label>

                    <div class="col-md-6">
                        <textarea id="text" class="form-control" name="text" rows="3"
                                  autofocus>{{$news->text ?? old('text')}} </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="customFile" class="col-md-4 col-form-label text-md-right">
                        Загрузить изображение
                    </label>
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile" data-browse="Обзор">Выберите файл</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input @if (old('isPrivate') === "1" || $news->isPrivate == 1) checked
                                   @endif  id="newsPrivate" name="isPrivate"
                                   type="checkbox" value="1" class="form-check-input">

                            <label for="newsPrivate">Приватная</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-dark">
                            @if($news->id) Сохранить @else Опубликовать @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
