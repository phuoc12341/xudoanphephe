import { event } from "jquery";
import { post as ApiServicePost, get as ApiServiceGet, deleteAxios as ApiServiceDelete, patch as ApiServicePatch } from "./services/api";
import { notify, reloadPage, countSubstrings, getRoute, validateImageUpload, validateSizeFileUpload, imagesPreview, onlyPermitNumber} from './utils/helper';

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

    updateOrder() {
        $('.order-counter').on('focusout', async function () {
            await Post.__updateOrderRequest($(this));
        });
        $('.order-counter').on('keyup', async function (event) {
            if (event.keyCode === 13) {
                $(this).unbind('focusout');
               await Page.__updateRankRequest($(this));
            }
        })
    },
    async __updateOrderRequest(element) {
        let currentOrder = parseInt(element.val());
        let oldOrder = parseInt(element.data('old-order')) ? parseInt(element.data('old-order')) : NaN;
        if (currentOrder === oldOrder) {
            return ;
        }
        let request = {
            order: currentOrder,
            id: element.data('id')
        };
        console.log(request)
        $('.order-counter').attr('disabled', true);

        try {
            const response = await ApiServicePatch(route.posts.order, request)
            console.log(response)
            if (response.status = 200) {
                notify('success', 'Thay đổi thứ tự bài viết thành công')
                reloadPage()
            }
        } catch (error) {
            notify('error', 'Không thể thay đổi thứ tự bài viết này')
        }
    },

    initBtnNumber() {
        $('.btn-number').click(function(e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function() {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            if (Number.isNaN(valueCurrent)) {
                return true
            }

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
        });

        $(".input-number .order-counter").on('keydown', function(e) {
            onlyPermitNumber(e)
        });
    },

    init() {
        this.uploadImage()
        this.clearPreviewImage()
        this.delete()
        this.switchStatus()
        this.updateOrder()
        this.initBtnNumber()
    }
};
$(async function () {
    await Post.init();
});
export default Post;
