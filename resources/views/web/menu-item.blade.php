<ul class="sub-menu custom-dropdown-menu dropdown-submenu">
    @foreach ($menus as $menu)
        <li>
            <a class="custom-dropdown-item @if ($menu->child->count() > 0) active @endif" href="{{ $menu->link }}" @if ($menu->redirect)
                    target="_blank" @endif>{{ $menu->name }}</a>
            @if ($menu->child->count() > 0)
                @include('web.menu-item', ['menus' => $menu->child])
            @endif
        </li>
    @endforeach
</ul>
