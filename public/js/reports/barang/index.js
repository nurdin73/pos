$(document).ready(function () {
    getProducts.loadData = ""
    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        var query_params = "?page=" + id
        getProducts.loadData = query_params
    })  
});

const getProducts = {
    set loadData(data) {
        const urlListProd = URL_API + "/reports/barang" + data
        Functions.prototype.getRequest(getProducts, urlListProd)
    },
    set successData(response) {
        $('#listProducts').empty()
        const { current_page, last_page, prev_page_url, data } = response.data
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
                        <td>${result.nama_barang}</td>
                        <td>${Functions.prototype.formatRupiah(harga_dasar.toString(), 'Rp. ')}</td>
                        <td>${stocks}</td>
                        <td>${result.selled}</td>
                    </tr>
                `)
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
            paginations = ""
            $('#totalBarangMasuk').text(response.totalStok)
            $('#totalBarangKeluar').text(response.totalSelled)
            $('#totalBarang').text(response.totalStok + response.totalSelled)
        } else {
            $('#listProducts').append(`
                <tr>
                    <td colspan="4" align="center">Barang Kosong</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}