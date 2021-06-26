@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <!-- form start -->
    <form>
        <div class="card-body">
          <div class="form-group">
            <label for="title">Tên danh mục</label>
            <input type="text" class="form-control" id="title" placeholder="Nhập tên danh mục ...">
          </div>


          <div class="form-group">
            <label>Danh mục cha</label>
            <select class="form-control select2" name="parentCategory" style="width: 100%;">
              <option selected="selected">Alabama</option>
              <option>Alaska</option>
              <option>California</option>
              <option>Delaware</option>
              <option>Tennessee</option>
              <option>Texas</option>
              <option>Washington</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!-- /.card-body -->
      </form>
@endsection

@push('scripts')
  <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $(function () {
      $('.select2').select2()
    })

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  </script>
@endpush