@extends('layouts.index')

@section('title', 'Редактирование новостей')


@section('content')
    <div class="container">
                {{ Breadcrumbs::render('admin.news') }}
        <h3 class="title">
            Редактирование новостей
        </h3>

        <div class="news mb-4">
            <div class="row mb-4 border-bottom">
                <div class="col-1">id</div>
                <div class="col-8">title</div>
                <div class="col-1">edit</div>
                <div class="col-1">del</div>
            </div>
            @foreach($news as $item)
                <div class="row mb-2">
                    <div class="col-1 ">{{ $item->id }}</div>
                    <div class="col-8">{{ $item->title  }}</div>
                    <div class="col-1"><a href="{{ route('admin.news.edit', $item) }}" class="btn btn-dark"><i class="fas fa-edit"></i></a></div>
                    <div class="col-1">
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>

            @endforeach

        </div>
        <nav class="news-pagination">
            {{ $news->onEachSide(1)->links() }}
        </nav>

    </div>

@endsection
