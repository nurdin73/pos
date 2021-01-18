$(document).ready(function () {
    $('.paginate').on('click', '.page-item a', function(e) {
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
        const { total_modal, modal} = response
        const { data, currentPage, pagination } = modal.original
        $('#sisaModal').text(Functions.prototype.formatRupiah(total_modal.toString(), 'Rp. '))
        if(data.length > 0) {
            data.map(result => {
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
        paginations = pagination
        $('.paginate').html(paginations)
        $('.paginate').find('a').each(function() {
            if($(this).text() === '‹'){
                $(this).attr('data-id', currentPage - 1);
            }else if($(this).text() === '›'){
                $(this).attr('data-id', currentPage + 1);
            }else{
                $(this).attr('data-id', $(this).html());
            }
        })
        paginations = ""
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}