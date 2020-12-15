var method = "tambah"
$(document).ready(function () {
  getListProducts.loadData = ""
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

  $('.stats').on('change', function(e) {
    e.preventDefault()
    const val = $(this).val()
    method = val
    if(val == "kurangi") {
      $('#harga_dasar').parent().parent().hide()
      $('#jumlah').parent().parent().removeClass('col-6').addClass('col-12')
    } else {
      $('#harga_dasar').parent().parent().show()
      $('#jumlah').parent().parent().removeClass('col-12').addClass('col-6')
    }
  })

  updateStok()
  detailStok()
  updateStokForm()
  showStok()
  editHistoryStok()
  updateFormStok()
  deleteStok()
});

function updateStok() {  
  $('#updateStok').on('click', function(e) {
    e.preventDefault()
    $('#detailStok').modal('hide')
    const id = $(this).data('id')
  })
}
function showStok() {  
  $('#showStok').on('click', function(e) {
    e.preventDefault()
    $('#detailStok').modal('hide')
    const id = $(this).data('id')
    const url = URL_API + "/managements/stocks/" + id
    Functions.prototype.requestDetail(getListStok, url)
  })

  const getListStok = {
    set successData(response) {
      $('.listStok').empty()
      var modal = 0
      if(response.length > 0) {
        response.map((result, i) => {
          modal += result.harga_dasar * result.stok
          if(i == 0) {
            $('.listStok').append(`
                <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-muted">Tanggal masuk</small>
                  <span class="text-uppercase font-weight-bold">${moment(result.tgl_update).format('D MMM YYYY')}</span>
                  <small class="text-muted">Sisa Stok</small>
                  <span class="text-uppercase font-weight-bold">${result.stok}</span>
                </div>
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <small class="text-muted">Harga dasar</small>
                  <span class="text-uppercase font-weight-bold">${Functions.prototype.formatRupiah(result.harga_dasar.toString(), 'Rp. ')}</span>
                </div>
              </div>
              <div class="dropdown-divider"></div>
            `)
          } else {
            $('.listStok').append(`
                <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-muted">Tanggal masuk</small>
                  <span class="text-uppercase font-weight-bold">${moment(result.tgl_update).format('D MMM YYYY')}</span>
                  <small class="text-muted">Sisa Stok</small>
                  <span class="text-uppercase font-weight-bold">${result.stok}</span>
                </div>
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <div class="btn-group">
                    <button class="btn btn-success btn-sm edit" data-id="${result.id}" data-toggle="modal" data-target="#updateStokHistory">Edit</button>
                    <button class="btn btn-danger btn-sm hapus" data-id="${result.id}">Hapus</button>
                  </div>
                  <small class="text-muted">Harga dasar</small>
                  <span class="text-uppercase font-weight-bold">${Functions.prototype.formatRupiah(result.harga_dasar.toString(), 'Rp. ')}</span>
                </div>
              </div>
              <div class="dropdown-divider"></div>
            `)
          }
        }) 
      } else {
        $('.listStok').append(`
        <div class="alert alert-primary">
          Stok tidak ada
        </div>
        `)
      }
      $('#modal').text(Functions.prototype.formatRupiah(modal.toString(), 'Rp. '))
    },
    set errorData(err) {
      toastr.error(err.responseJSON.message, "Error")
    }
  }
}

function editHistoryStok() {
  $('.listStok').on('click', 'div div .edit', function (e) {
    e.preventDefault()
    $('#listStokHistory').modal('hide')
    const id = $(this).data('id')
    const url = URL_API + "/managements/stok-detail/" + id
    Functions.prototype.requestDetail(getHistoryStok, url)
  })

  const getHistoryStok = {
    set successData(response) {
      $('#idStok').val(response.id)
      $('#harga_dasar_history').val(response.harga_dasar)
      $('#jumlah_history').val(response.stok)
    },
    set errorData(err) {
      toastr.error(err.responseJSON.message, 'Error')
    }
  }
}

function deleteStok() {  
  $('.listStok').on('click', 'div div .hapus', function (e) {
    e.preventDefault()
    const id = $(this).data('id')
    Swal.fire({
      title: 'Perhatian?',
      text: "Stok akan dihapus permanen",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $(this).parent().remove()
        const url = URL_API + "/managements/delete/stok/" + id
        Functions.prototype.deleteData(url)
        setTimeout(() => {
          window.location.reload()
        }, 3000);
      }
    })
  })
}

function updateFormStok() {  
  $('#updateStokHistoryForm').validate({
    rules: {
      harga_dasar_history: {
        required: true,
        number: true,
        min: 0
      },
      jumlah_history: {
        required: true,
        number: true,
        min: 0
      },
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
      const url = URL_API + "/managements/update/stok-history/" + $('#idStok').val()
      const data = {
        harga_dasar: $('#harga_dasar_history').val(),
        stok: $('#jumlah_history').val(),
      }
      Functions.prototype.httpRequest(url, data, 'put')
      $('#updateStokHistoryForm')[0].reset()
      $('#updateStokHistory').modal('hide')
      $('#harga_dasar_history').removeClass('is-valid')
      $('#jumlah_history').removeClass('is-valid')
      getListProducts.loadData = ""
    }
  })
}

function detailStok() {
  $('#listProducts').on('click', 'tr td .detail', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const url = URL_API + "/managements/barang/" + id
    Functions.prototype.requestDetail(getDetailProduct, url)
  })
}

function updateStokForm() {
  $('#updateStokForm').on('submit', function(e) {
    e.preventDefault()
    const id = $('#idProd').val()
    const url = URL_API + "/managements/update/stok/" + id
    const data = {
      harga_dasar: method == "tambah" ? $('#harga_dasar').val() : 0,
      jumlah: $('#jumlah').val(),
      method: method
    }
    Functions.prototype.updateData(url, data, 'put')
    $('#changeStok').modal('hide')
    $(this)[0].reset()
    getListProducts.loadData = ""
  })
}

const getDetailProduct = {
  set successData(response) {
    var stocks = 0
    var harga_dasar = 0
    if(response.stocks.length > 0) {
      response.stocks.map(result => {
        stocks += result.stok
        harga_dasar = result.harga_dasar
      })
    } 
    $('#imageProduct').attr('src', response.images != null ? BASE_URL + "/" + response.images[0].image : "https://demo.getstisla.com/assets/img/avatar/avatar-1.png")
    $('#nameProduct').text(response.nama_barang)
    $('#kodeProduct').text(response.kode_barang)
    $('#stokProduct').text(stocks)
    $('#hargaDasar').text(Functions.prototype.formatRupiah(harga_dasar.toString(), 'Rp. '))
    $('#updateStok').data('id', response.id)
    $('#showStok').data('id', response.id)
    $('#harga_dasar').val(harga_dasar)
    $('#idProd').val(response.id)
  }, 
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

const getListProducts = {
  set loadData(data) {
    const urlListProd = URL_API + "/managements" + data
    Functions.prototype.getRequest(getListProducts, urlListProd)
  },
  set successData(response) {
    $('#listProducts').empty()
    const { data, currentPage, pagination } = response
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
                <button class='btn btn-sm btn-primary btn-block detail' data-id="${result.id}" data-toggle="modal" data-target="#detailStok">Detail</button>
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
    var paginations = ""
    paginations = pagination
    $('.paginate').html(paginations)
    $('.paginate').find('a').each(function() {
      if($(this).text() === '‹'){
        $(this).attr('data-id', currentPage - 1);
      }else if($(this).text() === '›'){
        $(this).attr('data-id', currentPage + 1);
      }else{
        $(this).attr('data-id', $(this).html());
      }
    })
    paginations = ""
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message)
  }
}