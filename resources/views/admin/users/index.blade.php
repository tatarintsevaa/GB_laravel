@extends('layouts.index')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('admin.users') }}
        <h2 class="title">Пользователи</h2>
        <div class="news mb-4">
            <div class="row mb-4 border-bottom">
                <div class="col-1">id</div>
                <div class="col-4">name</div>
                <div class="col-3">email</div>
                <div class="col-2">isAdmin</div>
                <div class="col-1">save</div>
                <div class="col-1">delete</div>
            </div>
            @foreach($users as $item)
                <div class="row mb-2 user-row" data-isAdmin="{{ $item->is_admin }}" data-id="{{ $item->id }}">
                    <div class="col-1 ">{{ $item->id }}</div>
                    <div class="col-4">{{ $item->name  }}</div>
                    <div class="col-3">{{ $item->email  }}</div>
                    <div class="col-2">
                        @if (Auth::user()->id == $item->id)
                            <p>Админ</p>
                        @else
                            <select class="form-control is-admin" data-id="{{ $item->id }}">
                                <option value="1" @if($item->is_admin) selected @endif>Админ</option>
                                <option value="0" @if(!$item->is_admin) selected @endif >Не Админ</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-1">
                        <button class="btn btn-dark save" @if (Auth::user()->id == $item->id) disabled @endif"><i
                            class="fas fa-save"></i></button>
                    </div>
                    <div class="col-1">
                        <form action="{{ route('admin.users.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"
                                    @if (Auth::user()->id == $item->id) disabled @endif>
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
<script>

</script>
