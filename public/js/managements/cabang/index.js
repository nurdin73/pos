$(document).ready(function () {
    var query_params = ""
    $('#no_telp').mask('0000-0000-0000')
    $('#no_telp_update').mask('0000-0000-0000')
    getAll.loadData = query_params
    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        getAll.loadData = query_params
    })
    $('#filteringData').on('submit', function(e) {
        e.preventDefault()
        query_params = ""
        query_params += "?" + $(this).serialize()
        getAll.loadData = query_params
    })
    $('.btn-reset').on('click', function(e) {
        e.preventDefault()
        $('#filteringData')[0].reset()
        getAll.loadData = ""
    })

    addBranchStore()
    getDetail()
    updateData()
    deleteData()
});

const getAll = {
    set loadData(data) {
        const url = URL_API + '/managements/branch-stores' + data
        Functions.prototype.getRequest(getAll, url)
    },
    set successData(response) {
        $('#listCabang').empty()
        const { last_page, current_page, data, prev_page_url } = response
        if(data.length > 0) {
            var no = 1
            data.map(branch => {
                $('#listCabang').append(`
                    <tr>
                        <td>${no++}</td>
                        <td>${branch.nama_cabang}</td>
                        <td>${branch.no_telp != null ? branch.no_telp : "-"}</td>
                        <td>${branch.alamat.length > 70 ? branch.alamat.substr(0, 70) + "..." : branch.alamat}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#updateBranchStoreModal" data-id="${branch.id}"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-primary detail" data-toggle="modal" data-target="#detailBranchStoreModal" data-id="${branch.id}"><i class="fa fa-book"></i></button>
                                <button class="btn btn-sm btn-danger delete" data-id="${branch.id}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `)
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
            paginations = ""
        } else {
            $('#listCabang').append(`
                <tr>
                    <td colspan="5" align="center">Belum ada cabang yang ditambahkan</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function addBranchStore() {
    $('#formAddbranchStore').validate({
        rules: {
            nama_cabang: {
                required: true
            },
            no_telp: {
                required: true
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
            const data = {
                nama_cabang: $('#nama_cabang').val(),
                no_telp: $('#no_telp').val(),
                alamat: $('#alamat').val(),
            }
            const url = URL_API + "/managements/add/branch-store"
            Functions.prototype.postRequest(addData, url, data)
        }
    })

    const addData = {
        set successData(response) {
            toastr.success(response.message, 'Success')
            $('#formAddbranchStore')[0].reset()
            $('#addBranchStoreModal').modal('hide')
            $('#nama_cabang').removeClass('is-valid')
            $('#no_telp').removeClass('is-valid')
            $('#alamat').removeClass('is-valid')
            getAll.loadData = ""
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
}

function getDetail() {
    $('#listCabang').on('click', 'tr td div .detail', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const url = URL_API + "/managements/branch-store/" + id
        Functions.prototype.requestDetail(detailCabang, url)
    })

    const detailCabang = {
        set successData(response) {
            $('#nama_cabang_detail').val(response.nama_cabang)
            $('#no_telp_detail').val(response.no_telp)
            $('#alamat_detail').val(response.alamat)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
}

function updateData() {
    var idCabang = ""
    $('#listCabang').on('click', 'tr td div .edit', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        idCabang = id
        const url = URL_API + "/managements/branch-store/" + id
        Functions.prototype.requestDetail(detailCabang, url)
    })

    const detailCabang = {
        set successData(response) {
            $('#nama_cabang_update').val(response.nama_cabang)
            $('#no_telp_update').val(response.no_telp)
            $('#alamat_update').val(response.alamat)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }

    $('#formUpdatebranchStore').validate({
        rules: {
            nama_cabang_update: {
                required: true
            },
            no_telp_update: {
                required: true
            },
            alamat_update: {
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
            const data = {
                nama_cabang: $('#nama_cabang_update').val(),
                no_telp: $('#no_telp_update').val(),
                alamat: $('#alamat_update').val(),
            }
            const url = URL_API + "/managements/update/branch-store/" + idCabang
            Functions.prototype.putRequest(updateCabang, url, data)
        }
    })

    const updateCabang = {
        set successData(response) {
            toastr.success(response.message, 'Success')
            $('#formUpdatebranchStore')[0].reset()
            $('#updateBranchStoreModal').modal('hide')
            $('#nama_cabang_update').removeClass('is-valid')
            $('#no_telp_update').removeClass('is-valid')
            $('#alamat_update').removeClass('is-valid')
            getAll.loadData = ""
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
}

function deleteData() {
    $('#listCabang').on('click', 'tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const urlDelete = URL_API + "/managements/delete/branch-store/" + id
        Swal.fire({
            title: 'Perhatian!',
            text: "Cabang akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Functions.prototype.deleteData(urlDelete);
                getAll.loadData = ""
            }
        })
    })
}