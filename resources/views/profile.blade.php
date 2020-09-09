@extends('layouts.index')

@section('title', 'Профиль')

@section('content')
    <div class="container">
        {{--        {{ Breadcrumbs::render('home') }}--}}
        <h3 class="title">Профиль</h3>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('profile.edit') }}" method="post">
                    @csrf
                    <div class="form-group ">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') ?? $user->name }}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('name') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="form-group ">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" aria-describedby="emailHelp" name="email"
                               value="{{ old('email') ?? $user->email }}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('email') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-dark " id="profileFormBtn">Сохранить изменения
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <form action="{{ route('profile.editPassword') }}" method="post" id="password">
                    @csrf
                    <div class="form-group">
                        <label for="password">Текущий пароль</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('password') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Новый пароль</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        @if ($errors->has('newPassword'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('newPassword') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="newPasswordСonfirm">Поддверждение пароля</label>
                        <input type="password" class="form-control" id="newPasswordСonfirm" name="newPasswordСonfirm">
                        @if ($errors->has('newPasswordСonfirm'))
                            <div class="invalid-feedback">
                                @foreach($errors->get('newPasswordСonfirm') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-dark " >Изменить пароль</button></label>
                </form>
            </div>
        </div>
    </div>
@endsection

