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
});

// functions

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/barang/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        $('#nama_barang').val(response.nama_barang)
        $('#type_barang').val(response.type_barang).trigger('change')
        $('#kode-barang').text(response.kode_barang)
        $('#harga_jual').val(response.harga_jual)
        $('#kategori').val(response.kategori_id)
        $('#berat').val(response.berat)
        $('#satuan').val(response.satuan).trigger('change')
        $('#diskon').val(response.diskon)
        $('#rak').val(response.rak)
        $('#keterangan').val(response.keterangan)
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
    },
    set errorData(err) {
        console.log(err);
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
        console.log(err);
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
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
      e.preventDefault()
      const urlUpdateProduct = URL_API + "/managements/update/barang/" + id
      const data = {
        nama_barang: $('#nama_barang').val(),
        type_barang: $('#type_barang').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        satuan: showAll ? $('#satuan').val() : "",
        diskon: showAll ? $('#diskon').val() : "",
        rak: showAll ? $('#rak').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
      }
      Functions.prototype.updateData(urlUpdateProduct, data, 'put')
    }
})