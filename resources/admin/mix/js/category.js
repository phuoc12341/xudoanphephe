import { post as ApiServicePost } from "./services/api";
// import { resetErr, showErrByClass, notify, initSelect2 } from "../../utils/helper";

const Branch = {
    setBranch() {
        $(document).on('submit', '#form-branch', async function (e) {
            e.preventDefault();
            resetErr();
            let that = $(this);
            let branchInventory = $(this).find('select[name="branchInventory[]"]').val();
            let typeBranch = $(this).find('input[name="typeBranch"]').val();
            let branchOrder = $(this).find('select[name="branchOrder"]').val();

            let request = {
                branchInventory: branchInventory,
                typeBranch: typeBranch,
                branchOrder: branchOrder,
            };
            const response = await ApiServicePost(request, app.admin.branch.setBranchConfig);
            if (response.data.code === 0) {
                showErrByClass(that, response.data.data);
            } else {
                notify('success', response.data.message);
                window.location.reload();

            }
        });
    },
    selectAll() {
        $(document).on('click', '#check-all', function () {
            if ($(this).is(':checked')) {
                const options = $.map($("select.branchInventory option"), function (option) {
                    return option.value;
                });

                $("select.branchInventory").val(options).trigger("change");
            } else {
                $("select.branchInventory").val(null).trigger("change");
            }
        });
        $(document).on('click', '#check-all-surcharge', function () {
            if ($(this).is(':checked')) {
                const options = $.map($("select.surcharges option"), function (option) {
                    return option.value;
                });

                $("select.surcharges").val(options).trigger("change");
            } else {
                $("select.surcharges").val(null).trigger("change");
            }
        });
    },
    unselectBranch() {

        let $eventSelect = $("select.branchInventory");
        const totalOption = $eventSelect.find('option').length;
        let optionSelected = $eventSelect.find(':selected').length;
        if (optionSelected === totalOption) {
            $('#check-all').prop('checked', true);
        }

        $eventSelect.on("select2:unselect", function (e) {
            $('#check-all').prop('checked', false);

        });
        $eventSelect.on("select2:select", function (e) {
            optionSelected = $eventSelect.find(':selected').length;
            if (optionSelected === totalOption) {
                $('#check-all').prop('checked', true);
            }
        });

    },

    updateSurcharge() {
        $(document).on('submit', '#form-surcharge', async function (e) {
            e.preventDefault();
            resetErr();
            let that = $(this);
            let surcharge = $(this).find('select[name="surcharge[]"]').val() || [];
            surcharge = surcharge.map(item => {
                return parseInt(item)
            })

            let request = {
                surchargeIds: surcharge
            };
            const response = await ApiServicePost(request, app.admin.general.updateSurchargeConfig);
            if (response.data.code === 0) {
                showErrByClass(that, response.data.data);
            } else {
                notify('success', response.data.message);
                window.location.reload();

            }
        });
    },

    selectCheckboxSurcharge() {
        let $eventSelect = $("select.surcharges");
        let totalOption = $eventSelect.find('option').length;
        let optionSelected = $eventSelect.find(':selected').length;
        if (optionSelected === totalOption) {
            $('#check-all-surcharge').prop('checked', true);
        }

        $eventSelect.on("select2:unselect", function (e) {
            $('#check-all-surcharge').prop('checked', false);

        });
        $eventSelect.on("select2:select", function (e) {
            optionSelected = $eventSelect.find(':selected').length;
            if (optionSelected === totalOption) {
                $('#check-all-surcharge').prop('checked', true);
            }
        });

    },

    test() {
        $('#create-category-btn').on('click', async function (e) {
            const categoryName = $('#categoryName').val()
            console.log(categoryName)
            const parentCategory = $('#parentCategory').val()

            let paramsObj = {
                'name': categoryName,
                'parentCategory': parentCategory,
            };
            
            const test = await ApiServicePost('categories', paramsObj)
            
            // console.log(test);
        });

    },

    init() {
        // initSelect2();
        // this.selectAll();
        // this.unselectBranch();
        // this.setBranch();
        // this.updateSurcharge();
        // this.selectCheckboxSurcharge();

        this.test()
    }
};
$(async function () {
    await Branch.init();
});
export default Branch;
