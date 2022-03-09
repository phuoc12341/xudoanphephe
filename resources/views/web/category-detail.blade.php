<x-layout>
    <x-breadcrumb type="category" :menuItem="$category"></x-breadcrumb>

    <!-- Page heading -->
    <div class="container p-t-4 p-b-40">
        <h2 class="f1-l-1 cl2">
            {{ $category->name }}
        </h2>
    </div>

    @if ($featurePosts->count() >= 4)
        <!-- Feature post -->
        <section class="bg0">
            <div class="container">
                <div class="row m-rl--1">
                    <div class="col-md-6 p-rl-1 p-b-2">
                        <div class="bg-img1 size-a-3 how1 pos-relative"
                            style="background-image: url({{ $featurePosts->get(0)->imagePath }});">
                            <a href="{{ $featurePosts->get(0)->link }}" class="dis-block how1-child1 trans-03"></a>

                            <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                <a href="#"
                                    class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                    {{ $featurePosts->get(0)->category->name }}
                                </a>

                                <h3 class="how1-child2 m-t-14 m-b-10">
                                    <a href="{{ $featurePosts->get(0)->link }}"
                                        class="how-txt1 size-a-6 f1-l-1 cl0 hov-cl10 trans-03">
                                        {{ $featurePosts->get(0)->title }}
                                    </a>
                                </h3>

                                <span class="how1-child2">
                                    <span class="f1-s-4 cl11">
                                        Jack Sims
                                    </span>

                                    <span class="f1-s-3 cl11 m-rl-3">
                                        -
                                    </span>

                                    <span class="f1-s-3 cl11">
                                        {{ $featurePosts->get(0)->created_at }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 p-rl-1">
                        <div class="row m-rl--1">
                            <div class="col-sm-6 p-rl-1 p-b-2">
                                <div class="bg-img1 size-a-14 how1 pos-relative"
                                    style="background-image: url({{ $featurePosts->get(1)->imagePath }});">
                                    <a href="{{ $featurePosts->get(1)->link }}"
                                        class="dis-block how1-child1 trans-03"></a>

                                    <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                        <a href="#"
                                            class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                            {{ $featurePosts->get(1)->category->name }}
                                        </a>

                                        <h3 class="how1-child2 m-t-14">
                                            <a href="{{ $featurePosts->get(1)->link }}"
                                                class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
                                                {{ $featurePosts->get(1)->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 p-rl-1 p-b-2">
                                <div class="bg-img1 size-a-14 how1 pos-relative"
                                    style="background-image: url({{ $featurePosts->get(2)->imagePath }});">
                                    <a href="{{ $featurePosts->get(2)->link }}"
                                        class="dis-block how1-child1 trans-03"></a>

                                    <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                        <a href="#"
                                            class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                            {{ $featurePosts->get(2)->category->name }}
                                        </a>

                                        <h3 class="how1-child2 m-t-14">
                                            <a href="blog-detail-01.html"
                                                class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
                                                {{ $featurePosts->get(2)->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 p-rl-1 p-b-2">
                                <div class="bg-img1 size-a-14 how1 pos-relative"
                                    style="background-image: url({{ $featurePosts->get(3)->imagePath }});">
                                    <a href="{{ $featurePosts->get(3)->link }}"
                                        class="dis-block how1-child1 trans-03"></a>

                                    <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                        <a href="#"
                                            class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                            {{ $featurePosts->get(3)->category->name }}
                                        </a>

                                        <h3 class="how1-child2 m-t-14">
                                            <a href="blog-detail-01.html"
                                                class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
                                                {{ $featurePosts->get(3)->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 p-rl-1 p-b-2">
                                <div class="bg-img1 size-a-14 how1 pos-relative"
                                    style="background-image: url({{ $featurePosts->get(4)->imagePath }});">
                                    <a href="{{ $featurePosts->get(4)->link }}"
                                        class="dis-block how1-child1 trans-03"></a>

                                    <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                        <a href="#"
                                            class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                            {{ $featurePosts->get(4)->category->name }}
                                        </a>

                                        <h3 class="how1-child2 m-t-14">
                                            <a href="blog-detail-01.html"
                                                class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
                                                {{ $featurePosts->get(4)->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Post -->
    <section class="bg0 p-t-70 p-b-55">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 p-b-80">
                    <div class="row">
                        @foreach ($posts as $post)

                            <div class="col-sm-6 p-r-25 p-r-15-sr991">
                                <!-- Item latest -->
                                <div class="m-b-45">
                                    <a href="{{ $post->link }}" class="wrap-pic-w hov1 trans-03">
                                        <img class="image-cover" src="{{ $post->imagePath }}" alt="IMG">
                                    </a>

                                    <div class="p-t-16">
                                        <h5 class="p-b-5">
                                            <a href="{{ $post->link }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                                {{ $post->title }}
                                            </a>
                                        </h5>

                                        <span class="cl8">
                                            <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                                                by John Alvarado
                                            </a>

                                            <span class="f1-s-3 m-rl-3">
                                                -
                                            </span>

                                            <span class="f1-s-3">
                                                {{ $post->updated_at }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="flex-wr-s-c m-rl--7 p-t-15">
                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <a class="page-item disabled" aria-disabled="true"><span
                                        class="page-link">{{ $element }}</span></a>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-active"
                                            aria-current="page">{{ $page }}</a>
                                    @else
                                        <a href="{{ $url }}"
                                            class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="col-md-10 col-lg-4 p-b-80">
                    <div class="p-l-10 p-rl-0-sr991">
                        <!-- Subscribe -->
                        {{-- <div class="bg10 p-rl-35 p-t-28 p-b-35 m-b-50">
                            <h5 class="f1-m-5 cl0 p-b-10">
                                Subscribe
                            </h5>

                            <p class="f1-s-1 cl0 p-b-25">
                                Get all latest content delivered to your email a few times a month.
                            </p>

                            <form class="size-a-9 pos-relative">
                                <input class="s-full f1-m-6 cl6 plh9 p-l-20 p-r-55" type="text" name="email"
                                    placeholder="Email">

                                <button class="size-a-10 flex-c-c ab-t-r fs-16 cl9 hov-cl10 trans-03">
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </form>
                        </div> --}}

                        <!-- Most Popular -->
                        <div class="p-b-23">
                            <div class="how2 how2-cl4 flex-s-c">
                                <h3 class="f1-m-2 cl3 tab01-title">
                                    Bài viết phổ biến
                                </h3>
                            </div>

                            <ul class="p-t-35">
                                @foreach ($popularPosts as $post)
                                    <li class="flex-wr-sb-s p-b-22">
                                        <div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 m-b-6">
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
                        <div class="flex-c-s p-b-50">
                            <a href="#">
                                <img class="max-w-full" src="images/banner-02.jpg" alt="IMG">
                            </a>
                        </div>

                        <!-- Tag -->
                        <div>
                            <div class="how2 how2-cl4 flex-s-c m-b-30">
                                <h3 class="f1-m-2 cl3 tab01-title">
                                    Tags
                                </h3>
                            </div>

                            <div class="flex-wr-s-s m-rl--5">
                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Fashion
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Lifestyle
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Denim
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Streetstyle
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Crafts
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Magazine
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    News
                                </a>

                                <a href="#"
                                    class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    Blogs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
