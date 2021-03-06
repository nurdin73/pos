$(document).ready(function () {
    getDetail.loadData = id
    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const page = $(this).data('id');
        var query_params = "?page=" + page
        getDetail.loadData = id + query_params
    })
});

const getDetail = {
    set loadData(data) {
        const url = URL_API + "/managements/suplier/" + data
        Functions.prototype.requestDetail(getDetail, url)
    },
    set successData(response) {
        const { current_page, data, prev_page_url, next_page_url } = response.products
        $('#nameSuplier').text(response.nama_suplier)
        $('#emailSuplier').text(response.email != null ? response.email : "-")
        $('#addressSuplier').text(response.alamat.length > 70 ? response.alamat.substr(0, 70) : response.alamat)
        $('#noTelpSuplier').mask('0000-0000-0000').text(response.no_telp)
        $('#listProducts').empty()
        if(data.length > 0) {
            var no = 1
            data.map(product => {
                $('#listProducts').append(`
                    <tr>
                        <td>${no++}</td>
                        <td>${product.kode_barang}</td>
                        <td>${product.nama_barang}</td>
                        <td>${product.selled}</td>
                    </tr>
                `)
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, prev_page_url, next_page_url)
            $('.pagination').html(paginations)
        } else {
            $('#listProducts').append(`
                <tr>
                    <td colspan="4" align="center">Suplier tidak memiliki produk</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}