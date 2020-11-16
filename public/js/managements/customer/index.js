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
        {data : 'nama', name: 'nama'},
        {data : 'email', name: 'email'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#dataTables", urlCust, columns)
}

function addCustomers() {
    $('#formAddCustomer').validate({
        rules: {
            nama: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            no_telp: {
                required: true,
                number:true
            },
            alamat: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPost = URL_API + "/managements/add/pelanggan"
            const data = {
                nama: $('#nama').val(),
                email: $('#email').val(),
                no_telp: $('#no_telp').val(),
                alamat: $('#alamat').val(),
            }
            Functions.prototype.httpRequest(urlPost, data, 'post')
            if(window.location.search != "") {
                const urlParams = new URLSearchParams(window.location.search)
                if(urlParams.get('redirect') != "") {
                    setTimeout(() => {
                        window.location.href = urlParams.get('redirect')
                    }, 1500);
                }
            } else {
                getCustomers()
            }
        }
    })
}
function updateCustomer() {
    $('#formUpdateCustomer').validate({
        rules: {
            nama: {
                required: true
            },
            no_telp: {
                required: true,
                number:true
            },
            alamat: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPost = URL_API + "/managements/update/pelanggan/" + $('#id').val()
            const data = {
                nama: $('#update_nama').val(),
                no_telp: $('#update_no_telp').val(),
                alamat: $('#update_alamat').val(),
            }
            Functions.prototype.httpRequest(urlPost, data, 'put')
            getCustomers()
        }
    })
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
            $('#detail_nama').val(response.nama)
            $('#detail_email').val(response.email)
            $('#detail_no_telp').val(response.no_telp)
            $('#detail_alamat').val(response.alamat)
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