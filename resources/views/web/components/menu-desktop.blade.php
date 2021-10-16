    <!--  -->
    <div class="wrap-main-nav">
        <div class="main-nav">
            <!-- Menu desktop -->
            <nav class="menu-desktop">
                <a class="logo-stick" href="index.html">
                    <img src="images/icons/logo-01.png" alt="LOGO">
                </a>
                <ul class="main-menu custom-dropdown-menu">
                    @foreach ($topMenu->child as $menu)
                        <li class="main-menu-active">
                            <a class="custom-dropdown-item" href="{{ $menu->link }}" @if ($menu->redirect) target="_blank" @endif>{{ $menu->name }}</a>

                            @if ($menu->child)
                                @include('web.menu-item', ['menus' => $menu->child ?? ''])
                            @endif

                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
