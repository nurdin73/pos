$(document).on('keydown', function(e) {
  if(e.ctrlKey == true) {
    if(e.which == 88) {
      diskonTransaksi()
    } else if(e.which == 89) {
      $('#barcode').focus()
    } else if(e.which == 13) {
      processPayment(e)
    } else if(e.which == 67) {
      cancelOrder(e)
    }
  }
})


function diskonTransaksi() {
  const grandTotal = $('#grandTotal').val()
  const diskonValue = $('#diskonValue').val()
  if(grandTotal < 1 && diskonValue == 0) {
    Swal.fire({
      text: 'isi barang terlebih dahulu',
      title: 'perhatian!',
      icon: 'warning'
    })
  } else {
    Swal.fire({
      title: 'Masukkan diskon transaksi',
      input: 'number',
      inputAttributes: {
        autocapitalize: 'off',
      },
      inputValue: $('#diskonValue').val(),
      showCancelButton: true,
      confirmButtonText: 'Simpan',
      showLoaderOnConfirm: true,
      preConfirm: (diskon) => {
        if(diskon > $('#subTotal').val()) {
          Swal.showValidationMessage(
            `Jumlah diskon melebihi total pembelian`
          )
        } else {
          return diskon
        }
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        const grandTotal = $('#subTotal').val() - result.value
        $('#diskonTrxLabel').text(Functions.prototype.formatRupiah(result.value.toString(), 'Rp. '))
        $('.grand_total').text(Functions.prototype.formatRupiah(grandTotal.toString(), 'Rp. '))
        $('#grandTotal').val(grandTotal)
        $('#diskonValue').val(result.value)
      }
    })
  }
}

$(function () {
  getCarts.loadData = noInvoice
  $('#btn-proccess-payment').on('click', processPayment)
  $('#cancelOrder').on('click', cancelOrder)
  eceran()
  updateCart()
  customerFunc()
  deleteCart()
  $('#listCarts').on('click', 'tr td .update', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const urlDetail = URL_API + "/managements/cart/" + id
    Functions.prototype.requestDetail(detailCart, urlDetail)
  })
});

function customerFunc() {
  var option = new Option("Umum", 0, true, true)
  $("#customer").append(option).trigger('change')
  $("#customer").trigger({
    type: 'select2:select',
    params: {
      name : null
    }
  })
  $('#customer').select2({
    theme:'bootstrap4',
    ajax: {
      url: URL_API + "/managements/search-pelanggan",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Authorization' : "Bearer " + sessionStorage.getItem('token')
      },
      data: function (params) {
        return {
          name: params.term,
        }
      },
      processResults: function(data, params) {
        return {
          results: data.map(result => {
            return {
              text: result.nama,
              id: result.id
            }
          })
        }
      },
    }
  })
}


const detailCart = {
  set successData(response) {
    var fieldInput = "";
    const typePrices = response.product.type_prices
    fieldInput += `<input type="hidden" name="id_cart" id="idCart" value="${response.id}">`
    if(typePrices.length > 0) {
      fieldInput += `<div class="form-group row">`
      fieldInput += `<label for="harga_barang_update" class="col-sm-4 col-form-label">Harga Barang</label>`
      fieldInput += `<div class="col-sm-8">`
      fieldInput += `<select name="harga_barang_update" id="harga_barang_update" class="custom-select" data-id-cart="${response.id}">`
      typePrices.map(result => {
        if(response.harga_product == result.harga) {
          fieldInput += `<option value="${result.harga}" selected>${result.harga} - ${result.nama_agen}</option>`
        } else {
          fieldInput += `<option value="${result.harga}">${result.harga} - ${result.nama_agen}</option>`
        }
      })
      if(response.harga_product == response.product.harga_jual) {
        fieldInput += `<option value="${response.product.harga_jual}" selected>${response.product.harga_jual} - default</option>`
      } else {
        fieldInput += `<option value="${response.product.harga_jual}">${response.product.harga_jual} - default</option>`
      }
      fieldInput += `</select>`
      fieldInput += `</div>`
      fieldInput += `</div>`
    } else {
      fieldInput += `
      <div class="form-group row">
        <label for="harga_barang_update" class="col-sm-4 col-form-label">Harga Barang</label>
        <div class="col-sm-8">
          <input type="text" id="harga_barang_update" name="harga_barang_update" class="form-control" value="${response.harga_product}" readonly>
        </div>
      </div>
      `
    }
    fieldInput += `
      <div class="form-group row">
        <label for="qty_barang" class="col-sm-4 col-form-label">Qty</label>
        <div class="col-sm-8">
          <input type="number" name="qty_barang" class="form-control" id="qyt_update" value="${response.qyt}">
        </div>
      </div>
      <div class="form-group row">
        <label for="diskon_update" class="col-sm-4 col-form-label">Diskon barang</label>
        <div class="col-sm-8">
          <input type="number" class="form-control" id="diskon_update" value="${response.diskon_product}">
        </div>
      </div>
    `
    const title = response.product.nama_barang.length > 20 ? response.product.nama_barang.substr(0, 20) + "..." : response.product.nama_barang
    $('#namaBarangLabel').text(title)
    $('#idCart').val(response.id)

    $('#fieldUpdateCartForm').html(fieldInput)
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

function updateCart() {
  $('#formUpdateCart').on('submit', async function(e) {
    e.preventDefault()
    const id = $('#idCart').val()
    const url = URL_API + "/managements/update/cart/" + id
    const data = {
      qyt: $('#qyt_update').val(),
      diskon_product: $('#diskon_update').val(),
      harga_product: $('#harga_barang_update').val()
    }
    Functions.prototype.updatingData(url, data, 'put')
    await new Promise(resolve => setTimeout(resolve, 500))
    getCarts.loadData = noInvoice
    $('#formUpdateCart')[0].reset()
    $('#editCartModal').modal('hide')
  })
}


$('#barcode').on('keydown', function(e) {
  if(e.ctrlKey == false) {
    if(e.keyCode == 13) {
      const kode = $('#barcode').val()
      const no_invoice = noInvoice
      const data = {
        kode: kode,
        no_invoice: no_invoice
      }
      addDataCart.loadData = data
    }
  }
})

const addDataCart = {
  set loadData(data) {
    const url = URL_API + "/managements/add/cart"
    Functions.prototype.postRequest(addDataCart, url, data)
  },
  set successData(response) {
    toastr.success(response.message, 'Success')
    getCarts.loadData = response.no_invoice
    $('#barcode').val('')
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'error')
    $('#barcode').val('')
  }
}

function cancelOrder(e) {
  e.preventDefault()
  const grandTotal = $('#grandTotal').val()
  if(grandTotal < 1) {
    Swal.fire({
      text: 'Transaksi masih kosong. silahkan tambahkan terlebih dahulu',
      title: 'perhatian!',
      icon: 'warning'
    })
  } else {
    Swal.fire({
      title: 'Apa kamu yakin?',
      text: `transaksi dengan kode ${noInvoice} akan dihapus!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yakin'
    }).then((result) => {
      if (result.isConfirmed) {
        const urlCancelOrder = URL_API + "/managements/delete/transaksi/" + noInvoice
        Functions.prototype.deleteingData(processCancelOrder, urlCancelOrder)
      }
    })
  }

  const processCancelOrder = {
    set successData(response) {
      Swal.fire(
        'Berhasil!',
        response.message,
        'success'
      )
      getCarts.loadData = noInvoice
    }, 
    set errorData(err) {
      toastr.error(err.responseJSON.message, 'Error')
    }
  }

}

function deleteCart() {
  $('#listCarts').on('click', 'tr td .delete', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    Swal.fire({
      title: 'Perhatian?',
      text: "Yakin ingin menghapus produk ini",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        const url = URL_API + "/managements/delete/cart/" + id
        Functions.prototype.deleteingData(prosessDeletingData, url)
      }
    })
  })

  const prosessDeletingData = {
    set successData(response) {
      toastr.success(response.message, 'Success')
      getCarts.loadData = noInvoice
    },
    set errorData(err) {
      toastr.error(err.responseJSON.message, 'Error')
    }
  }
}


const getCarts = {
  set loadData(data) {
    const url = URL_API + "/managements/carts/" + data
    Functions.prototype.requestDetail(getCarts, url)
  },
  set successData(response) {
    var subTotal = 0
    $('#listCarts').empty()
    if(response.length > 0) {
      var x = 1
      response.map((result, i) => {
        var hargaAsal = result.harga_product,
          totalDiskon = result.diskon_product * result.qyt,
          totalHargaProduk = (result.qyt * hargaAsal) - totalDiskon,
          pajak = totalHargaProduk * (persentasePajak / 100)
        const layanan = totalHargaProduk * (persentaseLayanan / 100)
        const typeHarga = result.product.type_prices
        subTotal += totalHargaProduk
        const total = subTotal
        const title = result.product.nama_barang.length > 20 ? result.product.nama_barang.substr(0, 20) + "..." : result.product.nama_barang
        $('#pajak').val(pajak)
        $('#listCarts').append(`
          <tr>
            <td class="text-center">${x++}</td>
            <td><a herf="#" data-toggle="modal" data-id="${result.id}" class="update" data-target="#editCartModal"><span class="text-primary" data-toggle="tooltip" data-placement="top" title="Klik disini untuk edit" style="cursor: pointer">${title}</span></a></td>
            <td class="text-center" style="width: 10%"><span class="text-success">${Functions.prototype.formatRupiah(hargaAsal.toString(), '')}</span> x <span class="text-danger">${result.qyt}</span></td>
            <td>
              <div class="custom-control custom-switch">
                <input type="checkbox" ${hargaAsal == result.product.harga_satuan ? "checked" : ""} class="custom-control-input eceran" data-id="${result.id}" data-harga-eceran="${result.product.harga_satuan}" data-harga-jual="${result.product.harga_jual}" name="eceranOpsi${result.id}" id="eceranOpsi${result.id}" ${result.product.isRetail == 0 ? "disabled" : ""}>
                <label class="custom-control-label" for="eceranOpsi${result.id}">Ya</label>
              </div>
            </td>
            <td>
              <button class="badge badge-danger border-0 delete" data-id="${result.id}" style="outline: none;"><i class="fas fa-times"></i></button>
            </td>
          </tr>
        `)
      })
      $('[data-toggle="tooltip"]').tooltip()
    } else {
      $('#listCarts').html(`
        <tr>
          <td colspan="5" align="center">keranjang masih kosong</td>
        </tr>
      `)
    }

    $('.subTotalBadge').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#subTotal').val(subTotal)
    $('.grand_total').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#grandTotal').val(subTotal)
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

function eceran() {
  $('#listCarts').on('change', 'tr td div .eceran', async function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const check = $(`input[name=eceranOpsi${id}]:checked`).length
    const urlUpdatePrice = URL_API + "/managements/update/price-cart/" + id
    if(check > 0) {
      const data = {
        price: $(this).data('harga-eceran'),
        eceran: 1
      }
      Functions.prototype.updatingData(urlUpdatePrice, data, 'put')
    } else {
      const data = {
        price: $(this).data('harga-jual'),
        eceran: 0
      }
      Functions.prototype.updatingData(urlUpdatePrice, data, 'put')
    }
    await new Promise(resolve => setTimeout(resolve, 500));
    getCarts.loadData = noInvoice
  })
}

function processPayment(e) {  
  e.preventDefault()
  const idUser = idUserInput
  const customer = $('#customer').val() == "" ? "0" : $('#customer').val();
  const grandTotal = $('#grandTotal').val()
  const diskon = $('#diskon').val()
  const no_invoice = noInvoice
  const keterangan = $('#keterangan').val()
  const cash = $('#fieldCash').val()
  const change = cash - grandTotal
  const pajak = $('#pajak').val()
  if(grandTotal < 1) {
    Swal.fire({
      text: 'isi barang terlebih dahulu',
      title: 'perhatian!',
      icon: 'warning'
    })
  } else {
    Swal.fire({
      title: `Total belanja ${Functions.prototype.formatRupiah(grandTotal, 'Rp.')}`,
      input: 'text',
      inputAttributes: {
        placeholder: 'Masukkan jumlah uang',
      },
      text: `Pastikan jumlah uang sudah benar`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Benar!',
      showLoaderOnConfirm: true,
      preConfirm: (totalUang) => {
        const urlAddTransaction = URL_API + "/managements/add/transaction"
        const data = {
          createdBy: idUser,
          no_invoice: no_invoice,
          customer_id: customer,
          diskon_transaksi: diskon != "" ? diskon : 0,
          keterangan: keterangan,
          total: grandTotal,
          cash: totalUang,
          change: totalUang - grandTotal,
          pajak: pajak
        }
        return fetch(urlAddTransaction, {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization' : "Bearer " + sessionStorage.getItem('token')
          },
          method: 'POST',
          body: JSON.stringify(data)
        }).then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          toastr.error(error, 'Error')
        })
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: `Kembalian : ${Functions.prototype.formatRupiah(result.value.kembalian.toString(), 'Rp. ')}`,
          text: 'Ingin cetak struk?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Cetak',
          cancelButtonText: 'Tidak'
        }).then((res) => {
          if (res.isConfirmed) {
            const cetakStruk = URL_API + "/managements/cetak-struk/" + result.value.idTrx
            Functions.prototype.getRequest(processPrintTrx, cetakStruk)
          } else {
            setTimeout(() => {
              window.location.reload()
            }, 500);
          }
        })
      }
    })
  }
}