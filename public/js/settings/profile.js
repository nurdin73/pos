$(document).ready(function () {
    getProfile.loadData = ""

    updateData()
    changePass()
});

const getProfile = {
    set loadData(data) {
        const url = URL_API + "/settings/profile"
        Functions.prototype.getRequest(getProfile, url)
    },
    set successData(response) {
        $('#nameUser').text(response.name)
        $('#emailUser').text(response.email)
        $('#roleUser').text(response.role)
        $('#addressUser').text(response.alamat != null ? response.alamat : "-")
        $('#nama').val(response.name)
        $('#email').val(response.email).attr('disabled', true).addClass('disabled')
        $('#alamat').val(response.alamat)
        $('#id_user').val(response.id)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function updateData() {
    $('#updateProfile').validate({
        rules: {
            nama: {
                required: true,
            },
            files: {
                accept: "image/jpeg, image/png, image/jpg"
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            const url = URL_API + "/settings/update/profile/" + $('#id_user').val() 
            const data = {
                name: $('#nama').val(),
                alamat: $('#alamat').val()
            }
            Functions.prototype.httpRequest(url, data, 'put')
            getProfile.loadData = ""
            $('#nama').removeClass('is-valid')
            $('#alamat').removeClass('is-valid')
        }
    })
}

function changePass() {
    $('#changePass').validate({
        rules: {
            password_lama: {
                required: true
            },
            password_baru: {
                required: true
            },
            password_confirm: {
                required: true,
                equalTo: "#password_baru"
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            const url = URL_API + "/settings/update/change-password"
            const data = {
                old_pass: $('#password_lama').val(),
                new_pass: $('#password_baru').val(),
                confirm_pass: $('#password_confirm').val(),
            }
            Functions.prototype.updateData(url, data, 'put')
            getProfile.loadData = ""
            $('#password_lama').removeClass('is-valid')
            $('#password_baru').removeClass('is-valid')
            $('#password_confirm').removeClass('is-valid')
        }
    })
}