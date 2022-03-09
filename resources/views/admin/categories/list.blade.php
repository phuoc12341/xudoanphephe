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
                    <button type="button" class="btn float-right btn-success" id="add-new-category" data-toggle="modal"
                        data-target="#modal-category"><i class="fas fa-plus mr-2"></i>Thêm danh mục bài viết</button>
                </div>
                <!-- /.card-header -->


                <div class="card-body p-0">
                    <table class="table table-striped projects">

                        <thead>
                            <tr>
                                <th style="width: 5ch">
                                    Tên danh mục
                                </th>
                                <th style="width: 10%">
                                    Thứ tự
                                </th>
                                <th style="width: 20%">
                                    Số lượng bài viết
                                </th>
                                <th style="width: 20%">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('admin.categories.row', ['categories' => $categories, 'level' => 0])
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

    @include('admin.categories.modal')
@endsection

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('mix/admin/js/category.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
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

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

    </script>
@endpush
