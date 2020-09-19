@extends('layouts.index')

@section('title')
    @parent{{ $news->title  }}
@endsection

@section('content')
    @if ($news)
        <div class="container">
            {{ Breadcrumbs::render('one', $news) }}
            @if ($news->is_private && Auth::check() || !$news->is_private)
                <h1 class="title">
                    {{ $news->title }}
                </h1>
                <img src="{{ $news->image ?? 'https://via.placeholder.com/300x150' }}"
                     class="img-fluid" alt="image">
                <p>{!! $news->text !!}</p>
                <div class="card">
                    <div class="card-header">
                        Комментарии
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <p class="col-2"><strong>Имя</strong></p>
                                <p class="col-10">Коммент</p>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Новость приватная. Зарегистрируйтесь для просмоотра
                </div>
            @endif
        </div>
    @else
        <div class="container">Такой новости нет</div>
    @endif
@endsection
<script>

</script>
