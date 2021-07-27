import { post as ApiServicePost, get as ApiServiceGet, deleteAxios as ApiServiceDelete, patch as ApiServicePatch } from "./services/api";
import { notify, reloadPage, countSubstrings, getRoute} from './utils/helper';

const Category = {
    async getAllCategory() {
        $('#add-new-category').on('click', async function (e) {
            try {
                const response = await ApiServiceGet(route.categories.index)

                if (response.status = 200) {
                    let listAllCategory = response.data.data
                    $('#select-category').empty()
                    $('#select-category').append(`<option selected="selected" value="">- Lựa chọn -</option>`);
                    
                    $.each(listAllCategory, function (index, element) {
                        $('#select-category').append(`<option value="${element.id}">${element.name}</option>`);
                    });
                }
            } catch (error) {
                notify('error', 'Không lấy được các danh mục')
            }
        });
    },

    async updateOrCreate() {
        $('#create-or-update-category-btn').on('click', async function (e) {
            if ($(this).data('method') === 'create') {
                Category.create()
            }

            if ($(this).data('method') === 'update') {
                console.log(4534)
                Category.update()
            }
        });
    },

    async create() {
        const categoryName = $('#input-category-name').val()
        const parentCategory = $('#select-category').val()
        let paramsObj = {
            'name': categoryName,
            'parent_id': parentCategory,
        };

        try {
            const response = await ApiServicePost(route.categories.store, paramsObj)
            if (response.status = 200) {
                $('#modal-category').modal('hide')
                notify('success', 'Tạo danh mục thành công')
                reloadPage()
            }
        } catch (error) {
            notify('error', 'Không tạo được danh mục')
        }
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
            $('#create-or-update-category-btn').attr('data-method', 'update')
            $('#modal-title').text('Sửa danh mục')
            $('#input-category-name').val($(this).data('name'))
            
            let id = $(this).data('id')
            $('#create-or-update-category-btn').data('id', id)

            try {
                const response = await ApiServiceGet(getRoute(route.categories.edit, [id]))
                if (response.status = 200) {
                    let arrCategoryIdCanBeParent = response.data.data.categoriesCanBeParent

                    $.each($('#select-category option'), function (index, element) {
                        let categoryId = parseInt(element.getAttribute('value'))

                        if (isNaN(categoryId)) {
                            categoryId = null
                        }
                        
                        if (arrCategoryIdCanBeParent.indexOf(categoryId) == -1 && index !== 0) {
                            $(this).prop('disabled', true)
                        }

                        if (categoryId === response.data.data.parent_id) {
                            $(this).prop('selected', 'selected').trigger('change')
                        }
                    });

                    $('#modal-category').on('hidden.bs.modal', function () {
                        $('#select-category option').each(function () {
                            $(this).prop('disabled', false)
                            $(this).removeProp('selected')
                        });
                        
                        $('#modal-title').text('Thêm mới danh mục')
                        $('#input-category-name').val('')
                        $('#create-or-update-category-btn').attr('data-method', 'create')
                        $('#create-or-update-category-btn').removeAttr('data-id')

                    });
                    
                }
            } catch (error) {
                console.log(error)
                notify('error', 'Không lấy được các danh mục')
            }
        });
    },

    async update() {
        let id = $('#create-or-update-category-btn').data('id')
        const categoryName = $('#input-category-name').val()
        const parentCategory = parseInt($('#select-category').val())

        let paramsObj = {
            'name': categoryName,
            'parent_id': parentCategory,
        };
        try {
            const response = await ApiServicePatch(getRoute(route.categories.update, [id]), paramsObj)
            if (response.status = 200) {
                $('#modal-category').modal('hide')
                notify('success', 'Cập nhật danh mục thành công')
                reloadPage()
            }
        } catch (error) {
            notify('error', 'Cập nhật danh mục thất bại')
        }
    },

    init() {
        // this.getAllCategory()
        // this.create()
        // this.update()
        this.updateOrCreate()
        this.switchStatus()
        this.delete()
        this.edit()
    }
};
$(async function () {
    await Category.init();
});
export default Category;
