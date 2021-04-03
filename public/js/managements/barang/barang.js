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

  $('#eceranOpsi').change(function(e) {
    var checked = $('input[name=eceranOpsi]:checked').length
    if(checked <= 0) {
      $('#showEceran').fadeOut()
    } else {
      $('#showEceran').fadeIn()
    }
  })

  $('.paginate').on('click', '.pagination .page-item a', function(e) {
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
  getSuplier()
  addCodeBarang()
  getCabang()

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

function addCodeBarang() {
  $('#formKodeBarang').on('submit', function(e) {
    const values = $('#inputCodeBarang').val()
    const valueBefore = $('#kode_barang').val() + ","
    $('#kode_barang').val(valueBefore + values)
    $('#modalKodeBarang').modal('hide')
    $('#inputCodeBarang').val('')
  })
}

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
      satuan: {
        required: true,
      },
      harga_dasar: {
        required : true,
        number : true
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
        number: true,
      },
      point: {
        number: true,
        min: 0,
      },
      jumlah_persatuan: {
        number: true,
        min: 1,
      },
      harga_persatuan: {
        number: true,
        min: 0
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
      const kode_barang = $('#kode_barang').val().split(',')
      const filteringkodebarang = []
      $.each(kode_barang, function(i, el) {
        if(el != "") {
          if($.inArray(el, filteringkodebarang) === -1) filteringkodebarang.push(el)
        }
      })
      const urlPostBarang = URL_API + "/managements/add/barang"
      const formData = new FormData()
      const data = {
        suplier_id: $('#suplier_id').val() != null ? $('#suplier_id').val() : 0,
        cabang_id: $('#cabang_id').val() != null ? $('#cabang_id').val() : 0,
        nama_barang: $('#nama_barang').val(),
        satuan: $('#satuan').val(),
        type_barang: $('#type_barang').val(),
        stok: $('#stok').val(),
        harga_dasar: $('#harga_dasar').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        diskon: showAll ? $('#diskon').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
        point: showAll ? $('#point').val() : 0,
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
      formData.append('keterangan', data.keterangan)
      formData.append('typeHarga', data.typeHarga)
      formData.append('nama_agen', data.nama_agen)
      formData.append('harga', data.harga)
      // formData.append('kode_barang', data.kode_barang)
      for (let i = 0; i < filteringkodebarang.length; i++) {
        const element = filteringkodebarang[i];
        formData.append('kode_barang[]', element)
      }
      formData.append('suplier_id', data.suplier_id)
      formData.append('cabang_id', data.cabang_id)
      formData.append('point', data.point)
      for (let i = 0; i < files.length; i++) {
        const element = files[i];
        formData.append('files[]', element)
      }
      var checked = $('input[name=eceranOpsi]:checked').length
      if(checked > 0) {
        formData.append('isRetail', checked)
        formData.append('jumlah', $('#jumlah_persatuan').val())
        formData.append('harga_satuan', $('#harga_persatuan').val())
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

function getSuplier() {
  $('#suplier_id').select2({
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
}
function getCabang() {
  $('#cabang_id').select2({
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
    $('.paginate').empty()
    $('#listProducts').empty()
    const { data, currentPage, pagination } = response
    if(data.length > 0) {
      data.map(result => {
        var stocks = 0
        var harga_dasar = 0
        result.stocks.map(dataStok => {
          stocks += parseInt(dataStok.stok)
          harga_dasar = dataStok.harga_dasar
        })
        $('#listProducts').append(`
          <tr>
            <td>${result.nama_barang}</td>
            <td>${result.isRetail == 1 ? `${stocks - 1}(${result.jumlah})` : stocks}</td>
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
    $('.paginate').html(pagination)
    $('.paginate').find('a').each(function() {
      if($(this).text() === '‹'){
        $(this).attr('data-id', currentPage - 1);
      }else if($(this).text() === '›'){
        $(this).attr('data-id', currentPage + 1);
      }else{
        $(this).attr('data-id', $(this).html());
      }
    })
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