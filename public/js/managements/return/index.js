$(function () {
    processGetAllProdReturn.loadData = ""
    var query_params = ""
    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        processGetAllProdReturn.loadData = query_params
    })

    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = "?" + $(this).serialize()
        processGetAllProdReturn.loadData = query_params
    })
    $('#reset').on('click', function(e) {
        e.preventDefault()
        $('#search').val('')
        query_params = ""
        processGetAllProdReturn.loadData = ""
    })

});

const processGetAllProdReturn = {
    set loadData(query_params) {
        const urlListAll = URL_API + "/managements/return-products" + query_params
        Functions.prototype.getRequest(processGetAllProdReturn, urlListAll)
    },
    set successData(response) {
        const { data, pagination, currentPage } = response
        $('#listReturnProd').empty()
        if(data.length > 0) {
            data.map(result => {
                var status = "";
                if(result.status == "reject") {
                    status = `<span class="badge badge-danger">Reject</span>`
                } else if(result.status == "accept") {
                    status = `<span class="badge badge-success">Accept</span>`
                } else {
                    status = `<span class="badge badge-primary">Waiting</span>`
                }
                $('#listReturnProd').append(`
                <tr>
                    <td>${result.product.nama_barang}</td>
                    <td class="text-center">${result.qyt}</td>
                    <td class="text-center">${status}</td>
                    <td>
                        <div class="btn-group">
                            <button data-id="${result.id}" class="btn btn-sm btn-primary detail">Detail</button>
                            <button data-id="${result.id}" class="btn btn-sm btn-info update">Update</button>
                            <button data-id="${result.id}" class="btn btn-sm btn-danger delete">Hapus</button>
                        </div>
                    </td>
                </tr>
                `)
            })
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
        } else {
            $('#listReturnProd').html(`
                <tr>
                    <td colspan="4" align="center">Produk return kosong</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}