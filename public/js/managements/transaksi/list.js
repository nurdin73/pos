$(document).ready(function () {
    var query_params = ""
    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        query_params += "?page=" + id
        getDataList.loadData = query_params
    })
    listTransactions.loadData = ""
});

const listTransactions = {
    set loadData(query) {
        const url = URL_API + "/managements/list-transaction" + query
        Functions.prototype.getRequest(listTransactions, url)
    },
    set successData(response) {
        $('#listTransactions').empty()
        $('#paginate').empty()
        const { data, currentPage, pagination } = response
        if(data.length > 0) {
            data.map(result => {
                const customer = result.customer != null ? result.customer.nama : "umum"
                $('#listTransactions').append(`
                    <tr>
                        <td>${result.no_invoice}</td>
                        <td><span class="badge badge-info">${customer}</span></td>
                        <td><span class="badge badge-primary">${result.user.name}</span></td>
                        <td>${moment(result.tgl_transaksi).format('D MMMM YYYY')}</td>
                        <td>${Functions.prototype.formatRupiah(result.total.toString(), 'Rp. ')}</td>
                        <td>
                            <a href="${invoiceUrl + result.id}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                `)
            })

            $('#paginate').html(pagination)
            $('.paginate').find('a').each(function() {
                if($(this).text() === '‹'){
                    $(this).attr('data-id', currentPage - 1);
                }else if($(this).text() === '›'){
                    $(this).attr('data-id', currentPage + 1);
                }else{
                    $(this).attr('data-id', $(this).html());
                }
            })
        }

    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}