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
      for (let i = 0; i < files.length; i++) {
        const element = files[i];
        formData.append('files[]', element)
      }
      const sendData = Functions.prototype.uploadFile(urlPostBarang, formData, 'post')
      console.log(sendData);
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
        $('#listProducts').append(`
          <tr>
            <td>${result.kode_barang}</td>
            <td>${result.nama_barang}</td>
            <td>${result.stok}</td>
            <td>${result.harga_dasar}</td>
            <td>${result.harga_jual}</td>
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
    console.log(err);
  }
}