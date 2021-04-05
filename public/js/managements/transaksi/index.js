$(document).ready(function () {
    getData()
    getCarts.loadData = noInvoice
    actionDelAndUpdate()
    processPayment()
    updateCart()
    changeHarga()
    eceran()
    cacl()
    cancelOrder()
    qytForm()
    if(hargaBarangPajak == 0) {
      $('#pajakDetail').text('* harga belum termasuk ' + namaPajak + `(${persentasePajak}%)`)
    } else {
      $('#pajakDetail').text('* harga termasuk ' + namaPajak + `(${persentasePajak}%)`)
    }

});

function qytForm() {
  $('#listCarts').on('change', 'tr td .qytForm', async function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const discount = $(this).data('discount')
    const qytUpdate = {
      qyt: $(this).val(),
      diskon_product: discount
    }
    const url = URL_API + "/managements/update/cart/" + id
    Functions.prototype.updatingData(url, qytUpdate, 'put')
    await new Promise(resolve => setTimeout(resolve, 500))
    getCarts.loadData = noInvoice
  })
}

function cancelOrder() {
  $('#cancelOrder').on('click', function(e) {
    e.preventDefault()
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
  })

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




function cacl() {
  $('.btn-number').on('click', function (e) {  
    e.preventDefault()
    const number = $(this).data('number')
    if(number == "C") {
      $('#fieldCash').val('')
    } else {  
      var valueField = $('#fieldCash').val()
      $('#fieldCash').val(valueField + number)
    }
  })
}

function getData() {
    var totalPriceNoDisc = 0
    $('#noInvoice').text(noInvoice)
    $('#kasir').val(name).attr('disabled', true).addClass('disabled')
    $('#persentasePajak').val(persentasePajak).attr('disabled', true).addClass('disabled')
    $('#barcode').on('keyup', function(e) {
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
    
    $('#diskon').on('keyup', function(e) {
      e.preventDefault()
      const subTotal = $('#sub_total').val()
      const val = $(this).val()
      const cash = $('#cash').val()
      const grandTotal = subTotal - val
      $('#grand_total').text(Functions.prototype.formatRupiah(grandTotal.toString(), 'Rp. '))
      $('#subTotalBadge').text(Functions.prototype.formatRupiah(grandTotal.toString(), 'Rp. '))
      $('#grandTotal').val(grandTotal)
      $('#paymentModal').text(Functions.prototype.formatRupiah(grandTotal.toString(), 'Rp. '))
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
      var x = 1
      var lists = ""
      response.map((result, i) => {
        var hargaAsal = result.harga_product,
            totalDiskon = result.diskon_product * result.qyt,
            totalHargaProduk = (result.qyt * hargaAsal) - totalDiskon,
            pajak = totalHargaProduk * (persentasePajak / 100)
        const layanan = totalHargaProduk * (persentaseLayanan / 100)
        const typeHarga = result.product.type_prices
        subTotal += totalHargaProduk
        const total = subTotal
        lists += `
          <tr data-id="${result.id}">
            <td>${x++}</td>
            <td>${result.product.nama_barang}</td>
            <td>`
              if(typeHarga.length > 0) {
                lists += `<select name="typePrice" class="form-control TypeHarga" data-id-cart="${result.id}">`
                typeHarga.map(price => {
                  if(hargaAsal == price.harga) {
                    lists += `<option value="${price.harga}" selected>${price.harga} - ${price.nama_agen}</option>`
                  } else {
                    lists += `<option value="${price.harga}">${price.harga} - ${price.nama_agen}</option>`
                  }
                })
                if(hargaAsal == result.product.harga_jual) {
                  lists += `<option value="${result.product.harga_jual}" selected>${result.product.harga_jual} - default</option>`
                } else {
                  lists += `<option value="${result.product.harga_jual}">${result.product.harga_jual} - default</option>`
                }
                lists +=  `</select>`
              } else {
                lists += Functions.prototype.formatRupiah(hargaAsal.toString(), 'Rp. ')
              }
              lists +=
            `</td>
            <td><input type="number" value="${result.qyt}" data-id="${result.id}" data-discount="${result.diskon_product}" min="1" class="form-control qytForm"></td>
            <td>
              <div class="custom-control custom-switch">
                <input type="checkbox" ${hargaAsal == result.product.harga_satuan ? "checked" : ""} class="custom-control-input eceran" data-id="${result.id}" data-harga-eceran="${result.product.harga_satuan}" data-harga-jual="${result.product.harga_jual}" name="eceranOpsi" id="eceranOpsi${i}" ${result.product.isRetail == 0 ? "disabled" : ""}>
                <label class="custom-control-label" for="eceranOpsi${i}">Ya</label>
              </div>
            </td>
            <td>${Functions.prototype.formatRupiah(totalDiskon.toString(), 'Rp. ')}</td>
            <td>${Functions.prototype.formatRupiah(totalHargaProduk.toString(), 'Rp. ')}</td>
            <td>
              <div class="btn-group">
                <button class="btn btn-sm btn-danger delete" data-id="${result.id}">Hapus</button>
                <button class="btn btn-sm btn-info update" data-toggle="modal" data-target="#detailCart" data-id="${result.id}">Edit</button>
              </div>
            </td>
          </tr>
        `
        $('#sub_total').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
        $('#diskon').attr('max', subTotal)
        $('#pajak').val(pajak)
        $('#total').text(Functions.prototype.formatRupiah(total.toString(), 'Rp. '))
      })
      $('#cancelOrder').attr('disabled', false)
    } else {
      lists += `
        <tr>
          <td colspan="8" align="center">keranjang masih kosong</td>
        </tr>
      `
      $('#cancelOrder').attr('disabled', true)
    }

    $('#listCarts').html(lists)
    $('#subTotalBadge').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#sub_total').val(subTotal).attr('readonly', true).addClass('disabled')
    $('#grand_total').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#grandTotal').val(subTotal)
    $('#paymentModal').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'error')
  }
}

function eceran() {
  $('#listCarts').on('change', 'tr td div .eceran', async function(e) {
    // e.preventDefault()
    const check = $('input[name=eceranOpsi]:checked').length
    const id = $(this).data('id')
    const urlUpdatePrice = URL_API + "/managements/update/price-cart/" + id
    if(check > 0) {
      const data = {
        price: $(this).data('harga-eceran'),
        eceran: 1
      }
      Functions.prototype.updateData(urlUpdatePrice, data, 'put')
    } else {
      const data = {
        price: $(this).data('harga-jual'),
        eceran: 0
      }
      Functions.prototype.updateData(urlUpdatePrice, data, 'put')
    }
    await new Promise(resolve => setTimeout(resolve, 500));
    getCarts.loadData = noInvoice
  })
}

function changeHarga() {  
  $('#listCarts').on('change', 'tr td .TypeHarga', async function(e) {
    e.preventDefault()
    $(this).attr('selected')
    var val = $(this).val()
    const urlUpdatePrice = URL_API + "/managements/update/price-cart/" + $(this).data('id-cart')
    const data = {
      price: val
    }
    Functions.prototype.updateData(urlUpdatePrice, data, 'put')
    await new Promise(resolve => setTimeout(resolve, 500));
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
        Functions.prototype.deleteingData(prosessDeletingData, url)
      }
    })
  })

  const prosessDeletingData = {
    set successData(response) {
      toastr.success(response.message, 'Success')
      $('#sub_total').text("Rp. 0 ,-")
      $('#total_pajak').text("Rp. 0 ,-")
      $('#total').text("Rp. 0 ,-")
      getCarts.loadData = noInvoice
    },
    set errorData(err) {
      toastr.error(err.responseJSON.message, 'Error')
    }
  }

  $('#listCarts').on('click', 'tr td div .update', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    const urlDetail = URL_API + "/managements/cart/" + id
    Functions.prototype.requestDetail(detailCart, urlDetail)
  })
  const detailCart = {
    set successData(response) {
      $('#hargaBarangUpdate').text(Functions.prototype.formatRupiah(response.harga_product.toString(), 'Rp. '))
      $('#namaBarangUpdate').text(response.product.nama_barang)
      $('#id_cart').val(response.id)
      $('#qyt_update').val(response.qyt)
      $('#dicount_barang_update').val(response.diskon_product).attr('max', response.harga_product)
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
    submitHandler: async function(form, e) {
      e.preventDefault()
      const id = $('#id_cart').val()
      const url = URL_API + "/managements/update/cart/" + id
      const data = {
        qyt: $('#qyt_update').val(),
        diskon_product: $('#dicount_barang_update').val()
      }
      Functions.prototype.updateData(url, data, 'put')
      await new Promise(resolve => setTimeout(resolve, 500))
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
              'Content-Type': 'application/json'
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
  })
}


const processPrintTrx = {
  set successData(response) {
    console.log(response);
    if(response.connection == "bluetooth") {
        var form = document.createElement('form')
				form.setAttribute('method', 'post')
				form.setAttribute('action', urlCetakStruk)

				var input = document.createElement('input')
				input.setAttribute('value', response.message)
				input.setAttribute('name', 'isi')
				input.setAttribute('id', 'isi')
				input.setAttribute('type', 'hidden')

        var input2 = document.createElement('input')
				input2.setAttribute('value', response.no_inv)
				input2.setAttribute('name', 'noInv')
				input2.setAttribute('id', 'noInv')
				input2.setAttribute('type', 'hidden')

        var input3 = document.createElement('input')
				input3.setAttribute('value', $('meta[name="csrf-token"]').attr('content'))
				input3.setAttribute('name', '_token')
				input3.setAttribute('id', '_token')
				input3.setAttribute('type', 'hidden')

				form.appendChild(input)
        form.appendChild(input2)
        form.appendChild(input3)
				document.body.appendChild(form)
				form.submit()

        // var S = "#Intent;scheme=rawbt;";
        // var P =  "package=ru.a402d.rawbtprinter;end;";
        // var textEncoded = encodeURI(response.message)
        // window.location.href = "intent:"+textEncoded+S+P;
        setTimeout(() => {
          window.location.reload()
        }, 1500);
    } else {
      toastr.success(response.message, 'Success')
      setTimeout(() => {
        window.location.reload()
      }, 1500);
    }
  },
  set errorData(err) {
    console.log(err);
    toastr.error(err.responseJSON.message)
  }
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

