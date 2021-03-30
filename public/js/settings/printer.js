$(document).ready(function () {
    getDetailPrinterSetting.loadData = 1

    $('#settingPrinter').on('submit', function(e) {
        e.preventDefault()
        const data = {
            os: $('#os').val(),
            koneksi: $('#koneksi').val(),
            name_printer: $('#name_printer').val(),
        }
        const urlPrinterSetting = BASE_URL_API + "/settings/printer/" + 1
        Functions.prototype.postRequest(postSettingPrinter, urlPrinterSetting, data)
    })

    $('#testConnection').on('click', function(e) {
        e.preventDefault()
        const urlTestConnection = BASE_URL_API + "/settings/test-printer"
        Functions.prototype.getRequest(testConnection, urlTestConnection)
    })
});

const testConnection = {
    set successData(response) {
        toastr.success(response.message, 'Success')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const postSettingPrinter = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getDetailPrinterSetting.loadData = 1
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getDetailPrinterSetting = {
    set loadData(query_params) {
        const urlPrinterSetting = BASE_URL_API + "/settings/printer/" + query_params
        Functions.prototype.getRequest(getDetailPrinterSetting, urlPrinterSetting)
    },
    set successData(response) {
        $('#os').val(response.os).trigger('change')
        $('#koneksi').val(response.koneksi).trigger('change')
        $('#name_printer').val(response.name_printer)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}