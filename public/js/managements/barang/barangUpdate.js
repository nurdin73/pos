var showAll = false
$(document).ready(function () {
    getDetail.loadData = id
    $('#addCategory').on('click', function(e) {
        $('#formAdd').slideToggle()
    })

    $('#btnShowOther').on('click', function(e) {
        if(showAll == true) {
            showAll = false
        } else {
            showAll = true
        }
        $('#showOther').slideToggle()
    })
    $('#submitCategory').on('click', function(e) {
        e.preventDefault()
        const nameCategory = $('#kategoriAdd').val()
        if(!nameCategory) return toastr.warning("Nama kategori tidak boleh kosong", 'perhatian!')
        const data = {
            name : nameCategory
        }
        const url = URL_API + "/managements/add/kategori"
        Functions.prototype.httpRequest(url, data, "post")
        $('#kategoriAdd').removeClass('is-valid').val('')
    })
    $('#kategori').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/categories",
            data: function (params) {
                return {
                    name: params.term,
                }
            },
            processResults: function(data, params) {
                return {
                    results: data.map(result => {
                        return {
                            text: result.name,
                            id: result.id
                        }
                    })
                }
            },
        }
    })
    $('#suplier').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/supliers",
            data: function (params) {
                return {
                    search_nama_suplier: params.term,
                }
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(result => {
                        return {
                            text: result.nama_suplier,
                            id: result.id
                        }
                    })
                }
            },
        }
    })
    $('#cabang').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/branch-stores",
            data: function (params) {
                return {
                    search_cabang: params.term,
                }
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(result => {
                        return {
                            text: result.nama_cabang,
                            id: result.id
                        }
                    })
                }
            },
        }
    })

    $('#addKode').on('submit', function (e) {  
        e.preventDefault()
        console.log($('#barcode').val());
    })
});

// functions

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/barang/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        $('#idProdPrice').val(response.id)
        $('#nama_barang').val(response.nama_barang)
        var option = response.suplier != null ? new Option(response.suplier.nama_suplier, response.suplier.id, true, true) : new Option("", "", true, true)
        $("#suplier").append(option).trigger('change')

        $("#suplier").trigger({
            type: 'select2:select',
            params: {
                data : response.suplier != null ? response.suplier.nama_suplier : ""
            }
        })
        var option2 = response.branch != null ? new Option(response.branch.nama_cabang, response.branch.id, true, true) : new Option("", "", true, true)
        $("#cabang").append(option2).trigger('change')

        $("#cabang").trigger({
            type: 'select2:select',
            params: {
                data : response.branch != null ? response.branch.nama_cabang : ""
            }
        })
        $('#type_barang').val(response.type_barang).trigger('change')
        $('#harga_jual').val(response.harga_jual)
        $('#kategori').val(response.kategori_id)
        $('#berat').val(response.berat)
        $('#satuan').val(response.satuan)
        $('#diskon').val(response.diskon)
        $('#keterangan').val(response.keterangan)
        $('#point').val(response.point)
        getKategoriById.loadData = response.kategori_id
        if(response.images.length > 0) {
            var listImage = ""
            response.images.map(image => {
                listImage += `
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <img src="${URL_IMAGE + "/" + image.image}" alt="${URL_IMAGE + "/" + image.image}" class="img-responsive img-fluid img-thumbnail">
                        <button class="btn btn-sm btn-danger delImage" data-image-id="${image.id}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`
            })
            $('#fieldUpload').before(listImage)
        }
        if(response.type_prices.length > 0) {
            $('#listTypeHarga').empty()
            response.type_prices.map(price => {
                $('#listTypeHarga').append(`
                <div class="border rounded p-2 mb-2 listTypeHarga">
                    <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Type : ${price.nama_agen}</span>
                    <input type="hidden" name="nama_agent[]" value="${price.nama_agen}" />
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success edit" data-id="${price.id}" data-toggle="modal" data-target="#updatePrice">Edit</button>
                        <button class="btn btn-sm btn-danger hapus" data-id="${price.id}">Hapus</button>
                    </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">
                    <div class="col-3">
                        1
                    </div>
                    <div class="col-9">
                        <span id="harga">${Functions.prototype.formatRupiah(price.harga.toString(), 'Rp. ')}</span>
                        <input type="hidden" name="type_harga[]" value="${price.harga}" />
                    </div>
                    </div>
                </div>
                `)
            })
        }
        
        if(response.code_products.data.length > 0) {
            $('#listCodeProduct').empty()
            response.code_products.data.map(result => {
                $('#listCodeProduct').append(`
                    <tr>
                        <td>${result.kode_barang}</td>
                        <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-danger" data-id="${result.id}">Hapus</button>
                            <button class="btn btn-sm btn-primary" data-id="${result.id}">Edit</button>
                        </div>
                        </td>
                    </tr>
                `)
            })
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getKategoriById = {
    set loadData(data) {
        var url_local = URL_API + "/managements/kategori/" + data
        Functions.prototype.requestDetail(getKategoriById, url_local)
    }, 
    set successData(result) {
        var option = new Option(result.name, result.id, true, true)
        $("#kategori").append(option).trigger('change')

        $("#kategori").trigger({
            type: 'select2:select',
            params: {
                data : data
            }
        })
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

$('.update-file').on('change', function(e) {
    e.preventDefault()
    const files = document.getElementById('updateFile').files
    const urlUpload = URL_API + "/managements/upload-image-product"

    Functions.prototype.uploadImage(files[0], urlUpload, id)
})

$('#fieldImage').on('click', 'div .delImage', function(e) {
    e.preventDefault()
    const image_id = $(this).data('image-id')
    const urlDeleteImage = URL_API + "/managements/delete-image-product/" + image_id
    Swal.fire({
      title: 'Yakin ingin menghapus gambar ini?',
      text: "gambar akan dihapus permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $(this).parent().remove()
        Functions.prototype.deleteData(urlDeleteImage);
      }
    })
})

$('#updateProduct').validate({
    rules: {
        nama_barang: {
            required : true
        },
        type_barang: {
            required : true
        },
        harga_jual: {
            required : true,
            number : true
        },
        kategori: {
            required : true
        },
        berat: {
            number: true
        },
        diskon: {
            number: true
        },
        satuan: {
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
      const urlUpdateProduct = URL_API + "/managements/update/barang/" + id
      const data = {
        suplier_id: $('#suplier').val() != null ? $('#suplier').val() : 0,
        cabang_id: $('#cabang').val() != null ? $('#cabang').val() : 0,
        nama_barang: $('#nama_barang').val(),
        type_barang: $('#type_barang').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        satuan: $('#satuan').val(),
        diskon: showAll ? $('#diskon').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
        point: showAll ? $('#point').val() : "",
      }
      Functions.prototype.updateData(urlUpdateProduct, data, 'put')
    }
})

$('#formTypeHarga').validate({
    rules: {
        nama_agen: {
            required: true,
        },
        harga_type: {
            required: true,
            number: true
        },
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
        e.preventDefault()
        const data = {
            product_id: $('#idProdPrice').val(),
            nama_agen: $('#nama_agen').val(),
            harga: $('#harga_type').val()
        }
        const urlPost = URL_API + "/managements/add/type-price"
        const postTypePrice = {
            set successData(response) {
                toastr.success(response.message, 'Success')
                setTimeout(() => {
                    window.location.reload()
                }, 500);
            },
            set errorData(err) {
                toastr.error(err.responseJSON.message, 'Error')
            }
        }
        Functions.prototype.postRequest(postTypePrice, urlPost, data)
    }
})

$('#listTypeHarga').on('click', 'div div .hapus', function(e) {
    e.preventDefault()
    const idPrice = $(this).data('id')
    const urlDelPrice = URL_API + "/managements/delete/type-price/" + idPrice
    Swal.fire({
        title: 'Perhatian?',
        text: "type harga akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).parent().parent().parent().remove()
            Functions.prototype.deleteData(urlDelPrice);
        }
    })
})
$('#listTypeHarga').on('click', 'div div .edit', function(e) {
    e.preventDefault()
    const idPrice = $(this).data('id')
    const urlDetailPrice = URL_API + "/managements/type-price/" + idPrice
    const detailPrice = {
        set successData(response) {
            $('#nama_agen_update').val(response.nama_agen)
            $('#harga_type_update').val(response.harga)
            $('#idProdPrice').val(response.id)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'Error')
        }
    }
    Functions.prototype.requestDetail(detailPrice, urlDetailPrice)
})

$('#formTypeHargaUpdate').validate({
    rules: {
        nama_agen_update: {
            required: true,
        },
        harga_type_update: {
            required: true,
            number: true,
            min: 0
        },
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
        e.preventDefault()
        const data = {
            nama_agen: $('#nama_agen_update').val(),
            harga: $('#harga_type_update').val()
        }
        const idPrice = $('#idProdPrice').val()
        const urlUpdatePrice = URL_API + "/managements/update/type-price/" + idPrice
        Functions.prototype.updateData(urlUpdatePrice, data, 'put')
        setTimeout(() => {
            window.location.reload()
        }, 500);
    }
})

