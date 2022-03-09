    <!-- Footer -->
    <footer>
        <div class="bg2 p-t-40 p-b-25">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <a href="index.html">
                                <img class="max-s-full" src="images/icons/logo-02.png" alt="LOGO">
                            </a>
                        </div>

                        <div>
                            <p class="f1-s-1 cl11 p-b-16">
                                Địa chỉ: 180/2 Nguyễn Lương Bằng, P. Quang Trung, Ðống Ða, Hà Nội

                            </p>

                            <p class="f1-s-1 cl11 p-b-16">
                                Điện thoại: 0123456789
                            </p>

                            <div class="p-t-15">
                                <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-facebook-f"></span>
                                </a>

                                <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-twitter"></span>
                                </a>

                                <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-pinterest-p"></span>
                                </a>

                                <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-vimeo-v"></span>
                                </a>

                                <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-youtube"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <h5 class="f1-m-7 cl0">
                                Bài viết phổ biến
                            </h5>
                        </div>

                        <ul>
                            @foreach ($popularPosts->take(3) as $post)
                                <li class="flex-wr-sb-s p-b-20">
                                    <a href="{{ $post->link }}" class="size-w-4 wrap-pic-w hov1 trans-03">
                                        <img src="{{ $post->imagePath }}" alt="IMG">
                                    </a>

                                    <div class="size-w-5">
                                        <h6 class="p-b-5">
                                            <a href="{{ $post->link }}"
                                                class="f1-s-5 cl11 hov-cl10 trans-03 how-txt1">
                                                {{ $post->title }}
                                            </a>
                                        </h6>

                                        <span class="f1-s-3 cl6">
                                            {{ $post->updated_at }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-sm-6 col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <h5 class="f1-m-7 cl0">
                                Danh mục
                            </h5>
                        </div>

                        <ul class="m-t--12">
                            @isset($footerMenu)
                                @foreach ($footerMenu->child as $menu)
                                    <li class="how-bor1 p-rl-5 p-tb-10">
                                        <a href="{{ $menu->link }}" class="f1-s-5 cl11 hov-cl10 trans-03 p-tb-8 how-txt2">
                                            {{ $menu->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg11">
            <div class="container size-h-4 flex-c-c p-tb-15">
                <span class="f1-s-1 cl0 txt-center">
                    Copyright © 1992-<script>
                        document.write(new Date().getFullYear());

                    </script>.

                    <a href="#" class="f1-s-1 cl10 hov-link1">
                        Xứ đoàn thiếu nhi Thánh Thể Phê-rô Phao-lô Giáo xứ Thái Hà
                </span>
            </div>
        </div>
    </footer>
