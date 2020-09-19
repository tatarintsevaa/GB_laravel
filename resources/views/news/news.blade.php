@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.index')


@section('title')
    @parentНовости@isset($category) - {{ $category }}@endisset
@endsection

@section('content')
    <div class="container">
        @isset($category)
            {{ Breadcrumbs::render('category', $category) }}
        @else
            {{ Breadcrumbs::render('news') }}
        @endisset
        <h3 class="title">Новости @isset($category)категории {{ $category }} @endisset</h3>
        <div class="row row-cols-1 row-cols-md-2">
{{--TODO вывести sidebar с настройками отображения новостей по категориям и датам--}}
            @forelse($news as $item)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-4">
                                <div class="card-image">
                                    <img src="{{ $item->image ?? 'https://via.placeholder.com/150' }}"
                                         class="card-img img-fluid" alt="image">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($item->title, 50)}}</h5>
                                    <p class="card-text">{{ Str::limit($item->text, 150) }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-white">
                            @if ($item->is_private && !Auth::check())
                                <a class="btn btn-secondary disabled"
                                   href="{{ route('news.show', ['id' => $item->id]) }}"
                                   role="button" tabindex="-1" aria-disabled="true">
                                    Подробнее &raquo;
                                </a>
                            @else
                                <a class="btn btn-secondary" href="{{ route('news.show', ['id' => $item->id]) }}"
                                   role="button">
                                    Подробнее &raquo;
                                </a>
                            @endif
                            <span class="card-links">
                            <div>
                              <i class="far fa-eye"></i>
                                <small class="text-muted">{{ $item->views()->count() }}</small>
                            </div>
                            <div>
                                <i class="far fa-comment-dots"></i>
                                <small class="text-muted">0</small>
                            </div>
                        </span>
                        </div>
                    </div>
                </div>
            @empty
                <p>Новостей нет</p>
            @endforelse
        </div>
        <nav class="news-pagination">
            {{ $news->onEachSide(1)->links() }}
        </nav>
    </div>
@endsection

