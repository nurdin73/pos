$(document).ready(function () {
    getDetail.loadData = ""
    updateLogo()
    updateDetailStore()
});

const getDetail = {
    set loadData(data) {
        const url = URL_API + "/settings/store"
        Functions.prototype.requestDetail(getDetail, url)
    },
    set successData(response) {
        $('#prevLogo').attr('src', BASE_URL + "/" + response.logo)
        $('#jenis_usaha').val(response.jenis_usaha)
        $('#nama_toko').val(response.nama_toko)
        $('#owner').val(response.owner)
        $('#no_telp').val(response.no_telp)
        $('#alamat').val(response.alamat)
        $('#npwp').val(response.npwp)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function updateLogo() {
    $('#logo').on('change', function (e) {
        e.preventDefault()

        if(Functions.prototype.validateFile($(this))) {
            const data = new FormData()
            const file = $(this)[0].files
            Functions.prototype.prevImage(file[0], $('#prevLogo'))
            data.append('logo', file[0])
            setTimeout(() => {
                const dataImg = $('#prevLogo').attr('src')
                Swal.fire({
                    html: `
                        <img src="${dataImg}" alt="avatar" class="img-fluid img-thumbnail">
                    `,
                    title: 'Apakah logo yang dipilih sudah benar?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = URL_API + "/settings/update/change-logo"
                        Functions.prototype.uploadFile(url, data, 'post')
                    } else {
                        $('#prevLogo').attr('src', "https://demo.getstisla.com/assets/img/avatar/avatar-1.png")
                    }
                })
            }, 100);
        }
    })
}

function updateDetailStore() {
    $('#no_telp').mask('0000-0000-0000')
    $('#npwp').mask('00.000.000.0-000.000')
    $('#updateStoreDetail').validate({
        rules: {
            nama_toko: {
                required: true
            },
            jenis_usaha: {
                required: true
            },
            owner: {
                required: true
            },
            no_telp: {
                required: true,
            },
            alamat: {
                required: true
            },
            npwp: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        errorPlacement: function errorPlacement(error, element) {
            error.addClass('invalid-feedback');
        
            if (element.prop('type') === 'checkbox') {
              error.insertAfter(element.parent('label'));
            } else {
              error.insertAfter(element);
            }
        },
        // eslint-disable-next-line object-shorthand
        highlight: function highlight(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        // eslint-disable-next-line object-shorthand
        unhighlight: function unhighlight(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        submitHandler: function(form, e) {
            const url = URL_API + "/settings/update/change-detail-store"
            const data = $('#updateStoreDetail').serialize()
            Functions.prototype.httpRequest(url, data, 'put')
            getDetail.loadData = ""
            $('#jenis_usaha').removeClass('is-valid')
            $('#nama_toko').removeClass('is-valid')
            $('#owner').removeClass('is-valid')
            $('#no_telp').removeClass('is-valid')
            $('#alamat').removeClass('is-valid')
            $('#npwp').removeClass('is-valid')
        }
    })
}