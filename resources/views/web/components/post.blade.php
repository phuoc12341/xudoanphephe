    <!-- Post -->
    <section class="bg0 p-t-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="p-b-20">

                        @foreach ($categories as $category)
                            @php
                                $featuredPosts = $category->featuredPost;
                            @endphp

                            @if ($featuredPosts->count() == 4)
                                <!-- Entertainment -->
                                <div class="tab01 p-b-20">
                                    <div class="tab01-head how2 how2-cl1 bocl12 flex-s-c m-r-10 m-r-0-sr991">
                                        <!-- Brand tab -->
                                        <h3 class="f1-m-2 cl12 tab01-title">
                                            {{ $category->name }}
                                        </h3>

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach ($category->child as $cat)
                                                <li class="nav-item">
                                                    <a class="nav-link">{{ $cat->name }}</a>
                                                </li>
                                            @endforeach

                                            <li class="nav-item-more dropdown dis-none">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </a>

                                                <ul class="dropdown-menu">

                                                </ul>
                                            </li>
                                        </ul>

                                        <!--  -->
                                        <a href="{{ $categories->first()->link }}"
                                            class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                                            Xem tất cả
                                            <i class="fs-12 m-l-5 fa fa-caret-right"></i>
                                        </a>
                                    </div>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-t-35">
                                        <!-- - -->
                                        <div class="tab-pane fade show active">
                                            <div class="row">
                                                <div class="col-sm-6 p-r-25 p-r-15-sr991">
                                                    <!-- Item post -->
                                                    <div class="m-b-30">
                                                        <a href="{{ $featuredPosts->get(0)->link }}"
                                                            class="wrap-pic-w hov1 trans-03">
                                                            <img src="{{ $featuredPosts->get(0)->imagePath }}"
                                                                alt="IMG">
                                                        </a>

                                                        <div class="p-t-20">
                                                            <h5 class="p-b-5">
                                                                <a href="{{ $featuredPosts->get(0)->link }}"
                                                                    class="f1-m-3 cl2 hov-cl10 trans-03 how-txt1">
                                                                    {{ $featuredPosts->get(0)->title }}
                                                                </a>
                                                            </h5>

                                                            <span class="cl8">
                                                                <a href="{{ $featuredPosts->get(0)->category->link }}"
                                                                    class="f1-s-4 cl8 hov-cl10 trans-03">
                                                                    {{ $featuredPosts->get(0)->category->name }}
                                                                </a>

                                                                <span class="f1-s-3 m-rl-3">
                                                                    -
                                                                </span>

                                                                <span class="f1-s-3">
                                                                    {{ $featuredPosts->get(0)->updated_at }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 p-r-25 p-r-15-sr991">
                                                    <!-- Item post -->
                                                    <div class="flex-wr-sb-s m-b-30">
                                                        <a href="{{ $featuredPosts->get(1)->link }}"
                                                            class="size-w-1 wrap-pic-w hov1 trans-03">
                                                            <img src="{{ $featuredPosts->get(1)->imagePath }}"
                                                                alt="IMG">
                                                        </a>

                                                        <div class="size-w-2">
                                                            <h5 class="p-b-5">
                                                                <a href="{{ $featuredPosts->get(1)->link }}"
                                                                    class="f1-s-5 cl3 hov-cl10 trans-03 how-txt1">
                                                                    {{ $featuredPosts->get(1)->title }}
                                                                </a>
                                                            </h5>

                                                            <span class="cl8">
                                                                <a href="{{ $featuredPosts->get(1)->category->link }}"
                                                                    class="f1-s-6 cl8 hov-cl10 trans-03">
                                                                    {{ $featuredPosts->get(1)->category->name }}
                                                                </a>

                                                                <span class="f1-s-3 m-rl-3">
                                                                    -
                                                                </span>

                                                                <span class="f1-s-3">
                                                                    {{ $featuredPosts->get(1)->updated_at }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Item post -->
                                                    <div class="flex-wr-sb-s m-b-30">
                                                        <a href="{{ $featuredPosts->get(2)->link }}"
                                                            class="size-w-1 wrap-pic-w hov1 trans-03">
                                                            <img src="{{ $featuredPosts->get(2)->imagePath }}"
                                                                alt="IMG">
                                                        </a>

                                                        <div class="size-w-2">
                                                            <h5 class="p-b-5">
                                                                <a href="{{ $featuredPosts->get(2)->link }}"
                                                                    class="f1-s-5 cl3 hov-cl10 trans-03 how-txt1">
                                                                    {{ $featuredPosts->get(2)->title }}
                                                                </a>
                                                            </h5>

                                                            <span class="cl8">
                                                                <a href="{{ $featuredPosts->get(2)->category->link }}"
                                                                    class="f1-s-6 cl8 hov-cl10 trans-03">
                                                                    {{ $featuredPosts->get(2)->category->name }}
                                                                </a>

                                                                <span class="f1-s-3 m-rl-3">
                                                                    -
                                                                </span>

                                                                <span class="f1-s-3">
                                                                    {{ $featuredPosts->get(2)->updated_at }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Item post -->
                                                    <div class="flex-wr-sb-s m-b-30">
                                                        <a href="{{ $featuredPosts->get(3)->link }}"
                                                            class="size-w-1 wrap-pic-w hov1 trans-03">
                                                            <img src="{{ $featuredPosts->get(3)->imagePath }}"
                                                                alt="IMG">
                                                        </a>

                                                        <div class="size-w-2">
                                                            <h5 class="p-b-5">
                                                                <a href="{{ $featuredPosts->get(3)->link }}"
                                                                    class="f1-s-5 cl3 hov-cl10 trans-03 how-txt1">
                                                                    {{ $featuredPosts->get(3)->title }}
                                                                </a>
                                                            </h5>

                                                            <span class="cl8">
                                                                <a href="{{ $featuredPosts->get(3)->category->link }}"
                                                                    class="f1-s-6 cl8 hov-cl10 trans-03">
                                                                    {{ $featuredPosts->get(3)->category->name }}
                                                                </a>

                                                                <span class="f1-s-3 m-rl-3">
                                                                    -
                                                                </span>

                                                                <span class="f1-s-3">
                                                                    {{ $featuredPosts->get(3)->updated_at }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>

                <div class="col-md-10 col-lg-4">
                    <div class="p-l-10 p-rl-0-sr991 p-b-20">
                        <!--  -->
                        <div>
                            <div class="how2 how2-cl4 flex-s-c">
                                <h3 class="f1-m-2 cl3 tab01-title">
                                    Phổ biến nhất
                                </h3>
                            </div>

                            <ul class="p-t-35">
                                @foreach ($popularPosts as $post)
                                    <li class="flex-wr-sb-s p-b-22">
                                        <div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 @if (!$loop->last) m-b-6 @endif">
                                            {{ $loop->iteration }}
                                        </div>

                                        <a href="{{ $post->link }}"
                                            class="size-w-3 f1-s-7 cl3 hov-cl10 trans-03 how-txt1">
                                            {{ $post->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!--  -->
                        <div class="flex-c-s p-t-8">
                            <a href="#">
                                <img class="max-w-full" src="images/banner-02.jpg" alt="IMG">
                            </a>
                        </div>

                        <!--  -->
                        <div class="p-t-50">
                            <div class="how2 how2-cl4 flex-s-c">
                                <h3 class="f1-m-2 cl3 tab01-title">
                                    Stay Connected
                                </h3>
                            </div>

                            <ul class="p-t-35">
                                <li class="flex-wr-sb-c p-b-20">
                                    <a href="#"
                                        class="size-a-8 flex-c-c borad-3 size-a-8 bg-facebook fs-16 cl0 hov-cl0">
                                        <span class="fab fa-facebook-f"></span>
                                    </a>

                                    <div class="size-w-3 flex-wr-sb-c">
                                        <span class="f1-s-8 cl3 p-r-20">
                                            6879 Fans
                                        </span>

                                        <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                            Like
                                        </a>
                                    </div>
                                </li>

                                <li class="flex-wr-sb-c p-b-20">
                                    <a href="#" class="size-a-8 flex-c-c borad-3 size-a-8 bg-twitter fs-16 cl0 hov-cl0">
                                        <span class="fab fa-twitter"></span>
                                    </a>

                                    <div class="size-w-3 flex-wr-sb-c">
                                        <span class="f1-s-8 cl3 p-r-20">
                                            568 Followers
                                        </span>

                                        <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                            Follow
                                        </a>
                                    </div>
                                </li>

                                <li class="flex-wr-sb-c p-b-20">
                                    <a href="#" class="size-a-8 flex-c-c borad-3 size-a-8 bg-youtube fs-16 cl0 hov-cl0">
                                        <span class="fab fa-youtube"></span>
                                    </a>

                                    <div class="size-w-3 flex-wr-sb-c">
                                        <span class="f1-s-8 cl3 p-r-20">
                                            5039 Subscribers
                                        </span>

                                        <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                            Subscribe
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
