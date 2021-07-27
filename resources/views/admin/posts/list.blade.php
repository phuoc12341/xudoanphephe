@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
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
                                    Danh mục
                                </th>
                                <th>
                                    Tag
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
                                        <a>
                                            {{ $post->category->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach ($post->tags as $tag)
                                            <span class="badge badge-primary">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a>
                                            {{ $post->created_at }}
                                        </a>
                                    </td>
                                    <td class="project-actions">

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

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('mix/admin/js/post.js') }}"></script>
    <script>
        var route = {!! json_encode($routeNames) !!}
        console.log(route)

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>
@endpush
