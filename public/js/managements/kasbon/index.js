$(document).ready(function () {
    var query_params = ""
    getDataList.loadData = query_params
    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = ""
        query_params += $(this).serialize()
        getDataList.loadData = query_params
    })

    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        query_params += "&page=" + id
        getDataList.loadData = query_params
    })
    $('#jatuh_tempo').datepicker({
        format: 'yyyy-mm-dd',
    })
    $('#add_jatuh_tempo').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '+7d'
    })
    $('.reset').on('click', function(e) {
        e.preventDefault()
        $('#filterData')[0].reset()
        getDataList.loadData = ""
        query_params = ""
    })
    searchCustomers()
    addKasbon()
});


const getDataList = {
    set loadData(data) {
        const urlKasbonList = URL_API + "/managements/kasbon?" + data
        Functions.prototype.getRequest(getDataList, urlKasbonList)
    },
    set successData(response) {
        var paginations = ""
        $('#listData').empty()
        if(response.data.length > 0) {
            response.data.map(result => {
                $('#listData').append(`
                    <tr>
                        <td>${result.customer ? result.customer.nama : ""}</td>
                        <td>${Functions.prototype.formatRupiah(result.jumlah.toString(), 'Rp.')}</td>
                        <td>${moment(result.jatuh_tempo).format('D MMMM YYYY')}</td>
                        <td>${result.status == "belum lunas" ? `<span class="badge badge-danger">${result.status}</span>` : `<span class="badge badge-success">${result.status}</span>`}</td>
                        <td align="center">
                            ${result.status == "belum lunas" ? 
                                `<a href="${window.location.href + '/bayar/' + result.customer.id}" class="btn btn-sm btn-success">Bayar</a>` :
                                `<span class="btn btn-sm btn-success">Lunas</span>`
                            }
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listData').append(`
                <tr>
                    <td colspan="5" align="center">Data not found</td>
                </tr>
            `)
        }
        if(response.prev_page_url == null) {
            paginations += `<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>`
        } else {
            paginations += `<li class="page-item">
                <a class="page-link" data-id="${response.current_page - 1}" href="#">Previous</a>
            </li>`
        }
        for (let i = 1; i <= response.last_page; i++) {
            if(response.current_page == i) {
                paginations += `<li class="page-item active" aria-current="page">
                <a class="page-link" href="#" data-id="${response.current_page}">${response.current_page} <span class="sr-only">(current)</span></a>
              </li>`
            } else {
                paginations += `<li class="page-item"><a class="page-link" data-id="${i}" href="#">${i}</a></li>`
            }
        }
        if(response.current_page == response.last_page) {
            paginations += `<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" data-id="${response.current_page}" aria-disabled="true">Next</a>
            </li>`
        } else {
            paginations += `<li class="page-item">
            <a class="page-link" data-id="${response.current_page + 1}" href="#">Next</a>
          </li>`
        }
        $('.pagination').html(paginations)
        paginations = ""
        $('#totalKasbon').text(Functions.prototype.formatRupiah(response.total_kasbon, 'Rp. '))
        $('#totalTransaksi').text(response.total)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'error')
    }
}

function searchCustomers() {
    $('#nama_pelanggan').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/search-pelanggan",
            data: function (params) {
                return {
                    name: params.term,
                }
            },
            processResults: function(data, params) {
                return {
                    results: data.map(result => {
                        return {
                            text: result.nama,
                            id: result.id
                        }
                    })
                }
            },
        }
    })
}

function addKasbon() {
    $('#formAddKasbon').validate({
        rules: {
            nama_pelanggan: {
                required: true
            },
            jumlah: {
                required: true,
                number: true
            },
            add_jatuh_tempo: {
                required: true,
            },
            keterangan: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPostKasbon = URL_API + "/managements/add/kasbon"
            const data = {
                pelanggan_id : $('#nama_pelanggan').val(),
                jumlah: $('#jumlah').val(),
                jatuh_tempo: $('#add_jatuh_tempo').val(),
                keterangan: $('#keterangan').val()
            }
            Functions.prototype.httpRequest(urlPostKasbon, data, 'post')
            setTimeout(() => {
                window.location.reload()
            }, 3000);
        }
    })
}