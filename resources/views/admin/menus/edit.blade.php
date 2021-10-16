@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <section class="content">
        {{-- <form method="POST" enctype="multipart/form-data" action="{{ route('admin.menus.store') }}">
            @csrf --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thiết lập thông tin trang</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tên menu</label>
                            <input type="hidden" id="menu-id" value="{{ $menu->id }}">
                            <input type="text" class="form-control form-control-border" id="menu-name" name="menu-name"
                                placeholder="Nhập tên Menu" value="{{ $menu->name }}">
                        </div>

                        <div id="menu-setting" class="menu-table-group dd">
                            <ul class="dd-list">
                                @php
                                    $indexOfMenu = 1;
                                @endphp
                                @include('admin.menus.menu-item')
                            </ul>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-save update-menu">
                            <i class="far fa-save mr10"></i> Lưu
                        </button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mục tự tạo</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tên mục</label>
                            <input type="text" class="form-control form-control-border" id="custom-menu-name"
                                placeholder="Nhập tên mục">
                        </div>

                        <div class="form-group">
                            <label for="title">URL</label>
                            <input type="text" class="form-control form-control-border" id="custom-menu-url"
                                placeholder="Nhập đường dẫn">
                        </div>
                        <button type="button" class="btn float-right btn-success" id="add-custom-menu"><i
                                class="fas fa-plus mr-2"></i>Thêm</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="card collapse-wrapper collapsed-card">
                    <div class="card-header card-tools" data-card-widget="collapse">
                        <h3 class="card-title">Trang</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($pages->isNotEmpty())
                            <ul class="list-group cover-menu">
                                @foreach ($pages as $page)
                                    <li class="list-group-item">
                                        <div class=" item">
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-plus add-menu" data-id="{{ $page->id }}"
                                                    data-type="page" data-name="{{ $page->title }}"></i>
                                            </a>
                                            <span class="page-name">{{ $page->title }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="search-no-result text-center">
                                <p class="is-search">Không có trang nào được tìm thấy</p>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="card collapsed-card">
                    <div class="card-header card-tools" data-card-widget="collapse">
                        <h3 class="card-title">Danh mục bài viết</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body collapse-wrapper collapse show" id="collapseMenuCategory" style="">
                        <div class="menu-selection-search">
                            <input id="search-categories" class="form-control" placeholder="Tìm kiếm">
                        </div>

                        <div class="menu-selection-search-result search-result">
                            @if ($categories->isNotEmpty())
                                @include('admin.menus.row-category', ['categories' => $categories])
                            @else
                                <div class="search-no-result text-center">
                                    <p class="is-search">Không có danh mục nào được tìm thấy</p>
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="card collapsed-card">
                    <div class="card-header card-tools" data-card-widget="collapse">
                        <h3 class="card-title">Bài viết</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body collapse-wrapper collapse show" id="collapseMenuCategory" style="">
                        <div class=" menu-selection-search">
                            <input id="search-pages" class="form-control" placeholder="Tìm kiếm">
                        </div>

                        <div class="menu-selection-search-result search-result">
                            @if ($posts->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($posts as $post)
                                        <li class="list-group-item">
                                            <div class=" item">
                                                <a href="javascript:void(0)">
                                                    <i class="fas fa-plus add-menu" data-id="{{ $post->id }}"
                                                        data-type="post" data-name="{{ $post->title }}"></i>
                                                </a>
                                                <span class="category-name">{{ $post->title }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="search-no-result text-center">
                                    <p class="is-search d-none">Không có bài viết nào được tìm thấy</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        {{-- </form> --}}
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('mix/admin/js/menu.js') }}"></script>
@endpush
