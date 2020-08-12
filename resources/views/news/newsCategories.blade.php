@extends('layouts.index')
@section('content')
    <div class="container">
       <div class="row justify-content-center">
           @forelse($categories as $category)
               <a href="{{ route('newsByCategories', ['name' => $category['slug']]) }}">
                   <div class="col-md-4">
                       {{ $category['name'] }}
                   </div>
               </a>
           @empty
               Нет категорий новостей
           @endforelse
       </div>
    </div>
@endsection
