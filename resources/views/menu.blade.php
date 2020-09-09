<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        {{-- TODO Придумать как делать пункт меню активным при адресе с 3 мя и более / --}}
        <a class="nav-link {{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           id="navbarDropdownNewsCategories" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">Новости</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdownNewsCategories">
            {{--            <div class="dropdown-divider"></div>--}}
            @forelse(\App\Category::all() as $category)
                <a class="dropdown-item " href="{{ route('news.category.show', ['name' => $category->slug]) }}">
                    {{ $category->name }}
                </a>
            @empty
                Нет категорий новостей
            @endforelse
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('news.index') }}">Все новости</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('news.category.index') }}">Категории новостей</a>
        </div>
    </li>
    @if(true) {{-- что то вроде isAdmin --}}
    @guest
    @else
        @if(Auth::user()->is_admin)
            @include('admin.menu')
        @endif
    @endguest
    @endif
</ul>
