import { post as ApiServicePost, get as ApiServiceGet, deleteAxios as ApiServiceDelete, patch as ApiServicePatch } from "./services/api";
import { notify, reloadPage, countSubstrings, getRoute, validateImageUpload, validateSizeFileUpload, imagesPreview} from './utils/helper';

const Post = {
    uploadImage() {
        $('#upload-post-image').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $('.file-label').text(fileName)

            if (validateImageUpload(this)) {
                if (validateSizeFileUpload(this, 2)) {

                    let place = $('#preview-image');
                    $('#is-delete-image').val(0);
                    $('#delete-image').removeClass('d-none');
                    imagesPreview(this, place, 'img-preview-category');
                }

            }
        });
    },

    clearPreviewImage() {
        $('#delete-image').on('click', function () {
            let defaultImage = $(this).data('default-image');
            $('#preview-image').attr('src', defaultImage);
            $('.file-label').text('');
            $('#upload-post-image').val('');
            $('#is-delete-image').val(1);
            $(this).addClass('d-none');
        })
    },

    async switchStatus() {
        $('.switch-post-status').on('click', async function () {
            let paramsObj = {
                id: $(this).data('id'),
                status: 1 - $(this).data('status'),
            };

            try {
                const response = await ApiServicePost(route.posts.status, paramsObj)
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
        $('.delete-post').on('click', async function () {
            let result = confirm('Bạn có chắc chắn xóa bài viết này ?');
            if (result == false) {
                return false
            }

            let id = $(this).data('id');

            try {
                const response = await ApiServiceDelete(getRoute(route.posts.destroy, [id]))
                console.log(response)
                if (response.status = 200) {
                    notify('success', 'Xóa bài viết thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Không thể xóa được bài viết này')
            }
        });
    },

    init() {
        this.uploadImage()
        this.clearPreviewImage()
        this.delete()
        this.switchStatus()
    }
};
$(async function () {
    await Post.init();
});
export default Post;
