@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@section('content')
    <!-- form start -->
    <form>
        <div class="card-body">
          <div class="form-group">
            <label for="title">Tiêu đề bài viết</label>
            <input type="text" class="form-control" id="title" placeholder="Nhập tiêu đề bài viết">
          </div>


          <div class="form-group">
            <label for="title">Nội dung bài viết</label>
            <textarea id="summernote">
                Chỉnh sửa bài viết như trong Word <strong>tại đây ...</strong>
            </textarea>
          </div>
          

          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!-- /.card-body -->


      </form>
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
          // Summernote
          $('#summernote').summernote()
      
          // CodeMirror
          CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
          });
        })
      </script>
@endpush
