@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">DataTable with minimal features & hover style</span>
                    <button type="button" class="btn float-right btn-success" data-toggle="modal"
                        data-target="#modal-create-category"><i class="fas fa-plus mr-2"></i>Thêm danh mục bài viết</button>
                </div>
                <!-- /.card-header -->


                <div class="card-body p-0">
                    <table class="table table-striped projects">

                        <thead>
                            <tr>
                                <th style="width: 50%">
                                    Tên danh mục
                                </th>
                                <th style="width: 20%">
                                    Số lượng bài viết
                                </th>
                                <th style="width: 30%">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a>
                                        AdminLTE v3
                                    </a>
                                    <br />
                                    <small>
                                        Created 01.01.2019
                                    </small>
                                </td>
                                <td class="project-state">
                                    <span class="badge badge-success">Success</span>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-outline-warning btn-sm" href="#">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-success btn-sm" href="#">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a class="btn btn-outline-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a class="btn btn-outline-primary btn-sm" href="#">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a>
                                        AdminLTE v3
                                    </a>
                                    <br />
                                    <small>
                                        Created 01.01.2019
                                    </small>
                                </td>
                                <td class="project-state">
                                    <span class="badge badge-success">Success</span>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-outline-warning btn-sm" href="#">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-outline-success btn-sm" href="#">
                                        <i class="fas fa-eye-slash"></i>
                                    </a>
                                    <a class="btn btn-outline-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a class="btn btn-outline-primary btn-sm" href="#">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
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

    <div class="modal fade" id="modal-create-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới danh mục</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Tên danh mục</label>
                        <input type="text" class="form-control" id="categoryName" placeholder="Nhập tên danh mục ...">
                    </div>


                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select class="form-control select2" name="parentCategory" id="parentCategory" style="width: 100%;">
                            <option selected="selected">- Lựa chọn -</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-ban mr-2"></i>Hủy</button>
                    <button type="button" class="btn btn-primary" id="create-category-btn"><i class="fas fa-save mr-2"></i>Lưu</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('mix/admin/js/category.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2()
        })

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    </script>
@endpush
