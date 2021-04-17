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
    addReturnProduct()
    getProduct()
});

function getProduct() {
    $('#product').select2({
        theme:'bootstrap4',
        placeholder: "Cari produk",
        ajax: {
            url: URL_API + "/managements",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            data: function (params) {
                return {
                    search_nama_barang: params.term,
                }
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(result => {
                        return {
                                text: result.nama_barang,
                                id: result.id
                            }
                    })
                }
            },
        }
    })
}

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

function addReturnProduct() {
    $('#addReturnProductForm').on('submit', function(e) {
        e.preventDefault()
        const product = $('#product').val()
        if(product == "" || product == null) {
            return toastr.error("Pilih produk terlebih dahulu", "error")
        }
        const data = {
            product_id: product,
            qyt: $('#qyt').val(),
            reason: $('#reason').val()
        }
        const urlAdd = URL_API + "/managements/add/return-product"
        Functions.prototype.postRequest(processAddReturnProduct, urlAdd, data)
    })
}

const processAddReturnProduct = {
    set successData(response) {
        toastr.success(response.message)
        setTimeout(() => {
            window.location.reload()
        }, 1500);
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}