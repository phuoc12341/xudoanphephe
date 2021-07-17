import { post as ApiServicePost, get as ApiServiceGet, deleteAxios as ApiServiceDelete, patch as ApiServicePatch } from "./services/api";
import { notify, reloadPage, countSubstrings, getRoute} from './utils/helper';

const Category = {
    async getAllCategory() {
        $('#add-new-category').on('click', async function (e) {
            try {
                const response = await ApiServiceGet(route.categories.index)

                if (response.status = 200) {
                    let listAllCategory = response.data.data
                    $('#select-create-category').empty()
                    $('#select-create-category').append(`<option selected="selected" value="">- Lựa chọn -</option>`);
                    
                    $.each(listAllCategory, function (index, element) {
                        $('#select-create-category').append(`<option value="${element.id}">${element.name}</option>`);
                    });
                }
            } catch (error) {
                notify('error', 'Không lấy được các danh mục')
            }
        });
    },

    async create() {
        $('#create-category-btn').on('click', async function (e) {
            const categoryName = $('#input-create-category-name').val()
            const parentCategory = $('#select-create-category').val()
            let paramsObj = {
                'name': categoryName,
                'parent_id': parentCategory,
            };

            try {
                const response = await ApiServicePost(route.categories.store, paramsObj)
                if (response.status = 200) {
                    $('#modal-create-category').modal('hide')
                    notify('success', 'Tạo danh mục thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Không tạo được danh mục')
            }
        });
    },

    async switchStatus() {
        $('.switch-category-status').on('click', async function () {
            let paramsObj = {
                id: $(this).data('id'),
                status: 1 - $(this).data('status'),
            };

            try {
                const response = await ApiServicePost(route.categories.status, paramsObj)
                if (response.status = 200) {
                    notify('success', 'Thay đổi trạng thái thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Thay đổi trạng thái thất bại')
            }
        });
    },

    async delete() {
        $('.delete-category').on('click', async function () {
            let result = confirm('Bạn có chắc chắn xóa danh mục bài viết này ?');
            if (result == false) {
                return false
            }

            let id = $(this).data('id');

            try {
                const response = await ApiServiceDelete(getRoute(route.categories.destroy, [id]))
                console.log(response)
                if (response.status = 200) {
                    notify('success', 'Xóa danh mục thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Không thể xóa được danh mục này')
            }
        });
    },

    async edit() {
        $('.edit-category').on('click', async function () {
            let id = $(this).data('id')
            $('#edit-category-btn').data('id', id)

            try {
                const response = await ApiServiceGet(getRoute(route.categories.edit, [id]))
                if (response.status = 200) {
                    $('#modal-edit-category #input-edit-category-name').val(response.data.data.name)
                    $('#select-edit-category').empty()
                    $('#select-edit-category').append(`<option value="">- Lựa chọn -</option>`);
                    $.each(response.data.data.categoriesCanBeParennt, function (index, element) {
                        if (element.id === response.data.data.parent_id) {
                            $('#select-edit-category').append(`<option value="${element.id}" selected="selected">${element.name}</option>`);
                        } else {
                            $('#select-edit-category').append(`<option value="${element.id}">${element.name}</option>`);
                        }
                    });
                }
            } catch (error) {
                console.log(error)
                notify('error', 'Không lấy được các danh mục')
            }
        });
    },

    async update() {
        $('#edit-category-btn').on('click', async function () {
            let id = $(this).data('id')
            const categoryName = $('#input-edit-category-name').val()
            const parentCategory = $('#select-edit-category').val()

            let paramsObj = {
                'name': categoryName,
                'parent_id': parentCategory,
            };

            try {
                const response = await ApiServicePatch(getRoute(route.categories.update, [id]), paramsObj)
                if (response.status = 200) {
                    $('#modal-edit-category').modal('hide')
                    notify('success', 'Cập nhật danh mục thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Cập nhật danh mục thất bại')
            }
        });
    },

    init() {
        this.getAllCategory()
        this.create()
        this.switchStatus()
        this.delete()
        this.edit()
        this.update()
    }
};
$(async function () {
    await Category.init();
});
export default Category;
