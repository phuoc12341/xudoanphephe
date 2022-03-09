<!-- Breadcrumb -->
<div class="container">
    <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 m-tb-6">
            @foreach ($breadcrumb as $item)
                @if ($loop->first)
                    <a href="/" class="breadcrumb-item f1-s-3 cl9">
                        {{ $item }}
                    </a>
                @elseif ($loop->last)
                    <span class="breadcrumb-item f1-s-3 cl9">
                        {{ $item }}
                    </span>
                @else
                    <a href="{{ App\Helper\Helper::getPublicCategoryLink($item->slug, $item->id) }}"
                        class="breadcrumb-item f1-s-3 cl9">
                        {{ $item->name }}
                    </a>
                @endif

            @endforeach
        </div>

        <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
            <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Search">
            <button class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
                <i class="zmdi zmdi-search"></i>
            </button>
        </div>
    </div>
</div>
