@extends('layouts.index')
@section('content')
    <div class="container">
       <div class="row justify-content-center">
           @forelse($categories as $category)
               <a href="{{ route('newsByCategories', ['name' => $category['slug']]) }}">
                   <div class="category-box col-md-4">
                           <h3>{{ $category['name'] }}</h3>
                   </div>
               </a>
           @empty
               Нет категорий новостей
           @endforelse
       </div>
    </div>
@endsection
