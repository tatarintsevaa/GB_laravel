@extends('layouts.index')

@section('title', 'Создание новости')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin.resource.create', $resource) }}
        <h3 class="title">
            @if ($resource->id) Редактирование ресурса {{ $resource->id }} @else Добавить ресурс @endif
        </h3>
        <div class="card-body">
            <form enctype="multipart/form-data" method="post"
                  action="@if($resource->id){{ route('admin.resource.update', $resource) }}@else{{route('admin.resource.store')}}@endif">
                @csrf
                @if($resource->id)
                    @method('PUT')
                @endif
                <div class="form-group row">
                    <label for="link" class="col-md-4 col-form-label text-md-right">Ресурс</label>

                    <div class="col-md-6">
                        <input id="link" type="text" class="form-control @if ($errors->has('link')) is-invalid @endif" name="link" autofocus
                               value="{{ old('link') ?? $resource->link }}" placeholder="Введите ссылку на источник">
                        @if ($errors->has('link'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('link') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-dark">@if($resource->id)Сохранить@elseДобавить@endif</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
