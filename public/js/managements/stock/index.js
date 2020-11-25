var method = "tambah"
$(document).ready(function () {
  getListProducts.loadData = ""
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

});

function updateStok() {  
  $('#updateStok').on('click', function(e) {
    e.preventDefault()
    $('#detailStok').modal('hide')
    const id = $(this).data('id')
    console.log(id);
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
  })
}

const getDetailProduct = {
  set successData(response) {
    var stocks = 0
    var harga_dasar = 0
    response.stocks.map(result => {
      stocks += result.stok
      harga_dasar = result.harga_dasar
    })
    $('#imageProduct').attr('src', response.images != null ? BASE_URL + "/" + response.images[0].image : "https://demo.getstisla.com/assets/img/avatar/avatar-1.png")
    $('#nameProduct').text(response.nama_barang)
    $('#kodeProduct').text(response.kode_barang)
    $('#stokProduct').text(stocks - response.selled)
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