import { deleteAxios as ApiServiceDelete } from "./services/api";
import { notify, reloadPage,getRoute } from './utils/helper';

const Page = {
    async delete() {
        $('.delete-page').on('click', async function () {
            let result = confirm('Bạn có chắc chắn xóa trang này ?');
            if (result == false) {
                return false
            }

            let id = $(this).data('id');

            try {
                const response = await ApiServiceDelete(getRoute(route.pages.destroy, [id]))
                console.log(response)
                if (response.status = 200) {
                    notify('success', 'Xóa trang thành công')
                    reloadPage()
                }
            } catch (error) {
                notify('error', 'Không thể xóa được trang này')
            }
        });
    },

    init() {
        this.delete()
    }
};
$(async function () {
    await Page.init();
});
export default Page;
