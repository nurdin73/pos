$(document).ready(function () {
    getCustomers()
    getDetail()
    getDetailForUpdate()
    addCustomers()
    updateCustomer()
    deleteCustomer()
    if(window.location.search != "") {
        $('#addCustomerModal').modal('show')
    }
});

function getCustomers() {  
    const urlCust = URL_API + "/managements/pelanggan"
    const columns = [
        {data : 'nik', name: 'nik'},
        {data : 'nama', name: 'nama'},
        {data : 'email', name: 'email'},
        {data : 'point', name: 'point'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#dataTables", urlCust, columns)
}

function addCustomers() {
    $('#no_telp').mask('000000000000')
    $('#formAddCustomer').validate({
        rules: {
            nik: {
                required: true,
                number: true,
                minlength: 16,
                maxlength: 17
            },
            nama: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            no_telp: {
                required: true,
            },
            alamat: {
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
            e.preventDefault()
            const urlPost = URL_API + "/managements/add/pelanggan"
            const data = {
                nik: $('#nik').val(),
                nama: $('#nama').val(),
                email: $('#email').val(),
                no_telp: $('#no_telp').val(),
                alamat: $('#alamat').val(),
            }
            Functions.prototype.postRequest(postCustomer, urlPost, data)
        }
    })

    const postCustomer = {
        set successData(response) {
            toastr.success(response.message, 'Success')
            if(window.location.search != "") {
                const urlParams = new URLSearchParams(window.location.search)
                if(urlParams.get('redirect') != "") {
                    setTimeout(() => {
                        window.location.href = urlParams.get('redirect')
                    }, 1500);
                }
            } else {
                getCustomers()
                $('#formAddCustomer')[0].reset()
                $('#addCustomerModal').modal('hide')
                $('#nama').removeClass('is-valid')
                $('#email').removeClass('is-valid')
                $('#no_telp').removeClass('is-valid')
                $('#alamat').removeClass('is-valid')
                $('#nik').removeClass('is-valid')
            }
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
}
function updateCustomer() {
    $('#update_no_telp').mask('000000000000')
    $('#update_nik').mask('0000000000000000')
    $('#formUpdateCustomer').validate({
        rules: {
            update_nik: {
                required: true,
                number: true,
                minlength: 16
            },
            update_nama: {
                required: true
            },
            update_no_telp: {
                required: true,
            },
            update_point: {
                required: true,
                number:true,
                min: 0
            },
            update_alamat: {
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
            e.preventDefault()
            const urlPost = URL_API + "/managements/update/pelanggan/" + $('#id').val()
            const data = {
                nik: $('#update_nik').val(),
                nama: $('#update_nama').val(),
                no_telp: $('#update_no_telp').val(),
                alamat: $('#update_alamat').val(),
                point: $('#update_point').val(),
            }
            Functions.prototype.putRequest(putDataCustomer, urlPost, data)
            // Functions.prototype.httpRequest(urlPost, data, 'put')
        }
    })
    const putDataCustomer = {
        set successData(response) {
            toastr.success(response.message, 'Success')
            getCustomers()
            $('#formUpdateCustomer')[0].reset()
            $('#updateCustModal').modal('hide')
            $('#nama_update').removeClass('is-valid')
            $('#email_update').removeClass('is-valid')
            $('#no_telp_update').removeClass('is-valid')
            $('#alamat_update').removeClass('is-valid')
            $('#nik_update').removeClass('is-valid')
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
}

function getDetail() {  
    $('#dataTables').on('click', 'tbody tr td div .detail', function(e) {
        const id = $(this).data('id')
        getDetail.loadData = id
    })

    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_API + "/managements/pelanggan/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#detail_nik').val(response.nik)
            $('#detail_nama').val(response.nama)
            $('#detail_email').val(response.email)
            $('#detail_no_telp').val(response.no_telp)
            $('#detail_alamat').val(response.alamat)
            $('#detail_alamat').val(response.alamat)
            $('#detail_point').val(response.point)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'error!!')
        }
    }
}

function getDetailForUpdate() {  
    $('#dataTables').on('click', 'tbody tr td div .update', function(e) {
        const id = $(this).data('id')
        getDetailUpdate.loadData = id
    })

    const getDetailUpdate = {
        set loadData(data) {
            const urlDetail = URL_API + "/managements/pelanggan/" + data
            Functions.prototype.requestDetail(getDetailUpdate, urlDetail)
        },
        set successData(response) {
            $('#id').val(response.id)
            $('#update_nama').val(response.nama)
            $('#update_email').val(response.email).attr('disabled', true)
            $('#update_no_telp').val(response.no_telp)
            $('#update_alamat').val(response.alamat)
            $('#update_alamat').val(response.alamat)
            $('#update_point').val(response.point)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'error!!')
        }
    }
}

function deleteCustomer() {
    $('#dataTables').on('click', 'tbody tr td div .delete', function(e) {
        const id = $(this).data('id')
        const urlDelete = URL_API + "/managements/delete/pelanggan/" + id
        Swal.fire({
            title: 'Yakin ingin menghapus pelanggan ini?',
            text: "Pelanggan akan terhapus selamanya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Functions.prototype.deleteData(urlDelete);
                getCustomers()
            }
        })
    })
}