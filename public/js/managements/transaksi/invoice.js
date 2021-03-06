$(document).ready(function () {
    getInvoice.loadData = id
});

const getInvoice = {
    set loadData(id) {
        const url = URL_API + "/managements/invoice/" + id
        Functions.prototype.getRequest(getInvoice, url)
    },
    set successData(response) {
        $('#listCarts').empty()
        const keterangan = response.keterangan != null ? response.keterangan : "-"
        $('.no_invoice').text(response.no_invoice)
        $('#tgl_transaksi').text(moment(response.tgl_transaksi).format('D MMMM YYYY'))
        $('#total').text(Functions.prototype.formatRupiah(response.total.toString(), 'Rp. '))
        $('#keterangan').text(keterangan)
        if(response.carts.length > 0) {
            var i = 1
            response.carts.map(cart => {
                const total = cart.qyt * (cart.harga_product - cart.diskon_product)
                $('#listCarts').append(`
                    <tr>
                        <td>${i++}</td>
                        <td>${cart.product.nama_barang}</td>
                        <td>${cart.qyt}</td>
                        <td>${Functions.prototype.formatRupiah(cart.harga_product.toString(), 'Rp. ')}</td>
                        <td>${Functions.prototype.formatRupiah(cart.diskon_product.toString(), 'Rp. ')}</td>
                        <td>${Functions.prototype.formatRupiah(total.toString(), 'Rp. ')}</td>
                    </tr>
                `)
            })
        } else {
            $('#listCarts').append(`
            <tr>
                <td colspan="6">Cart kosong</td>
            </tr>
            `)
        }
        const subTotal = response.total + response.diskon_transaksi,
              diskonTrx = response.diskon_transaksi,
              pajakTrx = response.pajak
        $('#subTotal').text(Functions.prototype.formatRupiah(subTotal.toString(), 'Rp. '))
        $('#diskonTrx').text(Functions.prototype.formatRupiah(diskonTrx.toString(), 'Rp. '))
        $('#pajakTrx').text(Functions.prototype.formatRupiah(pajakTrx.toString(), 'Rp. '))
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}