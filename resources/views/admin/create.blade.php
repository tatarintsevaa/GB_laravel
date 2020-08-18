@extends('layouts.index')

@section('content')
    <div class="container">
        <h3 class="title">
            Добавить новость
        </h3>
        <div class="card-body">
            <form method="POST" action="#">
                <div class="form-group row">
                    <label for="FormControlSelectTitle" class="col-md-4 col-form-label text-md-right">
                        Выбор категории
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="FormControlSelectTitle">
                            @foreach($categories as $category)
                                <option>{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">Заголовок</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control" name="title" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="text" class="col-md-4 col-form-label text-md-right">Текст</label>

                    <div class="col-md-6">
                        <textarea id="text" class="form-control" name="text" rows="3" autofocus></textarea>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-dark">
                            Опубликовать
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
