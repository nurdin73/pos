$(document).ready(function () {
    getDetail.loadData = '?branch=' + id
    getDataDetail.loadData = ""
});

const getDataDetail = {
    set loadData(query_params) {
        const url = URL_API + "/managements/branch-store/" + id
        Functions.prototype.requestDetail(getDataDetail, url)
    },
    set successData(response) {
        $('#namaCabang').text(response.nama_cabang)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getDetail = {
    set loadData(query_params) {
        const url = URL_API + "/managements" + query_params
        Functions.prototype.getRequest(getDetail, url)
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