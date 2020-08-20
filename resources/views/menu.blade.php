<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        {{-- TODO Придумать как делать пункт меню активным при адресе с 3 мя и более / --}}
        <a class="nav-link {{ request()->routeIs('Home')?'active':'' }}" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('news')?'active':'' }}" href="{{ route('news') }}">Новости</a>
    </li>
    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request()->routeIs('news')?'active':'' }}" href="{{ route('categories') }}"
               id="navbarDropdownNewsCategories" role="button"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">Новости по категориям</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdownNewsCategories">
            {{--            <div class="dropdown-divider"></div>--}}
            @forelse($categories as $category) {{--TODO Переделать, так нельзя--}}
            <a class="dropdown-item " href="{{ route('newsByCategories', ['name' => $category['slug']]) }}">
                {{ $category['name'] }}
            </a>
            @empty
                Нет категорий новостей
            @endforelse
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('categories') }}">Категории новостей</a>
        </div>
    </li>
    @if(true) {{-- что то вроде isAdmin --}}
    @include('admin.menu')
    @endif
</ul>
{{--<ul class="nav nav-tabs">--}}

{{--    <li class="nav-item">--}}
{{--        @if (url()->current() == route('news'))--}}
{{--            <a class="nav-link active" href="{{ route('news') }}">Новости</a>--}}
{{--        @else--}}
{{--            <a class="nav-link " href="{{ route('news') }}">Новости</a>--}}
{{--        @endif--}}
{{--    </li>--}}
{{--    <li class="nav-item">--}}
{{--        @if (url()->current() == route('categories'))--}}
{{--            <a class="nav-link active" href="{{ route('categories') }}">Новости по категориям</a>--}}
{{--        @else--}}
{{--            <a class="nav-link" href="{{ route('categories') }}">Новости по категориям</a>--}}
{{--        @endif--}}
{{--    </li>--}}
{{--    <li class="nav-item">--}}
{{--        @if (url()->current() == route('admin.index'))--}}
{{--            <a class="nav-link active" href="{{ route('admin.index') }}">Админка</a>--}}
{{--        @else--}}
{{--            <a class="nav-link" href="{{ route('admin.index') }}">Админка</a>--}}
{{--        @endif--}}
{{--    </li>--}}
{{--    --}}{{--    <li class="nav-item">--}}
{{--    --}}{{--        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>--}}
{{--    --}}{{--    </li>--}}
{{--</ul>--}}
