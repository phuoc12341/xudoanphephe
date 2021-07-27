<div class="modal fade" id="modal-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Thêm mới danh mục</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Tên danh mục</label>
                    <input type="text" class="form-control" id="input-category-name"
                        placeholder="Nhập tên danh mục ...">
                </div>
                <div class="form-group">
                    <label>Danh mục cha</label>
                    <select class="form-control select2" id="select-category" style="width: 100%;">
                        <option selected="selected" value>- Lựa chọn -</option>
                        @include('admin.categories.option', ['categories' => $categories, 'level' => 0])
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                        class="fas fa-ban mr-2"></i>Hủy</button>
                <button type="button" class="btn btn-primary" id="create-or-update-category-btn" data-method="create"><i
                        class="fas fa-save mr-2"></i>Lưu</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
