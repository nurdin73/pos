$(document).on('keydown', function(e) {
  if(e.ctrlKey == true) {
    if(e.which == 66) {
      alert('diskon')
    } else if(e.which == 89) {
      $('#barcode').focus()
    } else if(e.which == 77) {
      alert('change customer')
    } else if(e.which == 13) {
      processPayment(e)
    }
  }
})


$(function () {
  getCarts.loadData = noInvoice
  $('#btn-proccess-payment').on('click', processPayment)
  eceran()
  cancelOrder()
});

$('#barcode').on('keydown', function(e) {
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
            <td><span data-toggle="modal" data-target="#halo"><a href="#" data-toggle="tooltip" data-placement="top" title="Klik disini untuk edit">${title}</a></span></td>
            <td class="text-center" style="width: 10%"><span class="text-success">${Functions.prototype.formatRupiah(hargaAsal.toString(), '')}</span> x <span class="text-danger">${result.qyt}</span></td>
            <td>
              <div class="custom-control custom-switch">
                <input type="checkbox" ${hargaAsal == result.product.harga_satuan ? "checked" : ""} class="custom-control-input eceran" data-id="${result.id}" data-harga-eceran="${result.product.harga_satuan}" data-harga-jual="${result.product.harga_jual}" name="eceranOpsi" id="eceranOpsi${i}" ${result.product.isRetail == 0 ? "disabled" : ""}>
                <label class="custom-control-label" for="eceranOpsi${i}">Ya</label>
              </div>
            </td>
          </tr>
        `)
      })
    } else {
      $('#listCarts').html(`
        <tr>
          <td colspan="4" align="center">keranjang masih kosong</td>
        </tr>
      `)
    }

    $('.subTotalBadge').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('.grand_total').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
    $('#grandTotal').val(subTotal)
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
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