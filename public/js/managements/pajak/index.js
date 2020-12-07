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
    updateSuplier()
    deleteSuplier()
    getProduct()
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
            data.map(tax => {
                $('#listTaxes').append(`
                    <tr>
                        <td>${tax.nama_pajak}</td>
                        <td>${tax.barang_id}</td>
                        <td>${tax.persentase_pajak + "%"}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#updateSuplier" data-id="${tax.id}"><i class="fa fa-edit"></i></button>
                                
                                <button class="btn btn-sm btn-danger delete" data-id="${tax.id}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `)
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
        } else {
            $('#listTaxes').append(`
                <tr>
                    <td colspan="4" align="center">Tidak ada suplier</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function addTax() {
    $('#formAddTax').validate({
        rules: {
            nama_pajak: {
                required: true,
            },
            // nama_barang: {
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
                barang_id : $('#barang_id').val() != null ? $('#barang_id').val() : 1,
                persentase_pajak : $('#persentase_pajak').val(),
            }
            const url = URL_API + "/managements/add/pajak"
            Functions.prototype.postRequest(postData, url, data)
        }
    })
}

function getProduct() {
    $('#barang_id').select2({
      theme:'bootstrap4',
      ajax: {
        url: URL_API + "/managements",
        data: function (params) {
          return {
            Search_kode_barang: params.term,
          }
        },
        processResults: function(response, params) {
          return {
            results: response.data.map(result => {
              return {
                text: result.kode_barang + " - " + result.nama_barang,
                id: result.id
              }
            })
          }
        },
      }
    })
  }

const postData = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getAll.loadData = ""
        $('#formAddSuplier')[0].reset()
        $('#no_telp').removeClass('is-valid')
        $('#email_suplier').removeClass('is-valid')
        $('#alamat').removeClass('is-valid')
        $('#nama_suplier').removeClass('is-valid')
        $('#addSuplier').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function updateSuplier() {
    $('#listSupliers').on('click', 'tr td div .edit', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const url = URL_API + "/managements/suplier/" + id
        Functions.prototype.requestDetail(detailSuplier, url)
    })
    $('#formUpdateSuplier').validate({
        rules: {
            nama_suplier_update: {
                required: true,
            },
            email_suplier_update: {
                email: true,
            },
            no_telp_update: {
                required: true,
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
                nama_suplier : $('#nama_suplier_update').val(),
                email : $('#email_suplier_update').val() != null ? $('#email_suplier_update').val() : "",
                no_telp : $('#no_telp_update').val(),
                alamat : $('#alamat_update').val(),
            }
            const url = URL_API + "/managements/update/suplier/" + $('#idSuplier').val()
            Functions.prototype.putRequest(putData, url, data)
        }
    })
}

const putData = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getAll.loadData = ""
        $('#formUpdateSuplier')[0].reset()
        $('#no_telp_update').removeClass('is-valid')
        $('#email_suplier_update').removeClass('is-valid')
        $('#alamat_update').removeClass('is-valid')
        $('#nama_suplier_update').removeClass('is-valid')
        $('#updateSuplier').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const detailSuplier = {
    set successData(response) {
        $('#nama_suplier_update').val(response.nama_suplier)
        $('#email_suplier_update').val(response.email)
        $('#no_telp_update').val(response.no_telp)
        $('#alamat_update').val(response.alamat)
        $('#idSuplier').val(response.id)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function deleteSuplier() {  
    $('#listSupliers').on('click', 'tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        Swal.fire({
            title: 'Perhatian!',
            text: "Suplier akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = URL_API + "/managements/delete/suplier/" + id
                Functions.prototype.deleteData(url)
                getAll.loadData = ""
            }
        })
    })
}

