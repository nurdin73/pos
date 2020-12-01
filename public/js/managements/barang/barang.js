$(document).ready(function () {
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

  $('.pagination').on('click', '.page-item .page-link', function(e) {
    e.preventDefault()
    const id = $(this).data('id');
    if(query_params == "") {
      query_params = "?page=" + id
    } else {
      query_params += "&page=" + id
    }
    getListProducts.loadData = query_params
  })  
  addImage()
  addData()
  addCategory()
  delProduct()
  getCategory()
  typeHarga()

  $('#filteringData').on('submit', function(e) {
    e.preventDefault()
    query_params = ""
    query_params += "?" + $(this).serialize()
    getListProducts.loadData =  query_params
  })
  $('.btn-reset').on('click', function(e) {
    e.preventDefault()
    $('#filteringData')[0].reset()
    getListProducts.loadData = ""
  })

  getListProducts.loadData = "";
});

function validateFile(input) {  
  var fileType = ['.jpg', '.jpeg', '.png']
  var val = $(input).val()
  if (val.length > 0) {
      var fileValid = false
      for (let i = 0; i < fileType.length; i++) {
          const element = fileType[i];
          if(val.substr(val.length - element.length, element.length).toLowerCase() == element.toLowerCase()) {
              fileValid = true
              // break
          }
      }

      if(!fileValid) {
          toastr.warning("Type file tidak valid", 'perhatian!')
          $('.custom-file-label').text("Choose file")
          $(input).val("")
          return false
      }
  }
  return true
}

function addImage() {
  $('.custom-file-input').on('change', function(e) {
    $('.pgwSlider').empty()
    if(validateFile($(this))) {
      const files = document.getElementById('inputGroupFile01').files
      const nextSibling = e.target.nextElementSibling
      if(files.length > 1) {
        nextSibling.innerHTML = `${files.length} photo dipilih`
      } else {
        nextSibling.innerHTML = files[0].name
      }
      Functions.prototype.readURL(files)
    }
  })
}

function addData() {
  $('#formAddbarang').validate({
    rules: {
      kode_barang: {
        required : true
      },
      nama_barang: {
        required : true
      },
      type_barang: {
        required : true
      },
      stok: {
        required : true,
        number : true
      },
      harga_dasar: {
        required : true,
        number : true
      },
      harga_jual: {
        required : true,
        number : true
      },
      files: {
        required: true,
        accept: "image/jpeg, image/png, image/jpg"
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
      const urlPostBarang = URL_API + "/managements/add/barang"
      const formData = new FormData()
      const data = {
        suplier_id: $('#suplier_id').val(),
        nama_barang: $('#nama_barang').val(),
        type_barang: $('#type_barang').val(),
        stok: $('#stok').val(),
        harga_dasar: $('#harga_dasar').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        satuan: showAll ? $('#satuan').val() : "",
        diskon: showAll ? $('#diskon').val() : "",
        rak: showAll ? $('#rak').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
        kode_barang: $('#kode_barang').val(),
        typeHarga: typeHargaAdd,
        nama_agen: showAll ? (typeHargaAdd ? $('input[name^=nama_agent]').map((id, el) => { return $(el).val() }).get() : "") : "",
        harga: showAll ? (typeHargaAdd ? $('input[name^=type_harga]').map((id, el) => { return $(el).val() }).get() : "") : "",
      }
      const files = $('.custom-file-input')[0].files
      formData.append('nama_barang', data.nama_barang)
      formData.append('type_barang', data.type_barang)
      formData.append('stok', data.stok)
      formData.append('harga_dasar', data.harga_dasar)
      formData.append('harga_jual', data.harga_jual)
      formData.append('kategori', data.kategori)
      formData.append('berat', data.berat)
      formData.append('satuan', data.satuan)
      formData.append('diskon', data.diskon)
      formData.append('rak', data.rak)
      formData.append('keterangan', data.keterangan)
      formData.append('typeHarga', data.typeHarga)
      formData.append('nama_agen', data.nama_agen)
      formData.append('harga', data.harga)
      formData.append('kode_barang', data.kode_barang)
      formData.append('suplier_id', data.suplier_id)
      for (let i = 0; i < files.length; i++) {
        const element = files[i];
        formData.append('files[]', element)
      }
      const sendData = Functions.prototype.uploadFile(urlPostBarang, formData, 'post')
    }
  })
}

function addCategory() {
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
}

function getCategory() {
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
}

function delProduct() {
  $('#dataTables').on('click', 'tbody tr td .delete', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const urlDeleteProduct = URL_API + "/managements/delete/barang/" + id
    Swal.fire({
      title: 'Yakin ingin menghapus produk ini?',
      text: "produk akan dihapus permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $(this).parent().remove()
        Functions.prototype.deleteData(urlDeleteProduct);
        setTimeout(() => {
          window.location.reload()
        }, 3000);
      }
    })
  })
}

const getListProducts = {
  set loadData(data) {
    const urlListProd = URL_API + "/managements" + data
    Functions.prototype.getRequest(getListProducts, urlListProd)
  },
  set successData(response) {
    $('#listProducts').empty()
    const { current_page, last_page, prev_page_url, data, to, from, total } = response
    if(data.length > 0) {
      data.map(result => {
        var stocks = 0
        var harga_dasar = 0
        result.stocks.map(dataStok => {
          stocks += dataStok.stok
          harga_dasar = dataStok.harga_dasar
        })
        $('#listProducts').append(`
          <tr>
            <td>${result.kode_barang}</td>
            <td>${result.nama_barang}</td>
            <td>${stocks}</td>
            <td>${Functions.prototype.formatRupiah(harga_dasar.toString(), 'Rp. ')}</td>
            <td>${Functions.prototype.formatRupiah(result.harga_jual.toString(), 'Rp. ')}</td>
            <td>
              <div class="btn-group">
                <a href="${BASE_URL_ADMIN}/management/barang/edit/${result.id}" class='btn btn-info btn-sm'>Update</a>
                <a href="${BASE_URL_ADMIN}/management/barang/detail/${result.id}" class='btn btn-primary btn-sm'>Detail</a>
                <button class='btn btn-sm btn-danger delete' data-id="${result.id}">Delete</button>
              </div>
            </td>
          </tr>
        `)
      })
    } else {
      $('#listProducts').append(`
        <tr>
          <td colspan="6" align="center">Data tidak ditemukan</td>
        </tr>
      `)
    }
    $('#fromData').text(from)
    $('#toData').text(to)
    $('#totalData').text(total)
    var paginations = ""
    paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
    $('.pagination').html(paginations)
    paginations = ""
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

function typeHarga() {
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
      typeHargaAdd = true
      const data = {
        agen: $('#nama_agen').val(),
        harga: $('#harga_type').val()
      }

      const listTypePriceTemplate = `<div class="border rounded p-2 mb-2 listTypeHarga">
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">Type : ${data.agen}</span>
        <input type="hidden" name="nama_agent[]" value="${data.agen}" />
        <button class="btn btn-sm btn-danger hapus">Hapus</button>
      </div>
      <div class="dropdown-divider"></div>
      <div class="row">
        <div class="col-3">
          1
        </div>
        <div class="col-9">
          <span id="harga">${Functions.prototype.formatRupiah(data.harga.toString(), 'Rp. ')}</span>
          <input type="hidden" name="type_harga[]" value="${data.harga}" />
        </div>
      </div>
    </div>`

    $('#listTypeHarga').append(listTypePriceTemplate)
    $('#typeHargaModal').modal('hide')
    $('#formTypeHarga')[0].reset()
    $('#nama_agen').removeClass('is-valid')
    $('#harga_type').removeClass('is-valid')
    }
  })

  $('#listTypeHarga').on('click', 'div div .hapus', function(e) {
    e.preventDefault()
    if(confirm('mau menghapus type harga?')) {
      $(this).parent().parent().remove()
    }
  })
}