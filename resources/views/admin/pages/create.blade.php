@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <section class="content">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thiết lập thông tin trang</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Tên trang</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Nhập tên trang">
                            </div>
                            <div class="form-group">
                                <label>Loại trang</label>
                                <select class="form-control select2" style="width: 100%;">
                                    @foreach (config('common.page_type') as $value => $text)
                                        @if ($loop->first)
                                            <option selected="selected" value="{{ $value }}">{{ $text }}
                                            </option>
                                        @else
                                            <option value="{{ $value }}">{{ $text }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Tự tạo slug</label>
                                <input type="text" class="form-control" id="title" name="slug"
                                    placeholder="Slug sẽ tự động tạo nếu bạn không nhập" value="{{ old('slug') }}">
                            </div>

                            <div class="form-group">
                                <label for="title">Nội dung trang</label>
                                <textarea id="summernote" name="description" value="{{ old('description') }}"></textarea>
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
            $('.select2').select2()
            // Summernote
            $('#summernote').summernote({
                height: 350,
                minHeight: 200, // set minimum height of editor
                maxHeight: 700,
                lang: 'vi-VN'
            })
        })

    </script>
@endpush
