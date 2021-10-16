import { deleteAxios as ApiServiceDelete, post as ApiServicePost, patch as ApiServicePatch } from "./services/api";
import { notify, reloadPage, getRoute, removeXss } from './utils/helper';
import "nestable2";
import "nestable2/jquery.nestable.scss";

const Menu = {
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

    initMenus() {
        // Menu.updateData()
        // Menu.fireBeforeunloadEvent()
        $(".dd").nestable({
            // maxDepth: 3,
            collapseBtnHTML: false,
            expandBtnHTML: false,
            listNodeName: "ul",
            itemNodeName: "li",
            emptyClass: "empty-menu",
            // onDragStart() {
            //     let pageY = window.event.clientY;
            //     console.log(pageY)
            //     let stepScroll = 150;
            //     let oldEventPageY = pageY;
            //     $("body").on('mousemove', function(event){
            //         let action = '';
            //         if (event.pageY >= oldEventPageY) {
            //             action = 'down';
            //         } else {
            //             action = 'up';
            //         }
            //         oldEventPageY = event.pageY;
            //         let scrollY = $('.content').scrollTop();
            //         let s = scrollY + event.pageY - pageY;
            //         if (action === 'down' && s < stepScroll) {
            //             return;
            //         }
            //         $('.content').animate({scrollTop: Math.ceil(s / stepScroll) * stepScroll}, { queue:false, duration:400});
            //     });
            // },
            // beforeDragStop() {
            //     $("body").unbind();
            // }
        })

        // .on('change', function () {
        //     Menu.updateData()
        //     Menu.fireBeforeunloadEvent()
        // });
    },

    updateData() {
        $('.dd-handle').removeClass('hidden');
        $(".dd-item").each(function(index) {
            $(this).attr("data-id", index + 1);
            if ($(this).data('deleted')) {
                $(this).find('.dd-handle:not(:first)').addClass('hidden');
                $(this).find('.dd-handle').first().addClass('deleted');
                $(this).find('.dd-handle').find('.fa-exclamation-circle').first().removeClass('d-none');
            }
            if ($(this).data('status') === 0) {
                $(this).find('.dd-handle').addClass('hidden');
                $(this).find('.dd-handle').find('.fa-exclamation-triangle').first().removeClass('d-none');
            }
        });
        if ($(".dd-item").length> 0) {
            $("#empty-menu").addClass("d-none");
        } else {
            $("#empty-menu").removeClass("d-none");
        }
    },

    fireBeforeunloadEvent() {
        if (Menu.enableBeforeUnload) {
            $(window).bind("beforeunload", function() {
                return "confirm";
            });
        }
        Menu.enableBeforeUnload = true;
    },

    collapseEditMenu() {
        $('.toggle-edit-btn').on('mousedown', function (event) { event.preventDefault(); return false; })
        
        $(document).on("click", ".toggle-edit-btn", function() {
            if (
                $(this)
                    .find(".fas")
                    .hasClass("fa-caret-down")
            ) {
                $(this)
                    .closest(".main-item")
                    .siblings(".edit-box")
                    .removeClass("d-none");
                $(this)
                    .find(".fas")
                    .removeClass("fa-caret-down")
                    .addClass("fa-caret-up");
            } else {
                $(this)
                    .closest(".main-item")
                    .siblings(".edit-box")
                    .addClass("d-none");
                $(this)
                    .find(".fas")
                    .removeClass("fa-caret-up")
                    .addClass("fa-caret-down");
            }
        });
    },

    addToMenu() {
        $("#add-custom-menu").on("click", function() {
            let customMenuName = ($("#custom-menu-name").val() || "").trim();
            customMenuName = removeXss(customMenuName);

            if (!customMenuName) {
                notify("error", 'Bạn chưa nhập tên mục');
                return;
            }
            // Remove Xss

            let customMenuUrl = ($("#custom-menu-url").val() || "").trim();
            if (customMenuUrl) {
                try {
                    new URL(customMenuUrl);
                } catch (_) {
                    notify("error", 'Nhập đường dẫn không đúng định dạng');
                    return;
                }
            }
            $("#menu-setting").nestable("add", {
                url: customMenuUrl,
                // name: encodeURIComponent(customMenuName),
                name: customMenuName,
                type: "external",
                // icon: "",
                redirect: 0,
                content: Menu.getMenuContent(
                    customMenuName,
                    "external",
                    customMenuUrl
                )
            });
            notify("success", "Thêm mới mục thành công");
            Menu.initMenus();
            // SettingMenu.initIconPicker();
            $("#custom-menu-name").val("");
            $("#custom-menu-url").val("");
        });

        $(".add-menu").on("click", function() {
            if ($(this).hasClass("fa-check")) {
                return;
            }
            let name = $(this).data("name");
            name = removeXss(name);
            let type = $(this).data("type");
            let referId = $(this).data("id");
            $("#menu-setting").nestable("add", {
                refer_id: referId || null,
                name: name,
                // name: encodeURIComponent(name),
                // icon: "",
                type: type,
                content: Menu.getMenuContent(name, type)
            });
            Menu.initMenus();
            // Menu.initIconPicker();
            let self = $(this);
            self.removeClass("fa-plus").addClass("fa-check");
            setTimeout(function() {
                self.removeClass("fa-check").addClass("fa-plus");
            }, 2000);
        });
    },

    getMenuContent(name, type, url = "", icon = "", status = true, redirect = false) {
        let typeName = "";
        if (type === "external") {
            typeName = 'Mục tự tạo';
        } else if (type === "page") {
            typeName = "Trang";
        } else if (type === "category") {
            typeName = "Danh mục bài viết";
        } else if (type === "post") {
            typeName = "Bài viết";
        }

        return `
        <div class="main-item menu-card-header">
            <span class="menu-card-header--icon">
                <i class="fas fa-bars"></i>
            </span>
            <div class="menu-card-header--left">
                <span class="icon-input-box">
                    <i class="icon-preview "></i>
                </span>
                <h6 class="menu-name">${name}</h6>
                <span class="created-item">${typeName}</span>
            </div>
            <div class="menu-card-header--right">
                <i class="fa fa-exclamation-triangle hide d-none"
                    title="@lang('admin.general.menu.menu_content.hidden')"></i>
                <i class="fas fa-exclamation-circle removed d-none"
                    title="@lang('admin.general.menu.menu_content.category_removed')"></i>
                <a href="javascript:;" class="dd-nodrag toggle-edit-btn">
                    <i class="fas fa-caret-down"></i>
                </a>
            </div>
        </div>

        <div class="dd-nodrag edit-box d-none kv-menu-card-body">

            <div class="card-row">
                <label>Nhập tên mục tự chọn</label>
                <input type="text" placeholder="" name="name" value="${name}"
                    class="form-control form-control-border" />
                <p class="caption">Tên gốc <a href="javascript:void(0)"
                        class="original-name"><span>${name}</span></a>
                </p>
            </div>

            ${
                type === "external"
                    ? `<div class="card-row">
                            <label>Nhập URL</label>
                            <input type="text" placeholder="Nhập đường dẫn" name="url" value="${url}" class="form-control form-control-border">
                        </div>`
                    : ""
            }

            <div class="card-row">
                <div class="custom-control custom-checkbox" style="margin-top: 18px">
                    <input class="custom-control-input" type="checkbox" ${redirect ? 'checked' : ''}
                        name="active-redirect" id="active-redirect"
                        style="margin-top: 18px">
                    <label for="active-redirect" class="custom-control-label">Mở
                        trong tab
                        mới</label>
                </div>
            </div>

            <div class="kv-menu-card-footer">
                <div class="kv-menu-card-footer--left" style="z-index: 100;">
                    <a href="javascript:;" class="btn-delete color-red">
                        <i class="far fa-trash-alt mr5"></i>Xóa mục
                    </a>
                </div>
                <div class="kv-menu-card-footer--right">
                    <button
                        class="btn-kv btn btn-default btn-cancel-item btn-cancel mr8">Hủy</button>
                    <button
                        class="btn-kv btn btn-primary btn-save-item btn-save">Lưu</button>
                </div>
            </div>
        </div>`
    },

    saveItem() {
        $(document).on("click", ".btn-save-item", function() {
            let editBox = $(this).closest(".edit-box");
            let name = (editBox.find('input[name="name"]').val() || "").trim();
            if (!name) {
                notify("error", window.i18n.trans('menu_name_null'));
                return;
            }
            let url = (editBox.find('input[name="url"]').val() || "").trim();
            if (url) {
                try {
                    new URL(url);
                } catch (_) {
                    notify("error", window.i18n.trans('menu_url_wrong_format'));
                    return false;
                }
            }
            // let icon = editBox.find('input[name="icon"]').val() || "";
            let activeRedirect = editBox.find('input[name="active-redirect"]:checked').length;
            // editBox
            //     .siblings(".main-item")
            //     .find(".icon-preview")
            //     .attr("class", `icon-preview ${icon}`);
            editBox
                .siblings(".main-item")
                .find(".menu-name")
                .text(name);
            $(this)
                .closest(".dd-item")
                .attr("data-name", name);
            $(this)
                .closest(".dd-item")
                .attr("data-url", url);
            // $(this)
            //     .closest(".dd-item")
            //     .attr("data-icon", icon);
            $(this)
                .closest(".dd-item")
                .attr("data-redirect", activeRedirect);
            editBox.addClass("d-none");
            editBox
                .siblings(".main-item")
                .find(".toggle-edit-btn")
                .find(".fas")
                .removeClass("fa-caret-up")
                .addClass("fa-caret-down");
            Menu.initMenus();
        });
    },

    save() {
        $(".create-menu").on("click", async function() {
            let menuName = ($("#menu-name").val() || "").trim();
            if (!menuName) {
                notify("error", "Bạn chưa nhập tên Menu");
                return;
            }
            $(this).attr("disabled", true)
            let tableContent = $("#menu-setting").nestable("serialize");
            console.log(tableContent)
            let request = {
                id: $("#menu-id").val(),
                active_top: $("#top-menu").is(":checked"),
                active_footer: $("#footer-menu").is(":checked"),
                name: menuName,
                table_content: tableContent
            };
            const response = await ApiServicePost(
                route.menus.store,
                request
            );

            console.log(response)
            // if (response.data.code === 1) {
            //     notify("success", response.data.message);
            //     $(window).unbind("beforeunload");
            //     setTimeout(function() {
            //         if ('referrer' in document) {
            //             window.location = document.referrer;
            //         } else {
            //             window.history.back();
            //         }
            //     }, 1000);
            // } else {
            //     notify("error", response.data.message);
            // }
        });
    },

    updateMenu() {
        $(".update-menu").on("click", async function() {
            let menuName = ($("#menu-name").val() || "").trim();
            if (!menuName) {
                notify("error", "Bạn chưa nhập tên Menu");
                return;
            }
            $(this).attr("disabled", true)
            let tableContent = $("#menu-setting").nestable("serialize");
            let menuId = $("#menu-id").val()
            console.log(tableContent)
            let paramsObj = {
                id: menuId,
                name: menuName,
                table_content: tableContent
            };

            const response = await ApiServicePatch(getRoute(route.menus.update, [menuId]), paramsObj)

            console.log(response)
            // if (response.data.code === 1) {
            //     notify("success", response.data.message);
            //     $(window).unbind("beforeunload");
            //     setTimeout(function() {
            //         if ('referrer' in document) {
            //             window.location = document.referrer;
            //         } else {
            //             window.history.back();
            //         }
            //     }, 1000);
            // } else {
            //     notify("error", response.data.message);
            // }
        });
    },

    createMenu() {
        $(".create-menu").on("click", async function() {
            let menuName = ($("#menu-name").val() || "").trim();
            if (!menuName) {
                notify("error", "Bạn chưa nhập tên Menu");
                return;
            }
            $(this).attr("disabled", true)
            let tableContent = $("#menu-setting").nestable("serialize");
            console.log(tableContent)
            let request = {
                id: $("#menu-id").val(),
                active_top: $("#top-menu").is(":checked"),
                active_footer: $("#footer-menu").is(":checked"),
                name: menuName,
                table_content: tableContent
            };
            const response = await ApiServicePost(
                route.menus.store,
                request
            );

            console.log(response)
            // if (response.data.code === 1) {
            //     notify("success", response.data.message);
            //     $(window).unbind("beforeunload");
            //     setTimeout(function() {
            //         if ('referrer' in document) {
            //             window.location = document.referrer;
            //         } else {
            //             window.history.back();
            //         }
            //     }, 1000);
            // } else {
            //     notify("error", response.data.message);
            // }
        });
    },

    
    init() {
        this.initMenus()
        this.delete()
        this.addToMenu()
        this.collapseEditMenu()
        this.saveItem()
        this.createMenu()
        this.updateMenu()
    }
};
$(async function () {
    
    await Menu.init();
});
export default Menu;
