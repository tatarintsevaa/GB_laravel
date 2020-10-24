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
                @if ( $news->image )
                    <div class="img-fluid">
                        <img src="{{ $news->image }}" class="img-fluid mb-2" alt="image">
                    </div>
                @endif
                <p class="mb-2">{!! $news->text !!}</p>
                <p class="mb-2">Подробности в <a href="{{ $news->link }}" target="_blank">источнике</a>.</p>

                <div class="card mb-2">
                    <div class="card-header">
                        Комментарии
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="comments-list">
                                @forelse($comments as $comment)
                                    <div class="row comment-item">
                                        <p class="col-md-2"><strong>{{ $comment['name'] }}</strong></p>
                                        <p class="col-md-10">{{ $comment['comment'] }}</p>
                                        <p class="col-md-12">
                                            <a href="#" data-comment-id="{{ $comment['id'] }}"
                                               class="reply-btn">ответить
                                            </a>
                                        </p>
                                    </div>
                                    @isset($comment['children'])
                                        @include('comments.comments', ['child' => $comment['children']])
                                    @endisset
                                @empty
                                    <div class="no-comments">
                                        Комментариев пока нет
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Напсиать комментарий
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Имя</label>
                                        <input type="text" class="form-control" id="name"  name="name"
                                         @if(\Illuminate\Support\Facades\Auth::check())
                                            value="{{ \Illuminate\Support\Facades\Auth::user()->name }}"
                                         @endif placeholder="Ваше имя">
                                        <div id="name-feedback" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Текст комментария</label>
                                    <textarea class="form-control" id="comment"
                                              placeholder="Напишите ваш комментарий"></textarea>
                                    <div id="comment-feedback" class="invalid-feedback"></div>
                                </div>
                                <button data-news-id="{{ $news->id }}" type="button" class="btn btn-dark"
                                        id="send-comment">Отправить
                                </button>
                            </form>
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
