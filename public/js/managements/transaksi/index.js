$(document).ready(function () {
    getData()
    getCarts.loadData = noInvoice
    actionDelAndUpdate()
    processPayment()
    updateCart()
    changeHarga()
});

function getData() {
    var totalPriceNoDisc = 0
    $('#noInvoice').text(noInvoice)
    $('#kasir').val(name).attr('disabled', true).addClass('disabled')
    // $('#addProduct').validate({
    //   rules: {
    //     barcode: {
    //       required: true
    //     },
    //   },
    //   errorClass: "is-invalid",
    //   validClass: "is-valid",
    //   errorElement: "small",
    //   submitHandler: function(form, e) {
    //     e.preventDefault()
    //     const id_product = $('#barcode').val()
    //     const no_invoice = noInvoice
    //     const data = {
    //       product_id: id_product,
    //       no_invoice: no_invoice
    //     }
    //     addDataCart.loadData = data
    //   }
    // })
    $('#addProduct').on('keyup', function(e) {
      if(e.keyCode == 13) {
        const kode = $('#barcode').val()
        const no_invoice = noInvoice
        const data = {
          kode: kode,
          no_invoice: no_invoice
        }
        addDataCart.loadData = data
      }
    })
    // $('#barcode').on('change', function(e) {
    //   e.preventDefault()
    //   const id_product = $(this).val()
    //   const no_invoice = noInvoice
    //   const data = {
    //     product_id : id_product,
    //     no_invoice : no_invoice
    //   }
    //   getTax.loadData = id_product
    //   addDataCart.loadData = data
    // })
    // $('#barcode').select2({
    //   theme:'bootstrap4',
    //   ajax: {
    //     url: URL_API + "/managements",
    //     data: function (params) {
    //       return {
    //           search_kode_barang: params.term,
    //       }
    //     },
    //     processResults: function(response, params) {
    //       return {
    //         results: response.data.map(result => {
    //           return {
    //             text: result.kode_barang + " - " + result.nama_barang,
    //             id: result.id
    //           }
    //         })
    //       }
    //     },
    //   }
    // })

    $('#diskon').on('keyup', function(e) {
      e.preventDefault()
      const subTotal = $('#sub_total').val()
      const val = $(this).val()
      const cash = $('#cash').val()
      const grandTotal = subTotal - val
      $('#grand_total').val(grandTotal)
      $('#subTotalBadge').text(Functions.prototype.formatRupiah(grandTotal.toString(), 'Rp. '))
      if(cash > 0) {
        $('#change').val(cash - grandTotal)
      }
    })
    $('#cash').on('keyup', function(e) {
      e.preventDefault()
      const grandTotal = $('#grand_total').val()
      const val = $(this).val()
      const kembalian = val - grandTotal
      $('#change').val(kembalian)
    })
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

const getTax = {
  set loadData(data) {
    const url = URL_API + "/managements/tax/" + data
    Functions.prototype.requestDetail(getTax, url)
  },
  set successData(response) {
    $('#pajak').val(response.persentase_pajak).attr('disabled', true).addClass('disabled')
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

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

const getCarts = {
  set loadData(data) {
    const url = URL_API + "/managements/carts/" + data
    Functions.prototype.requestDetail(getCarts, url)
  },
  set successData(response) {
    var subTotal = 0
    $('#listCarts').empty()
    if(response.length > 0) {
      var i = 1
      var lists = ""
      response.map(result => {
        var harga_product = result.harga_product
        var diskonProduk = result.product.diskon != null ? harga_product * (result.product.diskon / 100) : 0,
            diskon = diskonProduk + result.diskon_product * result.qyt
            hargaProduk = harga_product,
            total = ((result.qyt * hargaProduk) - diskon)
        const typeHarga = result.product.type_prices
        subTotal += ((hargaProduk * result.qyt) - diskon)
        lists += `
          <tr data-id="${result.id}">
            <td>${i++}</td>
            <td>${result.product.kode_barang}</td>
            <td>${result.product.nama_barang}</td>
            <td>`
            if(typeHarga.length > 0) {
            lists += `<select name="typePrice" class="form-control TypeHarga" data-id-cart="${result.id}">`
            typeHarga.map(price => {
              if(hargaProduk == price.harga) {
                lists += `<option value="${price.harga}" selected>${price.harga} - ${price.nama_agen}</option>`
              } else {
                lists += `<option value="${price.harga}">${price.harga} - ${price.nama_agen}</option>`
              }
            })
            if(hargaProduk == result.product.harga_jual) {
              lists += `<option value="${result.product.harga_jual}" selected>${result.product.harga_jual} - default</option>`
            } else {
              lists += `<option value="${result.product.harga_jual}">${result.product.harga_jual} - default</option>`
            }
            lists +=  `</select>`
            } else {
            lists += Functions.prototype.formatRupiah(hargaProduk.toString(), 'Rp. ')
            }
            lists += `</td>
            <td>${result.qyt}</td>
            <td>${Functions.prototype.formatRupiah(diskon.toString(), 'Rp. ')}</td>
            <td>${Functions.prototype.formatRupiah(total.toString(), 'Rp. ')}</td>
            <td>
              <div class="btn-group">
                <button class="btn btn-sm btn-danger delete" data-id="${result.id}">Hapus</button>
                <button class="btn btn-sm btn-info update" data-toggle="modal" data-target="#detailCart" data-id="${result.id}">Edit</button>
              </div>
            </td>
          </tr>
          `
      })
    } else {
      lists += `
        <tr>
          <td colspan="8" align="center">keranjang masih kosong</td>
        </tr>
      `
    }

    $('#listCarts').html(lists)
    $('#subTotalBadge').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#sub_total').val(subTotal).attr('readonly', true).addClass('disabled')
    $('#grand_total').val(subTotal)
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'error')
  }
}

function changeHarga() {  
  $('#listCarts').on('change', 'tr td .TypeHarga', function(e) {
    e.preventDefault()
    $(this).attr('selected')
    var val = $(this).val()
    const urlUpdatePrice = URL_API + "/managements/update/price-cart/" + $(this).data('id-cart')
    const data = {
      price: val
    }
    Functions.prototype.updateData(urlUpdatePrice, data, 'put')
    getCarts.loadData = noInvoice
  })
}

function actionDelAndUpdate() {  
  $('#listCarts').on('click', 'tr td div .delete', function(e) {
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
        Functions.prototype.deleteData(url)
        getCarts.loadData = noInvoice
      }
    })
  })

  $('#listCarts').on('click', 'tr td div .update', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const urlDetail = URL_API + "/managements/cart/" + id
    Functions.prototype.requestDetail(detailCart, urlDetail)
  })
  const detailCart = {
    set successData(response) {
      $('#kodeBarangUpdate').text(response.product.kode_barang)
      $('#hargaBarangUpdate').text(Functions.prototype.formatRupiah(response.product.harga_jual.toString(), 'Rp. '))
      $('#namaBarangUpdate').text(response.product.nama_barang)
      $('#id_cart').val(response.id)
      $('#qyt_update').val(response.qyt)
      $('#dicount_barang_update').val(response.diskon_product)
    },
    set errorData(err) {
      toastr.error(err.responseJSON.message, 'Error')
    }
  }
}

function updateCart() {  
  $('#formUpdateCart').validate({
    rules: {
      qyt_update: {
        required: true,
        number: true,
        min: 1
      },
      dicount_barang_update: {
        required: true,
        number: true,
        min: 0,
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
      const id = $('#id_cart').val()
      const url = URL_API + "/managements/update/cart/" + id
      const data = {
        qyt: $('#qyt_update').val(),
        diskon_product: $('#dicount_barang_update').val()
      }
      Functions.prototype.updateData(url, data, 'put')
      getCarts.loadData = noInvoice
      $('#formUpdateCart')[0].reset()
      $('#detailCart').modal('hide')
      $('#qyt_update').removeClass('is-valid')
      $('#dicount_barang_update').removeClass('is-valid')
    }
  })
}

function processPayment() {  
  $('#btn-proccess-payment').on('click', function (e) {
    e.preventDefault()
    const idUser = idUserInput
    const customer = $('#customer').val()
    const grandTotal = $('#grand_total').val()
    const diskon = $('#diskon').val()
    const no_invoice = noInvoice
    const keterangan = $('#keterangan').val()
    const cash = $('#cash').val()
    const change = $('#change').val()
    if(grandTotal < 1) {
      Swal.fire({
        text: 'isi barang terlebih dahulu',
        title: 'perhatian!',
        icon: 'warning'
      })
    } else {
      Swal.fire({
        title: 'Perhatian?',
        text: "Apakah data yang dimasukkan sudah benar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Benar!'
      }).then((result) => {
        if (result.isConfirmed) {
          const urlAddTransaction = URL_API + "/managements/add/transaction"
          const data = {
            createdBy: idUser,
            no_invoice: no_invoice,
            customer_id: customer,
            diskon_transaksi: diskon != "" ? diskon : 0,
            keterangan: keterangan,
            total: grandTotal,
            cash: cash,
            change: change
          }
          Functions.prototype.postRequest(addTransaction, urlAddTransaction, data)
        }
      })
    }
  })
}

const addTransaction = {
  set successData(response) {
    toastr.success(response.message, 'Success')
    setTimeout(() => {
      window.location.reload()
    }, 1500);
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

