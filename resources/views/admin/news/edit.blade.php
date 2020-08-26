@extends('layouts.index')

@section('title', 'Редактирование новостей')


@section('content')
    <div class="container">
        {{--        {{ Breadcrumbs::render('download') }}--}}
        <h3 class="title">
            Редактирование новостей
        </h3>

        <div class="news mb-4">
            <div class="row">
                <div class="col-1">id</div>
                <div class="col-8">title</div>
                <div class="col-1">edit</div>
                <div class="col-1">del</div>
            </div>
            @foreach($news as $item)
                <div class="row">
                    <div class="col-1 mb-4">{{ $item->id }}</div>
                    <div class="col-8">{{ $item->title  }}</div>
                    <div class="col-1"><a href="" class="btn btn-dark"><i class="fas fa-edit"></i></a></div>
                    <div class="col-1"><a href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></div>
                </div>
            @endforeach

        </div>
        <nav class="news-pagination">
            {{ $news->onEachSide(1)->links() }}
        </nav>

    </div>

@endsection
