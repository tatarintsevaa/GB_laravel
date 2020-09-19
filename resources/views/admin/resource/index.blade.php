@extends('layouts.index')

@section('title', 'Редактирование ресурсов новостей')


@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin.resource') }}
        <h2 class="title">Ресурсы</h2>
        <div class="mb-3">
            <a href="{{ route('admin.resource.create') }}" class="btn btn-outline-secondary">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="news mb-4">
            <div class="row mb-4 border-bottom">
                <div class="col-1">id</div>
                <div class="col-8">link</div>
                <div class="col-1">edit</div>
                <div class="col-1">del</div>
            </div>
            @foreach($resources as $item)
                <div class="row mb-2">
                    <div class="col-1 ">{{ $item->id }}</div>
                    <div class="col-8">{{ $item->link  }}</div>
                    <div class="col-1"><a href="{{ route('admin.resource.edit', $item) }}" class="btn btn-dark"><i class="fas fa-edit"></i></a></div>
                    <div class="col-1">
                        <form action="{{ route('admin.resource.destroy', $item) }}" method="POST" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection
