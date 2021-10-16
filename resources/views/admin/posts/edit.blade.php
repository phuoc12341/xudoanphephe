@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <section class="content">
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('admin.posts.update', ['post' => $post->id]) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thiết lập thông tin bài viết</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-9">
                                        <label>Chọn danh mục</label>
                                        <select class="form-control select2" id="select-create-category" name="category_id"
                                            style="width: 100%;">
                                            @include('admin.posts.option', ['categories' => $categories, 'level' => 0,
                                            'categoryId'
                                            => $post->category->id])
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label>Thứ tự</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <button type="button" class="btn btn-outline-secondary btn-number"
                                                    disabled="disabled" data-type="minus" data-field="order">
                                                    <span class="fa fa-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="order" class="form-control text-center input-number"
                                                value="{{ $post->order }}" min="1" max="10" placeholder="--"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = '--'">

                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-number"
                                                    data-type="plus" data-field="order">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Tên bài viết</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}"
                                    placeholder="Nhập tên bài viết">
                            </div>
                            <div class="form-group">
                                <label for="title">Tag</label>
                                <select class="select2" multiple="multiple" data-placeholder="Gắn tag cho bài viết"
                                    name="tags[]" style="width: 100%;">
                                    @foreach ($tags as $tag)
                                        <option @if ($postTags->contains($tag->id)) selected="selected" @endif
                                            value="{{ $tag->id }}">{{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Tự tạo slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Slug sẽ tự động tạo nếu bạn không nhập" value="{{ $post->slug }}">
                            </div>

                            <div class="form-group">
                                <label for="title">Nội dung bài viết</label>
                                <textarea id="summernote" name="description" value="{{ $post->description }}"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary btn-save">
                                <i class="far fa-save mr10"></i> Lưu
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ảnh đại diện</h3>
                        </div>

                        <div class="card-body" id="page-avatar">
                            <div class="product-thumb">
                                <span id="delete-image" class="product-thumb--delete @empty($post->image) d-none @endempty"
                                    data-default-image="{{ asset('assets/images/default-img.png') }}">
                                    <i class="fas fa-times"></i>
                                </span>
                                <figure class="kv-product-image ratio-1-1">
                                    <img src="{{ $post->imagePath }}" class="image image-contain default-img"
                                        id="preview-image">
                                </figure>
                                <p class="py15">Khuyến khích sử dụng ảnh có tỉ lệ 16:9 (1920x1080), dung lượng không vượt
                                    quá
                                    2MB và định dạng jpg, jpeg, png, gif.</p>
                                <div class="kv-file upload-file">
                                    <label for="upload-post-image" class="file-btn">Chọn tệp</label>
                                    <label for="upload-post-image" class="file-label">Chưa có tệp nào được chọn</label>
                                    <input type="file" id="upload-post-image" class="file-input" name="image"
                                        placeholder="" />
                                </div>
                                <input type="hidden" id="is-delete-image" name="is_delete_image" value="0" />
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary btn-save">
                                <i class="far fa-save mr10"></i> Lưu
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/lang/summernote-vi-VN.js') }}"></script>
    <script src="{{ asset('mix/admin/js/post.js') }}"></script>
    <script>
        $(function() {
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

            var descriptionPost = {!! json_encode($post->description) !!};
            $(function() {
                // Summernote
                $('#summernote').summernote({
                    height: 350,
                    minHeight: 200, // set minimum height of editor
                    maxHeight: 700,
                    lang: 'vi-VN',
                })
                $('#summernote').summernote('code', descriptionPost);
            })
        })

    </script>
@endpush
