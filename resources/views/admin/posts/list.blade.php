@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Lọc theo</label>
                    </div>
                    <div class="form-group">

                        <select class="select2 status" name="tags[]" style="width: 100%;">
                            <option selected="selected" value="">- Trạng thái -</option>
                            <option value="0">Tắt hiển thị</option>
                            <option value="1">Bật hiển thị</option>
                        </select>
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="javascript:void(0)" class="card-link">Xóa</a>
                        <button type="button" class="btn btn-success float-right">Áp dụng</button>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Danh mục</label>
                    </div>
                    <div class="form-group">
                        <select class="select2 category" name="tags[]" style="width: 100%;">
                            <option selected="selected" value="">- Lựa chọn -</option>
                            @include('admin.posts.option', ['categories' => $categories, 'level' => 0, 'categoryId'
                            => null])
                        </select>
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="javascript:void(0)" class="card-link">Xóa</a>
                        <button type="button" class="btn btn-success float-right">Áp dụng</button>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">DataTable with minimal features & hover style</span>
                    <a type="button" href="{{ route('admin.posts.create') }}" class="btn float-right btn-success"
                        id="add-new-category"><i class="fas fa-plus mr-2"></i>Tạo mới bài viết</a>
                </div>
                <!-- /.card-header -->

                <div class="card-body p-0">
                    <table class="table table-striped projects">

                        <thead>
                            <tr>
                                <th>
                                    Tên bài viết
                                </th>
                                <th>
                                    Thứ tự
                                </th>
                                <th>
                                    TG tạo
                                </th>
                                <th>
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>
                                        <a>
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <input type="text"
                                            class="form-control form-control-border bg-transparent text-center order-counter"
                                            placeholder="--" value="{{ $post->order }}"
                                            data-old-order="{{ $post->order }}" data-id="{{ $post->id }}"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = '--'">
                                    </td>
                                    <td>
                                        <a>
                                            {{ $post->created_at }}
                                        </a>
                                    </td>
                                    <td class="project-actions text-nowrap">

                                        <a class="btn btn-outline-warning btn-sm"
                                            href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">
                                            <i class=" fas fa-pencil-alt"></i>
                                        </a>
                                        @if ($post->category->status === App\Models\Category::INACTIVE)
                                            <a class="btn btn-default btn-sm action-disable" data-toggle="tooltip"
                                                data-placement="top" data-html="true"
                                                title="Vui lòng bật hiển thị danh mục này tại <a href='#'>Danh mục</a> để sử dụng tính năng này"
                                                href="javascript:void(0)" data-id="{{ $post->id }}"
                                                data-status="{{ $post->status }}">
                                                <i class="far fa-eye"></i>
                                            </a>

                                        @elseif ($post->status === App\Models\Post::ACTIVE)
                                            <a class="btn btn-success btn-sm switch-post-status @if ($post->category->status === App\Models\Category::INACTIVE) disable @endif"
                                                href="javascript:void(0)" data-id="{{ $post->id }}"
                                                data-status="{{ $post->status }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-success btn-sm switch-post-status @if ($post->category->status === App\Models\Category::INACTIVE) disable @endif"
                                                href="javascript:void(0)"
                                                data-id="{{ $post->id }}" data-status="{{ $post->status }}">
                                                <i class="fas fa-eye-slash"></i>
                                            </a>
                                        @endif

                                        <a class="btn btn-outline-danger btn-sm delete-post" href="javascript:void(0)"
                                            data-id={{ $post->id }}>
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        @if ($post->category->status === App\Models\Category::INACTIVE)
                                            <a class="btn btn-default btn-sm action-disable" data-toggle="tooltip"
                                                data-placement="top" data-html="true"
                                                title="Vui lòng bật hiển thị danh mục này tại <a href='#'>Danh mục</a> để sử dụng tính năng này"
                                                href="javascript:void(0)">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-outline-primary btn-sm" href="#">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            {{ $posts->links() }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('mix/admin/js/post.js') }}"></script>
    <script>
        $(function() {
            $('.select2.status').select2({
                minimumResultsForSearch: -1
            })
        })

        $(function() {
            $('.select2.category').select2({
                templateResult: formatState
            })
        })

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }

            var $state = $(
                `<span class="${state.element.className}" style="--level: ${state.element.getAttribute('data-level')};">${state.element.text}</span>`
            );

            return $state;
        };

        $(function() {
            $('.select2').select2({
                templateResult: formatState
            })
        })

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>
@endpush
