$(document).ready(function () {
    var query_params = ""
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
    addTax()
    updateTax()
    deleteTax()
});

const getAll = {
    set loadData(data) {
        const url = URL_API + "/managements/pajak" + data
        Functions.prototype.getRequest(getAll, url)
    },
    set successData(response) {
        $('#listTaxes').empty()
        const { last_page, current_page, data, prev_page_url } = response
        if(data.length > 0) {
            data.map(result => {
                if (result.type_pajak === 'lokal') {
                    $('#listTaxes').append(`
                    <tr>
                        <td>${result.nama_pajak}</td>
                        <td>${result.product.nama_barang}</td>
                        <td>${result.persentase_pajak + "%"}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#updateTax" data-id="${result.id}"><i class="fa fa-edit"></i></button>
                                
                                <button class="btn btn-sm btn-danger delete" data-id="${result.id}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    `)
                }
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
        } else {
            $('#listTaxes').append(`
                <tr>
                    <td colspan="4" align="center">Tidak ada pajak</td>
                </tr>
            `)
        }

        $('#taxUniv').empty()
        if(data.length > 0) {
            data.map(result => {
                if (result.type_pajak === 'universal') {
                    $('#taxUniv').append(`
                    <span class="lead text-uppercase">Nama Pajak : ${result.nama_pajak}</span>
                    <span id="persentase" class="lead text-uppercase">Persentase Pajak : ${result.persentase_pajak} %</span>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#updateTax" data-id="${result.id}"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete" data-id="${result.id}"><i class="fa fa-trash"></i></button>
                    </div>
                    `)
                }
            })
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function addTax() {
    $('#type_pajak').on('change', function(e) {
        if ($('#type_pajak').val() === 'universal') {
            $('#barang_id').attr('disabled', true)
        }
    })
    $('#formAddTax').validate({
        rules: {
            nama_pajak: {
                required: true,
            },
            btype_pajak: {
                required: true,
            },
            // barang_id: {
            //     required: true,
            // },
            persentase_pajak: {
                required: true,
                number: true,
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
                nama_pajak : $('#nama_pajak').val(),
                type_pajak : $('#type_pajak').val(),
                barang_id : $('#barang_id').val(),
                persentase_pajak : $('#persentase_pajak').val(),
            }
            const url = URL_API + "/managements/add/pajak"
            Functions.prototype.postRequest(postData, url, data)
        }
    })
}

const postData = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getAll.loadData = ""
        $('#formAddTax')[0].reset()
        $('#nama_pajak').removeClass('is-valid')
        $('#barang_id').removeClass('is-valid')
        $('#persentase_pajak').removeClass('is-valid')
        $('#addTax').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function updateTax() {
    $('#listTaxes, #taxUniv').on('click', 'tr td div .edit, div .edit', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const url = URL_API + "/managements/pajak/" + id
        Functions.prototype.requestDetail(detailTax, url)
    })
    $('#type_pajak_update').on('change', function(e) {
        if ($('#type_pajak_update').val() === 'universal') {
            $('#barang_id_update').attr('disabled', true)
        } else {
            $('#barang_id_update').removeAttr('disabled', true)
        }
    })
    $('#formUpdateTax').validate({
        rules: {
            nama_pajak_update: {
                required: true,
            },
            // barang_id_update: {
            //     required: true,
            // },
            persentase_pajak_update: {
                required: true,
                number: true,
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
                nama_pajak : $('#nama_pajak_update').val(),
                type_pajak : $('#type_pajak_update').val(),
                barang_id : $('#type_pajak_update').val() == 'lokal' ? $('#barang_id_update').val() : null,
                persentase_pajak : $('#persentase_pajak_update').val(),
            }          
            const url = URL_API + "/managements/update/pajak/" + $('#idTax').val()
            Functions.prototype.putRequest(putData, url, data)
        }
    })
}

const putData = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getAll.loadData = ""
        $('#formUpdateTax')[0].reset()
        $('#nama_barang_update').removeClass('is-valid')
        $('#barang_id_update').removeClass('is-valid')
        $('#pajak_persentase_update').removeClass('is-valid')
        $('#updateTax').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const detailTax = {
    set successData(response) {
        $('#nama_pajak_update').val(response.nama_pajak)
        $('#type_pajak_update').val(response.type_pajak)
        $('#barang_id_update').val(response.barang_id)
        $('#persentase_pajak_update').val(response.persentase_pajak)
        $('#idTax').val(response.id)
        getProductById.loadData = response.barang_id
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function deleteTax() {  
    $('.table').on('click', 'tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        Swal.fire({
            title: 'Perhatian!',
            text: "Pajak akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = URL_API + "/managements/delete/pajak/" + id
                Functions.prototype.deleteData(url)
                getAll.loadData = ""
            }
        })
    })
}

