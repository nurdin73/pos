$(document).ready(function () {
    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        query_params = "?page=" + id
        getListModal.loadData = query_params
    })  
    getListModal.loadData = query_params
});

const getListModal = {
    set loadData(data) {
        const url = URL_API + "/managements/modal" + data
        Functions.prototype.getRequest(getListModal, url)
    },
    set successData(response) {
        $('#listProduct').empty()
        const {current_page, last_page, prev_page_url, total_modal} = response
        $('#sisaModal').text(Functions.prototype.formatRupiah(total_modal.toString(), 'Rp. '))
        if(response.data.length > 0) {
            response.data.map(result => {
                const totalModal = result.stok * result.harga_dasar
                $('#listProduct').append(`
                    <tr>
                        <td>${result.product.nama_barang}</td>
                        <td>${result.stok}</td>
                        <td>${moment(result.tgl_update).format('D MMM YYYY')}</td>
                        <td>${Functions.prototype.formatRupiah(result.harga_dasar.toString(), 'Rp. ')}</td>
                        <td>${Functions.prototype.formatRupiah(totalModal.toString(), 'Rp. ')}</td>
                    </tr>
                `)
            })
        }
        var paginations = ""
        paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
        $('.pagination').html(paginations)
        paginations = ""
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}