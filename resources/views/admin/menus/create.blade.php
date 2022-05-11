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
                            <input type="text" class="form-control form-control-border" id="menu-name" name="menu-name"
                                value="{{ old('title') }}" placeholder="Nhập tên Menu">
                        </div>

                        <div class="form-group">
                            <label for="title">Vị trí hiển thị</label>

                            <ul class="kv-setting-menu-list list-inline update-menu-page mb-3">
                                <li class="list-inline-item">
                                    <img src="https://admin.mykiot.vn/backend/images/menu-top.png" alt="" />
                                    <a class="custom-control custom-checkbox text-dark" href="javascript:;">
                                        <input type="checkbox" id="top-menu" class="custom-control-input" />
                                        <label class="custom-control-label" for="top-menu">Top Menu</label>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <img src="https://admin.mykiot.vn/backend/images/menu-top.png" alt="" />
                                    <a class="custom-control custom-checkbox text-dark" href="javascript:;">
                                        <input type="checkbox" id="footer-menu" class="custom-control-input" />
                                        <label class="custom-control-label" for="footer-menu">Footer Menu</label>
                                    </a>
                                </li>
                            </ul>

                            <div class="form-group">
                                <label class="form-group-label" for="menu-name">Mục đã chọn</label>
                                <p class="caption mb-3">* Hướng dẫn: Kéo lên - xuống để thay đổi vị trí. Kéo phải - trái để
                                    gộp - tách danh mục cha con. Footer menu và Top menu chỉ có thể hiển thị menu cấp 1</p>
                            </div>

                            <div id="empty-menu" class="empty-menu text-center">
                                <b>Bạn chưa có Mục nào</b>
                            </div>

                            <div class="form-group">
                                <div id="menu-setting" class="menu-table-group dd">
                                    <ul class="dd-list">
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary btn-save create-menu">
                                <i class="far fa-save mr10"></i> Lưu
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
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
    <script>
        // var route = @json($routeNames)

    </script>
    <script src="{{ asset('mix/admin/js/menu.js') }}"></script>
    <script src="">
        jQuery(document).ready(function() {
            // This button will increment the value
            $('[data-quantity="plus"]').click(function(e) {
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                fieldName = $(this).attr('data-field');
                // Get its current value
                var currentVal = parseInt($('input[name=' + fieldName + ']').val());
                // If is not undefined
                if (!isNaN(currentVal)) {
                    // Increment
                    $('input[name=' + fieldName + ']').val(currentVal + 1);
                } else {
                    // Otherwise put a 0 there
                    $('input[name=' + fieldName + ']').val(0);
                }
            });
            // This button will decrement the value till 0
            $('[data-quantity="minus"]').click(function(e) {
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                fieldName = $(this).attr('data-field');
                // Get its current value
                var currentVal = parseInt($('input[name=' + fieldName + ']').val());
                // If it isn't undefined or its greater than 0
                if (!isNaN(currentVal) && currentVal > 0) {
                    // Decrement one
                    $('input[name=' + fieldName + ']').val(currentVal - 1);
                } else {
                    // Otherwise put a 0 there
                    $('input[name=' + fieldName + ']').val(0);
                }
            });
        });

    </script>
@endpush
