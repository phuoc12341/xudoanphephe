@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">DataTable with minimal features & hover style</span>
                    <a type="button" href="{{ route('admin.pages.create') }}" class="btn float-right btn-success"
                        id="add-new-category"><i class="fas fa-plus mr-2"></i>Tạo mới trang</a>
                </div>
                <!-- /.card-header -->

                <div class="card-body p-0">
                    <table class="table table-striped projects">

                        <thead>
                            <tr>
                                <th>
                                    Tên trang
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
                            @foreach ($pages as $page)
                                <tr>
                                    <td>
                                        <a>
                                            {{ $page->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            {{ $page->created_at }}
                                        </a>
                                    </td>
                                    <td class="project-actions text-nowrap">
                                        <a class="btn btn-outline-warning btn-sm"
                                            href="{{ route('admin.pages.edit', ['page' => $page->id]) }}">
                                            <i class=" fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm delete-page" href="javascript:void(0)"
                                            data-id={{ $page->id }}>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a class="btn btn-outline-primary btn-sm" href="#">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
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
    <script src="{{ asset('mix/admin/js/page.js') }}"></script>
@endpush
