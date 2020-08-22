<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin')?'active':'' }}"
       href="#" id="navbarDropdownAdmin" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        Админка
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
        <a class="dropdown-item" href="{{ route('admin.create') }}">Создать новость</a>
        <a class="dropdown-item" href="{{ route('admin.download') }}">Скачать новости</a>
        {{--            <div class="dropdown-divider"></div>--}}
    </div>
</li>
