@extends('layouts.index')

@section('content')
    <div class="container">
        <h3 class="title">
            Скачать новости по категории
        </h3>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.download') }}">
                @csrf
                <div class="form-group row">
                    <label for="FormControlSelectTitle" class="col-md-4 col-form-label text-md-right">
                        Выбор категории
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="FormControlSelectTitle" name="category">
                            @foreach($categories as $category)
                                <option @if ($category['id'] == old('category')) selected @endif
                                value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-dark">
                            Скачать
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
